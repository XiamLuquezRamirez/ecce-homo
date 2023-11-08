<?php

require('fpdf/fpdf.php');
include("Conectar.php");
$link = conectar();


$consulta = "SELECT TK_ADMIN FROM config_empresa";
$resultado = mysqli_query($link, $consulta);
if (mysqli_num_rows($resultado) > 0) {
    while ($fila = mysqli_fetch_array($resultado)) {
        $admin = $fila['TK_ADMIN'];
    }
}


$consulta = "SELECT cl.contrato_cliente ncont, fecha_creacion fcre,pl.Nombre_plan nplan, tipo_vinculacion tvin, empresa_anterior empresa,
 empr.Nombre_empresa nempr,empr.Nit_empresa nitempr, empr.Telefono_empresa telempr, empr.Direccion_empresa diremp,
Cedula_cliente id_titu, CONCAT(Nombres_cliente,' ',Apellidos_cliente) nomb_titu,tipo_cliente tipo_cli, sexo sex_cli,correo_cliente corr, 
fecha_nacimiento fec_cli, direccion_cliente dir_cli, telefono_cliente tel_cli, Cuota_cliente cuot,(Cuota_cliente*12) vanul, Fecha_ingreso_cliente fingr,asesor
 FROM cliente cl LEFT JOIN plan pl ON cl.idPlan_cliente=pl.idPlan 
LEFT JOIN empresa empr ON cl.idEmpresa_cliente=empr.idEmpresa  
WHERE idCliente='" . $_REQUEST["id"] . "'";
//echo $consulta;
$resultado = mysqli_query($link, $consulta);
if (mysqli_num_rows($resultado) > 0) {
    while ($fila = mysqli_fetch_array($resultado)) {
        $ncontrato = $fila["ncont"];
        $fecha_cre = $fila["fcre"];
        $ciudad = "VALLEDUPAR";
        $depar = "CESAR";
        $plan = $fila["nplan"];
        $tipo_vinc = $fila["tvin"];
        $empresa = acentos($fila["empresa"]);
        $id_titu = $fila["id_titu"];
        $nomb_titu = acentos($fila["nomb_titu"]);
        $tipo_cli = $fila["tipo_cli"];
        $sex_cli = $fila["sex_cli"];
        $fec_cli = $fila["fec_cli"];
        $dir_cli = acentos($fila["dir_cli"]);
        $tel_cli = $fila["tel_cli"];
//        $dir_recau = acentos($fila["dir_recau"]);
//        $otr_dir = acentos($fila["otr_dir"]);
//        $id_emple = $fila["id_emple"];
        $nom_emple = acentos($fila["nempr"]);
        $nitempresa = $fila["nitempr"];
        $dir_emple = acentos($fila["diremp"]);
        $tel_emple = $fila["telempr"];
//        $email_cli = acentos($fila["email_cli"]);
        $ciud_emple = "VALLEDUPAR";
        $depar_emple = "CESAR";
     
        $val_anual = number_format($fila["vanul"], 2, ",", ".");
        $val_mes = number_format($fila["cuot"], 2, ",", ".");
        $form_pago = "MENSUAL";
        $fech_ini = $fila["fingr"];
        $asesor = acentos($fila["asesor"]);

       
    }
}


$vini = "";
$vren = "";
$vtra = "";


if ($tipo_vinc == "INICIAL") {
    $vini = "X";
}
if ($tipo_vinc == "RENOVACION") {
    $vren = "X";
}
if ($tipo_vinc == "TRASLADO") {
    $vtra = "X";
}

$pdio = "";
$pfam = "";
$pdor = "";


if ($plan == "DIOCESANO") {
    $pdio = "X";
}
if ($plan == "FAMILIA INTEGRAL") {
    $pfam = "X";
}
if ($plan == "DORADO") {
    $pdor = "X";
}


$tcdep = "";
$tcind = "";
$tccoo = "";


