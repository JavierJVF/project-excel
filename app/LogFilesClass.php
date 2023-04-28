<?php

class LogFiles 
{

    private $excel_dir;
    private $log_dir;
    private $file_xlsx;
    private $file_excel_to_save;
    private $type_import;

    public function __construct($file_xlsx,$post)
    {
        $id_doc = md5(uniqid());
        $this->file_xlsx = $file_xlsx;
        $this->type_import = $post['type_import'];
        $info = new SplFileInfo($this->file_xlsx['name']);
        
        
        $this->excel_dir = $id_doc .'.'.$info->getExtension();
        $this->log_dir = $id_doc .'.txt';
        
        $this->file_excel_to_save['excel_dir'] = $this->excel_dir;
        $this->file_excel_to_save['log_dir'] = $this->log_dir;
        $this->file_excel_to_save['excel_name'] = $this->file_xlsx['name'];
        $this->file_excel_to_save['type_import'] = $this->type_import;
        $this->file_excel_to_save['nameImport'] = $post['nameImport'];;
        
    }

    public function getExcel_dir()
    {
        return $this->excel_dir;
    }  
    
    public function getLog_dir()
    {
        return $this->log_dir;
    } 
    
    public function getFile_excel_to_save()
    {
        return $this->file_excel_to_save;
    }  

    private function agregar_linea_log($info){

        $route_serve = "/public/logs/";
        $route = '..'.$route_serve.$this->log_dir;
        $file = fopen($route, "a");

        fwrite($file, $info . PHP_EOL);

        fclose($file);
    }


    public function mensaje_inicio_importacion()
    {
        $this->agregar_linea_log('La importacion de los datos del archivo '.$this->file_xlsx['name'].' ah iniciado');
    }

    public function mensaje_archivo_nombre_servidor()
    {
        $this->agregar_linea_log('El archivo se registro en el servidor como '.$this->excel_dir);
    }

    public function mensaje_arror_guardar_archivo()
    {
        $this->agregar_linea_log('Ocurrio un error al intentar guardar el archivo '.$this->file_xlsx['name']);
    }

    public function mensaje_log_error_al_crear_en_bd($indexRow,$log_mensaje)
    {
        $this->agregar_linea_log('Linea '.$indexRow.': '.$log_mensaje);
        
    }

    public function mensaje_fin_proceso()
    {
        $this->agregar_linea_log('Fin del proceso de importacion');
        
    }

    public function mensaje_registro_archivo_bd_negativo()
    {
        $this->agregar_linea_log('Ocurrio un error al intentar guardar La direccion de los archivos en la base de datos');
        $this->agregar_linea_log('El proceso de importacion se detendra');
    }

    public function mensaje_registro_archivo_bd_positivo($excel_id)
    {
        $this->agregar_linea_log('La direccion de los archivos se guardo en la base de datos');
        $this->agregar_linea_log('el ID es: '.$excel_id);
        
    }

    public function mensaje_registro_rellenado($parametro,$num_fila)
    {
        $this->agregar_linea_log('Linea '.$num_fila.': El parametro '.$parametro.' estaba vacio y se relleno por uno existente en la bd');
    }

    public function mensaje_registro_envio_repetido($num_fila)
    {
        $this->agregar_linea_log('Linea '.$num_fila.': El registro esta repetido y no se almacenara');
    }

    public function mensaje_registro_evento_repetido($num_fila)
    {
        $this->agregar_linea_log('Linea '.$num_fila.': El registro esta repetido y no se almacenara');
    }

    public function mensaje_codigo_no_valido($parametro,$num_fila)
    {
        $this->agregar_linea_log('Linea '.$num_fila.': No se puede registrar por '.$parametro.' no valido');
    }

    

    public function mensaje_registro_no_rellenado_2($parametro,$num_fila)
    {
        $this->agregar_linea_log('Linea '.$num_fila.': La seccion de '. $parametro.' no tiene ni nombre ni codigo');
    }

    public function mensaje_registro_no_rellenado($parametro,$num_fila)
    {
        $this->agregar_linea_log('Linea '.$num_fila.': El parametro '.$parametro.' esta vacio y no se encontraron registros previos en la bd');
    }

    public function saveXLSX()
    {
        $route_serve = "/public/files/";
        //the path where the image is stored
        $route = '..'.$route_serve.$this->excel_dir;

        if(!file_exists($route))//check if image path exists
        {
            if (move_uploaded_file($this->file_xlsx['tmp_name'], $route)) //store image in path
            {
                chmod($route, 0777);//Give permissions
                return true;
            }else return false;
        }return true;
    }



    
}