<?php session_start();

   include("../Conectar.php");

   $success=1;
   $error="";
   $link=conectar();
   $link2=conectar();

   $cad="";
   $cad2 = "";
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
                    . "<i class=\"fa fa-angle-right\"></i> Usuario"
                    . "</th>"
                    . "<th>"
                    . "<i class=\"fa fa-angle-right\"></i> Fecha"
                    . "</th>"
                    . "<th>"
                    . "<i class=\"fa fa-angle-right\"></i> Hora"
                    . "</th>"
                    . "<th>"
                    . "<i class=\"fa fa-angle-right\"></i>Tipo de Accion"
                    . "</th>"
                    . "<th>"
                    . "<i class=\"fa fa-angle-right\"></i> Acción"
                    . "</th>"
                    . "<th>"
                    . "<i class=\"fa fa-angle-right\"></i> Interfaz"
                    . "</th>"
                    . "<th>"
                    . "<i class=\"fa fa-angle-right\"></i> IP"
                    . "</th>"
                    . "</tr>"
                    . "</thead>"
                    . "<tbody>";

            $busq = $_POST["bus"];

            if ($busq!="") {
                $busq =str_replace("+"," ",$busq);
                $buscar =explode(" ",$busq);
               
                $consulta = "SELECT * FROM logs WHERE  ";
                
            for ($i = 0; $i < count($buscar,1); $i++) {
                    $consulta .= "CONCAT( "
                            . "  usuario_id, "
                            . "  ' ', "
                            . "  log_tipo, "
                            . "  ' ', "
                            . "  log_accion "
                            . ") LIKE '%" . $buscar[$i] . "%' ";
                    if (($i) == count($buscar,1) - 1) {

                    } else {
                        $consulta .= " AND ";
                    }
                }
                $consulta .= " order by log_tipo ASC LIMIT " . $regemp . "," . $regmos;

            } else {
               
                $consulta = "SELECT * FROM logs "
                        . " order by log_tipo ASC LIMIT " . $regemp . "," . $regmos;
            }

           
              $resultado=mysqli_query($link,$consulta); 
    if (mysqli_num_rows($resultado) > 0) {
        
        while ($fila = mysqli_fetch_array($resultado)) {
            $cod = "";
          
                $cod = $fila["ident_responsable"];
                $cad .= "<tr>"
                        . "<td class=\"highlight\">"
                        . $fila["usuario_id"] . " "
                        . "</td>"
                        . "<td class=\"highlight\">"
                        . $fila["log_fecha"] . ""
                        . "</td>"
                        . "<td class=\"highlight\">"
                        . $fila["log_hora"] . ""
                        . "</td>"
                        . "<td class=\"highlight\">"
                        . $fila["log_tipo"] . ""
                        . "</td>"
                        . "<td class=\"highlight\">"
                        . $fila["log_accion"] . ""
                        . "</td>"
                       
                        . "<td class=\"highlight\">"
                        . $fila["log_interfaz"] . ""
                        . "</td>"
                       
                        . "<td class=\"highlight\">"
                        . $fila["log_direccion"] . ""
                        . "</td>"
                       
                        . "</tr>";

    }}

            $consulta = "SELECT count(*) as conta FROM logs";
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
                $cad2 = $cad2 . "<td>Pagina No: <select id='selectpag' class='bs-select form-control small' onchange=\"$.combopag(this.value,'../paginador_centros')\">";
                for ($j = 1; $j <= $div; $j++) {
                    if ($j == $pagact) {
                        $cad2 = $cad2 . "<option value='" . $j . "' selected='selected'>" . $j . "</option>";
                    } else {
                        $cad2 = $cad2 . "<option value='" . $j . "'>" . $j . "</option>";
                    }
                }
                $cad2 = $cad2 . "</select></td>";
                if ($pagact < $div) {
                    $cad2 = $cad2 . "<td><input type='button' style=\"width: 70px;\" class=\"btn btn-circle blue btn-sm dropdown-toggle\" value=' > ' onclick=\"$.paginador('" . $pagsig . "','../paginador_centros');\" style='padding: 4px 4px 4px 4px' />";
                } else {
                    $cad2 = $cad2 . "<td><input type='button' style=\"width: 70px;\"  class=\"btn btn-circle blue btn-sm dropdown-toggle\" value=' > ' onclick=\"$.paginador('" . $pagsig . "','../paginador_centros');\" disabled style='padding: 4px 4px 4px 4px' />";
                }
                $cad2 = $cad2 . "<td><input type='button' style=\"width: 70px;\" class=\"btn btn-circle blue btn-sm dropdown-toggle\" value=' >> ' onclick=\"$.paginador('" . $div . "','../paginador_centros');\"  style='padding: 4px 4px 4px 4px' /><input type='hidden' id='txttotal' value='" . $div . "' />"
                        . "<input type='hidden' id='codter' name='codter' value='' /></td>";
                $cad2 = $cad2 . "</tr>"
                        . "</table>";
            }

           echo $cad . "//" . $cad2;

    mysqli_close($link);

?>