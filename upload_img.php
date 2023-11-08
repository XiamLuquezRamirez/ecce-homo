<?php

session_start();

include("Conectar.php");

$success = 1;
$error = "";
$link = conectar();
mysqli_query("BEGIN");

$ruta = 'galerias/' . $_SESSION['ses_nomgal'] . '/'; //Decalaramos una variable con la ruta en donde almacenaremos los archivos

$mensage = ''; //Declaramos una variable mensaje quue almacenara el resultado de las operaciones.

foreach ($_FILES as $key) { //Iteramos el arreglo de archivos
    $prefijo = substr(md5(uniqid(rand())), 0, 6);
    
    if ($key['error'] == UPLOAD_ERR_OK) {//Si el archivo se paso correctamente Ccontinuamos 
        $NombreOriginal = $key['name']; //Obtenemos el nombre original del archivo
        $temporal = $key['tmp_name']; //Obtenemos la ruta Original del archivo
        $nomArchi = $prefijo . '_' . sanear_string($NombreOriginal);
        $Destino = $ruta . $nomArchi; //Creamos una ruta de destino con la variable ruta y el nombre original del archivo	
       
        move_uploaded_file($temporal, $Destino); //Movemos el archivo temporal a la ruta especificada	

        $consulta = "INSERT INTO imagenes VALUES(null,'" . $_SESSION['ses_idgal']  . "','" . $nomArchi . "')";
        $qc = mysqli_query($link,$consulta);

        if (($qc == false) || (mysqli_affected_rows($link) == -1) || mysqli_errno($link) != 0) {
            $success = 0;
            $error = 1;
        }
    }

    if ($key['error'] == '') { //Si no existio ningun error, retornamos un mensaje por cada archivo subido
        $mensage .= '-> Archivo <b>' . $nomArchi . '</b> Subido correctamente. <br>';
    }
    if ($key['error'] != '') {//Si existio algún error retornamos un el error por cada archivo.
        $mensage .= '-> No se pudo subir el archivo <b>' . $nomArchi . '</b> debido al siguiente Error: n' . $key['error'];
    }
}
if ($success == 0) {
    mysqli_query("ROLLBACK");
    echo $error;
    echo $consulta;
} else {
    mysqli_query("COMMIT");
    //echo "bien";
}

mysqli_close();
echo $mensage; // Regresamos los mensajes generados al cliente

function sanear_string($string) {

    $string = trim($string);

    $string = str_replace(
            array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'), array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'), $string
    );

    $string = str_replace(
            array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'), array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'), $string
    );

    $string = str_replace(
            array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'), array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'), $string
    );

    $string = str_replace(
            array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'), array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'), $string
    );

    $string = str_replace(
            array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'), array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'), $string
    );

    $string = str_replace(
            array('ñ', 'Ñ', 'ç', 'Ç'), array('n', 'N', 'c', 'C',), $string
    );

    //Esta parte se encarga de eliminar cualquier caracter extraño
    $string = str_replace(
            array("¨", "º", "-", "~", "", "@", "|", "!",
        "·", "$", "%", "&", "/",
        "(", ")", "?", "'", " h¡",
        "¿", "[", "^", "<code>", "]",
        "+", "}", "{", "¨", "´",
        ">", "< ", ";", ",", ":",
        " "), '', $string
    );


    return $string;
}

?>