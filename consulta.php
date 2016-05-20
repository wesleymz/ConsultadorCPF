<html>
<head>
	<title>Consulta</title>
</head>
<body>
<div style="height: 250px; width: 270px; padding: 50px; margin: 0 auto; margin-top: 100px;">
<?php
require("Consultador.php");
if (strlen($_GET["numero"]) == 14)
{
	$img = Consultador::receberCaptchaCnpj();
	//print "<img src='{$img}' />";
	print '<form action="processa.php" method="post">
         CNPJ: <input size="16" maxlength="164" name="cnpj" value="' . $_GET["numero"] . '" /><br /><br />';
         
   print "<img src='{$img}' /><br />";
   print 'Captcha: <input size="15" maxlength="6" name="captcha" id="captcha" autofocus/><br />
         <input type="submit" />
      </form>';
}


// Formulario de conculta de CPF para 11 digitos
if (strlen($_GET["numero"]) == 11)
{
	$img = Consultador::receberCaptchaCpf();

	//print "<img src='{$img}' />";
	print '<form action="processa.php" method="post">
         CPF: <input size="16" maxlength="164" name="cpf" value="' . $_GET["numero"] . '" /><br /><br />
         Data de nascimento: <input size="16" maxlength="164" name="data_nasc" value="' . $_GET["data_nasc"] . '" /><br /><br />';
         
   print "<img src='{$img}' /><br />";
   print 'Captcha: <input size="15" maxlength="6" name="captcha" id="captcha" autofocus/><br/>
         <input type="submit" />
      </form>';
}
?>
</div>
</body>
</html>