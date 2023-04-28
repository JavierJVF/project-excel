<?php
    session_start();
    require '../vendor/autoload.php';
    require_once 'Conexion.php';
    require_once 'Model/RegistroEnvioModel.php';
    require_once 'Model/ExcelFileModel.php';
    require_once 'Model/AduanaModel.php';
    require_once 'Model/ConsignatarioModel.php';
    require_once 'Model/DesembarqueModel.php';
    require_once 'Model/EmbarqueModel.php';
    require_once 'Model/ExportadorModel.php';
    require_once 'Model/TransportistaModel.php';
    require_once 'LogFilesClass.php';
    use PhpOffice\PhpSpreadsheet\IOFactory;
    use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

    function Response($code,$mensaje,$data){
        $response['code'] = $code;
        $response['data'] = $data;
        $response['mensaje'] = $mensaje;
        
        return $response;
    }

    function validar_embarque($registro,$model, $log, $num_fila){
        if($registro['codigo_lugar_embarque'] == '' || $registro['codigo_lugar_embarque'] == null){
            if($registro['nombre_lugar_embarque'] != '' && $registro['nombre_lugar_embarque'] != null){
                $data = $model->findCodeByName($registro);
                if($data){
                    $registro['codigo_lugar_embarque'] = $data['codigo'];
                    $log->mensaje_registro_rellenado('codigo_lugar_embarque',$num_fila);
                }else{
                    $log->mensaje_registro_no_rellenado('codigo_lugar_embarque',$num_fila);
                    return [false,$registro];
                }
            }else{
                $log->mensaje_registro_no_rellenado_2('embarque',$num_fila);
                return [false,$registro];
            }
        }else{
            $data = $model->findByCode($registro);
            if($data){
                if (strtoupper($data['pais'])  == 'VENEZUELA'){
                    $registro['actividad'] = 'EXPORTACION';
                }else{
                    $registro['actividad'] = 'IMPORTACION';
                }
            }else{
                $log->mensaje_codigo_no_valido('codigo_lugar_embarque',$num_fila);
                return [false,$registro];
            }
        }
        return [true,$registro];
            
    }

    function validar_parametro($registro,$name,$codigo,$model, $log, $num_fila){
        if($registro[$codigo] == '' || $registro[$codigo] == null){
            if($registro[$name] != '' && $registro[$name] != null){
                $data = $model->findCodeByName($registro);
                if($data){
                    $registro[$codigo] = $data['codigo'];
                    $log->mensaje_registro_rellenado($codigo,$num_fila);
                }else{
                    $log->mensaje_registro_no_rellenado($codigo,$num_fila);
                    return [false,$registro];
                }
            }else{
                $log->mensaje_registro_no_rellenado_2('embarque',$num_fila);
                return [false,$registro];
            }
        }else{
            $data = $model->findByCode($registro);
            if($data == false){
                $log->mensaje_codigo_no_valido($codigo,$num_fila);
                return [false,$registro];
            }
        }
        return [true,$registro];

    }


    function validar_repetidos($registro,$model, $log, $num_fila){
        $data = $model->findEnviosByAllCodes($registro);

        if($data){
            $log->mensaje_registro_envio_repetido($num_fila);
            return false;
        }else{
            return true;
        }
    }

    function validar_fila_vacia($registro){
        if($registro['codigo_aduana'] == '' && $registro['nombre_aduana']=='' && $registro['numero_registro_manifiesto'] ==''
                && $registro['fecha_llegada'] == ''){
                return true;
            }
        return false;
    }


    function store(){
        if(!isset($_FILES['excelFile'])) return Response(400,'Bad Request',null);

        $mensaje = '';

        $doc = IOFactory::load($_FILES['excelFile']['tmp_name']);
        $total_hojas = $doc->getSheetCount();

        if($total_hojas < 1) return Response(400,'El archivo no tiene hojas',null);

        $primeraHoja = $doc->getSheet(0);

        $tope_filas = $primeraHoja->getHighestDataRow();
        $tope_columnas_letra = $primeraHoja->getHighestColumn();

        $tope_columnas = Coordinate::columnIndexFromString($tope_columnas_letra);
        if ($tope_columnas < 34) return Response(400,'Al archivo le faltan columnas',null);

        $log = new LogFiles($_FILES['excelFile'],$_POST);
        $log->mensaje_inicio_importacion();

        try {
            $log->saveXLSX();
            $log->mensaje_archivo_nombre_servidor();
            
        } catch (\Throwable $th) {
            $log->mensaje_arror_guardar_archivo();
            return Response(500,'Internal Server Error',null);
        }

        $modelExcelFile = new ExcelFileModel();
        $modelRegistroEnvio = new RegistroEnvioModel();

        $modelAduana = new AduanaModel();
        $modelConsignatario = new ConsignatarioModel();
        $modelDesmbarque = new DesembarqueModel();
        $modelEmbarque = new EmbarqueModel();
        $modelExportador = new ExportadorModel();
        $modelTransportista = new TransportistaModel();

        try {
            $excel_id = $modelExcelFile->create($log->getFile_excel_to_save());
            if ($excel_id){
                $log->mensaje_registro_archivo_bd_positivo($excel_id);
            }else{
                $log->mensaje_registro_archivo_bd_negativo();
                return Response(500,'Internal Server Error',null);
            }
            
        } catch (\Throwable $th) {
            $log->mensaje_registro_archivo_bd_negativo();
            return Response(500,'Internal Server Error',null);
        }

        for($indexRow = 2; $indexRow < $tope_filas; $indexRow++){


            $registro = array();
            
            $registro['excel_id'] = $excel_id;
            $registro['codigo_aduana'] = $primeraHoja->getCellByColumnAndRow(1,$indexRow);
            $registro['nombre_aduana'] = $primeraHoja->getCellByColumnAndRow(2,$indexRow);
            $registro['numero_registro_manifiesto'] = $primeraHoja->getCellByColumnAndRow(3,$indexRow);
            $registro['fecha_llegada'] = $primeraHoja->getCellByColumnAndRow(4,$indexRow);

            if(validar_fila_vacia($registro))break;

            $registro['nombre_medio_transporte'] = $primeraHoja->getCellByColumnAndRow(5,$indexRow);
            $registro['codigo_bandera'] = $primeraHoja->getCellByColumnAndRow(6,$indexRow);
            $registro['nombre_pais_bandera'] = $primeraHoja->getCellByColumnAndRow(7,$indexRow);
            $registro['documento_transporte'] = $primeraHoja->getCellByColumnAndRow(8,$indexRow);
            $registro['id_contenedor'] = $primeraHoja->getCellByColumnAndRow(9,$indexRow);
            $registro['codigo_tipo_contenedor'] = $primeraHoja->getCellByColumnAndRow(10,$indexRow);
            $registro['descripcion_tipo_contenedor'] = $primeraHoja->getCellByColumnAndRow(11,$indexRow);
            $registro['paquetes_en_contenedor'] = $primeraHoja->getCellByColumnAndRow(12,$indexRow);
            $registro['peso_contenedor'] = $primeraHoja->getCellByColumnAndRow(13,$indexRow);

            $registro['codigo_transportista'] = $primeraHoja->getCellByColumnAndRow(18,$indexRow);
            $registro['nombre_transportista'] = $primeraHoja->getCellByColumnAndRow(19,$indexRow);
            $registro['codigo_exportador'] = $primeraHoja->getCellByColumnAndRow(20,$indexRow);
            $registro['nombre_exportador'] = $primeraHoja->getCellByColumnAndRow(21,$indexRow);
            $registro['datos_exportador'] = $primeraHoja->getCellByColumnAndRow(22,$indexRow);
            $registro['codigo_consignatario'] = $primeraHoja->getCellByColumnAndRow(23,$indexRow);

            $registro['tipo_cliente'] = $primeraHoja->getCellByColumnAndRow(27,$indexRow);

            $registro['nombre_consignatario'] = $primeraHoja->getCellByColumnAndRow(24,$indexRow);
            $registro['datos_consignatario'] = $primeraHoja->getCellByColumnAndRow(25,$indexRow);
            $registro['total_paquetes_dt'] = $primeraHoja->getCellByColumnAndRow(26,$indexRow);
            $registro['codigo_embalaje'] = $primeraHoja->getCellByColumnAndRow(27,$indexRow);
            $registro['nombre_embalaje'] = $primeraHoja->getCellByColumnAndRow(28,$indexRow);
            $registro['descripcion_mercancias'] = $primeraHoja->getCellByColumnAndRow(29,$indexRow);
            $registro['peso_total'] = $primeraHoja->getCellByColumnAndRow(30,$indexRow);
            $registro['monto_valor'] = $primeraHoja->getCellByColumnAndRow(31,$indexRow);
            $registro['moneda_valor'] = $primeraHoja->getCellByColumnAndRow(32,$indexRow);
            $registro['codigo_localizacion'] = $primeraHoja->getCellByColumnAndRow(33,$indexRow);
            $registro['nombre_localizacion'] = $primeraHoja->getCellByColumnAndRow(34,$indexRow);

            $registro['codigo_lugar_embarque'] = $primeraHoja->getCellByColumnAndRow(14,$indexRow);
            $registro['nombre_lugar_embarque'] = $primeraHoja->getCellByColumnAndRow(15,$indexRow);

            $registro['codigo_lugar_desembarque'] = $primeraHoja->getCellByColumnAndRow(16,$indexRow);
            $registro['nombre_lugar_desembarque'] = $primeraHoja->getCellByColumnAndRow(17,$indexRow);

            $registro['mercancia_agrupada'] = 'SIN ASIGNAR';

            $registro_to_save = $registro;

            list($validated_embarque,$registro_to_save) = validar_embarque($registro,$modelEmbarque,$log,$indexRow);
            list($validated_desembarque,$registro_to_save) = validar_parametro($registro_to_save,'nombre_lugar_desembarque','codigo_lugar_desembarque',$modelDesmbarque,$log,$indexRow);
            list($validated_aduana,$registro_to_save) = validar_parametro($registro_to_save,'nombre_aduana','codigo_aduana',$modelAduana,$log,$indexRow);
            list($validated_exportador,$registro_to_save) = validar_parametro($registro_to_save,'nombre_exportador','codigo_exportador',$modelExportador,$log,$indexRow);
            list($validated_trasportista,$registro_to_save) = validar_parametro($registro_to_save,'nombre_transportista','codigo_transportista',$modelTransportista,$log,$indexRow);
            list($validated_consignatario,$registro_to_save) = validar_parametro($registro_to_save,'nombre_consignatario','codigo_consignatario',$modelConsignatario,$log,$indexRow);

            if ($validated_embarque != false && $validated_desembarque != false && $validated_aduana != false && 
                $validated_exportador != false && $validated_trasportista != false && $validated_consignatario != false) {

                if(validar_repetidos($registro_to_save,$modelRegistroEnvio,$log,$indexRow)){
                    list($id_registro,$log_mensaje) = $modelRegistroEnvio->create($registro_to_save);

                    if(!$id_registro){
                        $log->mensaje_log_error_al_crear_en_bd($indexRow,$log_mensaje);
                    }
                }
            }
            
        }

        $log->mensaje_fin_proceso();



        return Response(200,'success',$mensaje);
    }

    $res = store();
    header('Content-Type: application/json');
    echo json_encode($res);
?>