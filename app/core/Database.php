<?php

class Database
{
    private $user             =  DB_USER;
    private $password         =  DB_PASS;
    private $host             =  DB_HOST;
    private $dbname           =  DB_NAME;

    protected $conn             =  null;

    protected function connect()
    {
        //Check from where is calling
        if(!$this->isModel()){
            die();
        }
        //Check connection and set
        if(is_null($this->conn))
        {
            
            try
            {
                $this->conn = new PDO('mysql:host='.$this->host.';dbname='.$this->dbname,$this->user,$this->password);
                $this->conn->exec("set names utf8");
            }
            catch(PDOException $e)
            {
                die($e);
            }
        }
        return $this->conn;
    }

    private function isModel(){
        //Debug
        $trace = debug_backtrace();
        
        //Check and Set
        if($trace[2]['class'] == "Model")
        {
            return true;
        }
        return false;
    }

}
