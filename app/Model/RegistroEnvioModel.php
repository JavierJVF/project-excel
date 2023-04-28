<?php

class RegistroEnvioModel 
{

    private $conn;

    public function __construct()
    {
        
        $bd = new Conexion();
        $this->conn = $bd->getConn();
    }

                

    public function create($registro)
    {
        $sql = 'INSERT INTO envios (importe_id, codigo_aduana, numero_registro_manifiesto, fecha_llegada, nombre_medio_transporte, codigo_bandera, nombre_pais_bandera,
                        documento_transporte,id_contenedor,codigo_tipo_contenedor,descripcion_tipo_contenedor,paquetes_en_contenedor, 
                        peso_contenedor,actividad,codigo_lugar_embarque,codigo_lugar_desembarque,codigo_transportista, codigo_consignatario, 
                        codigo_exportador, total_paquetes_dt,codigo_embalaje,nombre_embalaje,mercancia_agrupada,
                        descripcion_mercancias,peso_total,monto_valor,moneda_valor,codigo_localizacion,nombre_localizacion) VALUES (
            "'.$registro['excel_id'].'",
            "'.$registro['codigo_aduana'].'",
            "'.$registro['numero_registro_manifiesto'].'",
            "'.$registro['fecha_llegada'].'",
            "'.$registro['nombre_medio_transporte'].'",
            "'.$registro['codigo_bandera'].'",
            "'.$registro['nombre_pais_bandera'].'",
            "'.$registro['documento_transporte'].'",
            "'.$registro['id_contenedor'].'",
            "'.$registro['codigo_tipo_contenedor'].'",
            "'.$registro['descripcion_tipo_contenedor'].'",
            "'.$registro['paquetes_en_contenedor'].'",
            "'.$registro['peso_contenedor'].'",
            "'.$registro['actividad'].'",
            "'.$registro['codigo_lugar_embarque'].'",
            "'.$registro['codigo_lugar_desembarque'].'",
            "'.$registro['codigo_transportista'].'",
            "'.$registro['codigo_consignatario'].'",
            "'.$registro['codigo_exportador'].'",
            "'.$registro['total_paquetes_dt'].'",
            "'.$registro['codigo_embalaje'].'",
            "'.$registro['nombre_embalaje'].'",
            "'.$registro['mercancia_agrupada'].'",
            "'.$registro['descripcion_mercancias'].'",
            "'.$registro['peso_total'].'",
            "'.$registro['monto_valor'].'",
            "'.$registro['moneda_valor'].'",
            "'.$registro['codigo_localizacion'].'",
            "'.$registro['nombre_localizacion'].'"
            )';
        
        $result = $this->conn->query($sql);
        
