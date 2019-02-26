<?php
//  Incluye libreria con clase//
include_once "clase.php";

$obj= new REGISTRO();
print_r($obj);

//RECORRE EL ARCHIVO SOLICITADO Y CREA EL STRING POSTERIOR A GUARDAR
function recorrer_ficheros()
{
 $archivo = fopen("012015.HTM", "r+");//$handle = $archivo
$lineas= "";

while(!feof($archivo))
{

$linea = fgets($archivo);
$linea =str_replace("\n","",$linea);
if(strpos($linea,"</tr>")===FALSE)
{
    if(strpos($linea,"checkbox")!==FALSE)
    {
        if(strpos($linea,"checked")!==FALSE)
          {
            $lineas.="si";

          }
          else
          {
            $lineas.="no";


          }
    }
    else
    {
            $linea=str_replace(">","",strip_tags($linea));
            $lineas.=str_replace("&nbsp;","",$linea);

    }
}
else
{
    $lineas.="</br>";// fin de registro de tabla
}

}



fclose($archivo);

return ($lineas);
}

//FUNCION GUARDA Y tiene un arreglo para evitar los saltos de lineas en lugares indeseados.
function guardar($anio=0,$mes=0,$contenido=0)
{
  $fp = fopen("fichero.txt", "w");

  $contenido=utf8_encode($contenido);
  echo $contenido;
  $contenido=preg_replace("/[\n|\r|\n\r]/i","",$contenido);
  $contenido=str_replace("</br>","\n",$contenido);

  fputs($fp, $contenido);
  fclose($fp);
}

// SE EJECUTAN LAS FUNCIONES
$content=recorrer_ficheros();

guardar(2015,1,$content);





?>