if ($tipo_cli == "DEPENDIENTE") {
    $tcdep = "X";
}
if ($tipo_cli == "INDEPENDIENTE") {
    $tcind = "X";
}
if ($tipo_cli == "COOPERADO") {
    $tccoo = "X";
}


$sem = "";
$sef = "";
if ($sex_cli == "MASCULINO") {
    $sem = "x";
}
if ($sex_cli == "FEMENINO") {
    $sef = "x";
}

//$drs = "";
//$dot = "";
//if ($dir_recau == "RESIDENCIA") {
//    $drs = "x";
//}
//if ($dir_recau == "OTRA") {
//    $dot = "x";
//}

class PDF extends FPDF {

    //Cabecera de página
    function Header() {
        $this->Image('Img/cabecera_pdf.png', 10, 8, 100);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(100, 25, '', 1, 0, 'C');
        $this->cell(0, 25, utf8_decode(''), 1, 2, 'C');
        $this->SetXY(110, 9);
        $this->cell(0, 25, utf8_decode('CONTRATO DE PREVISIÓN'), 0, 2, 'C');
        $this->SetXY(110, 14);
        $this->cell(0, 25, utf8_decode('ANUAL EXEQUIAL - P.A.E.E'), 0, 2, 'C');
    }

    function TablaBasica() {
        $this->SetFont('Arial', 'B', 10);
        //*****
        $this->SetXY(110, 37);
        $this->Cell(30, 5, 'FECHA', 1, 2, 'C');
        $this->Cell(30, 6, $GLOBALS['fecha_cre'], 1, 0, 'C');
        $this->SetXY(140, 37);
        $this->Cell(60, 5, utf8_decode(' CONTRATO'), 1, 2, 'C');
        $this->Cell(60, 6, $GLOBALS['ncontrato'], 1, 0, 'C');
        // $this->Line(10, 45.5, 200, 45.5);

        $this->SetXY(10, 37);
        $this->Cell(20, 8, 'Tipo de Cliente: ', 0, 'L');

        $this->SetFont('Arial', '', 9);
        $this->SetXY(10, 44);
        $this->Cell(10, 8, 'DEPENDIENTE:  ' . utf8_decode($GLOBALS['tcdep']), 0, 'L');
        $this->Line(34, 49.5, 39, 49.5);
        $this->SetXY(40, 44);
        $this->Cell(10, 8, 'INDEPENDIENTE:  ' . utf8_decode($GLOBALS['tcind']), 0, 'L');
        $this->Line(68, 49.5, 73, 49.5);
        $this->SetXY(75, 44);
        $this->Cell(10, 8, utf8_decode('COOPERADO:  ' . $GLOBALS['tccoo']), 0, 'L');
        $this->Line(98, 49.5, 103, 49.5);

        $this->SetXY(10, 53);
        $this->SetFont('Arial', 'B', 9);
        $this->SetFillColor(205, 205, 205); // establece el color del fondo de la celda (en este caso es AZUL
        $this->Cell(0, 5, 'DATOS DEL TITULAR', 1, 2, 'L', True); // en orden lo que informan estos parametros es:



        $this->SetFont('Arial', 'B', 7);
        $this->SetXY(10, 57);
        $this->Cell(30, 8, utf8_decode('Identificación.'), 0, 'L');
        $this->SetXY(10, 61);
        $this->SetFont('Arial', '', 9);
        $this->Cell(30, 8, utf8_decode($GLOBALS['id_titu']), 0, 'L');
        $this->SetXY(55, 57);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(70, 8, utf8_decode('Nombre.'), 0, 'L');
        $this->SetFont('Arial', '', 9);
        $this->SetXY(55, 61);
        $this->Cell(70, 8, utf8_decode($GLOBALS['nomb_titu']), 0, 'L');
        $this->SetXY(150, 57);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(50, 8, utf8_decode('Fecha Nacimiento.'), 0, 'L');
        $this->SetFont('Arial', '', 9);
        $this->SetXY(150, 61);
        $this->Cell(50, 8, utf8_decode($GLOBALS['fec_cli']), 0, 'L');
        $this->SetXY(185, 57);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(30, 8, utf8_decode('Sexo.'), 0, 'L');
        $this->SetXY(185, 61);
        $this->SetFont('Arial', '', 9);
        $this->Cell(30, 8, utf8_decode('M ' . $GLOBALS['sem'] . '  F ' . $GLOBALS['sef'] . ''), 0, 'L');
        $this->Line(189, 66.5, 192, 66.5);
        $this->Line(195, 66.5, 198, 66.5);
        $this->Line(10, 67.5, 200, 67.5);

        //*****
        $this->SetXY(10, 66);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(100, 8, utf8_decode('Dirección.'), 0, 0, 'L');
        $this->SetXY(10, 70);
        $this->SetFont('Arial', '', 9);
        $this->Cell(100, 8, utf8_decode($GLOBALS['dir_cli']), 0, 0, 'L');

        $this->SetXY(100, 66);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(20, 8, utf8_decode('Ciudad.'), 0, 1, 'L');
        $this->SetXY(100, 70);
        $this->SetFont('Arial', '', 9);
        $this->Cell(20, 8, utf8_decode($GLOBALS['ciudad']), 0, 1, 'L');

        $this->SetXY(140, 66);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(20, 8, utf8_decode('Departamento.'), 0, 1, 'L');
        $this->SetXY(140, 70);
        $this->SetFont('Arial', '', 9);
        $this->Cell(20, 8, utf8_decode($GLOBALS['depar']), 0, 1, 'L');

        $this->SetXY(175, 66);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(20, 8, utf8_decode('Teléfono.'), 0, 1, 'L');
        $this->SetXY(175, 70);
        $this->SetFont('Arial', '', 9);
        $this->Cell(20, 8, utf8_decode($GLOBALS['tel_cli']), 0, 1, 'L');

        $this->Line(10, 76.5, 200, 76.5);

        //*****
//        $this->SetXY(10, 75);
//        $this->SetFont('Arial', 'B', 7);
//        $this->Cell(100, 8, utf8_decode('E-Mail.'), 0, 0, 'L');
//        $this->SetXY(10, 79);
//        $this->SetFont('Arial', '', 9);
//        $this->Cell(100, 8, utf8_decode($GLOBALS['email_cli']), 0, 0, 'L');
//        $this->SetXY(100, 75);
//        $this->SetFont('Arial', 'B', 7);
//        $this->Cell(20, 8, utf8_decode('Dirección de Recaudo para Independientes: Residencia ' . $GLOBALS['drs'] . '     Otras ' . $GLOBALS['dot'] . '  '), 0, 1, 'L');
//        $this->Line(166, 80, 170, 80);
//        $this->Line(178, 80, 182, 80);
//        $this->SetXY(100, 79);
//        $this->SetFont('Arial', '', 9);
//        $this->Cell(20, 8, utf8_decode('Cual: ' . $GLOBALS['otr_dir']), 0, 1, 'L');

        $this->Line(10, 85.5, 200, 85.5);
        //*****
        $this->SetXY(10, 84);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(100, 8, utf8_decode('Plan de prevención anual exequial.'), 0, 0, 'L');
        $this->SetXY(10, 88);
        $this->SetFont('Arial', '', 9);
        $this->Cell(100, 8, utf8_decode($GLOBALS['plan']), 0, 0, 'L');
        $this->Line(10, 94, 84, 94);

        $this->SetXY(87, 84);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(100, 8, utf8_decode('Tipo de vinculación.'), 0, 0, 'L');
        $this->SetXY(87, 88);
        $this->SetFont('Arial', '', 9);
        $this->Cell(100, 8, utf8_decode('Inicial  ' . $GLOBALS['pdio'] . '       Renovación  ' . $GLOBALS['pfam'] . '        Traslado  ' . $GLOBALS['pdor'] . ''), 0, 0, 'L');
        $this->Line(96, 93, 104, 93);
        $this->Line(123, 93, 130, 93);
        $this->Line(144, 93, 150, 93);

        $this->SetXY(152, 84);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(100, 8, utf8_decode('Empresa Anterior.'), 0, 0, 'L');
        $this->SetXY(152, 88);
        $this->SetFont('Arial', '', 9);
        $this->Cell(100, 8, utf8_decode($GLOBALS['empresa']), 0, 0, 'L');

        //  $this->Line(10, 94.5, 200, 94.5);

        $this->SetXY(10, 96);
        $this->SetFont('Arial', 'B', 9);
        $this->SetFillColor(205, 205, 205); // establece el color del fondo de la celda (en este caso es AZUL
        $this->Cell(0, 5, utf8_decode('DATOS EMPLEADOR/AGREMIACIÓN O ASOCIACIÓN(INDEPENDIENTE CON AFILIACIÓN COLETIVA O COOPERADO)'), 1, 2, 'L', True); // en orden lo que informan estos parametros es:


        $this->SetFont('Arial', 'B', 7);
        $this->SetXY(10, 100);
        $this->Cell(30, 8, utf8_decode('NIT.'), 0, 'L');
        $this->SetXY(10, 104);
        $this->SetFont('Arial', '', 9);
        $this->Cell(30, 8, utf8_decode($GLOBALS['nitempresa']), 0, 'L');
        $this->SetXY(55, 100);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(70, 8, utf8_decode('Nombre o Razón Social del Empleador.'), 0, 'L');
        $this->SetFont('Arial', '', 9);
        $this->SetXY(55, 104);
        $this->Cell(0, 8, utf8_decode($GLOBALS['nom_emple']), 0, 'L');

        $this->Line(10, 110.5, 200, 110.5);
        //*****
        $this->SetXY(10, 109);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(100, 8, utf8_decode('Dirección donde se genera la nomina de la empresa.'), 0, 0, 'L');
        $this->SetXY(10, 113);
        $this->SetFont('Arial', '', 9);
        $this->Cell(100, 8, utf8_decode($GLOBALS['dir_emple']), 0, 0, 'L');

        $this->SetXY(100, 109);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(20, 8, utf8_decode('Ciudad.'), 0, 1, 'L');
        $this->SetXY(100, 113);
        $this->SetFont('Arial', '', 9);
        $this->Cell(20, 8, utf8_decode($GLOBALS['ciud_emple']), 0, 1, 'L');

        $this->SetXY(140, 109);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(20, 8, utf8_decode('Departamento.'), 0, 1, 'L');
        $this->SetXY(140, 113);
        $this->SetFont('Arial', '', 9);
        $this->Cell(20, 8, utf8_decode($GLOBALS['depar_emple']), 0, 1, 'L');

        $this->SetXY(175, 109);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(20, 8, utf8_decode('Teléfono.'), 0, 1, 'L');
        $this->SetXY(175, 113);
        $this->SetFont('Arial', '', 9);
        $this->Cell(20, 8, utf8_decode($GLOBALS['tel_emple']), 0, 1, 'L');
    }

