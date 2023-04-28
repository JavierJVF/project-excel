<?php

class EventModel 
{

    private $conn;

    public function __construct()
    {
        
        $bd = new Conexion();
        $this->conn = $bd->getConn();
    }

                

    public function create($registro)
    {
        $sql = 'INSERT INTO eventos (importe_id, base_inicial, tipo, empresa, miembro_wca, sector, contacto, cargo,
                        telefono1,telefono2,email,estatus_llamada,estatus_correo,fecha_envio_Correo,estatus_citas) VALUES (
            "'.$registro['excel_id'].'",
            "'.$registro['base_inicial'].'",
            "'.$registro['tipo'].'",
            "'.$registro['empresa'].'",
            "'.$registro['miembro_wca'].'",
            "'.$registro['sector'].'",
            "'.$registro['contacto'].'",
            "'.$registro['cargo'].'",
            "'.$registro['telefono1'].'",
            "'.$registro['telefono2'].'",
            "'.$registro['email'].'",
            "'.$registro['estatus_llamada'].'",
            "'.$registro['estatus_correo'].'",
            "'.$registro['fecha_envio_Correo'].'",
            "'.$registro['estatus_citas'].'"
            )';
        
        
        $result = $this->conn->query($sql);
        
        if($result) return [mysqli_insert_id($this->conn),'successs'];
        else return [false,mysqli_error($this->conn)];
    }

    public function findEventByAllParams($registro)
    {
        $sql = 'SELECT *  FROM eventos WHERE (
            base_inicial = "'.$registro['base_inicial'].'" and 
            tipo = "'.$registro['tipo'].'" and 
            empresa = "'.$registro['empresa'].'" and 
            miembro_wca = "'.$registro['miembro_wca'].'" and 
            sector = "'.$registro['sector'].'" and 
            contacto = "'.$registro['contacto'].'" and 
            cargo = "'.$registro['cargo'].'" and 
            telefono1 = "'.$registro['telefono1'].'" and 
            telefono2 = "'.$registro['telefono2'].'" and 
            email = "'.$registro['email'].'" and 
            estatus_llamada = "'.$registro['estatus_llamada'].'" and 
            estatus_correo = "'.$registro['estatus_correo'].'" and 
            fecha_envio_Correo = "'.$registro['fecha_envio_Correo'].'" and 
            estatus_citas = "'.$registro['estatus_citas'].'") LIMIT 1';
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