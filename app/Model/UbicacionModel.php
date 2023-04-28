<?php

class UbicacionModel 
{

    private $conn;

    public function __construct()
    {
        
        $bd = new Conexion();
        $this->conn = $bd->getConn();
    }

    public function create($excel)
    {
        $sql = 'INSERT INTO ubicaciones (code,pais,lugar) VALUES (
            "'.$excel['code'].'",
            "'.$excel['pais'].'",
            "'.$excel['loglugar_dir'].'"
            )';
        
        $result = $this->conn->query($sql);
        
        if($result) return mysqli_insert_id($this->conn);
        else return false;
    }

    public function findById()
    {
        
    }



    
}