    function TablaGrupos() {


        $this->SetXY(10, 120);
        $this->SetFont('Arial', 'B', 9);
        $this->SetFillColor(205, 205, 205); // establece el color del fondo de la celda (en este caso es AZUL
        $this->Cell(0, 5, utf8_decode('NUCLEO FAMILIAR REPORTADO'), 1, 2, 'C', True); // en orden lo que informan estos parametros es:
        // $this->Line(10, 120.5, 200, 120.5);
        $this->Ln(1);
        $this->SetFont('Arial', 'B', 8);
        $this->SetFillColor(205, 205, 205);
        $this->Cell(5, 8, '#', 0, 0, 'L', True);
        $this->Cell(20, 8, utf8_decode('Indentifición.'), 0, 0, 'L', True);
        $this->Cell(70, 8, utf8_decode('Nombre'), 0, 0, 'L', True);
        $this->Cell(25, 8, utf8_decode('Parentesco.'), 0, 0, 'L', True);
        $this->Cell(25, 8, 'Estado Salud', 0, 0, 'L', True);
        $this->Cell(10, 8, 'Edad', 0, 0, 'C', True);
        $this->Cell(0, 8, 'Ciudad', 0, 0, 'L', True);
        //$this->Line(10, 120.5, 200, 120.5);

        $consulta = "SELECT * FROM  beneficiario WHERE idCliente_beneficiario='" . $_REQUEST["id"] . "' and tipo_benefi='basico'";
        //echo $consulta;
        $item = 0;
        $resultado = mysqli_query($GLOBALS['link'], $consulta);
        $Y = 135;

        $this->SetFont('Arial', '', 7);
        if (mysqli_num_rows($resultado) > 0) {
            while ($fila = mysqli_fetch_array($resultado)) {
                $this->SetXY(10, $Y);
                $item = $item + 1;
                $this->Cell(5, 5, $item, 0);
                $this->Cell(20, 5, $fila['idBeneficiario'], 0);
                $this->MultiCell(70, 5, utf8_decode(acentos($fila['nombre_beneficiario'] . " " . $fila['apellido_beneficiario'])), 0);
                $H = $this->GetY();
                $height = $H - $Y;
                $this->SetXY(105, $Y);
                $this->Cell(25, $height, utf8_decode(acentos($fila['parentesco_beneficiario'])), 0, 0);
                $this->SetXY(130, $Y);
                $this->Cell(25, $height, utf8_decode($fila['estado_beneficiario']), 0);
                $this->SetXY(155, $Y);
                $this->Cell(10, $height, utf8_decode($fila['edad_beneficiario']), 0, 0, 'C');
                $this->SetXY(165, $Y);
                $this->Cell(0, $height, utf8_decode(acentos($fila['ciudad_beneficiario'])), 0);
                $this->Ln(7);

                $Y = $H;
            }
        }


        $Y = $this->GetY();

        //GRUPO SECUNDARIO
        $this->SetXY(10, $Y + 2);
        $this->SetFont('Arial', 'B', 9);
        $this->SetFillColor(205, 205, 205); // establece el color del fondo de la celda (en este caso es AZUL
        $this->Cell(0, 5, utf8_decode('NUCLEO FAMILIAR SECUNDADIO Y/O ADICIONALES'), 1, 2, 'C', True); // en orden lo que informan estos parametros es:
        // $this->Line(10, 120.5, 200, 120.5);
        $this->Ln(1);
        $this->SetFont('Arial', 'B', 8);
        $this->SetFillColor(205, 205, 205);
        $this->Cell(5, 8, '#', 0, 0, 'L', True);
        $this->Cell(20, 8, utf8_decode('Indentifición.'), 0, 0, 'L', True);
        $this->Cell(70, 8, utf8_decode('Nombre'), 0, 0, 'L', True);
        $this->Cell(25, 8, utf8_decode('Parentesco.'), 0, 0, 'L', True);
        $this->Cell(25, 8, 'Estado Salud', 0, 0, 'L', True);
        $this->Cell(10, 8, 'Edad', 0, 0, 'C', True);
        $this->Cell(0, 8, 'Ciudad', 0, 0, 'L', True);
        //$this->Line(10, 120.5, 200, 120.5);

        $consulta = "SELECT * FROM  beneficiario WHERE idCliente_beneficiario='" . $_REQUEST["id"] . "' and tipo_benefi='secundario'";
        //echo $consulta;
        $item = 0;
        $resultado = mysqli_query($GLOBALS['link'], $consulta);
        $Y = $Y + 17;

        $this->SetFont('Arial', '', 7);
        if (mysqli_num_rows($resultado) > 0) {
            while ($fila = mysqli_fetch_array($resultado)) {
                $this->SetXY(10, $Y);
                $item = $item + 1;
                $this->Cell(5, 5, $item, 0);
                $this->Cell(20, 5, $fila['idBeneficiario'], 0);
                $this->MultiCell(70, 5, utf8_decode(acentos($fila['nombre_beneficiario'] . " " . $fila['apellido_beneficiario'])), 0);
                $H = $this->GetY();
                $height = $H - $Y;
                $this->SetXY(105, $Y);
                $this->Cell(25, $height, utf8_decode(acentos($fila['parentesco_beneficiario'])), 0, 0);
                $this->SetXY(130, $Y);
                $this->Cell(25, $height, utf8_decode($fila['estado_beneficiario']), 0);
                $this->SetXY(155, $Y);
                $this->Cell(10, $height, utf8_decode($fila['edad_beneficiario']), 0, 0, 'C');
                $this->SetXY(165, $Y);
                $this->Cell(0, $height, utf8_decode($fila['ciudad_beneficiario']), 0);
                $this->Ln(7);

                $Y = $H;
            }
        }
    }

