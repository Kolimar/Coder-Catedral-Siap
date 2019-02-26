<?php
//vendedor = proveedor
class REGISTRO
{
  //Las variables son declaradas publicas salvo q se indique lo contrario..//

  var $tipo_comp;//8-11
  var $punto_venta;//talon de comprobante
  var $nro_comprobante;//resto
  var $cod_doc_vendedor;//80
  var $nro_id_vendedor;//CUIT
  var $importe_neto_gravado;
  var $alicuota_de_IVA;//codigo 005(21%) - 004(10.5%)
  var $impuesto_liquidado;
  var $cant_alicuotas;

 public function REGISTRO(){

   $this->cod_doc_vendedor="80";

  }

}




?>
