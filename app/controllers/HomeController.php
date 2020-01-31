<?php 

class HomeController extends Controller
{

    public function index()
    {
        $this->isAuth('dashboard');


        $FormValidation = $this->formValidation();
        $data['csrf'] = $FormValidation->GenerateCSRFToken();
            
        if(isset($_POST['submitLogin']) && $FormValidation->CheckCSRFToken($_POST['token']))
        {
            
            if(!$this->handleLogin($_POST))
            {
                $data['error'] = $this->getError();
            }
        }
        
        
        $this->view('home', $data);


    }


    private function handleLogin($PostData)
    {

        //Fields Protection
        $fields = ['studentIdentityNumber', 'password', 'token', 'submitLogin'];
        $FormValidation = $this->formValidation();
        $FormValidation->fieldSet($fields);
        
        if(!$FormValidation->fieldCheck($PostData))
        {
            http_response_code(406);
            die();
        }

        //Empty Fields Validation
        if($FormValidation->isEmpty($PostData))
        {
            $EmptyField = $FormValidation->isEmpty($PostData);

            if($EmptyField == "studentIdentityNumber" || $EmptyField == "password")
            {
                $this->setError("Please type your ID and password");
            }
        }

        //Sanitaze ID

        if(!is_numeric($PostData['studentIdentityNumber']))
        {
            $this->setError("Your ID should only contain numbers");
        }
        //Check for error and auth
        if(is_null($this->getError()))
        {
            $id = trim(htmlentities($PostData['studentIdentityNumber']));
            $password = $this->model('Home')->getPassword($id);

            if(!empty($password))
            {
                $dbPass = $password[0]->student_password;

                if(password_verify($PostData['password'], $dbPass))
                {
                    $_SESSION['auth'] = $id;
                    return true;
                }
            }
            $this->setError("Id or password not match");
            return false;

        }else
        {
            return false;
        }

    }

}