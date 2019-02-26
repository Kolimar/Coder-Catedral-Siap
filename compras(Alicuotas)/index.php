<?php
//  Incluye libreria con clase//
include_once "clase.php";


//RECORRE EL ARCHIVO SOLICITADO
function recorrer_ficheros($nombre)
{

 $archivo = fopen("C:/xampp/htdocs/compras/2015/".$nombre.".HTM", "r+");//$handle = $archivo
 $bandera=FALSE;
//$lineas= "";
$i=0;
$obj= new REGISTRO();
$ArrayObject= array();
while(!feof($archivo))
{


$linea = fgets($archivo);

  if(strpos($linea,"font")!==FALSE)
  {
    switch ($i) {

      case 4:
                  $arreglo=str_pad(str_replace("\n","",str_replace("-","",strip_tags(trim($linea)))),22,"0",STR_PAD_LEFT);
                  $obj->nro_id_vendedor=trim(str_replace(">","",$arreglo));
                  echo "<pre>";
                  break;

      case 6:
                if(strpos(strip_tags($linea),"Factura")!==FALSE)
                {
                $obj->tipo_comp="001";
                }
                if(strpos(strip_tags($linea),"Nota")!==FALSE)
                {
                $obj->tipo_comp="003";
                }


                break;
     case 9:
                $linea=str_replace("\n","",str_replace("/","",strip_tags(trim($linea))));
                $division=explode("-",$linea);
                $obj->nro_comprobante=str_pad(trim($division[1]),20,"0",STR_PAD_LEFT);
                $obj->punto_venta=str_replace(">","0",$division[0]);

                break;

    case 11:
              $linea=str_replace(">","",strip_tags($linea));
              $linea=str_replace(".","",strip_tags($linea));

              if(trim($linea)!=="000"){
                  $obj->importe_neto_gravado=str_pad(str_replace("\n","",trim($linea)),15,"0",STR_PAD_LEFT);
                  if(strpos($obj->importe_neto_gravado,"-")!==FALSE)
                  {
                    $obj->importe_neto_gravado=str_replace("-","0",$obj->importe_neto_gravado);
                    $obj->importe_neto_gravado[0]="-";
                  }

                  $obj->alicuota_de_IVA="0005";
                  $obj->cant_alicuotas+=1;
                  $int =(int)$obj->importe_neto_gravado;
                  $iva=round(($int*0.21)/100,2);
                  $iva=str_replace(".","",strip_tags($iva));
                  $obj->impuesto_liquidado=str_pad(str_replace("\n","",trim($iva)),15,"0",STR_PAD_LEFT);
                  if(strpos($obj->impuesto_liquidado,"-")!==FALSE)
                  {
                    $obj->impuesto_liquidado=str_replace("-","0",$obj->impuesto_liquidado);
                    $obj->impuesto_liquidado[0]="-";
                  }

                    array_push($ArrayObject,$obj);
                }
               break;

    case 12:
              $obj2=new REGISTRO();
              $obj2->nro_id_vendedor=  $obj->nro_id_vendedor;
              $obj2->nro_comprobante=$obj->nro_comprobante;
              $obj2->punto_venta=  $obj->punto_venta;
              $obj2->tipo_comp=$obj->tipo_comp;
              $obj2->cant_alicuotas=  $obj->cant_alicuotas;

              $linea=str_replace(">","",strip_tags($linea));
              $linea=str_replace(".","",strip_tags($linea));
              if(trim($linea)!=="000")
              {
                  $obj2->importe_neto_gravado=str_pad(str_replace("\n","",trim($linea)),15,"0",STR_PAD_LEFT);

               if(strpos($obj2->importe_neto_gravado,"-")!==FALSE)
                  {

                    $obj2->importe_neto_gravado=str_replace("-","0",$obj2->importe_neto_gravado);

                    $obj2->importe_neto_gravado[0]="-";
                    print_r($nombre);
                  }

                  $obj2->alicuota_de_IVA="0004";
                  $obj2->cant_alicuotas+=1;
                  $int = (int)$obj2->importe_neto_gravado;
                  $iva=round(($int  *0.105)/100,2);
                  $iva=str_replace(".","",strip_tags($iva));
                  $obj2->impuesto_liquidado=str_pad(str_replace("\n","",trim($iva)),15,"0",STR_PAD_LEFT);
                  if(strpos($obj->impuesto_liquidado,"-")!==FALSE)
                  {
                    $obj2->impuesto_liquidado=str_replace("-","0",$obj->impuesto_liquidado);
                    $obj2->impuesto_liquidado[0]="-";
                  }
                    array_push($ArrayObject,$obj2);
                }

                break;




      default:
        # code...
        break;
    }

   $i++;
  }

  if(strpos($linea,'</tr>')!==FALSE and $bandera!=FALSE)
  {

      $i=0;
      $obj=new REGISTRO();
  }

 if(strpos($linea,'<tr>')!==FALSE)//EVITA EL PIE
 {
   break;
 };

  $bandera=TRUE;

}

fclose($archivo);

return $ArrayObject;
}


function guardar($nombre,$oc)
{
  $fp = fopen($nombre.".txt", "w");



  foreach ($oc as $obj) {
    $linea="";
    $linea.=trim($obj->tipo_comp);
    $linea.=trim($obj->punto_venta);
    $linea.=trim($obj->nro_comprobante);
    $linea.=$obj->cod_doc_vendedor;
    $linea.=$obj->nro_id_vendedor;
    $linea.=$obj->importe_neto_gravado;
    $linea.=$obj->alicuota_de_IVA;
    $linea.=$obj->impuesto_liquidado;
    $linea=preg_replace("/[\n|\r|\n\r]/i","",$linea);
    $linea.="\r\n";


    fputs($fp,$linea);


  }

  fclose($fp);
}
/*
$name="012015";
$ObjCollection= recorrer_ficheros($name);
echo "<pre>";
print_r($ObjCollection);
*/
//****************************************
for($mes=1;$mes<=12;$mes++){

if($mes<10)
$name="0".$mes."2015";
else
$name=$mes."2015";


$ObjCollection= recorrer_ficheros($name);
guardar($name,$ObjCollection);

}


?>
