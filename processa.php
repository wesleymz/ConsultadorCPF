<?php

require_once("Consultador.php");
$html = "";
if (isset($_POST["cnpj"])) {
    $cnpj = $_POST["cnpj"];
    $cod_cliente = $_POST["cod_cliente"];
    $captcha = $_POST["captcha"];
    $html = Consultador::getHtmlCNPJ($cnpj, $captcha);

    // Recebe nome se for valido, ou mensagem de erro se CNPJ for inválido ou inexistente.
    $output = Consultador::extrairNomeEmpresarial($html);
	
	print $html;
	
    // Retorna ao formulario de consulta caso o captcha digitado for incorreto.
    if (strpos($html, "<b>Erro na Consulta</b>")) {
        header("Location: consulta.php?cod_cliente=" . $cod_cliente . "&numero=" . $cnpj);
    }
}

if (isset($_POST["cpf"]) && isset($_POST["data_nasc"])) {
    $cpf = $_POST["cpf"];
    $cod_cliente = $_POST["cod_cliente"];
    $data_nasc = $_POST["data_nasc"];
    $captcha = $_POST["captcha"];
    $html = Consultador::getHtmlCpf($cpf, $data_nasc, $captcha);

    // Recebe nome se cpf for válido, ou mensagem de erro se for inválido ou inexistente.
    $output = Consultador::extrairNomePessoaFisica($html);
	
	print $html;
	
    // Retorna ao formulario de consulta caso o captcha esteja incorreto.
    if (strpos($html, "Por favor, envie novamente.") || strpos($html, "Por favor, preencha os dados novamente.")) {
        header("Location: consulta.php?cod_cliente=" . $cod_cliente . "&numero=" . $_POST["cpf"] . "&data_nasc=" . $_POST["data_nasc"]);
    }
}

if (isset($output)) {
    if ($output["erro"] == false && $output["nome"] != "") {
        
		//$msg = Consultador::saveCpfCnpj($cod_cliente, $output["nome"]);
        //print "<script>window.opener.document.getElementById('cpf_nome_registro_".$cod_cliente."').value='".trim($output["nome"])."';window.alert('".$msg."');window.close();</script>";
    } else {
        print $output["erro"];
        exit();
    }
}

//print $html;
?>
