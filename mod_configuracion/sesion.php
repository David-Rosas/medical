<?php
session_start();
require("configuracion.php");

if ($_POST["usuario"]){
	$conn_bd=mysql_connect($bd_host, $bd_user, $bd_pass ) or die("Error en la conexión a la base de datos");
	mysql_query( $bd_name, $conn_bd );
	$result=mysql_query("SELECT * FROM usuarios WHERE login='".$_POST["usuario"]."' and password='".$_POST["password"]."'",$conn_bd);
	
	if (mysql_num_rows($result)==1){
		$_SESSION["usuario"]=mysql_fetch_result($result,0,"login");
		$_SESSION["tipo"]=mysql_fetch_result($result,0,"tipo");
		$_SESSION["nombre"]=mysql_fetch_result($result,0,"nombre");
		header("Location: index.php");
	} else
	{
		?>
        <script type="text/javascript">
		alert("Un error ha ocurrido \n Favor de contactar al Administrador");
		window.location = "../index.php";
		</script>
		<?php 
	}
}
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