        if($result) return [mysqli_insert_id($this->conn),'successs'];
        else return [false,mysqli_error($this->conn)];
    }

    public function findEnviosByAllCodes($registro)
    {
        $moneda_valor = $registro['moneda_valor'];
        $monto_valor = $registro['monto_valor'];
        $peso_total = $registro['peso_total'];
        if($moneda_valor == '')$moneda_valor = 0;
        if($monto_valor == '')$monto_valor = 0;
        if($peso_total == '')$peso_total = 0;

        $sql = 'SELECT *  FROM envios WHERE (
            codigo_aduana = "'.$registro['codigo_aduana'].'" and 
            numero_registro_manifiesto = "'.$registro['numero_registro_manifiesto'].'" and 
            fecha_llegada = "'.$registro['fecha_llegada'].'" and 
            nombre_medio_transporte = "'.$registro['nombre_medio_transporte'].'" and 
            codigo_bandera = "'.$registro['codigo_bandera'].'" and 
            documento_transporte = "'.$registro['documento_transporte'].'" and 
            id_contenedor = "'.$registro['id_contenedor'].'" and 
            codigo_tipo_contenedor = "'.$registro['codigo_tipo_contenedor'].'" and 
            paquetes_en_contenedor = "'.$registro['paquetes_en_contenedor'].'" and 
            peso_contenedor = "'.$registro['peso_contenedor'].'" and 
            actividad = "'.$registro['actividad'].'" and 
            codigo_lugar_embarque = "'.$registro['codigo_lugar_embarque'].'" and 
            codigo_exportador = "'.$registro['codigo_exportador'].'" and 
            codigo_transportista = "'.$registro['codigo_transportista'].'" and 
            codigo_consignatario = "'.$registro['codigo_consignatario'].'" and 
            total_paquetes_dt = "'.$registro['total_paquetes_dt'].'" and 
            codigo_embalaje = "'.$registro['codigo_embalaje'].'" and 
            mercancia_agrupada = "'.$registro['mercancia_agrupada'].'" and 
            descripcion_mercancias = "'.$registro['descripcion_mercancias'].'" and
            (ABS(peso_total - "'.$peso_total.'")<0.0001 ) and
            (ABS(monto_valor - "'.$monto_valor.'")<0.0001 ) and
            (ABS(moneda_valor - "'.$moneda_valor.'")<0.0001 ) and
            codigo_localizacion = "'.$registro['codigo_localizacion'].'") LIMIT 1';
        
        $result = $this->conn->query($sql);

        try{
            
            $data = $result->fetch_assoc();
            return $data;
        }catch (\Throwable $th){
            return false;
        }
    }

    public function findCodeAduanaByName($registro)
    {
        $sql = 'SELECT id,codigo_aduana  FROM envios WHERE ( nombre_aduana = "'.$registro['nombre_aduana'].'" and codigo_aduana != "") LIMIT 1';
        $result = $this->conn->query($sql);

        try{
            
            $data = $result->fetch_assoc();
            return $data;
        }catch (\Throwable $th){
            return false;
        }
    }

    public function findCodePaisByName($registro)
    {
        $sql = 'SELECT id,codigo_bandera  FROM envios WHERE ( nombre_pais_bandera = "'.$registro['nombre_pais_bandera'].'" and codigo_bandera != "") LIMIT 1';
        $result = $this->conn->query($sql);

        try{
            
            $data = $result->fetch_assoc();
            return $data;
        }catch (\Throwable $th){
            return false;
        }
    }

    public function findCodeContenedorByName($registro)
    {
        $sql = 'SELECT id,codigo_tipo_contenedor  FROM envios WHERE ( descripcion_tipo_contenedor = "'.$registro['descripcion_tipo_contenedor'].'" and codigo_tipo_contenedor != "") LIMIT 1';
        $result = $this->conn->query($sql);

        try{
            
            $data = $result->fetch_assoc();
            return $data;
        }catch (\Throwable $th){
            return false;
        }
    }

    public function findCodeEmbarqueByName($registro)
    {
        $sql = 'SELECT id,codigo_lugar_embarque  FROM envios WHERE ( nombre_lugar_embarque = "'.$registro['nombre_lugar_embarque'].'" and codigo_lugar_embarque != "") LIMIT 1';
        $result = $this->conn->query($sql);

        try{
            
            $data = $result->fetch_assoc();
            return $data;
        }catch (\Throwable $th){
            return false;
        }
    }

    public function findCodeDesembarqueByName($registro)
    {
        $sql = 'SELECT id,codigo_lugar_desembarque  FROM envios WHERE ( nombre_lugar_desembarque = "'.$registro['nombre_lugar_desembarque'].'" and codigo_lugar_desembarque != "") LIMIT 1';
        $result = $this->conn->query($sql);

        try{
            
            $data = $result->fetch_assoc();
            return $data;
        }catch (\Throwable $th){
            return false;
        }
    }

    public function findCodeTransportistaByName($registro)
    {
        $sql = 'SELECT id,codigo_transportista  FROM envios WHERE ( nombre_transportista = "'.$registro['nombre_transportista'].'" and codigo_transportista != "") LIMIT 1';
        $result = $this->conn->query($sql);

        try{
            
            $data = $result->fetch_assoc();
            return $data;
        }catch (\Throwable $th){
            return false;
        }
    }

    public function findCodeExportadorByName($registro)
    {
        $sql = 'SELECT id,codigo_exportador  FROM envios WHERE (nombre_exportador = "'.$registro['nombre_exportador'].'" and codigo_exportador != "") LIMIT 1';
        $result = $this->conn->query($sql);

        try{
            
            $data = $result->fetch_assoc();
            return $data;
        }catch (\Throwable $th){
            return false;
        }
    }

    public function findCodeConsignatarioByName($registro)
    {
        $sql = 'SELECT id,codigo_consignatario  FROM envios WHERE (nombre_consignatario = "'.$registro['nombre_consignatario'].'" and codigo_consignatario != "") LIMIT 1';
        $result = $this->conn->query($sql);

        try{
            
            $data = $result->fetch_assoc();
            return $data;
        }catch (\Throwable $th){
            return false;
        }
    }

    public function findCodeEmbalajeByName($registro)
    {
        $sql = 'SELECT id,codigo_embalaje  FROM envios WHERE (nombre_embalaje = "'.$registro['nombre_embalaje'].'" and codigo_embalaje != "") LIMIT 1';
        $result = $this->conn->query($sql);

        try{
            
            $data = $result->fetch_assoc();
            return $data;
        }catch (\Throwable $th){
            return false;
        }
    }

    public function findCodeLocalizacionByName($registro)
    {
        $sql = 'SELECT id,codigo_localizacion  FROM envios WHERE nombre_localizacion = "'.$registro['nombre_localizacion'].'" LIMIT 1';
        $result = $this->conn->query($sql);

        try{
            
            $data = $result->fetch_assoc();
            return $data;
        }catch (\Throwable $th){
            return false;
        }
    }


    

    
}