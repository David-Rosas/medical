<?php 
session_start();
require("configuracion.php");
$con = mysql_connect($bd_host,$bd_usuario,$bd_pass);
mysql_select_db($bd_base,$con);
require("funciones.php");
if ($_SESSION["login"]!=""){
    $result = mysql_query("SELECT * FROM usuarios WHERE login='".$_SESSION["login"]."' and password='".$_SESSION["password"]."'",$con);
    if (mysql_num_rows($result) == 1){
       $_SESSION["tipo"]=mysql_result($result,0,"tipo");
	   $_SESSION["nombre"]=mysql_result($result,0,"nombre");
	  } else
    {
        header("Location: login.php");
		exit;
    }
} else
{
 	header("Location: login.php");
	exit;
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

