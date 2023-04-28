<?php

class TransportistaModel 
{

    private $conn;

    public function __construct()
    {
        
        $bd = new Conexion();
        $this->conn = $bd->getConn();
    }


    public function findCodeByName($registro)
    {
        $sql = 'SELECT * FROM transportistas WHERE ( nombre = "'.$registro['nombre_transportista'].'") LIMIT 1';
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
        $sql = 'SELECT * FROM transportistas WHERE ( codigo = "'.$registro['codigo_transportista'].'") LIMIT 1';
        $result = $this->conn->query($sql);

        try{
            
            $data = $result->fetch_assoc();
            return $data;
        }catch (\Throwable $th){
            return false;
        }
    }


    

    
}