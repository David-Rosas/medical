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
<div class="titulo">Registro del Paciente</div><br /><br />
<?php
if (strtolower($_REQUEST["acc"])=="registrar"){
		//validaciones 
		if($_REQUEST["cedula"]=="" or $_REQUEST["nombre"]=="" or $_REQUEST["apellido"]=="" or 
		$_REQUEST["dia1"]=="" or $_REQUEST["mes1"]=="" or $_REQUEST["ano1"]=="" or 
		$_REQUEST["sexo"]=="" or $_REQUEST["nomrep"]=="" or $_REQUEST["telefono"]=="" or 
		$_REQUEST["sala"]=="" or  $_REQUEST["direccion"]==""){
			cuadro_error("Debe llenar todos los campos");
		}else{
		//valida fecha de nacimiento
		if($_REQUEST["dia1"]<=0 or $_REQUEST["dia1"]>31 or $_REQUEST["mes1"]<=0 or $_REQUEST["mes1"]>12 or $_REQUEST["ano1"]<=0 or $_REQUEST["ano1"]<=1900){cuadro_error("Fecha errada, verifique.");}else{
		//Subir imagen a nuestro fichero
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
		}else{
			if (move_uploaded_file($_FILES['userfile']['tmp_name'], $nombre_archivo)){
			   rename($nombre_archivo,$nuevo_archivo);
   		  //  cuadro_mensaje("El archivo ha sido cargado correctamente");
  			}else{
   				    cuadro_error("Ocurrió algún error al subir el archivo. No pudo guardarse");
 			     }
} 
		}else{$nuevo_archivo= "fotopaciente/NoPicture.gif";}//sino hay imagen asigna una por defecto
		//donde se llevan los datos a la BD
			$sql="insert into paciente(ced,nombre,apellido,fec_nac,sexo,nombre_representante,pais,estado,ciudad,municipio,estado_civil,emergencia,grusan,vih,ocupacion,alergico,med_act,enf_act,peso,talla,foto) values('".$_REQUEST["cedula"]."','".strtoupper($_REQUEST["nombre"])."','".strtoupper($_REQUEST["apellido"])."','".$_REQUEST["ano1"]."-".$_REQUEST["mes1"]."-".$_REQUEST["dia1"]."','".$_REQUEST["sexo"]."','".strtoupper($_REQUEST["nomrep"])."','".$_REQUEST["pais"]."','".strtoupper($_REQUEST["estado"])."','".strtoupper($_REQUEST["ciudad"])."','".strtoupper($_REQUEST["municipio"])."','".$_REQUEST["estciv"]."','".strtoupper($_REQUEST["emergencia"])."','".$_REQUEST["grusan"]."','".$_REQUEST["vih"]."','".strtoupper($_REQUEST["ocupacion"])."','".strtoupper($_REQUEST["alergico"])."','".strtoupper($_REQUEST["medact"])."','".strtoupper($_REQUEST["enfermedad"])."','".strtoupper($_REQUEST["peso"])."','".strtoupper($_REQUEST["talla"])."','".$nuevo_archivo."')";
			$sql2="insert into expediente(ced_paciente,estado_exp,sala,direccion,telefono) values('".$_REQUEST["cedula"]."','0','".$_REQUEST["sala"]."','".$_REQUEST["direccion"]."','".$_REQUEST["telefono"]."')";
			if(mysql_query($sql,$con)){
				if(mysql_query($sql2,$con)){
					cuadro_mensaje("Paciente Registrad@ Correctamente...");
					 echo "<br><br><br><br><br>";
					require("../theme/footer_inicio.php");
					exit;
				}else{
				cuadro_error(mysql_error());//emite un mensaje de error de la BD sino se realizo la operacion
				}
			}else{
				cuadro_error(mysql_error());
				}
		//////////////
		}
		}
}
?>
<form name="registro" action="reg_est.php" method="post" enctype="multipart/form-data">
<table width="700" align="center" class="tabla">
<tr>
	<td class="tdatos" colspan="2" align="center"><h3>DATOS PERSONALES DEL PACIENTE</h3></td>
</tr>
<tr>
	<td class="tdatos">C&eacute;dula</td>
	<td class="dtabla"><input type="text" name="cedula" value="<?php echo $_REQUEST["cedula"]; ?>" size="12" /></td>
</tr>
<tr>
	<td class="tdatos">Foto</td>
	<td class="dtabla"><input name="userfile" type="file"/></td>
</tr>
<tr>
	<td class="tdatos">Nombres</td>
	<td class="dtabla"><input type="text" name="nombre" value="<?php echo $_REQUEST["nombre"]; ?>" size="40" /></td>
</tr>
<tr>
	<td class="tdatos">Apellidos</td>
	<td class="dtabla"><input type="text" name="apellido" value="<?php echo $_REQUEST["apellido"]; ?>" size="40" /></td>
