<?php
    session_start();
    require '../vendor/autoload.php';
    require_once 'Conexion.php';
    require_once 'Model/EventModel.php';
    require_once 'Model/ExcelFileModel.php';
    require_once 'LogFilesClass.php';
    use PhpOffice\PhpSpreadsheet\IOFactory;
    use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
    use PhpOffice\PhpSpreadsheet\Shared\Date;
    function Response($code,$mensaje,$data){
        $response['code'] = $code;
        $response['data'] = $data;
        $response['mensaje'] = $mensaje;
        
        return $response;
    }


    function validar_repetidos($registro,$model, $log, $num_fila){
        $data = $model->findEventByAllParams($registro);

        if($data){
            $log->mensaje_registro_evento_repetido($num_fila);
            return false;
        }else{
            return true;
        }
    }

    function validar_fila_vacia($registro){
        if($registro['base_inicial'] == '' && $registro['tipo']=='' && $registro['empresa'] ==''
                && $registro['miembro_wca'] == ''){
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
        if ($tope_columnas < 14) return Response(400,'Al archivo le faltan columnas',null);

        
        $log = new LogFiles($_FILES['excelFile'], $_POST);
        $log->mensaje_inicio_importacion();

        try {
            $log->saveXLSX();
            $log->mensaje_archivo_nombre_servidor();
            
        } catch (\Throwable $th) {
            $log->mensaje_arror_guardar_archivo();
            return Response(500,'Internal Server Error',null);
        }

        $modelExcelFile = new ExcelFileModel();
        $modelEvent = new EventModel();


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
            $registro['base_inicial'] = $primeraHoja->getCellByColumnAndRow(2,$indexRow);
            $registro['tipo'] = $primeraHoja->getCellByColumnAndRow(3,$indexRow);
            $registro['empresa'] = $primeraHoja->getCellByColumnAndRow(4,$indexRow);
            $registro['miembro_wca'] = $primeraHoja->getCellByColumnAndRow(5,$indexRow);

            if(validar_fila_vacia($registro))break;

            $registro['sector'] = $primeraHoja->getCellByColumnAndRow(6,$indexRow);
            $registro['contacto'] = $primeraHoja->getCellByColumnAndRow(7,$indexRow);
            $registro['cargo'] = $primeraHoja->getCellByColumnAndRow(8,$indexRow);
            $registro['telefono1'] = $primeraHoja->getCellByColumnAndRow(9,$indexRow);
            $registro['telefono2'] = $primeraHoja->getCellByColumnAndRow(10,$indexRow);
            $registro['email'] = $primeraHoja->getCellByColumnAndRow(11,$indexRow);
            $registro['estatus_llamada'] = $primeraHoja->getCellByColumnAndRow(12,$indexRow);
            $registro['estatus_correo'] = $primeraHoja->getCellByColumnAndRow(13,$indexRow);
            $registro['fecha_envio_Correo'] = $primeraHoja->getCellByColumnAndRow(14,$indexRow);
            $registro['estatus_citas'] = $primeraHoja->getCellByColumnAndRow(15,$indexRow);

        

            if(validar_repetidos($registro,$modelEvent,$log,$indexRow)){
                list($id_registro,$log_mensaje) = $modelEvent->create($registro);
                if(!$id_registro){
                    $log->mensaje_log_error_al_crear_en_bd($indexRow,$log_mensaje);
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