<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Sistema de Generación de Certificados en Linea (JORNASTEC)</title>
<meta http-equiv="Content-Language" content="English" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" type="text/css" href="style.css" media="screen" />
</head>
<body>

<div id="wrap">
<div id="header">
</div>

<div id="right">

<h2><a href="#">Solicitud de certificados de participante</a></h2>
<div class="articles">

<script type="text/javascript">
 var RecaptchaOptions = {    
    custom_translations : {
                        instructions_visual : "Ingrese las 2 palabras:",
     },
    lang : 'es',
    theme : 'white'
	
 };
 </script>

<form name="consulta" method="POST" action='certificado.php'>

 <label>Ingrese su cédula de identidad</label>
&nbsp;&nbsp;<input type='text' name='cedula_identidad' tabindex="1" placeholder="Cédula de identidad" required>
<br>
<br>
 <label>Ingrese los caracteres que ve en la imagen que se muestra a continuación <font size="1" ><a href="http://es.wikipedia.org/wiki/Captcha">¿Porqué?</a></font></label>
<br>
<br>
<?php
	error_reporting(0);

	@session_start();
	if ($_SESSION["mensaje-error"]!= null) 
		echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <font color='red'>".$_SESSION['mensaje-error']."</font>";
	
          require_once('recaptchaPhp/recaptchalib.php');
          $publickey = ""; // you got this from the signup page
          echo recaptcha_get_html($publickey);
	
?>
<br>
<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='submit' name='imprimir' value='Descargar Certificado Digital' tabindex="2">
</form>
<br>

</div>

</div>

<div id="left"> 

<h3>Ir a : </h3>
<ul>
<li><a href="http://www.jornastec.org.ve">Inicio</a></li> 
<li><a href="http://colectivoteletriunfador.wordpress.com">Colectivo Teletriunfador</a></li> 
</ul>


</div>
<div style="clear: both;"> </div>


<div id="footer">
<img src="images/pie_pagina_app.png" alt="JORNASTEC" /> 

Inspirado en <a href="http://www.free-css-templates.com/">Free CSS Templates</a>

</div>
</div>


</body>
</html>
