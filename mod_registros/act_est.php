<?php
require("../mod_configuracion/conexion.php");
require("../theme/header_inicio.php");
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
<br />
<div class="titulo">Actualizaci&oacute;n Datos de Paciente</div><br /><br />
<?php
/************************************************************
****************** Eliminar Registros ***********************
************************************************************/
if(strtolower($_POST["del"]) == "eliminar"){
	
	$sqldelexp = "delete from expediente where ced_paciente='".(int)$_REQUEST["cedula"]."'";
	$sqldelpac = "delete from paciente where ced='".(int)$_REQUEST["cedula"]."'";
	$sqldelhis = "delete from historial where ced_pac='".(int)$_REQUEST["cedula"]."'";
	$sqldelpat = "delete from patologia where ced='".(int)$_REQUEST["cedula"]."'";
	
	if(  mysql_query($sqldelexp, $con) && mysql_query($sqldelpac, $con) && mysql_query($sqldelhis, $con) && mysql_query($sqldelpat, $con) ){
		cuadro_mensaje("Datos Eliminados Correctamente...");
		 			echo "<br><br><br><br><br>";
					require("../theme/footer_inicio.php");
					exit;
		
		}
	
	}

/************************************************************
****************** Editar Registros ***********************
************************************************************/
if (strtolower($_REQUEST["acc"])=="guardar"){
		//validaciones 
		if($_REQUEST["cedula"]=="" or $_REQUEST["nombre"]=="" or $_REQUEST["apellido"]=="" or 
		$_REQUEST["dia1"]=="" or $_REQUEST["mes1"]=="" or $_REQUEST["ano1"]=="" or 
		$_REQUEST["sexo"]=="" or $_REQUEST["nomrep"]=="" or $_REQUEST["telefono"]=="" or 
		$_REQUEST["sala"]=="" or $_REQUEST["direccion"]==""){
			cuadro_error("Debe llenar todos los campos");
		}else{
		//valida fecha de nacimiento
		if($_REQUEST["dia1"]<=0 or $_REQUEST["dia1"]>31 or $_REQUEST["mes1"]<=0 or $_REQUEST["mes1"]>12 or $_REQUEST["ano1"]<=0 or $_REQUEST["ano1"]<=1900){cuadro_error("Fecha errada, verifique.");}else{
		//Subir imagen a nuestro fichero
		$foto=quitar($_REQUEST["ant_foto"]);
		if($_FILES['userfile']['name']!=""){//comprueba que la imagen exista
		//INICIALIZACION DE VARIABLES PARA EL ARCHIVO
		//datos del arhivo
		$nombre_archivo = "fotopaciente/" . $_FILES['userfile']['name'];
		$tipo_archivo = $_FILES['userfile']['type'];
		$tamano_archivo = $_FILES['userfile']['size'];
		$nuevo_archivo= "fotopaciente/" . quitar($_REQUEST["cedula"] .'.'. substr($tipo_archivo,6,4));
		//compruebo si las características del archivo son las que deseo
		  if (!((strpos($tipo_archivo, "gif") || strpos($tipo_archivo, "jpeg")) && ($tamano_archivo < 5000000))) {
		    cuadro_error("La extensión o el tamaño de los archivos no es correcta, Se permiten archivos .gif o .jpg de 5 Mb máximo");
		    if($foto!="fotopasiente/NoPicture.gif"){
		  	$nuevo_archivo=$foto;
		    }else{
			$nuevo_archivo= "fotopaciente/NoPicture.gif";
  		         }	
		  }else{
			if (move_uploaded_file($_FILES['userfile']['tmp_name'], $nombre_archivo)){
			   @unlink($foto);
			   rename($nombre_archivo,$nuevo_archivo);
   		  //  cuadro_mensaje("El archivo ha sido cargado correctamente");
  			}else{
   				    cuadro_error("Ocurrió algún error al subir el archivo. No pudo guardarse");
 			     }
		  } 
		}else{
 		 if($foto!="fotopaciente/NoPicture.gif"){
		  	$nuevo_archivo=$foto;
		  }else{
			$nuevo_archivo= "fotopaciente/NoPicture.gif";
  		       }

		}//sino hay imagen asigna una por defecto
		//donde se llevan los datos a la BD
		if($_REQUEST["apellido"]!=""){		
		mysql_query("update historial set ced_pac='".$_REQUEST["cedula"]."' where dni_historial='".$_REQUEST["id_his"]."'",$con);
		}
			$sql="update paciente set ced='".$_REQUEST["cedula"]."',nombre='".strtoupper($_REQUEST["nombre"])."',apellido='".strtoupper($_REQUEST["apellido"])."',fec_nac='".$_REQUEST["ano1"]."-".$_REQUEST["mes1"]."-".$_REQUEST["dia1"]."',sexo='".$_REQUEST["sexo"]."',nombre_representante='".strtoupper($_REQUEST["nomrep"])."',pais='".$_REQUEST["pais"]."',estado='".$_REQUEST["estado"]."',ciudad='".$_REQUEST["ciudad"]."',municipio='".strtoupper($_REQUEST["municipio"])."',estado_civil='".$_REQUEST["estciv"]."',emergencia='".$_REQUEST["emergencia"]."',grusan='".$_REQUEST["grusan"]."',vih='".$_REQUEST["vih"]."',ocupacion='".$_REQUEST["ocupacion"]."',alergico='".$_REQUEST["alergico"]."',med_act='".$_REQUEST["medact"]."',enf_act='".strtoupper($_REQUEST["enfermedad"])."',peso='".strtoupper($_REQUEST["peso"])."',talla='".strtoupper($_REQUEST["talla"])."',foto='".$nuevo_archivo."' where id_paciente='".$_REQUEST["id_pac"]."'";
			$sql2="update expediente set ced_paciente='".$_REQUEST["cedula"]."',sala='".$_REQUEST["sala"]."',direccion='".strtoupper($_REQUEST["direccion"])."',telefono='".$_REQUEST["telefono"]."' where dni_exp='".$_REQUEST["id_exp"]."'";
			if(mysql_query($sql,$con)){
				if(mysql_query($sql2,$con)){
					cuadro_mensaje("paciente Actualizad@ Correctamente...");
					 echo "<br><br><br><br><br>";
					require("../theme/footer_inicio.php");
					exit;
				}else{
				cuadro_error(mysql_error());//emite un mensaje de error de la BD sino se realizo la operacion
				 echo "<br><br><br><br><br>";
				require("../footer_inicio.php");
					exit;
				}
			}else{
				cuadro_error(mysql_error());
				}
		//////////////
		}
		}
}
?>
<form action="act_est.php" method="post">
<table align="center" class="tabla">
<tr>
	<td colspan="2" align="center">Ingrese N&ordm; de Cedula del paciente</td>
	<tr>
	<td><input name="cedula1" type="text" value="" size="20"></td>
	<td><input type="submit" value="Buscar"></td>
	</tr>
