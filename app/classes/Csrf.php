<?php

class Csrf{
    private $lenght = 32; // Longitud de nuestro token
    private $token; // token
    private $token_expiration; // tiempo de expiración
    private $expiration_time = 60*5; // 5 min de expiración

    // Crea nuestro token si no existe y es el primer ingreso al sistio 
    public function __construct(){
        if(!isset($_SESSION['csrf_token'])){
            $this->generate();
            $_SESSION['csrf_token'] = [
                'token' => $this->token,
                'expiration' => $this->token_expiration
            ];
            return $this;
        }
        
        $this->token = $_SESSION['csrf_token']['token'];
        $this->token_expiration = $_SESSION['csrf_token']['expiration'];
        
        return $this;
    }

    // Método para generar un nuevo token
    private function generate(){
        if(function_exists('bin2hex')){
            $this->token = bin2hex(random_bytes($this->lenght));
        } elseif(function_exists('mcrypt_create_iv')){
            $this->token = bin2hex(mcrypt_create_iv($this->lenght, MCRYPT_DEV_URANDOM));       
        } else {
            $this->token = bin2hex(openssl_random_pseudo_bytes($this->lenght));
        }

        $this->token_expiration = time() + $this->expiration_time;
        return $this;
    }

    // Validar el token de la petición con el del sistema
    public static function validate($csrf_token, $validate_expiration = false){
        $self = new self();
        
        // Validando el tiempo de expiración del token 
        if($validate_expiration && $self->get_expiration() < time()){
            return false;
        }

        if($csrf_token !== $self->get_token()){
            return false;
        }

        return true;
    }

    // Método para obtener el token 
    public function get_token(){
        return $this->token;
    }

    // Método para obtener la expiración del token 
    public function get_expiration(){
        return $this->token_expiration;
    }
}