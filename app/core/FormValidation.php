<?php

class FormValidation
{
    private $csrf = null;
    private $fields = [];

    public function GenerateCSRFToken()
    {
        if(empty($_SESSION['key']))
        {
            $_SESSION['key'] = bin2hex(random_bytes(32));
        }

        $this->csrf = hash_hmac('sha256', 'tokenQuery',$_SESSION['key']);
        hash_hmac('sha256', 'tokenQuery',$_SESSION['key']);
        return $this->csrf;
    }

    public function CheckCSRFToken($csrf)
    {
        if(hash_equals($this->csrf, $csrf)){
            return true;
        }
        return false;
    }

    public function fieldSet($fields)
    {
        $this->fields = $fields;
    }


    public function fieldCheck($PostRequest)
    {
        if(count($PostRequest) != count($this->fields))
        {
            return false;
        }

        foreach($PostRequest as $field => $value)
        {
            if(!in_array($field, $this->fields))
            {
                return false;
            }
        }

        return true;
    }

    public function isEmpty($PostRequest)
    {
        foreach($PostRequest as $key => $value)
        {
            if(empty($value)){
                return $key;
            }
        }

        return false;
    }

}