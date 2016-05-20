<?php

require("Consultador.php");

if (isset($_POST["cnpj"]))
{
	$cnpj = $_POST["cnpj"];
	$captcha = $_POST["captcha"];
	$html = Consultador::getHtmlCNPJ($cnpj, $captcha);
	
	// Retorna ao formulario de consulta caso o captcha digitado for incorreto.
	if (strpos($html, "<b>Erro na Consulta</b>"))
	{
		header("Location: consulta.php?numero=" . $cnpj);
	}
}

if (isset($_POST["cpf"]) && isset($_POST["data_nasc"]))
{
	$cpf = $_POST["cpf"];
	$data_nasc = $_POST["data_nasc"];
	$captcha = $_POST["captcha"];
	$html = Consultador::getHtmlCpf($cpf, $data_nasc, $captcha);

	// Retorna ao formulario de consulta caso o captcha esteja incorreto.
	if (strpos($html, "Os caracteres da imagem não foram preenchidos corretamente."))
	{
		header("Location: consulta.php?numero=" . $_POST["cpf"] . "&data_nasc=" . $_POST["data_nasc"]);
	}
}


print $html;

?>