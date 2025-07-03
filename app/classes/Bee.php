<?php

class Bee {

    // PROPIEDADES DEL FRAMEWORK 
    private $framework = 'Bee Framework';
    private $version = '1.0.0';
    private $uri = [];

    // FUNCIÓN PRINCIPAL (Se ejecuta al instanciar nuestra clase)
    function __construct(){
        $this->init();

        $this->filter_url();
        print_r($this->uri);
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
        

    }

    /**
     * Método para iniciar la sesión en el sistema
     */

     private function init_session(){
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
           require_once CLASSES.'Db.php';
           require_once CLASSES.'Model.php';
           require_once CLASSES.'Controller.php';

           return;
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

}