</tr>
<tr>
	<td  class="tdatos">Fecha de Nacimiento</td>
	<td class="dtabla"><input type="text" name="dia1" value="<?php echo $_REQUEST["dia1"]; ?>" size="1" />/<input type="text" name="mes1" value="<?php echo $_REQUEST["mes1"]; ?>" size="1" />/<input type="text" name="ano1" value="<?php echo $_REQUEST["ano1"]; ?>" size="2" />d&iacute;a/mes/a&ntilde;o</td>
</tr>
<tr>
	<td class="tdatos">Sexo</td>
	<td class="dtabla">
		<select name="sexo">
			<option value="">Seleccione</option>
			<option value="M" <?php if ($_REQUEST["sexo"]=="M") echo "selected" ?>>MASCULINO</option>
			<option value="F" <?php if ($_REQUEST["sexo"]=="F") echo "selected" ?>>FEMENINO</option>
			
		
		
		</select>
	</td>
</tr>
<tr>
	<td class="tdatos">Nombre del Representante</td>
	<td class="dtabla"><input type="text" name="nomrep" value="<?php echo $_REQUEST["nomrep"]; ?>" size="40" /></td>
</tr>
<tr>
	<td class="tdatos">Telefonos</td>
	<td class="dtabla"><input type="text" name="telefono" value="<?php echo $_REQUEST["telefono"]; ?>" size="20" /></td>
</tr>
<tr>
	<td class="tdatos">Sala</td>
	<td class="dtabla">
			<select name="sala">
			<option value="">Seleccione</option>
			<?php
				$result2=mysql_query("select * from sala",$con);
				while($row2=mysql_fetch_assoc($result2)){
					if ($row2["id_sala"]==$_REQUEST["sala"]){ $slt="selected ";}else{ $slt="";}
					echo "<option $slt value=\"".$row2["id_sala"]."\">".$row2["denominacion"]."</option>\n";
				}
			?>
			</select>	
	</td>
</tr>
<tr>
	<td class="tdatos">Direcci&oacute;n</td>
	<td class="dtabla"><textarea rows="2" name="direccion" cols="40"><?php echo $_REQUEST["direccion"]; ?></textarea></td>
</tr>
<tr>
	<td class="tdatos">Pais</td>
	<td class="dtabla">
		<select name="pais">
			<option value="">Seleccione</option>
			<option value="ARG" <?php if ($_REQUEST["pais"]=="ARG") echo "selected" ?>>ARGENTINA</option>
			<option value="BOL" <?php if ($_REQUEST["pais"]=="BOL") echo "selected" ?>>BOLIVIA</option>
			<option value="BRA" <?php if ($_REQUEST["pais"]=="BRA") echo "selected" ?>>BRASIL</option>
			<option value="CHI" <?php if ($_REQUEST["pais"]=="CHI") echo "selected" ?>>CHILE</option>
			<option value="COL" <?php if ($_REQUEST["pais"]=="COL") echo "selected" ?>>COLOMBIA</option>
			<option value="COS" <?php if ($_REQUEST["pais"]=="COS") echo "selected" ?>>COSTA RICA</option>
			<option value="CUB" <?php if ($_REQUEST["pais"]=="CUB") echo "selected" ?>>CUBA</option>
			<option value="REP" <?php if ($_REQUEST["pais"]=="REP") echo "selected" ?>>REPUBLICA DOMINICANA</option>
			<option value="ECU" <?php if ($_REQUEST["pais"]=="ECU") echo "selected" ?>>ECUADOR</option>
			<option value="ELS" <?php if ($_REQUEST["pais"]=="ELS") echo "selected" ?>>EL SALVADOR</option>
			<option value="GUA" <?php if ($_REQUEST["pais"]=="GUA") echo "selected" ?>>GUATEMALA</option>
			<option value="HAI" <?php if ($_REQUEST["pais"]=="HAI") echo "selected" ?>>HAITI</option>
			<option value="HON" <?php if ($_REQUEST["pais"]=="HON") echo "selected" ?>>HONDURAS</option>
			<option value="MEX" <?php if ($_REQUEST["pais"]=="MEX") echo "selected" ?>>MEXICO</option>
			<option value="NIC" <?php if ($_REQUEST["pais"]=="NIC") echo "selected" ?>>NICARAGUA</option>
			<option value="PAN" <?php if ($_REQUEST["pais"]=="PAN") echo "selected" ?>>PANAMA</option>
			<option value="PAR" <?php if ($_REQUEST["pais"]=="PAR") echo "selected" ?>>PARAGUAY</option>
			<option value="PER" <?php if ($_REQUEST["pais"]=="PER") echo "selected" ?>>PERU</option>
			<option value="URU" <?php if ($_REQUEST["pais"]=="URU") echo "selected" ?>>URUGUAY</option>
			<option value="VEN" <?php if ($_REQUEST["pais"]=="VEN") echo "selected" ?>>VENEZUELA</option>
							
		</select>
	</td>
