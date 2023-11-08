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

$consulta3 = "SET lc_time_names = 'es_CO';";
//echo $consulta;
mysqli_query($link, $consulta3);
$consulta = "SELECT pedido_contr,fecha_vent,ciudad_vent,cuota_vent,fpago_vent,"
        . "precios_vent,valcuini_vent,valcumes_vent,inde_cli,nom_cli,sex_cli,fec_cli,dir_cli,"
        . "tel_cli,"
        . "UPPER(DATE_FORMAT(fecha_vent, '%M')) mes"
        . " FROM contrato_venta contr LEFT JOIN clientes cli ON contr.ident_vent=cli.inde_cli where contr.id_contr='" . $_REQUEST["id"] . "'";
//echo $consulta;
$resultado = mysqli_query($link, $consulta);
if (mysqli_num_rows($resultado) > 0) {
    while ($fila = mysqli_fetch_array($resultado)) {
        $pedido_contr = $fila["pedido_contr"];
        $fecha_vent = $fila["fecha_vent"];
        $ciudad_vent = $fila["ciudad_vent"];
        $cuota_vent = $fila["cuota_vent"];
        $fpago_vent = $fila["fpago_vent"];
        $precios_vent = number_format($fila["precios_vent"], 2, ",", ".");
        $valcuini_vent = number_format($fila["valcuini_vent"], 2, ",", ".");
        $valcumes_vent = number_format($fila["valcumes_vent"], 2, ",", ".");
        $inde_cli = $fila["inde_cli"];
        $nom_cli = acentos($fila["nom_cli"]);
        $sex_cli = $fila["sex_cli"];
        $fec_cli = $fila["fec_cli"];
        $dir_cli = acentos($fila["dir_cli"]);
        $tel_cli = $fila["tel_cli"];
        $mes = $fila["mes"];
    }
}


$cnta = "";

if ($fpago_vent == "CONTADO") {
    $cnta = "X";
}

$fechas = explode("-", $fecha_vent);
$dias = $fechas[2];
$anios = $fechas[0];

class PDF extends FPDF {

    //Cabecera de página
    function Header() {
        $this->Image('Img/cabecera_pdf.png', 10, 8, 100);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(100, 25, '', 1, 0, 'C');
        $this->cell(0, 25, utf8_decode('CONTRATO DE VENTA DE OSARIO O LOTE'), 1, 2, 'C');
    }

