<?php

class conection {
    private $server;
    private $user;
    private $password;
    private $database;
    private $port;
    private $conection;

    function __construct(){
        $listadatos = $this->dataConection();

        foreach ($listadatos as $key => $value) {
            $this->server = $value['server'];
            $this->user = $value['user'];
            $this->password = $value['password'];
            $this->database = $value['database'];
            $this->port = $value['port'];
        }

        $this->conection = new mysqli($this->server,$this->user,$this->password,$this->database,$this->port);

        if($this->conection->connect_errno){
            echo "algo anda mal con la conección";
            die();
        }
    }


    private function dataConection(){
        $direction = dirname(__FILE__);
        $jsondata = file_get_contents($direction . "/" . "config");
        return json_decode($jsondata, true);
    }

    private function convertUTF8($array){
        array_walk_recursive($array, function(&$item,$key){
            if(!mb_detect_encoding($item, 'utf-8', true)){
                $item = mb_convert_encoding($item, 'UTF-8', 'ISO-8859-1');
            }
        });
        return $array;
    }

    public function getData($sqlstr){
        $results = $this->conection->query($sqlstr);
        $resultArray = array();

        foreach ($results as $key) {
            $resultArray[] = $key;
        }

        return $this->convertUTF8($resultArray);
    }


    public function nonQuery($sqlstr){
        $results = $this->conection->query($sqlstr);
        return $this->conection->affected_rows;
    }

    // INSERT
    public function nonQueryId($sqlstr){
        $results = $this->conection->query($sqlstr);
        $filas = $this->conection->affected_rows;
        if($filas >= 1){
            return $this->conection->insert_id;
        }else{
            return 0;
        }
    }




}