    function TablaInfPag() {

        $Y = $this->GetY();

        $this->SetXY(10, $Y);
        $this->SetFont('Arial', 'B', 9);
        $this->SetFillColor(205, 205, 205); // establece el color del fondo de la celda (en este caso es AZUL
        $this->Cell(0, 5, utf8_decode('FOMRA DE PAGO'), 1, 2, 'L', True); // en orden lo que informan estos parametros es:

        $this->SetXY(10, $Y + 4);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(40, 8, utf8_decode('Valor Anual/Previsión.'), 0, 0, 'L');
        $this->SetXY(10, $Y + 8);
        $this->SetFont('Arial', '', 9);
        $this->Cell(40, 8, '$ ' . utf8_decode($GLOBALS['val_anual']), 0, 0, 'L');

        $this->SetXY(55, $Y + 4);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(20, 8, utf8_decode('Valor Cuota Mes.'), 0, 1, 'L');
        $this->SetXY(55, $Y + 8);
        $this->SetFont('Arial', '', 9);
        $this->Cell(20, 8, '$ ' . utf8_decode($GLOBALS['val_mes']), 0, 1, 'L');

        $this->SetXY(100, $Y + 4);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(20, 8, utf8_decode('Forma de Pago.'), 0, 1, 'L');
        $this->SetXY(100, $Y + 8);
        $this->SetFont('Arial', '', 9);
        $this->Cell(20, 8, utf8_decode($GLOBALS['form_pago']), 0, 1, 'L');

        $this->SetXY(130, $Y + 4);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(20, 8, utf8_decode('A Partir De.'), 0, 1, 'L');
        $this->SetXY(130, $Y + 8);
        $this->SetFont('Arial', '', 9);
        $this->Cell(20, 8, utf8_decode($GLOBALS['fech_ini']), 0, 1, 'L');

        $this->SetXY(150, $Y + 4);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(20, 8, utf8_decode('Asesor.'), 0, 1, 'L');
        $this->SetXY(150, $Y + 8);
        $this->SetFont('Arial', '', 9);
        $this->Cell(20, 8, utf8_decode($GLOBALS['asesor']), 0, 1, 'L');

        $this->Line(10, $Y + 15, 200, $Y + 15);


        $y = $this->GetY();
        $this->SetXY(10, $y + 3);
        $this->Cell(100, 35, utf8_decode(''), 1, 0, 'C');
        $this->Cell(0, 35, utf8_decode(''), 1, 0, 'C');
        $this->SetXY(10, $y + 4);
        $this->SetFont('Arial', '', 5);
        $this->MultiCell(100, 2, utf8_decode('Declaro expresamente la acepatación y conformidad con los datos relacionados y los términosdel presente contrato.'
                        . 'Autorizo al departamento de nómina descontar de mi salario las cuotas correspondientes, para obteer los veneficios del Plan Excequial de la'
                        . 'entidad contratante, así como renovación automática e incremento anual del valor conforme a las nuevas tarifas en señal de ello firmo el presente contrato.'), 0, 'J', False);
        $this->SetFont('Arial', 'B', 8);
        $this->SetXY(10, $y + 30);
        $this->Cell(10, 3, utf8_decode('Firma del Titular:'), 0, 2, 'L');
        $this->Cell(10, 3, utf8_decode('Doc. Identidad:'), 0, 0, 'L');
        $this->Line(35, $Y + 48.3, 90, $Y + 48.3);

        $this->SetXY(110, $y + 4);
        $this->SetFont('Arial', '', 5);
        $this->MultiCell(90, 2, utf8_decode('Declaro que los datos suministrados por el tirular en la prsente solicitus corresponden a la información que me ha sido suministrada.'), 0, 'J', False);
        $this->SetFont('Arial', 'B', 8);
        $this->SetXY(117, $y + 33);
        $this->Cell(10, 3, utf8_decode('Firma y Sello del Representante Legal del Empleador:'), 0, 0, 'L');
        $this->Line(117, $Y + 48.3, 190, $Y + 48.3);


        $Y = $this->GetY();

        $this->SetXY(10, $Y + 8);
        $this->SetFont('Arial', 'B', 9);
        $this->SetFillColor(205, 205, 205); // establece el color del fondo de la celda (en este caso es AZUL
        $this->Cell(0, 5, utf8_decode('Para uso exclusivo de Exequiales la Esperanza'), 1, 2, 'L', True); // en orden lo que informan estos parametros es:

        $this->SetXY(10, $Y + 12);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(40, 8, utf8_decode('Revisado Por.'), 0, 0, 'L');
        $this->SetXY(10, $Y + 16);
        $this->SetFont('Arial', '', 9);
        $this->Cell(40, 8, '', 0, 0, 'L');
        $this->Line(10, $Y + 24.3, 70, $Y + 24.3);

        $this->SetXY(78, $Y + 12);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(40, 8, utf8_decode('Aprobó'), 0, 0, 'L');
        $this->SetXY(78, $Y + 16);
        $this->SetFont('Arial', '', 9);
        $this->Cell(40, 8, '', 0, 0, 'L');
        $this->Line(78, $Y + 24.3, 130, $Y + 24.3);


        $this->SetXY(138, $Y + 12);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(40, 8, utf8_decode('Fecha de Digitación'), 0, 0, 'L');
        $this->SetXY(138, $Y + 19);
        $this->SetFont('Arial', '', 9);
        $this->Cell(40, 8, $GLOBALS['fecha_cre'], 0, 0, 'L');
        $this->Line(138, $Y + 24.3, 180, $Y + 24.3);
    }

