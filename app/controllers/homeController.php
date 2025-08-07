<?php

class homeController extends Controller{
    function __construct(){
        
    }

    function index(){
        $token_peticion = '82ef7e4c06b8e86771ca68a4dab399fa1d3d68c37178ef132a0a2b1b838a6f41';
        echo $_SESSION['csrf_token']['token'] . "<br>";
        echo $token_peticion . "<br>";

        if(Csrf::validate($token_peticion)){
            echo 'valido';
        } else {
            echo 'No valido';
        }
        die;

        $data = ['title' => 'BeeFramework', 'bg'=>'dark'];
        View::render('bee', $data);
    }

    function test(){
        
        echo '<pre>';
        echo '</pre>';
        //View::render('test');
    }

    function flash(){
        Flasher::new("Hola mundo, soy una notificacion");
        Flasher::new("Hola mundo, soy una notificacion", "danger");
        Flasher::new("Hola mundo, soy una notificacion", "warning");
        Flasher::new("Hola mundo, soy una notificacion", "secondary");
        
        View::render('flash');
    }
}