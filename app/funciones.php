<?php

function rellenar_parametros_vacios($registro,$model, $log, $num_fila){
        if($registro['codigo_aduana'] == '' || $registro['codigo_aduana'] == null){
            if($registro['nombre_aduana'] != '' && $registro['nombre_aduana'] != null){
                $data = $model->findCodeAduanaByName($registro);
                if($data){
                    $registro['codigo_aduana'] = $data['codigo_aduana'];
                    $log->mensaje_registro_rellenado('codigo_aduana',$num_fila);
                }else{
                    $log->mensaje_registro_no_rellenado('codigo_aduana',$num_fila);
                }
            }else{
                $log->mensaje_registro_no_rellenado_2('aduana',$num_fila);
            }
            
        }

        if($registro['codigo_bandera'] == '' || $registro['codigo_bandera'] == null){
            if($registro['nombre_pais_bandera'] != '' && $registro['nombre_pais_bandera'] != null){
                $data = $model->findCodePaisByName($registro);
                if($data){
                    $registro['codigo_bandera'] = $data['codigo_bandera'];
                    $log->mensaje_registro_rellenado('codigo_bandera',$num_fila);
                }else{
                    $log->mensaje_registro_no_rellenado('codigo_bandera',$num_fila);
                }
            }else{
                $log->mensaje_registro_no_rellenado_2('bandera',$num_fila);
            }
            
        }

        if($registro['codigo_tipo_contenedor'] == '' || $registro['codigo_tipo_contenedor'] != null){
            if($registro['descripcion_tipo_contenedor'] != '' && $registro['descripcion_tipo_contenedor'] == null){
                $data = $model->findCodeContenedorByName($registro);
                if($data){
                    $registro['codigo_tipo_contenedor'] = $data['codigo_tipo_contenedor'];
                    $log->mensaje_registro_rellenado('codigo_tipo_contenedor',$num_fila);
                }else{
                    $log->mensaje_registro_no_rellenado('codigo_tipo_contenedor',$num_fila);
                }
            }else{
                $log->mensaje_registro_no_rellenado_2('contenedor',$num_fila);
            }
            
        }

        if($registro['codigo_lugar_embarque'] == '' || $registro['codigo_lugar_embarque'] == null){
            if($registro['nombre_lugar_embarque'] != '' && $registro['nombre_lugar_embarque'] != null){
                $data = $model->findCodeEmbarqueByName($registro);
                if($data){
                    $registro['codigo_lugar_embarque'] = $data['codigo_lugar_embarque'];
                    $log->mensaje_registro_rellenado('codigo_lugar_embarque',$num_fila);
                }else{
                    $log->mensaje_registro_no_rellenado('codigo_lugar_embarque',$num_fila);
                }
            }else{
                $log->mensaje_registro_no_rellenado_2('embarque',$num_fila);
            }
            
        }

        if($registro['codigo_lugar_desembarque'] == '' || $registro['codigo_lugar_desembarque'] == null){
            if($registro['nombre_lugar_desembarque'] != '' && $registro['nombre_lugar_desembarque'] != null){
                $data = $model->findCodeDesembarqueByName($registro);
                if($data){
                    $registro['codigo_lugar_desembarque'] = $data['codigo_lugar_desembarque'];
                    $log->mensaje_registro_rellenado('codigo_lugar_desembarque',$num_fila);
                }else{
                    $log->mensaje_registro_no_rellenado('codigo_lugar_desembarque',$num_fila);
                }
            }else{
                $log->mensaje_registro_no_rellenado_2('desembarque',$num_fila);
            }
            
        }

        if($registro['codigo_transportista'] == '' || $registro['codigo_transportista'] == null){
            if($registro['nombre_transportista'] != '' && $registro['nombre_transportista'] != null){
                $data = $model->findCodeTransportistaByName($registro);
                if($data){
                    $registro['codigo_transportista'] = $data['codigo_transportista'];
                    $log->mensaje_registro_rellenado('codigo_transportista',$num_fila);
                }else{
                    $log->mensaje_registro_no_rellenado('codigo_transportista',$num_fila);
                }
            }else{
                $log->mensaje_registro_no_rellenado_2('transportista',$num_fila);
            }
            
        }

        if($registro['codigo_exportador'] == '' || $registro['codigo_exportador'] == null){
            if($registro['nombre_exportador'] != '' && $registro['nombre_exportador'] != null){
                $data = $model->findCodeExportadorByName($registro);
                if($data){
                    $registro['codigo_exportador'] = $data['codigo_exportador'];
                    $log->mensaje_registro_rellenado('codigo_exportador',$num_fila);
                }else{
                    $log->mensaje_registro_no_rellenado('codigo_exportador',$num_fila);
                }
            }else{
                $log->mensaje_registro_no_rellenado_2('exportador',$num_fila);
            }
            
        }

        if($registro['codigo_consignatario'] == '' || $registro['codigo_consignatario'] == null){
            if($registro['nombre_consignatario'] != '' && $registro['nombre_consignatario'] != null){
                $data = $model->findCodeConsignatarioByName($registro);
                if($data){
                    $registro['codigo_consignatario'] = $data['codigo_consignatario'];
                    $log->mensaje_registro_rellenado('codigo_consignatario',$num_fila);
                }else{
                    $log->mensaje_registro_no_rellenado('codigo_consignatario',$num_fila);
                }
            }else{
                $log->mensaje_registro_no_rellenado_2('consignatario',$num_fila);
            }
            
        }

        if($registro['codigo_embalaje'] == '' || $registro['codigo_embalaje'] == null){
            if($registro['nombre_embalaje'] != '' && $registro['nombre_embalaje'] != null){
                $data = $model->findCodeEmbalajeByName($registro);
                if($data){
                    $registro['codigo_embalaje'] = $data['codigo_embalaje'];
                    $log->mensaje_registro_rellenado('codigo_embalaje',$num_fila);
                }else{
                    $log->mensaje_registro_no_rellenado('codigo_embalaje',$num_fila);
                }
            }else{
                $log->mensaje_registro_no_rellenado_2('embalaje',$num_fila);
            }
            
        }

        if($registro['codigo_localizacion'] == '' || $registro['codigo_localizacion'] == null){
            if($registro['nombre_localizacion'] != '' && $registro['nombre_localizacion'] != null){
                $data = $model->findCodeLocalizacionByName($registro);
                if($data){
                    $registro['codigo_localizacion'] = $data['codigo_localizacion'];
                    $log->mensaje_registro_rellenado('codigo_localizacion',$num_fila);
                }else{
                    $log->mensaje_registro_no_rellenado('codigo_localizacion',$num_fila);
                }
            }else{
                $log->mensaje_registro_no_rellenado_2('localizacion',$num_fila);
            }
            
        }
        return $registro;
    }

    function validar_desembarque($registro,$model, $log, $num_fila){
        if($registro['codigo_lugar_desembarque'] == '' || $registro['codigo_lugar_desembarque'] == null){
            if($registro['nombre_lugar_desembarque'] != '' && $registro['nombre_lugar_desembarque'] != null){
                $data = $model->findCodeEmbarqueByName($registro);
                if($data){
                    $registro['codigo_lugar_desembarque'] = $data['codigo'];
                    $log->mensaje_registro_rellenado('codigo_lugar_desembarque',$num_fila);
                }else{
                    $log->mensaje_registro_no_rellenado('codigo_lugar_desembarque',$num_fila);
                    return [false,$registro];
                }
            }else{
                $log->mensaje_registro_no_rellenado_2('embarque',$num_fila);
                return [false,$registro];
            }
        }else{
            $data = $model->findByCode($registro);
            if($data == false){
                $log->mensaje_registro_no_rellenado('codigo_lugar_desembarque',$num_fila);
                return [false,$registro];
            }
        }
        return [true,$registro];
            
    }

    function validar_aduana($registro,$model, $log, $num_fila){
        if($registro['codigo_aduana'] == '' || $registro['codigo_aduana'] == null){
            if($registro['nombre_aduana'] != '' && $registro['nombre_aduana'] != null){
                $data = $model->findCodeAduanaByName($registro);
                if($data){
                    $registro['codigo_aduana'] = $data['codigo'];
                    $log->mensaje_registro_rellenado('codigo_aduana',$num_fila);
                }else{
                    $log->mensaje_registro_no_rellenado('codigo_aduana',$num_fila);
                    return [false,$registro];
                }
            }else{
                $log->mensaje_registro_no_rellenado_2('embarque',$num_fila);
                return [false,$registro];
            }
        }else{
            $data = $model->findByCode($registro);
            if($data == false){
                $log->mensaje_registro_no_rellenado('codigo_aduana',$num_fila);
                return [false,$registro];
            }
        }
        return [true,$registro];

    }