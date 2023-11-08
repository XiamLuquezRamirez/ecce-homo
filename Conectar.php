<?php

function conectar() {
   // $mysqli = new mysqli('127.0.0.1', 'funeraria', 'Fune12345', 'funeraria');
    $mysqli = new mysqli('localhost', 'root', 'root', 'funeroku_eccehomo');
    $mysqli->set_charset("utf8");
    return $mysqli;
}

?>