<?php

require('fpdf/fpdf.php');
include("Conectar.php");
$link = conectar();


$consulta = "SELECT
  Nit_empresa,
  Nombre_empresa,
  COUNT(*) conta
FROM
  empresa emp
  LEFT JOIN cliente cli
    ON emp.idEmpresa = cli.idEmpresa_cliente
WHERE EMP.idEmpresa = '" . $_REQUEST["empr"] . "'
  AND cli.Estado_cliente = 'ACTIVO' ";

//echo $consulta;

$resultado2 = mysqli_query($link, $consulta);
if (mysqli_num_rows($resultado2) > 0) {

    while ($fila = mysqli_fetch_array($resultado2)) {
        $toAfi = $fila["conta"];
        $empre = $fila["Nombre_empresa"];
    }
}

class PDF extends FPDF {

    //Cabecera de página
    function Header() {
        $this->Image('Img/cabecera_pdf.png', 10, 8, 100);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(100, 25, '', 1, 0, 'C');
        $this->cell(0, 25, utf8_decode(''), 1, 2, 'C');
        $this->SetXY(110, 9);
        $this->cell(0, 25, utf8_decode('CONSULTA DE CARTERA EMPRESARIAL'), 0, 2, 'C');
    }

    function TablaConsulta() {


        $this->SetXY(10, 36);
        $this->SetFont('Arial', 'B', 9);
        $this->SetFillColor(205, 205, 205); // establece el color del fondo de la celda (en este caso es AZUL

        if ($_REQUEST["tcon"] == "empre") {
            $this->Cell(0, 5, utf8_decode('CARTERA DE ' . $GLOBALS['empre'] . " DEL AÑO " . $_REQUEST["anio"]), 1, 2, 'C', True); // en orden lo que informan estos parametros es:
        } else if ($_REQUEST["tcon"] == "mes") {
            $this->Cell(0, 5, utf8_decode('Mes de ' . $_REQUEST["mes"] . " del " . $_REQUEST["anio"]), 1, 2, 'C', True); // en orden lo que informan estos parametros es:
        }


        // $this->Line(10, 120.5, 200, 120.5);
        $this->Ln(1);
        $this->SetFont('Arial', 'B', 8);
        $this->SetFillColor(205, 205, 205);
        $this->Cell(5, 8, '#', 0, 0, 'L', True);

        if ($_REQUEST["tcon"] == "empre") {
            $this->Cell(165, 8, utf8_decode('Mes.'), 0, 0, 'L', True);
            $this->Cell(25, 8, utf8_decode('Valor'), 0, 0, 'L', True);
        } else {

            $this->Cell(120, 8, utf8_decode('Nombre.'), 0, 0, 'L', True);
            $this->Cell(45, 8, utf8_decode('No. Afiliados'), 0, 0, 'L', True);
            $this->Cell(30, 8, utf8_decode('Valor'), 0, 0, 'L', True);
        }

        //$this->Line(10, 120.5, 200, 120.5);



        if ($_REQUEST["tcon"] == "mes") {

            $consulta = "SELECT
            idEmpresa_cliente,
            IFNULL(emp.Nit_empresa, '') nit,
            Nombre_empresa,
            (SELECT
              COUNT(*)
            FROM
              cliente
            WHERE idEmpresa_cliente = idEmpresa
              AND estado_cliente = 'ACTIVO') afil,
            cart.Valor_cartera val
          FROM
            cliente cli
            LEFT JOIN empresa emp
              ON cli.idEmpresa_cliente = emp.idEmpresa
              LEFT JOIN cartera cart
              ON emp.idEmpresa=cart.idEmpresa_cartera
          WHERE cart.anio_cartera='" . $_REQUEST["anio"] . "' AND cart.mes_cartera='" . $_REQUEST["mes"] . "'
          GROUP BY idEmpresa_cliente
          ORDER BY Nombre_empresa ASC";

            ///////////CONSULTA CLIENTES AL DIA/////////////////////////////////
        } else {
            $consulta = "SELECT
            cart.mes_cartera,
            cart.Valor_cartera val
          FROM
            cliente cli
            LEFT JOIN empresa emp
              ON cli.idEmpresa_cliente = emp.idEmpresa
            LEFT JOIN cartera cart
              ON emp.idEmpresa = cart.idEmpresa_cartera
          WHERE cart.anio_cartera = '" . $_REQUEST["anio"] . "' AND cart.idEmpresa_cartera='" . $_REQUEST["empr"] . "'
          GROUP BY cart.mes_cartera ORDER BY idCartera ASC";
        }
        //echo $consulta;
        $item = 0;
        $topend = 0;
        $toAfi = 0;
        $resultado = mysqli_query($GLOBALS['link'], $consulta);
        $Y = 50;

        $this->SetFont('Arial', '', 10);
        if (mysqli_num_rows($resultado) > 0) {
            while ($fila = mysqli_fetch_array($resultado)) {
                if ($_REQUEST["tcon"] == "mes") {
                    $topend = $topend + $fila['val'];
                    $toAfi = $toAfi + $fila['afil'];
                    $this->SetXY(10, $Y);
                    $item = $item + 1;
                    $this->Cell(5, 5, $item, 0);
                    $this->Cell(120, 5, $fila['Nombre_empresa'], 0);
                    $this->MultiCell(120, 5, utf8_decode($fila['afil']), 0);
                    $H = $this->GetY();
                    $height = $H - $Y;
                    $this->SetXY(180, $Y);
                    $this->Cell(23, $height, number_format($fila['val'], 2, ",", "."), 0, 0);
                    $this->Ln(7);
                } else {
                    $topend = $topend + $fila['val'];
                    $this->SetXY(10, $Y);
                    $item = $item + 1;
                    $this->Cell(5, 5, $item, 0);
                    $this->Cell(120, 5, $fila['mes_cartera'], 0);
                    $this->MultiCell(120, 5, utf8_decode(""), 0);
                    $H = $this->GetY();
                    $height = $H - $Y;
                    $this->SetXY(180, $Y);
                    $this->Cell(23, $height, number_format($fila['val'], 2, ",", "."), 0, 0);
                    $this->Ln(7);
                }

                $this->Ln(7);

                $Y = $H;
            }
        }

        $y = $this->GetY();


        $this->SetFont('Arial', 'B', 10);
        $this->Line(10, $y + 1, 205, $y + 1);
        $this->SetXY(120, $y + 3);
        if ($_REQUEST["tcon"] == "mes") {
            $this->Cell(20, 6, 'Total Afiliados: ' . $toAfi, 0, 0, 'R');
        } else {
            $this->Cell(20, 6, 'Total Afiliados: ' . $GLOBALS['toAfi'], 0, 0, 'R');
        }

        $this->SetXY(160, $y + 3);
        $this->Cell(20, 6, 'Total Cartera: ', 0, 0, 'R');
        $this->SetXY(160, $y + 3);
        $this->Cell(0, 6, '$ ' . number_format($topend, 2, ",", "."), 0, 0, 'R');
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
$pdf->TablaConsulta();
$pdf->SetFont('Times', '', 12);
//Aquí escribimos lo que deseamos mostrar...
$pdf->Output('I', 'Cinsulta.pdf');
?>