</tr>
<tr>
	<td class="tdatos">Estado</td>
	<td class="dtabla"><input type="text" name="estado" value="<?php echo $_REQUEST["estado"]; ?>" size="13" /></td>
</tr>
<tr>
	<td class="tdatos">Ciudad</td>
	<td class="dtabla"><input type="text" name="ciudad" value="<?php echo $_REQUEST["ciudad"]; ?>" size="13" /></td>
</tr>
<tr>
	<td class="tdatos">Municipio</td>
	<td class="dtabla"><input type="text" name="municipio" value="<?php echo $_REQUEST["municipio"]; ?>" size="15" /></td>
</tr>
<tr>
	<td class="tdatos">Estado Civil</td>
	<td class="dtabla">
		<select name="estciv">
			<option value="">Seleccione</option>
			<option value="C" <?php if ($_REQUEST["estciv"]=="C") echo "selected" ?>>CASAD@</option>
			<option value="S" <?php if ($_REQUEST["estciv"]=="S") echo "selected" ?>>SOLTER@</option>		
		
		</select>
	</td>
</tr>
<tr>
	<td class="tdatos">Emergencia</td>
	<td class="dtabla"><textarea rows="2" name="emergencia" cols="40"><?php echo $_REQUEST["emergencia"]; ?></textarea></td>
</tr>
<tr>
	<td class="tdatos">Grupo Sanguineo</td>
	<td class="dtabla">
		<select name="grusan">
			<option value="">Seleccione</option>
			<option value="AME" <?php if ($_REQUEST["grusan"]=="AME") echo "selected" ?>>A RH-</option>
			<option value="AMA" <?php if ($_REQUEST["grusan"]=="AMA") echo "selected" ?>>A RH+</option>
			<option value="ABME" <?php if ($_REQUEST["grusan"]=="ABME") echo "selected" ?>>AB RH-</option>
			<option value="ABMA" <?php if ($_REQUEST["grusan"]=="ABMA") echo "selected" ?>>AB RH+</option>
			<option value="BME" <?php if ($_REQUEST["grusan"]=="BME") echo "selected" ?>>B RH-</option>
			<option value="BMA" <?php if ($_REQUEST["grusan"]=="BMA") echo "selected" ?>>B RH+</option>
			<option value="OME" <?php if ($_REQUEST["grusan"]=="OME") echo "selected" ?>>O RH-</option>
			<option value="OMA" <?php if ($_REQUEST["grusan"]=="OMA") echo "selected" ?>>O RH+</option>		
		
		</select>
	</td>
</tr>
<tr>
	<td class="tdatos">VIH</td>
	<td class="dtabla"> 
		<select name="vih">
			<option value="">Seleccione</option>
			<option value="S" <?php if ($_REQUEST["vih"]=="S") echo "selected" ?>>SI</option>
			<option value="N" <?php if ($_REQUEST["vih"]=="N") echo "selected" ?>>NO</option>		
		
		</select>
	</td>
</tr>
<tr>
	<td class="tdatos">Ocupacion</td>
	<td class="dtabla"><input type="text" name="ocupacion" value="<?php echo $_REQUEST["ocupacion"]; ?>" size="20" /></td>
</tr>
<tr>
	<td class="tdatos">Peso</td>
	<td class="dtabla"><input type="text" name="peso" value="<?php echo $_REQUEST["peso"]; ?>" size="5" /></td>
</tr>
<tr>
	<td class="tdatos">Talla</td>
	<td class="dtabla"><input type="text" name="talla" value="<?php echo $_REQUEST["talla"]; ?>" size="5" /></td>
</tr>
<tr>
	<td class="tdatos">Alergico</td>
	<td class="dtabla"><textarea rows="4" name="alergico" cols="40"><?php echo $_REQUEST["alergico"]; ?></textarea></td>
</tr>
<tr>
	<td class="tdatos">Medicamento Que Toma Actualmente</td>
	<td class="dtabla"><textarea rows="4" name="medact" cols="40"><?php echo $_REQUEST["medact"]; ?></textarea></td>
</tr>
<tr>
	<td class="tdatos">Enfermedad Que Tiene</td>
	<td class="dtabla"><textarea rows="4" name="enfermedad" cols="40"><?php echo $_REQUEST["enfermedad"]; ?></textarea></td>
</tr>
<tr>
	<td colspan="2" align="center"><input type="submit" name="acc" value="Registrar">
	<input name="Restablecer" type="reset" value="Limpiar" /></td>
</tr>
</table>
</form>
<?php
require("../theme/footer_inicio.php");
?>
