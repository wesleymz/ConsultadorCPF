<?php
@session_start();

class Consultador
{
	public static function receberCaptchaCnpj()
	{
		$ch = curl_init("http://www.receita.fazenda.gov.br/PessoaJuridica/CNPJ/cnpjreva/captcha/gerarCaptcha.asp");

		// Preenche cabecalho da requisicao http.
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:45.0) Gecko/20100101 Firefox/45.0");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLINFO_HEADER_OUT, true);
		

		$data = curl_exec($ch);
		
		// Obtem length do cabecalho.
		$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
		
		// Separa o cabecalho.
		$header = substr($data, 0, $header_size);
		
		// Separa a imagem.
		$data = substr($data, $header_size, strlen($data));
		
		// Separa o cookie do restante do cabecalho.
		preg_match("/(Set-Cookie:\s)(.*)(;\spath=)/", $header, $cookie);
		
		// Salva cookie de sessao em uma outra sessao.
		$_SESSION["cookie"] = $cookie[2];

		curl_close($ch);

		$img = imagecreatefromstring($data);
		ob_start();
		imagepng($img);
		$png = ob_get_clean();
		$uri = "data:image/png;base64," . base64_encode($png);
		
		$ch = curl_init("http://www.receita.fazenda.gov.br/pessoajuridica/cnpj/cnpjreva/Cnpjreva_Solicitacao2.asp");

		// Preenche cabecalho da requisicao http.
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:45.0) Gecko/20100101 Firefox/45.0");
		curl_setopt($ch, CURLOPT_COOKIE, $cookie[2]);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_MAXREDIRS, 3);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLINFO_HEADER_OUT, true);

		curl_exec($ch);
		curl_close($ch);

		// Retorna imagem.
		return $uri;

	} // End function

	public static function receberCaptchaCpf()
	{
		$ch = curl_init("http://www.receita.fazenda.gov.br/Aplicacoes/ATCTA/cpf/captcha/gerarCaptcha.asp");

		// Preenche cabecalho da requisicao http
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:45.0) Gecko/20100101 Firefox/45.0");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLINFO_HEADER_OUT, true);

		$data = curl_exec($ch);

		// Obtem length do cabecalho
		$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);

		// Separa o cabecalho.
		$header = substr($data, 0, $header_size);

		// Separa a imagem.
		$data = substr($data, $header_size, strlen($data));

		// Separa o cookie do restante do cabecalho.
		preg_match("/(Set-Cookie:\s)(.*)(;\spath=)/", $header, $cookie);

		// Salva cookie de sessao em uma outra sessao.
		$_SESSION["cookie"] = $cookie[2];
		curl_close($ch);

		$img = imagecreatefromstring($data);
		ob_start();
		imagepng($img);
		$png = ob_get_clean();
		$uri = "data:image/png;base64," . base64_encode($png);

		return $uri;

	} // End function

	public static function getHtmlCNPJ($cnpj, $captcha)
	{
		$cookie = $_SESSION["cookie"] . "; flag=1";	

		$post = array
		(
			"origem" => "comprovante",
			"cnpj" => $cnpj,
			"txtTexto_captcha_serpro_gov_br" => $captcha,
			"submit1" => "Consultar",
			"search_type" => "cnpj",
		);

		$post = http_build_query($post, NULL, "&");

		$ch = curl_init("http://www.receita.fazenda.gov.br/pessoajuridica/cnpj/cnpjreva/valida.asp");

		// Define cabecalho da requisicao http.
		curl_setopt($ch, CURLOPT_POST, true);

		curl_setopt($ch, CURLOPT_POSTFIELDS, $post); // Post
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:45.0) Gecko/20100101 Firefox/45.0");
		curl_setopt($ch, CURLOPT_COOKIE, $cookie);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_MAXREDIRS, 3);
		curl_setopt($ch, CURLOPT_REFERER, "http://www.receita.fazenda.gov.br/pessoajuridica/cnpj/cnpjreva/Cnpjreva_Solicitacao2.asp");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$html = curl_exec($ch);
		curl_close($ch);

		// Retorna html da pagina resultante.
		return $html;
	
	} // End function

	public static function getHtmlCpf($cpf, $data_nasc, $captcha)
	{
		$cookie = $_SESSION["cookie"];

		$post = array
		(
			"txtTexto_captcha_serpro_gov_br" => $captcha,
			"tempTxtCPF" => $cpf,
			"tempTxtNascimento" => $data_nasc,
			"temptxtToken_captcha_serpro_gov_br" => "",
			"temptxtTexto_captcha_serpro_gov_br" => $captcha
		);

		$post = http_build_query($post, NULL, "&");

		$ch = curl_init("http://www.receita.fazenda.gov.br/Aplicacoes/ATCTA/cpf/ConsultaPublicaExibir.asp");

		// Preenche cabecalho da requisicao http.
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post); // Post
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:45.0) Gecko/20100101 Firefox/45.0");
		curl_setopt($ch, CURLOPT_COOKIE, $cookie);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_MAXREDIRS, 3);
		curl_setopt($ch, CURLOPT_REFERER, "http://www.receita.fazenda.gov.br/Aplicacoes/ATCTA/cpf/ConsultaPublica.asp?Error=1&CPF=" . $cpf . "&NASCIMENTO=" . $data_nasc);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$html = curl_exec($ch);
		curl_close($ch);
		print $cookie;
		// Retorna html da pagina resultante.
		return $html;

	} // End function

} // End class

?>