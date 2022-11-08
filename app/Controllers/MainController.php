<?php

namespace App\Controllers;

class MainController extends CoreController
{
    public function home()
    {
        $this->render('home');
    }

    public function contact()
    {
        $this->render('contact');
    }
}