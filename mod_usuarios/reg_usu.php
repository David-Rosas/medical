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
<div class="titulo">Registro de Usuarios y Profesional</div><br /><br />
<?php 
if (strtolower($_REQUEST["acc"])=="registrar"){
			if($_REQUEST["nombre"]!="" or $_REQUEST["login"]!="" or $_REQUEST["pass1"]!=""or $_REQUEST["pass2"]!="" or $_REQUEST["tipo"]!="" or $_REQUEST["ced_prof"]!="" or $_REQUEST["nombre_prof"]!="" or $_REQUEST["tipo_prof"]!="" ){
			
	if ($_REQUEST["pass1"]!=$_REQUEST["pass2"]){
		cuadro_error("Las contraseñas introducidas no coinciden");
	}else{
	$pass = ($_REQUEST["pass1"]);
	$sql_1 = mysqli_query("insert into usuarios(login,tipo,nombre,password) values('".htmlentities($_REQUEST["login"])."','".htmlentities($_REQUEST["tipo"])."','".strtoupper(htmlentities($_REQUEST["nombre"]))."','".htmlentities($pass)."') ",$con);
		
	$sql_2 = mysqli_query("insert into profesional values('".htmlentities($_REQUEST["ced_prof"])."','".strtoupper(htmlentities($_REQUEST["nombre_prof"]))."','".strtoupper(htmlentities($_REQUEST["tipo_prof"]))."')",$con);
	
	if(/*sql_1 and */sql_2)
	{
		echo"<br /><br />";
		cuadro_mensaje("Usuario Ingresado Correctamente. <b><a href=../index.php target=\"_self\"> Volver a Inicio</a></b><br><br>");
		require("../theme/footer_inicio.php");
		exit;
	} else
	{
		cuadro_error(mysqli_error());
	}
	}
}else
{
	cuadro_error("Debe llenar todos los campos.");
}

}
?>


<form name="usuarios" action="reg_usu.php" method="post">
<table class="tabla" align="center" width="500">
<tr>
	<td colspan="2" class="tdatos" align="center"><h3>DATOS DEL USUARIO</h3></td>
</tr>
<tr>
	<td class="tdatos">Nombre:</td>
	<td><input type="text" name="nombre" value="<?php echo $_REQUEST["nombre"]; ?>" size="45"></td>
</tr>
<tr>
	<td class="tdatos">Login</td>
	<td><input type="text" name="login" value="<?php echo $_REQUEST["login"]; ?>" onchange="this.form.submit()" size="45"></td>
</tr>
<?php
if ($_REQUEST["login"]!=""){
$result=mysql_query("select login from usuarios where login='".quitar($_REQUEST["login"])."' ",$con);
if(mysql_num_rows($result) == 1){
		echo '
     <tr>
	<td class="cuadro_error" colspan="2" align="center">Este login pertenece a otro usuario, cambie login</td>
      </tr>
		     ';
}else{
		echo '
     <tr>
	<td class="cuadro_mensaje" colspan="2" align="center">Login disponible</td>
      </tr>
		     ';
}
}
?>
<tr>
	<td class="tdatos">Password:</td>
	<td><input type="password" name="pass1" value="" size="45"></td>
</tr>
<tr>
	<td class="tdatos">Repetir Password:</td>
	<td><input type="password" name="pass2" value="" size="45"></td>
</tr>
<tr>
	<td class="tdatos">Tipo:</td>
	<td>
		<select name="tipo">
			<option value="ADMINISTRADOR" <?php if ($tipo=="ADMINISTRADOR") echo "selected" ?>>ADMINISTRADOR</option>
			<option value="ASISTENTE" <?php if ($tipo=="ASISTENTE") echo "selected" ?>>ASISTENTE</option>
		</select>
	</td>
</tr>
<!-- Add data to Table Professional -->
<tr>
	<td colspan="2" class="tdatos" align="center"><h3>DATOS DEL PROFECIONAL</h3></td>
<tr>
	<td class="tdatos">Cedula del Profesional:</td>
	<td><input type="text" name="ced_prof" value="<?php echo $_REQUEST["ced_prof"]; ?>"  size="45" /></td>
</tr>
<tr>
	<td class="tdatos">Nombre:</td>
	<td><input type="text" name="nombre_prof" value="<?php echo $_REQUEST["nombre_prof"]; ?>" size="45" /></td>
</tr>
<tr>
	<td class="tdatos">Tipo:</td>
	<td>
		<select name="tipo_prof">
			<option value="MEDICO" <?php if ($tipo=="MEDICO") echo "selected" ?>>MEDICO</option>
			<option value="ASISTENTE" <?php if ($tipo=="ASISTENTE") echo "selected" ?>>ASISTENTE</option>
			<option value="COORDINADOR" <?php if ($tipo=="COORDINADOR") echo "selected" ?>>COORDINADOR</option>
			<option value="PSICOLOGO" <?php if ($tipo=="PSICOLOGO") echo "selected" ?>>PSICOLOGO</option>
		</select>
		</td>
</tr>
<tr>
	<td colspan="2" align="center"><input type="submit" name="acc" value="Registrar" size="20">
	<input name="Restablecer" type="reset" value="Limpiar" /></td>
</tr>
</table>
</form>

<br /><br />
<?php
require("../theme/footer_inicio.php");
?>
