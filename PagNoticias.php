<?php session_start();

   include("Conectar.php");

   $success=1;
   $error="";
   $link=conectar();

   $cad="";
   $cad2 = "";
     $cbp="";
   $consulta="";
   $contador = 0;

        $i = 0;
        $j = 0;
    
            $regmos = $_POST["nreg"];
          
            $pag = $_POST["pag"];
            $op = $_POST["pag"];
            $buscar = array();
$cbp="";

            $regemp = 0;
            $pagact = 1;
            if ($pag != null) {
                $regemp = (intval($pag) - 1) * $regmos;
                
                $pagact = intval($pag);
            }

            $cad = "<table class=\"table table-striped table-bordered table-advance table-hover\">"
                    . "<thead>"
                    . "<tr>"
                    . "<th>"
                    . "<i class=\"fa fa-angle-right\"></i> Titulo de la Noticia"
                    . "</th>"
                    . "<th>"
                    . "<i class=\"fa fa-angle-right\"></i> Fecha"
                    . "</th>"
                    . "<th>"
                    . "<i class=\"fa fa-angle-right\"></i> Acción"
                    . "</th>"
                    . "</tr>"
                    . "</thead>"
                    . "<tbody>";

            $busq = $_POST["bus"];

            if ($busq!="") {
                $busq =str_replace("+"," ",$busq);
                $buscar =explode(" ",$busq);
               
                $consulta = "SELECT * FROM  noticias  WHERE ";

            for ($i = 0; $i < count($buscar,1); $i++) {
                    $consulta .= "CONCAT( "
                            . "  titu_not, "
                            . "  ' ', "
                            . "  descr "
                            . ") LIKE '%" . $buscar[$i] . "%' ";
                    if (($i) == count($buscar,1) - 1) {

                    } else {
                        $consulta .= " AND ";
                    }
                }
                $consulta .= " order by fecha ASC LIMIT " . $regemp . "," . $regmos;

            } else {
               
                $consulta = "SELECT * FROM noticias order by fecha ASC  LIMIT " . $regemp . "," . $regmos;
            }

       
              $resultado=mysqli_query($link,$consulta); 
    if (mysqli_num_rows($resultado) > 0) {
        
        while ($fila = mysqli_fetch_array($resultado)) {
           
                $cod = $fila["id_noticia"];
                $cad .= "<tr>"
                        . "<td class=\"highlight\">"
                        . $fila["titu_not"] . " "
                        . "</td>"
                        . "<td class=\"highlight\">"
                        . $fila["fecha"] . ""
                        . "</td>"
                        . "<td class=\"highlight\">"
                        . "<a  onclick=\"$.editNot('" . $cod . "')\"  class=\"btn default btn-xs blue\">"
                        . "<i class=\"fa fa-edit\"></i> Editar</a>"
                        . "<a   onclick=\"$.VerNot('" . $cod . "')\"  class=\"btn default btn-xs blue\">"
                        . "<i class=\"fa fa-search\"></i> Ver</a>"
                        . "<a onclick=\"$.deletNot('" . $cod . "')\" class=\"btn default btn-xs red\">"
                        . "<i class=\"fa fa-trash-o\"></i> Eliminar</a>"
                        . "</td>"
                        . "</tr>";

    }}

            $consulta = "SELECT count(*) as conta FROM noticias";
            $resultado2=mysqli_query($link,$consulta); 
    if (mysqli_num_rows($resultado2) > 0) {
        
        while ($fila = mysqli_fetch_array($resultado2)) {
                $contador =  intval($fila["conta"] );
            }
    }
            $cad .= "</tbody>"
                    . "</table>";

            $pagant = $pagact - 1;
            $pagsig = $pagact + 1;
            $div = $contador / $regmos;
            $mod = $contador % $regmos;
            if ($mod > 0) {
                $div++;
            }
              if ($contador > $regmos) {
                $cad2 = "<br />"
                        . "<table cellspacing=5 style=\"text-align: right;\">"
                        . "<tr >";
                $cad2 = $cad2 . "<td><input type='hidden' value='" . $j . "' name='contador' id='contador' />";
                $cad2 = $cad2 . "<input type='button' style=\"width: 70px;\" class=\"btn btn-circle blue btn-sm dropdown-toggle\" value=' << ' onclick=\"$.paginador('1','../paginador_centros');\" style='padding: 4px 4px 4px 4px' /></td>";
                if ($pagact > 1) {
                    $cad2 = $cad2 . "<td><input type='button'  style=\"width: 70px;\" class=\"btn btn-circle blue btn-sm dropdown-toggle\" value=' < ' onclick=\"$.paginador('" . $pagant . "','../paginador_centros');\" style='padding: 4px 4px 4px 4px' /></td>";
                } else {
                    $cad2 = $cad2 . "<td><input type='button'  style=\"width: 70px;\" class=\"btn btn-circle blue btn-sm dropdown-toggle\" value=' < ' onclick=\"$.paginador('" . $pagant . "','../paginador_centros');\" disabled style='padding: 4px 4px 4px 4px' /></td>";
                }
               $cbp = $cbp . "<td>Pagina No: <select id='selectpag' class='bs-select form-control small' onchange=\"$.combopag(this.value,'../paginador_centros')\">";
                for ($j = 1; $j <= $div; $j++) {
                    if ($j == $pagact) {
                        $cbp = $cbp . "<option value='" . $j . "' selected='selected'>" . $j . "</option>";
                    } else {
                        $cbp = $cbp . "<option value='" . $j . "'>" . $j . "</option>";
                    }
                }
                $cad2 = $cad2 . "</select></td>";
                if ($pagact < $div-1) {
                    $cad2 = $cad2 . "<td><input type='button' style=\"width: 70px;\" class=\"btn btn-circle blue btn-sm dropdown-toggle\" value=' > ' onclick=\"$.paginador('" . $pagsig . "','../paginador_centros');\" style='padding: 4px 4px 4px 4px' />";
                } else {
                    $cad2 = $cad2 . "<td><input type='button' style=\"width: 70px;\"  class=\"btn btn-circle blue btn-sm dropdown-toggle\" value=' > ' onclick=\"$.paginador('" . $pagsig . "','../paginador_centros');\" disabled style='padding: 4px 4px 4px 4px' />";
                }
                $cad2 = $cad2 . "<td><input type='button' style=\"width: 70px;\" class=\"btn btn-circle blue btn-sm dropdown-toggle\" value=' >> ' onclick=\"$.paginador('" . $div . "','../paginador_centros');\"  style='padding: 4px 4px 4px 4px' /><input type='hidden' id='txttotal' value='" . $div . "' />"
                        . "<input type='hidden' id='codter' name='codter' value='' /></td>";
                $cad2 = $cad2 . "</tr>"
                        . "</table>";
            }
            
            $salida = new stdClass();
            $salida->cad = $cad;
            $salida->cad2 = $cad2;
            $salida->cbp = $cbp;

           echo json_encode($salida);

    mysqli_close($link);

?>