    function TablaBasica() {
        $this->SetFont('Arial', 'B', 10);
        //*****
        $this->SetXY(110, 37);
        $this->Cell(30, 5, 'FECHA', 1, 2, 'C');
        $this->Cell(30, 6, $GLOBALS['fecha_vent'], 1, 0, 'C');
        $this->SetXY(140, 37);
        $this->Cell(60, 5, utf8_decode('PEDIDO - CONTRATO'), 1, 2, 'C');
        $this->Cell(60, 6, $GLOBALS['pedido_contr'], 1, 0, 'C');
        // $this->Line(10, 45.5, 200, 45.5);

        $this->SetFont('Arial', '', 10);
        $this->SetXY(10, 50);
        $this->Cell(30, 8, utf8_decode('Identificación: ' . $GLOBALS['inde_cli']), 0, 'L');
        $this->SetXY(60, 50);
        $this->Cell(100, 8, utf8_decode('Nombre: ' . $GLOBALS['nom_cli']), 0, 'L');
        $this->SetXY(155, 50);
        $this->Cell(40, 8, utf8_decode('Cuotas: ' . $GLOBALS['cuota_vent']), 0, 'L');
        $this->SetXY(175, 50);
        $this->Cell(30, 8, utf8_decode('Contado: ' . $GLOBALS['cnta']), 0, 'L');
        $this->Line(10, 56.5, 200, 56.5);

        //*****
        $this->SetXY(10, 56);
        $this->Cell(100, 8, utf8_decode('Dirección: ' . $GLOBALS['dir_cli']), 0, 0, 'L');

        $this->SetXY(120, 56);
        $this->Cell(20, 8, utf8_decode('Teléfono: ') . $GLOBALS['tel_cli'], 0, 1, 'C');

        $this->Line(10, 62.5, 200, 62.5);



        $this->SetXY(10, 64);
        $this->SetFont('Arial', 'B', 9);
        $this->SetFillColor(205, 205, 205); // establece el color del fondo de la celda (en este caso es AZUL
        $this->Cell(0, 5, utf8_decode('Venta de Lotes'), 1, 2, 'C', True); // en orden lo que informan estos parametros es:

        $this->Ln(1);
        $this->SetFont('Arial', 'B', 8);
        $this->SetFillColor(205, 205, 205);
        $this->Cell(5, 5, '#', 0, 0, 'L', True);
        $this->Cell(50, 5, utf8_decode('Ubicación.'), 0, 0, 'L', True);
        $this->Cell(20, 5, utf8_decode('Tipo de Lote '), 0, 0, 'L', True);
        $this->Cell(20, 5, utf8_decode('Precio.'), 0, 0, 'L', True);
        $this->Cell(40, 5, utf8_decode('Construcción.'), 0, 0, 'L', True);
        $this->Cell(0, 5, utf8_decode('Observación.'), 0, 0, 'C', True);

        $consulta = "SELECT * FROM  venta_deta_lote WHERE id_venta='" . $_REQUEST["id"] . "'";
        //echo $consulta;
        $item = 0;
        $resultado = mysqli_query($GLOBALS['link'], $consulta);
        $Y = 75;

        $this->SetFont('Arial', '', 7);
        if (mysqli_num_rows($resultado) > 0) {
            while ($fila = mysqli_fetch_array($resultado)) {
                $this->SetXY(10, $Y);
                $item = $item + 1;
                $this->Cell(5, 4, $item, 0);
                $this->Cell(50, 4, utf8_decode('Jardin: ' . $fila['jardin_vent'] . ' Zona: ' . $fila['zona_vent'] . ' Lote: ' . $fila['lote_vent'] . ''), 0);
                $this->Cell(20, 4, utf8_decode($fila['tlote']), 0);
                $this->Cell(20, 4, '$ ' . number_format($fila['precio_vent']), 0);
                $this->MultiCell(40, 4, utf8_decode(acentos($fila['costru_vent'])), 0);
                $H = $this->GetY();
                $height = $H - $Y;
                $this->SetXY(145, $Y);
                $this->MultiCell(0, $height, utf8_decode(acentos($fila['obser_vent'])), 0);
                $H = $this->GetY();
                $height = $H - $Y;
                $this->Ln(5);

                $Y = $H;
            }
        }


        $Y = $this->GetY();

        $this->SetXY(10, $Y - 5);
        $this->SetFont('Arial', 'B', 9);
        $this->SetFillColor(205, 205, 205); // establece el color del fondo de la celda (en este caso es AZUL
        $this->Cell(0, 5, utf8_decode('Venta de Lotes'), 1, 2, 'C', True); // en orden lo que informan estos parametros es:

        $this->Ln(1);
        $this->SetFont('Arial', 'B', 8);
        $this->SetFillColor(205, 205, 205);
        $this->Cell(5, 5, '#', 0, 0, 'L', True);
        $this->Cell(50, 5, utf8_decode('Ubicación.'), 0, 0, 'L', True);
        $this->Cell(20, 5, utf8_decode('Tipo de Lote '), 0, 0, 'L', True);
        $this->Cell(20, 5, utf8_decode('Precio.'), 0, 0, 'L', True);
        $this->Cell(40, 5, utf8_decode('Construcción.'), 0, 0, 'L', True);
        $this->Cell(0, 5, utf8_decode('Observación.'), 0, 0, 'C', True);

        $consulta = "SELECT * FROM  venta_deta_osario WHERE id_venta='" . $_REQUEST["id"] . "'";
        //echo $consulta;
        $item = 0;
        $resultado = mysqli_query($GLOBALS['link'], $consulta);

        $Y = $this->GetY();
        $Y = $Y + 5;
        $this->SetFont('Arial', '', 7);
        if (mysqli_num_rows($resultado) > 0) {
            while ($fila = mysqli_fetch_array($resultado)) {
                $this->SetXY(10, $Y);
                $item = $item + 1;
                $this->Cell(5, 4, $item, 0);
                $this->Cell(50, 4, utf8_decode('Jardin: ' . $fila['jardin_vent'] . ' Número: ' . $fila['osario_vent'] . ''), 0);
                $this->Cell(20, 4, utf8_decode($fila['tosario_vent']), 0);
                $this->Cell(20, 4, '$ ' . number_format($fila['prec_vent']), 0);
                $this->MultiCell(40, 4, utf8_decode(acentos($fila['costr_vent'])), 0);
                $H = $this->GetY();
                $height = $H - $Y;
                $this->SetXY(145, $Y);
                $this->MultiCell(0, $height, utf8_decode(acentos($fila['obser_vent'])), 0);
                $H = $this->GetY();
                $height = $H - $Y;
                $this->Ln(3);

                $Y = $H;
            }
        }
        $this->Line(10, $Y + 1, 200, $Y + 1);

        $this->SetFont('Arial', '', 9);
        $this->SetXY(10, $Y + 1);
        $this->Cell(40, 8, 'Precio Total: $ ' . $GLOBALS['precios_vent'], 0, 'L');
        $this->SetXY(60, $Y + 1);
        $this->Cell(40, 8, 'Val. Cuota Inicial: $ ' . $GLOBALS['valcuini_vent'], 0, 'L');
        $this->SetXY(120, $Y + 1);
        $this->Cell(40, 8, 'Val. Cuota Mes: $ ' . $GLOBALS['valcumes_vent'], 0, 'L');

        $this->Ln(1);


        $Y = $this->GetY();

        $this->SetXY(10, $Y + 5);
        $this->SetFont('Arial', 'B', 9);
        $this->SetFillColor(205, 205, 205); // establece el color del fondo de la celda (en este caso es AZUL
        $this->Cell(0, 5, utf8_decode('Personas para Ordenar Inhumaciones'), 1, 2, 'C', True); // en orden lo que informan estos parametros es:

        $this->Ln(1);
        $this->SetFont('Arial', 'B', 8);
        $this->SetFillColor(205, 205, 205);
        $this->Cell(5, 5, '#', 0, 0, 'L', True);
        $this->Cell(50, 5, utf8_decode('Identificación.'), 0, 0, 'L', True);
        $this->Cell(0, 5, utf8_decode('Nombre'), 0, 0, 'L', True);


        $consulta = "SELECT iden_persocont,nom_persocont FROM personas_contrato_venta  WHERE idcontr_persocont='" . $_REQUEST["id"] . "'";
        //echo $consulta;
        $item = 0;
        $resultado = mysqli_query($GLOBALS['link'], $consulta);
        $this->SetXY(10, $Y + 16);
        $this->SetFont('Arial', '', 7);
        if (mysqli_num_rows($resultado) > 0) {
            while ($fila = mysqli_fetch_array($resultado)) {
                $item = $item + 1;
                $this->Cell(5, 5, $item, 0);
                $this->Cell(50, 5, utf8_decode($fila['iden_persocont']), 0);
                $this->Cell(0, 5, utf8_decode(acentos($fila['nom_persocont'])), 0);
                $this->Ln(3);
            }
        }

        $y = $this->GetY();
        $this->Line(10, $y + 1, 200, $y + 1);


        //$this->Line(10, $y+8, 35, $y+8);


        $y = $this->GetY();

        $this->SetFont('Arial', 'B', 8);
        $this->SetXY(10, $y + 10);
        $this->Cell(10, 6, 'El Promitente Comrador C.C. No:', 0, 0, 'L');
        $this->Line(10, $y + 10, 80, $y + 10);

        $this->SetXY(95, $y + 10);
        $this->Cell(10, 6, 'El Promitente Vendedor', 0, 0, 'L');
        $this->Line(95, $y + 10, 130, $y + 10);

        $this->SetXY(150, $y + 10);
        $this->Cell(10, 6, 'Asesor Comercial', 0, 0, 'L');
        $this->Line(150, $y + 10, 190, $y + 10);

        $this->SetFont('Arial', '', 7);
        $y = $this->GetY();
        $this->SetXY(10, $y + 5);
        $this->MultiCell(190, 4, utf8_decode('Cualquier solicitus de reembolso de dinero por desistimiento de este negocio solo podra ser posible'
                        . ' dentro de las 12 horas siguientes; con un descuento del 5% por gastos administrativos sobre el valor cancelado.'));
        $this->Ln(2);

        $this->SetFont('Arial', 'B', 10);
        $this->SetFillColor(205, 205, 205); // establece el color del fondo de la celda (en este caso es AZUL
        $this->Cell(0, 5, utf8_decode('CONTRATO DE PROMESA DE COMPRAVENTA'), 1, 2, 'C', True); // en orden lo que informan estos parametros es:

        $this->SetFont('Arial', '', 6);
        $this->MultiCell(190, 3, utf8_decode('Entre los suscritos a saber: El obispo de la DIÓCESIS DE VALLEDUPAR, o a quien él delegue y en virtud '
                        . 'de ello Representante Legal de ésta Circunscripción, Eclesiástica, con domicilio y residencia en la ciudad de Valledupar, con '
                        . 'Nit. 892.300.318-0, quien en adelante se llamará PROMINIENTE VENDEDOR y quien adelante se llamarán PROMINIENTES COMPRADORES, '
                        . 'acordamos celebrar el Contrato de Promesa de Compraventa expresado en las Cláusulas que siguen: PRIMERO. OBJETO.-  LA DIÓCESIS '
                        . 'DE VALLEDUPAR  a través de sus representante legal, promete vender y estos, promenientes compradores prometen comprar mediante '
                        . 'título de propiedad, el inmueble de propiedad del primer nombrado, especificado con linderos y características de acuerdo a la '
                        . 'ubicación del plano general del Parque Cementerio. SEGUNDO. TRADICIÓN.-  El inmueble que por este contrato promete vender por '
                        . 'una parte, y promete comprar por otra, lo adquirió el prominente vendedor por compra según consta en Escrituras Públicas No. 9897 '
                        . 'del 28 de Diciembre de 1979 de la Notaría Quinta del Círculo de Bogotá y registrada en la oficina de Registro de Instrumentos '
                        . 'Públicos del Círculo de Valledupar bajo el No. 190-9633. TERCERO. PRECIO Y FORMA DE PAGO. -  El precio del inmueble aquí descrito '
                        . 'y la forma de pago es el estipulado en este mismo documento. En todo caso, la mora en el pago de una o más cuotas facultad al '
                        . 'prominente vendedor para dar por terminado el contrato sin previo aviso. CUARTO. CLÁUSULA PENAL.-  Los prominentes vendedor y '
                        . 'comprador establecemos para caso de incumplimiento que el 40% del precio total de este contrato, se aplicará como sanción si el '
                        . 'incumplimiento es de parte del prominiente comprador. QUINTO. PLAZO.-  El título de propiedad será entregado una vez sea cumplido '
                        . 'el pago total de la obligación y se encuentre la documentación requerida para tal fin. SEXTO. PRÓRROGA.-  Sólo se podrá prorrogar '
                        . 'el término para el cumplimiento de las obligaciones que por este contrato se contraen, cuando asi lo acuerden las partes mediante '
                        . 'cláusulas que se agreguen al presente instrumento, firmada por las partes con dos días de aticipación al término señalado. '
                        . 'SÉPTIMO. ENTREGA.-  la fecha de otorgamiento del título de propiedad del prominente comprador será de 30 días después de haber '
                        . 'cancelado la totalidad del precio convenido. La entrega material del inmueble al prominente comprador, con sus mejoras anexidades '
                        . 'usos y servidumbres se hará al momento de su utilización del cual se elaborará una acta para constancia de la diligencia. También '
                        . 'el prominente vendedor se obliga a entregar el inmueble determinado en este contrato cuya ubicación de lotes y mausoleos es la '
                        . 'convenida en este contrato. OCTAVO. DERECHOS, OBLIGACIONES, SERVICIOS Y COMPROMISOS. 1. -Para la utilización del lote y osario '
                        . 'estos deben de estar cancelados en su totalidad. 2. -Misa comunitaria el domingo siguiente a la utilización del lote. 3. -Mantenimiento, '
                        . 'ornato y vigilancia de Jardines del Ecce Homo. 4. -De conformidad con el reglamento de servicios del Ecce Homo el presente contrato es '
                        . 'personal e intransferible, hatsa tanto no se haya cancelado su valor total, en consecuencia la utilización del inmueble, sólo podrá '
                        . 'hacerla el comprador o sus padres, hermanos, esposo(a) o hijos exclusivamente. 5. -Cumplir el reglamento interno del parque cementerio '
                        . 'que acepta y conoce al igual las disposiciones ambientales vigentes emanadas de la ley respectiva y a no realizar ningún muro o zanja '
                        . 'en contorno al lote de su propiedad que impida el normal desplazamiento del agua. Todo arreglo o trabjo en los lote y osarios, deberá '
                        . 'ser solicitada su autorización en la administración. 6. -Cuando por fuerza mayor, caso fortuito, o problema técnico de Jardines del '
                        . 'Ecce Homo, no pudiere prestar el servicio en el inmueble objeto de este contrato, cumplirá suministrando otro de precio y caracteristicas '
                        . 'similares. 7. -Los servicios de inhumación por primera vez en los mausoleos son por cuenta del PROMINENTE VENDEDOR. Para la reutilización '
                        . 'de Mausoleos, la adecuación será por cuenta del PROMINENTE COMPRADOR, quien cancelará de acuerdo a los precios vigentes al momento de '
                        . 'la reutilización. 8. -Serán por cuenta del PROMINENTE COMPRADOR los servicios de inhumación conrrespondiente a los lotes, en cuanto '
                        . 'a apertura, construcción, cierre de la bóveda y lápida. El servicio de adecuación de osarios y lotes se cancelará e el momento de su utilizacíon.'));

        $this->Ln(1);
        $this->SetFont('Arial', 'B', 9);
        $this->MultiCell(190, 5, utf8_decode('CLAUSULA ADICIONAL: '));
        $this->Ln(1);
        $this->SetFont('Arial', '', 7);
        $this->MultiCell(190, 3, utf8_decode('Los contratantes, leido el presente instrumento asienten expresamente lo estipulado y firman como aparece, '
                        . 'en la ciudad de valledupar, alos ' . $GLOBALS['dias'] . 'días del mes de ' . $GLOBALS['mes'] . ' del ' . $GLOBALS['anios'] . ' en dos ejemplares, uno para cada una de las partes.'));

        $y = $this->GetY();

        $this->SetXY(10, $y + 15);
        $this->Cell(15, 4, 'PROMINENTE VENDEDOR ', 0, 2, 'L');
        $this->Cell(15, 3, 'CC:', 0, 0, 'L');
        $this->Line(10, $y + 15, 60, $y + 15);


        $this->SetXY(150, $y + 15);
        $this->Cell(15, 4, 'PROMINENTE VENDEDOR ', 0, 2, 'L');
        $this->Cell(15, 3, 'CC:', 0, 0, 'L');
        $this->Line(150, $y + 15, 200, $y + 15);

        $y = $this->GetY();

        $this->SetXY(10, $y + 5);
        $this->Cell(15, 3, 'Representante ', 0, 2, 'L');
        $this->Cell(15, 3, utf8_decode('DIÓCESIS DE VALLEDUPAR'), 0, 2, 'L');
        $this->Cell(15, 3, utf8_decode('Nit. 892.300.318-0'), 0, 0, 'L');
    }

