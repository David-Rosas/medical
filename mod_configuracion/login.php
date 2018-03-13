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
require("configuracion.php");
require("funciones.php");
session_start();
$_SESSION=array();

if ($_POST["usuario"]){
	$conn_bd = mysqli_connect($bd_host,$bd_usuario,$bd_pass) or die("Error en la conexión a la base de datos");
	mysqli_select_db($conn_bd, $bd_base);
	$sql="SELECT * FROM usuarios WHERE login='".htmlentities($_POST["usuario"])."' and password='".$_POST["password"]."'";
	$result = mysqli_query($conn_bd, $sql);
	if (mysqli_num_rows($result)==1){
		$_SESSION["login"]=mysqli_result($result,0,"login");
		$_SESSION["password"]=mysqli_result($result,0,"password");
		$_SESSION["nombre"]=mysqli_result($result,0,"nombre");
		header("Location: ../mod_inicio/index.php");
	}else
	{
		?>
        <script type="text/javascript">
		alert("\tUsuario o Password incorrecto \n \t Favor de verificar los datos");
		window.location = "../index.php";
		</script>
		<?php 
    }
}
?>		
		<script type="text/javascript">
		window.location = "../index.php";
		</script>