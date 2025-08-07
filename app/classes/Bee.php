<?php

class Bee {

    // PROPIEDADES DEL FRAMEWORK 
    private $framework = 'Bee Framework';
    private $version = '1.0.0';
    private $uri = [];

    // FUNCIÓN PRINCIPAL (Se ejecuta al instanciar nuestra clase)
    function __construct(){
        $this->init();
    }

    /* 
        Método para ejecutar cada "método" de forma subsecuente 
    */
    private function init(){
        // Todos los metodos que queremos ejecutar consecutivamente 
        $this->init_session();
        $this->init_load_config();
        $this->init_load_functions();
        $this->init_autoload();
        $this->init_csrf();
        $this->dispatch();
    }

    /**
     * Método para iniciar la sesión en el sistema
     */

     private function init_session(){
        if(session_status() == PHP_SESSION_NONE){
            session_start();
        }
     }

     /**
      * Método para cargar la configuración del sistema 
      */
     private function init_load_config(){
        $file = 'bee_config.php';
        if(!is_file('app/config/'.$file)){
            die(sprintf('El archivo %s no se encuentra, es requerido para que %s funcione.', $file, $$this->framework));
        }

        require_once 'app/config/'.$file;
        return;
     }

     /**
      * Método para cargar todas las funciones core de nuestro framework (funciones del sistema y usuario)
      */
      private function init_load_functions(){
        $file = 'bee_core_functions.php';
        if(!is_file(FUNCTIONS.$file)){
            die(sprintf('El archivo %s no se encuentra, es requerido para que %s funcione.', $file, $$this->framework));
        }

        require_once FUNCTIONS.$file;

        $file = 'bee_custom_functions.php';
        if(!is_file(FUNCTIONS.$file)){
            die(sprintf('El archivo %s no se encuentra, es requerido para que %s funcione.', $file, $$this->framework));
        }

        require_once FUNCTIONS.$file;
        return;
      }

      /**
       * Método para cargar todos los archivos de forma automática 
       */

       private function init_autoload(){
           require_once CLASSES.'Autoloader.php';
           Autoloader::init();
           //require_once CLASSES.'Db.php';
           //require_once CLASSES.'Model.php';
           //require_once CLASSES.'Controller.php';
           //require_once CLASSES.'View.php';
           //require_once CONTROLLERS.DEFAULT_ERROR_CONTROLLER.'Controller.php';
           //require_once CONTROLLERS.DEFAULT_CONTROLLER.'Controller.php';

           return;
       }

       /**
        * Método para crear un nuevo token de la sesión del usuario
        */
       private function init_csrf(){
        $csrf = new Csrf();
       }

       /**
        * Método para filtrar y descomponer los elementos de nuestra URL y URI
        */

        private function filter_url(){
            if(isset($_GET['uri'])){
                $this->uri = $_GET['uri'];
                $this->uri = rtrim($this->uri,"/");
                $this->uri = filter_var($this->uri, FILTER_SANITIZE_URL);
                $this->uri = explode('/', strtolower($this->uri));

                return $this->uri; 
            }
        }

        /**
         * Método para ejecutar y cargar de forma automática el controlador solicitado por el usuario
         * su método y pasar parámtros a él.
         */
        private function dispatch(){
            // Filtrar la URL y separar la URI
            $this->filter_url();

            ///////////////////////////////////////////////////////////////////////////////
            // Necesitamos saber si se está pasando el nombre de un controlador en nuestro URI
            // $this->uri[0] es el controlador en cuestión
            if(isset($this->uri[0])){
                $current_controller = $this->uri[0];
                unset($this->uri[0]);
            } else {
                $current_controller = DEFAULT_CONTROLLER;
            }


            $controller = $current_controller.'Controller'; // homeController
            if(!class_exists($controller)){
                $controller = DEFAULT_ERROR_CONTROLLER.'Controller'; //errorController
                $current_controller = DEFAULT_ERROR_CONTROLLER;
            }

            ///////////////////////////////////////////////////////////////////////////////
            // Ejecución del método solicitado 
            if(isset($this->uri[1])){
                $method = str_replace('-','_', $this->uri[1]);
                
                // Existe o no el métood dentro de la clase a ejecutar (controlador)
                if(!method_exists($controller, $method)){
                    $controller = DEFAULT_ERROR_CONTROLLER.'Controller'; //errorController
                    $current_controller = DEFAULT_ERROR_CONTROLLER;
                    $current_method = DEFAULT_METHOD; // index
                } else {
                    $current_method = $method;
                }

                unset($this->uri[1]);
            } else {
                $current_method = DEFAULT_METHOD; // index
            }

            ///////////////////////////////////////////////////////////////////////////////
            // Creando constantes para utilizar más adelante

            define('CONTROLLER', $current_controller);
            define('METHOD'    , $current_method);


            ///////////////////////////////////////////////////////////////////////////////
            // Ejecutando controlador y método según sea la petición.
            $controller = new $controller;

            // Obteniendo los parámetros de la URI
            $params = array_values(empty($this->uri) ? [] : $this->uri);

            // Llamada al método que solicita el usuario en curso 
            if(empty($params)) {
                call_user_func([$controller, $current_method]);
            } else {
                call_user_func_array([$controller, $current_method], $params);
            }

            /* 
            print_r($this->uri);
            echo $current_controller . ' / ';
            echo $current_method; */
        }
        
        /**
         * Corre el framework
         */
        public static function fly(){
            $bee = new self();
            return;
        }
}