    //Pie de página
    function Footer() {

        $this->SetY(-13);

        $this->SetFont('Arial', 'I', 8);

        $this->Cell(0, 3, utf8_decode('Carrera 18 N° 15 - 108 Tels.: 571 2873 - 570 2689 - Fax: 5600993 - Valledupar - Cesar'), 0, 2, 'C');
        $this->Cell(0, 3, utf8_decode('Página Web: www.funerarialaesperanza.org - E-mail: esperanzaeccehomo@hotmail.com'), 0, 0, 'C');
    }

}

//Creación del objeto de la clase heredada
$pdf = new PDF();
$pdf->AddPage('P', 'Legal');
$pdf->SetY(40);
$pdf->TablaBasica();
$pdf->TablaGrupos();
$pdf->TablaInfPag();
$pdf->SetFont('Times', '', 12);
//Aquí escribimos lo que deseamos mostrar...
$pdf->Output('I', 'Constancia_' . $ncontrato . '.pdf');

function acentos($cadena) {
    $search = explode(",", "á,é,í,ó,ú,ñ,Á,É,Í,Ó,Ú,Ñ,Ã¡,Ã©,Ã*,Ã³,Ãº,Ã±,ÃÃ¡,ÃÃ©,ÃÃ*,ÃÃ³,ÃÃº,Ã‘,Ã“,Ã ,Ã‰,Ã ,Ãš,â€œ,â€ ,Â¿,ü,Âº");
    $replace = explode(",", "á,é,í,ó,ú,ñ,Á,É,Í,Ó,Ú,Ñ,á,é,í,ó,ú,ñ,Á,É,Í,Ó,Ú,Ñ,Ó,Á,É,Í,Ú,\",\",¿,&uuml;,º");
    $cadena = str_replace($search, $replace, $cadena);
    return $cadena;
}

?>