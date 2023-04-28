<?php

class EmbarqueModel 
{

    private $conn;

    public function __construct()
    {
        
        $bd = new Conexion();
        $this->conn = $bd->getConn();
    }


    public function findCodeByName($registro)
    {
        $sql = 'SELECT * FROM embarques WHERE ( lugar = "'.$registro['nombre_lugar_embarque'].'") LIMIT 1';
        
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
        $sql = 'SELECT * FROM embarques WHERE ( codigo = "'.$registro['codigo_lugar_embarque'].'") LIMIT 1';
        
        $result = $this->conn->query($sql);

        try{
            
            $data = $result->fetch_assoc();
            return $data;
        }catch (\Throwable $th){
            return false;
        }
    }


    

    
}