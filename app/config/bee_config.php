<?php 

// Saber si estamos trabajando de forma local o remota
define('IS_LOCAL', in_array($_SERVER['REMOTE_ADDR'], ['127.0.0.1','::1']));

// Definir el uso horario del sistema
date_default_timezone_set('America/Mexico_City');

// Lenguaje 
define('LANG', 'es');

// Ruta base del proyecto 
define('BASEPATH', IS_LOCAL ? '/MVC/P01/' : '____EL BASEPATH EN PRODUCCIÓN___');

// Sal del sistema
define('AUTH_SALT', 'BeeFramewotk<3');

// Puerto y la URL del sitio 
define('PORT', '80');
define('URL', IS_LOCAL ? 'http://127.0.0.1:'.PORT."/MVC/P01/" : "___URL EN PRODUCCION___");

// Rutas de directorios y archivos 
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', getcwd().DS);

define('APP', ROOT.'app'.DS);
define('CLASSES', APP.'classes'.DS);
define('CONFIG', APP.'config'.DS);
define('CONTROLLERS', APP.'controllers'.DS);
define('FUNCTIONS', APP.'functions'.DS);
define('MODELS', APP.'models'.DS);

define('TEMPLATES', ROOT.'templates'.DS);
define('INCLUDES', TEMPLATES.'includes'.DS);
define('MODULES', TEMPLATES.'modules'.DS);
define('VIEWS', TEMPLATES.'views'.DS);

define('ASSETS', URL.'assets/');
define('CSS', ASSETS.'css/');
define('FAVICON', ASSETS.'favicon/');
define('FONTS', ASSETS.'fonts/');
define('IMAGES', ASSETS.'images/');
define('JS', ASSETS.'js/');
define('PLUGINS', ASSETS.'plugins/');
define('UPLOADS', ASSETS.'uploads/');

// Credenciales de la base de datos 
// Set para conexión local o de desarrollo 
define('LDB_ENGINE', 'mysql');
define('LDB_HOST', 'localhost');
define('LDB_NAME', 'u4_p1_db');
define('LDB_USER', 'root');
define('LDB_PASS', '');
define('LDB_CHARSET', 'utf8');

// Set para conexión en producción o servidor real 
define('DB_ENGINE', 'mysql');
define('DB_HOST', 'localhost');
define('DB_NAME', '__REMOTE DB__');
define('DB_USER', '__REMOTE DB__');
define('DB_PASS', '__REMOTE DB__');
define('DB_CHARSET', '__REMOTE CHARSET__');

// El controlador por defecto / el método por defecto / y el controlador de errores por defecto 
define('DEFAULT_CONTROLLER', 'home');
define('DEFAULT_ERROR_CONTROLLER', 'error');
define('DEFAULT_METHOD', 'index');