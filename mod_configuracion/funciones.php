<?php 
/*******************************************************************
**************     Medical Center Version 1.0.1    *****************
********************************************************************
***************  @Author ISC.Ulises Rodriguez T.   *****************
********************************************************************
***************   @Author Ing.Jorge Hernández.     *****************
********************************************************************
***************          @copyright 2010           ***************** 
********************************************************************
***************           @No modificar            *****************
********************************************************************/
?>
<?php
function cuadro_error($mensaje){
	if ($mensaje!=""){
	echo '
		<table width="300" align="center" class="cuadro_error">
		<tr>
			<td><div class="mensaje_error">'.$mensaje.'</div></td>
		</tr>
		</table><br />
	';
	}
}
function cuadro_mensaje($mensaje){
if ($mensaje!=""){
	echo '
		<table width="300" align="center" class="cuadro_mensaje">
		<tr>
			<td><div class="mensaje_error">'.$mensaje.'</div></td>
		</tr>
		</table><br />
	';
	}
}
function quitar($mensaje)
{
$mensaje = str_replace("<","&lt;",$mensaje);
$mensaje = str_replace(">","&gt;",$mensaje);
$mensaje = str_replace("\'","&#39;",$mensaje);
$mensaje = str_replace('\"',"&quot;",$mensaje);
$mensaje = str_replace("\\\\","&#92;",$mensaje);
$mensaje = str_replace(" ","",$mensaje);
$mensaje = str_replace("+","",$mensaje);
return $mensaje;
}
function fecha($fecha){
		$dia=substr($fecha,8,2);
		$mes=substr($fecha,5,2);
		$ano=substr($fecha,0,4);
return $dia.'/'.$mes.'/'.$ano;
}
function numero($str)
{
  $legalChars = "%[^0-9\-\. ]%";

  $str=preg_replace($legalChars,"",$str);
  return $str;
}
function admin(){
	if ($_SESSION["tipo"]!="AD"){
	cuadro_error("ACCESO RESTRINGIDO A ESTA SECCION");
	exit;
	}
}
?>
