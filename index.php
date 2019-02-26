<?php
//  Incluye libreria con clase//
include_once "clase.php";


//RECORRE EL ARCHIVO SOLICITADO
function recorrer_ficheros($nombre)
{
$directorio = "C:/xampp/htdocs/compras/2017/".$nombre.".HTM";
$archivo = fopen($directorio, "r+");//$handle = $archivo
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
      case 5:
                $linea=str_replace(">","",strip_tags($linea));
                $obj->fecha=str_replace("\n","",str_replace("/","",strip_tags($linea)));
                break;

      case 7:
                if(strpos(strip_tags($linea),"A")!==FALSE)
                {
                $obj->tipo_comp="001";
                }

                break;
     case 9:
                $linea=str_replace("\n","",str_replace("/","",strip_tags(trim($linea))));
                $division=explode("-",$linea);
                $obj->nro_comprobante=str_pad(trim($division[1]),20,"0",STR_PAD_LEFT);
                $obj->punto_venta=str_replace(">","0",$division[0]);
                break;
    case 4:
                $arreglo=str_pad(str_replace("\n","",str_replace("-","",strip_tags(trim($linea)))),22,"0",STR_PAD_LEFT);
                $obj->nro_id_vendedor=trim(str_replace(">","",$arreglo));
                break;

    case 2:
                $linea=str_replace(">","",strip_tags(trim($linea)));

                $obj->razon_social=utf8_encode(str_pad(str_replace("\n","",trim($linea)),30," ",STR_PAD_RIGHT));
                if(strpos(strip_tags($linea),"ALFREDO")!==FALSE)
                {
                 $obj->razon_social=utf8_encode(str_pad(str_replace("\n","",trim("CORTINIA ALFREDO HUGO")),30," ",STR_PAD_RIGHT));

                }
                $obj->razon_social=substr( $obj->razon_social, 0,30);
                break;


    case 34:
                $linea=str_replace(">","",strip_tags($linea));
                $linea=str_replace(".","",strip_tags($linea));
                $obj->total_operacion=str_pad(str_replace("\n","",trim($linea)),15,"0",STR_PAD_LEFT);
                if(strpos($obj->total_operacion,"-"))
                {
                  $neg= $obj->total_operacion;
                  $neg=str_replace("-","0",$neg);
                  $neg[0]="-";
                  $obj->total_operacion=$neg;

                }  
                break;


    case 21:
                $linea=str_replace(">","",strip_tags("0"));
                $linea=str_replace(".","",strip_tags("0"));
                $obj->total_conceptos=str_pad(str_replace("\n","",trim($linea)),15,"0",STR_PAD_LEFT);
                break;
    case 19:
                $linea=str_replace(">","",strip_tags($linea));
                $linea=str_replace(".","",strip_tags($linea));

                $obj->importe_valor_agregado=str_pad(str_replace("\n","",trim($linea)),15,"0",STR_PAD_LEFT);
                if(trim($linea)!="000"){

                $obj->cant_alicuotas+=1;
                }
                  if(strpos($obj->importe_valor_agregado,"-"))
                {
                  $neg= $obj->importe_valor_agregado;
                  $neg=str_replace("-","0",$neg);
                  $neg[0]="-";
                  $obj->importe_valor_agregado=$neg;

                }
                break;
    case 20:
                $linea=str_replace(">","",strip_tags($linea));
                $linea=str_replace(".","",strip_tags($linea));
                if(trim($linea)!="000"){

                  $obj->importe_valor_agregado+= $linea;
                 if(strpos($obj->importe_valor_agregado,"-"))
                {
                  $neg= $obj->importe_valor_agregado;
                  $neg=str_replace("-","0",$neg);
                  $neg[0]="-";
                  $obj->importe_valor_agregado=$neg;

                }  

                  $obj->cant_alicuotas+=1;
                }
                break;

     case 26:
                $linea=str_replace(">","",strip_tags($linea));
                $linea=str_replace(".","",strip_tags($linea));
              
                  $obj->percep_iva= str_pad(str_replace("\n","",trim($linea)),15,"0",STR_PAD_LEFT);
               
                if(strpos($obj->percep_iva,"-"))
                {
                  $neg= $obj->percep_iva;
                  $neg=str_replace("-","0",$neg);
                  $neg[0]="-";
                  $obj->percep_iva=$neg;

                }  
                break;               


    case 28:
                $linea=str_replace(">","",strip_tags($linea));
                $linea=str_replace(".","",strip_tags($linea));
                $obj->importe_IB=str_pad(str_replace("\n","",trim($linea)),15,"0",STR_PAD_LEFT);
                 if(strpos($obj->importe_IB,"-"))
                {
                  $neg= $obj->importe_IB;
                  $neg=str_replace("-","0",$neg);
                  $neg[0]="-";
                  $obj->importe_IB=$neg;

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
      array_push($ArrayObject,$obj);
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
  $fp = fopen("COMPROBANTES/".$nombre.".txt", "w");


  foreach ($oc as $obj) {
    $linea="";
    $linea.=trim($obj->fecha);
    $linea.=trim($obj->tipo_comp);
    $linea.=trim($obj->punto_venta);
    $linea.=trim($obj->nro_comprobante);
    $linea.=$obj->despacho;
    $linea.=$obj->cod_doc_vendedor;
    $linea.=$obj->nro_id_vendedor;
    $linea.=$obj->razon_social;
    $linea.=$obj->total_operacion;
    $linea.=$obj->total_conceptos;
    $linea.=$obj->importe_op_exentas;
    $linea.=$obj->percep_iva;
    $linea.=$obj->importe_imp_nacionales;
    $linea.=$obj->importe_IB;
    $linea.=$obj->importes_IM;
    $linea.=$obj->impuestos_internos;
    $linea.=$obj->codigo_moneda;
    $linea.=$obj->tipo_cambio;
    $linea.=$obj->cant_alicuotas;
    $linea.=$obj->codigo_oper;

    $VAR=$obj->percep_iva + $obj->importe_valor_agregado + $obj->importe_IB;

    $obj->cred_fiscal_computable=str_pad(str_replace("\n","",trim($VAR)),15,"0",STR_PAD_LEFT);

        if(strpos( $obj->cred_fiscal_computable,"-"))
                {
                  $neg=  $obj->cred_fiscal_computable;
                  $neg=str_replace("-","0",$neg);
                  $neg[0]="-";
                   $obj->cred_fiscal_computable=$neg;

                }  
    $linea.=$obj->cred_fiscal_computable;

    
    $linea.=$obj->otros_tributos;
    $linea.=$obj->cuit_emi;
    $linea.=$obj->denominacion_emi;
    $linea.=$obj->iva_comision;
     $linea=preg_replace("/[\n|\r|\n\r]/i","",$linea);
    $linea.="\r\n";
    echo "<pre>";
    print_r($obj);
    echo "</pre>";
    fputs($fp,$linea);


  }

  fclose($fp);
}




//****************************************
//****************************************
for($mes=1;$mes<5;$mes++){

if($mes<10)
$name="0".$mes."2017";
else
$name=$mes."2017";


$ObjCollection= recorrer_ficheros($name);
guardar($name,$ObjCollection);

}




?>
