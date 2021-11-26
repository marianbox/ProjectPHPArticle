<?php
session_start();

//affichage des erreurs et avertissement PHP
error_reporting(E_ALL);
ini_set("display_errors", 1);


//fonction debug 
function print_r2($tab_a_afficher_print_r)
{
    echo '<pre>';
    print_r($tab_a_afficher_print_r);
    echo '</pre>';
}

function loadClass($class)
{
    if (is_file("classes/" . $class . ".class.php")) {
        require_once("classes/" . $class . ".class.php");
    }
}
spl_autoload_register("loadClass");

require_once 'config/bdd.conf.php';

require_once 'config/script.php';
require_once 'vendor/autoload.php';

if (isset($_SESSION['notification'])) {
    $result = $_SESSION['notification']['result'];
    $message = $_SESSION['notification']['message'];
    unset($_SESSION['notification']);
} else {
    $result = $message = '';
}
