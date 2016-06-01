<?php

require("Consultador.php");
$html = "";
if (isset($_POST["cnpj"]))
{
	$cnpj = $_POST["cnpj"];
	$captcha = $_POST["captcha"];
	$html = Consultador::getHtmlCNPJ($cnpj, $captcha);
	
	// Recebe nome se for valido, ou mensagem de erro se CNPJ for inválido ou inexistente.
	$output = Consultador::extrairNomeEmpresarial($html);
	//print_r($output);
	
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

	// Recebe nome se cpf for válido, ou mensagem de erro se for inválido ou inexistente.
	$output = Consultador::extrairNomePessoaFisica($html);
	//print_r($output);
	
	// Retorna ao formulario de consulta caso o captcha esteja incorreto.
	if (strpos($html, "Por favor, envie novamente.") || strpos($html, "Por favor, preencha os dados novamente."))
	{
		header("Location: consulta.php?numero=" . $_POST["cpf"] . "&data_nasc=" . $_POST["data_nasc"]);
	}
}

print $html;

?>
