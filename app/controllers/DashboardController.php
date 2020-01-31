<?php 

class DashboardController extends Controller
{

    public function index()
    {
        $this->isAuth('home',true);

        $this->view('dashboard');


    }


}