<?php
session_start();
include "Conectar.php";

$success = 1;
$error = "";
$link = conectar();

$titulo = "";
$cementerio = "";

$sql = "SELECT  id, contrato, vigencia FROM prorroga_arriendo  ORDER BY id ASC ";

$resultado = mysqli_query($link, $sql);
$cont = "";

while ($data = mysqli_fetch_array($resultado)) {
    $consulta = "UPDATE contrato_arriendo SET hasta='" . $data['vigencia'] . "' WHERE id_arriendo='" . $data['contrato'] . "'";
    echo $consulta;
    mysqli_query($link, $consulta);
    $cont = $data['id'];
}
echo $cont;
