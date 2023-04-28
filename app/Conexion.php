<?php

class Conexion
{
    private $conn;

    private $host_bd;
    private $user_bd;
    private $pass_bd;
    private $name_bd;


    public function __construct()
    {
        //local test
        $this->host_bd = 'localhost';
        $this->user_bd = 'root';
        $this->pass_bd = '';
        $this->name_bd = 'aduanabd';


        $this->conn = new mysqli(
            $this->host_bd,
            $this->user_bd,
            $this->pass_bd,
            $this->name_bd
        );
        
        if(!$this->conn) die ('Conexion error');
    }

    public function getConn()
    {
        return $this->conn;
    }
}