<?php

class ExportadorModel 
{

    private $conn;

    public function __construct()
    {
        
        $bd = new Conexion();
        $this->conn = $bd->getConn();
    }


    public function findCodeByName($registro)
    {
        $sql = 'SELECT * FROM exportadores WHERE ( nombre = "'.$registro['nombre_exportador'].'") LIMIT 1';
        $result = $this->conn->query($sql);

        try{
            
            $data = $result->fetch_assoc();
            return $data;
        }catch (\Throwable $th){
            return false;
        }
    }

    public function findByCode($registro)
    {
        $sql = 'SELECT * FROM exportadores WHERE ( codigo = "'.$registro['codigo_exportador'].'") LIMIT 1';
        $result = $this->conn->query($sql);

        try{
            
            $data = $result->fetch_assoc();
            return $data;
        }catch (\Throwable $th){
            return false;
        }
    }


    

    
}