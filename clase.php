<?php
//vendedor = proveedor
class REGISTRO
{
  //Las variables son declaradas publicas salvo q se indique lo contrario..//
  var $fecha;//0-7
  var $tipo_comp;//8-11
  var $punto_venta;//talon de comprobante
  var $nro_comprobante;//resto
  var $despacho;//vacio
  var $cod_doc_vendedor;//80
  var $nro_id_vendedor;//CUIT
  var $razon_social;//Razón social del Proveedor
  var $total_operacion;//TOTAL
  var $total_conceptos;//TOTAL /1.21
  var $importe_op_exentas;//0.00
  var $percep_iva;//IVA
  var $importe_valor_agregado;
  var $importe_imp_nacionales;//0.00
  var $importe_IB;//percep IB
  var $importes_IM;//0.00
  var $impuestos_internos;//0.00
  var $codigo_moneda;//PES
  var $tipo_cambio;//1.000000
  var $cant_alicuotas;//
  var $codigo_oper;//
  var $cred_fiscal_computable;//
  var $otros_tributos;//
  var $cuit_emi;//
  var $denominacion_emi;//
  var $iva_comision;//

 public function REGISTRO(){
   $this->importes_IM=str_pad("000",15,"0",STR_PAD_LEFT);
   $this->importe_op_exentas=str_pad("000",15,"0",STR_PAD_LEFT);
   $this->importe_imp_nacionales=str_pad("000",15,"0",STR_PAD_LEFT);
   $this->cod_doc_vendedor="80";
   $this->codigo_moneda="PES";
   $this->cuit_emi=str_pad("",11,"0",STR_PAD_LEFT);
   $this->denominacion_emi=str_pad(" ",30," ",STR_PAD_LEFT);//1
   $this->iva_comision=str_pad("",15,"0",STR_PAD_LEFT);
   $this->despacho=str_pad(" ",16," ",STR_PAD_LEFT);//2
   $this->cred_fiscal_computable=str_pad("000",15,"0",STR_PAD_LEFT);
   $this->codigo_oper="0";
   $this->cant_alicuotas=0;
   $this->tipo_cambio=str_pad("1000000",10,"0",STR_PAD_LEFT);
   $this->impuestos_internos=str_pad("000",15,"0",STR_PAD_LEFT);
   $this->otros_tributos=str_pad("000",15,"0",STR_PAD_LEFT);

  }

}




?>