</tr>
</table>
</form>
<?php
//busqueda en la base de datos
if($_REQUEST["cedula1"]!=""){
$result=mysql_query("select a.*,b.* from paciente a, expediente b where a.ced='".quitar($_REQUEST["cedula1"])."' and a.ced=b.ced_paciente",$con);
if(mysql_num_rows($result) == 1){
$cedula=mysql_result($result,0,"ced");
$id_pac=mysql_result($result,0,"id_paciente");
$id_exp=mysql_result($result,0,"dni_exp");
$nombre=mysql_result($result,0,"nombre");
$apellido=mysql_result($result,0,"apellido");
$sexo=mysql_result($result,0,"sexo");
$nomrep=mysql_result($result,0,"nombre_representante");
$telefono=mysql_result($result,0,"telefono");
$sala=mysql_result($result,0,"sala");
$foto=mysql_result($result,0,"foto");
$direccion=mysql_result($result,0,"direccion");
$pais=mysql_result($result,0,"pais");
$estado=mysql_result($result,0,"estado");
$ciudad=mysql_result($result,0,"ciudad");
$municipio=mysql_result($result,0,"municipio");
$estciv=mysql_result($result,0,"estado_civil");
$emergencia=mysql_result($result,0,"emergencia");
$grusan=mysql_result($result,0,"grusan");
$vih=mysql_result($result,0,"vih");
$ocupacion=mysql_result($result,0,"ocupacion");
$alergico=mysql_result($result,0,"alergico");
$medact=mysql_result($result,0,"med_act");
$enfermedad=mysql_result($result,0,"enf_act");
$peso=mysql_result($result,0,"peso");
$talla=mysql_result($result,0,"talla");
$dia1=substr(mysql_result($result,0,"fec_nac"),8,2);
$mes1=substr(mysql_result($result,0,"fec_nac"),5,2);
$ano1=substr(mysql_result($result,0,"fec_nac"),0,4);
?>
<form name="registro" action="act_est.php" method="post" enctype="multipart/form-data">
<input type="hidden" name="ant_foto" value="<?php echo $foto;?>">
<input type="hidden" name="id_pac" value="<?php echo $id_pac;?>">
<input type="hidden" name="id_exp" value="<?php echo $id_exp;?>">
<?php $r=mysql_query("select dni_historial from historial where ced_pac='".$cedula."'",$con);
if(mysql_num_rows($r) == 1){echo '
					<input type="hidden" name="id_his" value="<?php echo mysql_result($result,0,"dni_historial")';}?>
				
<br>
<table width="650" align="center" class="tabla">
<tr>
	<td class="tdatos" colspan="2" align="center"><h3>DATOS PERSONALES DEL PACIENTE</h3></td>
</tr>
<tr>
	<td class="tdatos">C&eacute;dula</td>
	<td><input type="text" name="cedula" value="<?php echo $cedula; ?>" size="12" /></td>
</tr>
<tr>
	<td class="tdatos">Foto</td>
	<td><IMG SRC="<?php echo $foto; ?>" TITLE="<?php echo $nombre; ?>" WIDTH=80	HEIGHT=100></td>
</tr>
<tr>
	<td class="tdatos">Cambiar Foto</td>
	<td><input name="userfile" type="file"/></td>
</tr>
<tr>
	<td class="tdatos">Nombres</td>
	<td><input type="text" name="nombre" value="<?php echo $nombre; ?>" size="40" /></td>
</tr>
<tr>
	<td class="tdatos">Apellidos</td>
	<td><input type="text" name="apellido" value="<?php echo $apellido; ?>" size="40" /></td>
</tr>
<tr>
	<td  class="tdatos">Fecha de Nacimiento</td>
	<td><input type="text" name="dia1" value="<?php echo $dia1; ?>" size="1" />/<input type="text" name="mes1" value="<?php echo $mes1; ?>" size="1" />/<input type="text" name="ano1" value="<?php echo $ano1; ?>" size="2" />d&iacute;a/mes/a&ntilde;o</td>
</tr>
<tr>
	<td class="tdatos">Sexo</td>
	<td>
		<select name="sexo">
			<option value="">Seleccione</option>
			<option value="M" <?php if ($sexo=="M") echo "selected" ?>>MASCULINO</option>
			<option value="F" <?php if ($sexo=="F") echo "selected" ?>>FEMENINO</option>
		</select>
	</td>
</tr>
<tr>
	<td class="tdatos">Nombre del Representante</td>
	<td><input type="text" name="nomrep" value="<?php echo $nomrep; ?>" size="40" /></td>
</tr>
<tr>
	<td class="tdatos">Telefonos</td>
	<td><input type="text" name="telefono" value="<?php echo $telefono; ?>" size="20" /></td>
</tr>
<tr>
	<td class="tdatos">Sala</td>
	<td>
			<select name="sala">
			<option value="">seleccione</option>
			<?php
				$result2=mysql_query("select * from sala",$con);
				while($row2=mysql_fetch_assoc($result2)){
					if ($row2["id_sala"]==$seccion){ $slt="selected ";}else{ $slt="";}
					echo "<option $slt value=\"".$row2["id_sala"]."\">".$row2["denominacion"]."</option>\n";
				}
			?>
			</select>
	</td>
</tr>
<tr>
	<td class="tdatos">Direcci&oacute;n</td>
	<td><textarea rows="2" name="direccion" cols="40"><?php echo $direccion; ?></textarea></td>
</tr>
<tr>
	<td class="tdatos">Pais</td>
	<td>
		<select name="pais">
			<option value="">Seleccione</option>			
			<option value="A" <?php if ($pais=="A") echo "selected" ?>>ARGENTINA</option>
			<option value="B" <?php if ($pais=="B") echo "selected" ?>>BOLIVIA</option>
			<option value="B" <?php if ($pais=="B") echo "selected" ?>>BRASIL</option>
			<option value="C" <?php if ($pais=="C") echo "selected" ?>>CHILE</option>
			<option value="C" <?php if ($pais=="C") echo "selected" ?>>COLOMBIA</option>
			<option value="C" <?php if ($pais=="C") echo "selected" ?>>COSTA RICA</option>
			<option value="C" <?php if ($pais=="C") echo "selected" ?>>CUBA</option>
			<option value="R" <?php if ($pais=="R") echo "selected" ?>>REPUBLICA DOMINICANA</option>
			<option value="E" <?php if ($pais=="E") echo "selected" ?>>ECUADOR</option>
			<option value="E" <?php if ($pais=="E") echo "selected" ?>>EL SALVADOR</option>
			<option value="G" <?php if ($pais=="G") echo "selected" ?>>GUATEMALA</option>
			<option value="H" <?php if ($pais=="H") echo "selected" ?>>HAITI</option>
			<option value="H" <?php if ($pais=="H") echo "selected" ?>>HONDURAS</option>
			<option value="M" <?php if ($pais=="M") echo "selected" ?>>MEXICO</option>
			<option value="N" <?php if ($pais=="N") echo "selected" ?>>NICARAGUA</option>
			<option value="P" <?php if ($pais=="P") echo "selected" ?>>PANAMA</option>
			<option value="P" <?php if ($pais=="P") echo "selected" ?>>PARAGUAY</option>
			<option value="P" <?php if ($pais=="P") echo "selected" ?>>PERU</option>
			<option value="U" <?php if ($pais=="U") echo "selected" ?>>URUGUAY</option>
			<option value="V" <?php if ($pais=="V") echo "selected" ?>>VENEZUELA</option>
							
		</select>
	</td>
</tr>	
<tr>
	<td class="tdatos">estado</td>
	<td><input type="text" name="estado" value="<?php echo $estado; ?>" size="13" /></td>
</tr>
<tr>
	<td class="tdatos">Ciudad</td>
	<td><input type="text" name="ciudad" value="<?php echo $ciudad; ?>" size="13" /></td>
</tr>
<tr>
	<td class="tdatos">municipio</td>
	<td><input type="text" name="municipio" value="<?php echo $municipio; ?>" size="15" /></td>
</tr>
<tr>
	<td class="tdatos">Estado Civil</td>
	<td>
		<select name="estciv">
			<option value="">Seleccione</option>
			<option value="C" <?php if ($estciv=="C") echo "selected" ?>>CASAD@</option>
			<option value="S" <?php if ($estciv=="S") echo "selected" ?>>SOLTER@</option>
		</select>
	</td>
</tr>
<tr>
	<td class="tdatos">Emergencia</td>
	<td><textarea rows="2" name="emergencia" cols="40"><?php echo $emergencia; ?></textarea></td>
</tr>
<tr>
	<td class="tdatos">Grupo Sanguineo</td>
	<td>
		<select name="grusan">
			<option value="">Seleccione</option>
			<option value="AME" <?php if ($grusan=="AME") echo "selected" ?>>A RH-</option>
			<option value="AMA" <?php if ($grusan=="AMA") echo "selected" ?>>A RH+</option>
			<option value="ABME" <?php if ($grusan=="ABME") echo "selected" ?>>AB RH-</option>
			<option value="ABMA" <?php if ($grusan=="ABMA") echo "selected" ?>>AB RH+</option>
			<option value="BME" <?php if ($grusan=="BME") echo "selected" ?>>B RH-</option>
			<option value="BMA" <?php if ($grusan=="BMA") echo "selected" ?>>B RH+</option>
			<option value="OME" <?php if ($grusan=="OME") echo "selected" ?>>O RH-</option>
			<option value="OMA" <?php if ($grusan=="OMA") echo "selected" ?>>O RH+</option>
			
		</select>
	</td>
</tr>
<tr>
	<td class="tdatos">VIH</td>
	<td>
		<select name="vih">
			<option value="">Seleccione</option>
			<option value="S" <?php if ($vih=="S") echo "selected" ?>>SI</option>
			<option value="N" <?php if ($vih=="N") echo "selected" ?>>NO</option>
		</select>
	</td>
</tr>
<tr>
	<td class="tdatos">Peso</td>
	<td><input type="text" name="peso" value="<?php echo $peso; ?>" size="5" /></td>
</tr>
<tr>
	<td class="tdatos">Talla</td>
	<td><input type="text" name="talla" value="<?php echo $talla; ?>" size="5" /></td>
</tr>
<tr>
	<td class="tdatos">Ocupacion</td>
	<td><input type="text" name="ocupacion" value="<?php echo $ocupacion; ?>" size="40" /></td>
</tr>
<tr>
	<td class="tdatos">Alergico</td>
	<td><textarea rows="4" name="alergico" cols="40"><?php echo $alergico; ?></textarea></td>
</tr>
<tr>
	<td class="tdatos">Medicamento Que Toma Actualmente</td>
	<td><textarea rows="4" name="medact" cols="40"><?php echo $medact; ?></textarea></td>
</tr>
<tr>
	<td class="tdatos">Enfermedad Que Tiene</td>
	<td><textarea rows="4" name="enfermedad" cols="40"><?php echo $enfermedad; ?></textarea></td>
</tr>
<tr>
	<td colspan="2" align="center"><input type="submit" name="acc" value="Guardar">    
	&nbsp; 
	<input type="submit" name="del" value="Eliminar" onclick="confirmation();"></td>
</tr>
</table>
</form>
<?php
}else{
	echo "<br>";
	cuadro_error("Paciente No Encontrado <b><a href=reg_est.php  target=\"_self\">    Ir a Registrar</a></b>");	
}
}
?>

<?php
 echo "<br><br><br><br><br>";
require("../theme/footer_inicio.php");
?>
