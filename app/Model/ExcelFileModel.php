<?php

class ExcelFileModel 
{

    private $conn;

    public function __construct()
    {
        
        $bd = new Conexion();
        $this->conn = $bd->getConn();
    }

    public function create($excel)
    {
        $sql = 'INSERT INTO importes (excel_dir,name,excel_name,tipo, log_dir) VALUES (
            "'.$excel['excel_dir'].'",
            "'.$excel['nameImport'].'",
            "'.$excel['excel_name'].'",
            "'.$excel['type_import'].'",
            "'.$excel['log_dir'].'"
            )';
        
        $result = $this->conn->query($sql);
        
        if($result) return mysqli_insert_id($this->conn);
        else return false;
    }

    
}