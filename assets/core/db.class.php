<?php
date_default_timezone_set('europe/sofia');
class DB
{
    private $user             =  "root";
    private $password         =  "";
    private $host             =  "127.0.0.1";
    private $dbname           =  "crud";


    private static $instance  =  null;
    private static $conn             =  null;

    function __construct()
    {
        try
        {
            self::$conn = new PDO('mysql:host='.$this->host.';dbname='.$this->dbname,$this->user,$this->password);
            self::$conn->exec("set names utf8");
        }
        catch(PDOException $e)
        {
            die($e);
        }
    }

    protected static function getInstance()
    {
        if(!self::$instance)
        {
            self::$instance = new self();
        }
    }

    public static function query($queryT, $params = [])
    {
        self::getInstance();

        $query = self::$conn->prepare($queryT);

        if(!empty($params))
        {
        $query->execute($params);
        } else
        {
            $query->execute();
        }
        $firstW = explode(' ',$queryT)[0];

        if(strtolower($firstW) == "select")
        {
            return $query->fetchAll(PDO::FETCH_CLASS);
        }else {
            return true;
        }

    }

}
