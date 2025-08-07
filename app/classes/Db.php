<?php

class Db {
    private $link;
    private $engine;
    private $host;
    private $name;
    private $user;
    private $pass;
    private $charset;

    /**
     * Constructor
     */
    public function __construct(){
        $this->engine = IS_LOCAL ? LDB_ENGINE : DB_ENGINE;
        $this->name = IS_LOCAL ? LDB_NAME : DB_NAME;
        $this->user = IS_LOCAL ? LDB_USER : DB_USER;
        $this->pass = IS_LOCAL ? LDB_PASS : DB_PASS;
        $this->charset = IS_LOCAL ? LDB_CHARSET : DB_CHARSET;
        return $this;
    }

    /**
     * Método para abrir una conexión a la base de datos
     */
    private function connect(){

        try {
            $this->link = new PDO($this->engine.':host='.$this->host.';dbname='.$this->name.';charset='.$this->charset, $this->user, $this->pass);
            return $this->link;
        } catch (PDOException $e) {
            die(sprintf("No hay conexión a la base de datos. Hubo un error: %s", $e->getMessage()));
        }

    }

    /**
     * Método para hacer un query a la base de datos
     */
    public static function query($sql, $params = []){
        $db = new self();
        $link = $db->connect();
        $link->beginTransaction(); // Por cualquier error, checkpoint
        $query = $link->prepare($sql);

        if(!$query->execute($params)){
            $link->rollBack();
            $error = $query->errorInfo();
            // [0] tipo de error
            // [1] código del error
            // [2] mensaje del error
            throw new Exception($error[2]);
        }


        // Manejando el tipo de query
        if(strpos($sql, 'SELECT') !== false){
            return $query->rowCount() > 0 ? $query->fetchAll() : false;
        } elseif(strpos($sql, 'INSERT') !== false){
            $id = $link->lastInsertId();
            $link->commit();
            return $id;
        } elseif(strpos($sql, 'UPDATE') !== false){
            $link->commit();
            return true;
        } elseif(strpos($sql, 'DELETE') !== false) {
            if($query->rowCount()>0){
                $link->commit();
                return true;
            }

            $link->rollBack();
            return false; //Nada ha sido borrado
        } else {
            $link->commit();
            return true;
        }

    }
}