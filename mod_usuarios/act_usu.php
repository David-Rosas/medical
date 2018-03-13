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
<div class="titulo">Modificaci&oacute;n de Usuarios</div><br />
<div align="center"><br />
  <br />
  
  
  
  <?php 
if (strtolower($_REQUEST["acc"])=="modificar"){
			if($_REQUEST["nombre"]!="" or $_REQUEST["pass"]!=""or $_REQUEST["pass2"]!="" or $_REQUEST["tipo"]!=""){
	if ($_REQUEST["pass"]!=$_REQUEST["pass2"]){
		cuadro_error("Las contrase&ntilde;as introducidas no coinciden");
	}else
	{
	
	$pass = ($_REQUEST["pass"]);
	if (@mysqli_query("update usuarios set tipo='".$_REQUEST["tipo"]."',nombre='".strtoupper(htmlentities($_REQUEST["nombre"]))."',password='".htmlentities($pass)."' where id_usu='".$_REQUEST["iduser"]."' ",$con)){
		echo"<br /><br />";
		cuadro_mensaje("Usuario modificado correctamente. <b><a href=../index.php target=\"_self\"> Volver a Inicio</a></b><br><br><br><br><br><br>");
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
</div>
<div id="centercontent">
  <div align="center">
    <table>
      <td>
        <form action="act_usu.php" method="post">
          <input type="hidden" name="modificacion" value="login">
          <table class="tabla">
            <tr>
              <td colspan="2" align="center">Introduzca Login del Medico</td>
		    </tr>
            <tr>
              <td><input type="text" name="login" value="<?php echo $_REQUEST["login"]; ?>" size="15"></td>
			    <td><input type="submit" value="Buscar"></td>
		    </tr>
            </table>
	    </form>    </td>
    <td>
      <form action="act_usu.php" method="post">
        <input type="hidden" name="modificacion" value="nombre">
        <table class="tabla">
          <tr>
            <td colspan="2" align="center">Ingrese Nombre del Medico</td>
		    </tr>
          <tr>
            <td><input type="text" name="nombre" value="<?php echo $_REQUEST["nombre"]; ?>" size="15"></td>
			    <td><input type="submit" value="Buscar"></td>
		    </tr>
          </table>
	    </form>    </td>
    </table>
  </div>
</div>
<div align="center">
  <?php
if ($_REQUEST["login"]!="" or $_REQUEST["nombre"]!=""){
switch ($_REQUEST["modificacion"]){
	case'login':
	$result=mysqli_query("SELECT * FROM usuarios WHERE login='".$_REQUEST["login"]."'");
	break;
	case'nombre':
	$result=mysqli_query("SELECT * FROM usuarios WHERE nombre like '%".strtoupper($_REQUEST["nombre"])."%'");
	break;
	}
if (mysqli_num_rows(($result))==1){

?>
</div>
<form name="usuarios" action="act_usu.php" method="post">
<input type="hidden" name="iduser" value="<?php echo mysqli_result($result,0,"id_usu");?>">
<table class="tabla" align="center" width="500">
<tr>
	<td colspan="4" class="tdatos" align="center"><h3>DATOS DEL USUARIO MEDICO</h3></td>
</tr>
<tr>
	<td class="tdatos">Nombre</td>
	<td><input type="text" name="nombre" value="<?php echo mysqli_result($result,0,"nombre"); ?>" size="45"></td>
</tr>
<tr>
	<td class="tdatos">Login</td>
	<td><input type="text" name="login" value="<?php echo mysqli_result($result,0,"login"); ?>" readonly size="45"></td>
</tr>
<tr>
	<td class="tdatos">Password</td>
	<td><input type="password" name="pass" value="<?php echo mysqli_result($result,0,"password"); ?>" size="45"></td>
</tr>
<tr>
	<td class="tdatos">Repetir Password</td>
	<td><input type="password" name="pass2" value="<?php echo mysqli_result($result,0,"password"); ?>" size="45"></td>
</tr>
<tr>
	<td class="tdatos">Tipo</td>
	<td>
		<select name="tipo">
			<option value="ME" <?php if ($tipo=="ME") echo "selected" ?>>MEDICO</option>
			<option value="AS" <?php if ($tipo=="AS") echo "selected" ?>>ASISTENTE</option>
			<option value="CO" <?php if ($tipo=="CO") echo "selected" ?>>COORDINADOR</option>
			<option value="PS" <?php if ($tipo=="PS") echo "selected" ?>>PSICOLOGO</option>
		</select>
	</td>
</tr>
<tr>
	<td colspan="3" align="center"><input type="submit" name="acc" value="Modificar" size="20"></td>
</tr>
</table>
</form>

<?php
	}else{
		cuadro_mensaje ("No se encontraron registros");
	}
}
?>

<?php
require("../theme/footer_inicio.php");
?>