    //Pie de página
    function Footer() {

        $this->SetY(-10);

        $this->SetFont('Arial', 'I', 8);

        $this->Cell(0, 10, utf8_decode('Página Web: www.funerarialaesperanza.org - E-mail: esperanzaeccehomo@hotmail.com'), 0, 0, 'C');
    }

}

//Creación del objeto de la clase heredada
$pdf = new PDF();
$pdf->AddPage();
$pdf->SetY(40);
$pdf->TablaBasica();
$pdf->SetFont('Times', '', 12);
//Aquí escribimos lo que deseamos mostrar...
$pdf->Output('I', 'Constancia_' . $pedido_contr . '.pdf');

function acentos($cadena) {
    $search = explode(",", "á,é,í,ó,ú,ñ,Á,É,Í,Ó,Ú,Ñ,Ã¡,Ã©,Ã*,Ã³,Ãº,Ã±,ÃÃ¡,ÃÃ©,ÃÃ*,ÃÃ³,ÃÃº,Ã‘,Ã“,Ã ,Ã‰,Ã ,Ãš,â€œ,â€ ,Â¿,ü,Âº");
    $replace = explode(",", "á,é,í,ó,ú,ñ,Á,É,Í,Ó,Ú,Ñ,á,é,í,ó,ú,ñ,Á,É,Í,Ó,Ú,Ñ,Ó,Á,É,Í,Ú,\",\",¿,&uuml;,º");
    $cadena = str_replace($search, $replace, $cadena);
    return $cadena;
}

?>