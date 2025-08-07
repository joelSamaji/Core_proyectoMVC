<?php

// Convertir un arreglo en objeto
function to_object($array){
    return json_decode(json_encode($array));
}

// Regresa el nombre del framework
function get_sitname() {
    return "Bee framework";
}

function now() {
    return date('Y-m-d H:i:s');
}