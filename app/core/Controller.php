<?php

class Controller {

    private $modelExt = 'Model';
    private $included = [];
    private $error = null;

    final protected function model($model){
        //Formatting
        $model      =   ucfirst(strtolower($model));
        $modelExt   =   $model.$this->modelExt;
        $modelURL   =   "../app/models/".$model.".php";

        //File Check and Validation
        if( !file_exists($modelURL) )
        {
            die("Model ".$model." don't exist");
        }

        //Setting
        require_once $modelURL;
        return new $modelExt;
    }

    final protected function view($view, $data = []){
        //Formatting
        $view       =   strtolower($view);
        $viewUrl    =   "../app/views/".$view.".php";

        //File Check and Validation
        if( !file_exists($viewUrl) )
        {
            die("View ".$view." don't exist");
        }

        //Setting
        if( !empty($data) )
        {
            extract($data, EXTR_OVERWRITE);
        }
        require_once $viewUrl;
    }


    final protected function isAuth($urlRedirect = null, $reverse = null)
    {
        if(isset($_SESSION['auth']))
        {
            if(is_null($urlRedirect))
            {
                return true;
            }else
            {
                if(is_null($reverse)){
                    header("Location: ".$urlRedirect);
                    die();
                }
            }
        }else{
            if(is_null($reverse))
            {
                return false;
            }else
            {
                header("Location: ".$urlRedirect);
                die();
            }
        }
    }


    final protected function  formValidation()
    {
        if(!in_array('FormValidation',$this->included))
        {
            require_once "FormValidation.php";
            $this->included[] .= 'FormValidation';
        }

        return new FormValidation();
    }

    final protected function setError($text)
    {
        if(is_null($this->error))
        {
            $this->error = $text;
        }
    }

    final protected function getError()
    {
        return $this->error;
    }
    
}