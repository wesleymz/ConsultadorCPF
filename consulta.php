<html>
    <head>
        <title>Consulta</title>
    </head>
    <body>
        <div style="height: 250px; width: 270px; padding: 50px; margin: 0 auto; margin-top: 100px;">
            <?php
            require_once("Consultador.php");

            $numero = isset($_GET["numero"]) ? $_GET["numero"] : "";
            $cod_cliente = isset($_GET["cod_cliente"]) ? $_GET["cod_cliente"] : "";

            if (strlen($numero) == 14) {
                $img = Consultador::receberCaptchaCnpj();
                //print "<img src='{$img}' />";
                print '<form action="processa.php" method="post">CNPJ: <input size="16" maxlength="164" name="cnpj" value="' . $numero . '" /><br /><br />';
                print "<img src='{$img}' /><br />";
                print "<input type=\"hidden\" name=\"cod_cliente\" value=\"".$cod_cliente."\">";
                print 'Captcha: <input size="15" maxlength="6" name="captcha" id="captcha" autofocus/><br />
         <input type="submit" />
      </form>';
            }



// Formulario de conculta de CPF para 11 digitos
            if (strlen($numero) == 11) {
                $img = Consultador::receberCaptchaCpf();

                $data_nasc = isset($_GET["data_nasc"]) ? $_GET["data_nasc"] : "";

                //print "<img src='{$img}' />";
                print '<form action="processa.php" method="post">CPF: <input size="16" maxlength="164" name="cpf" value="' . $numero . '" /><br /><br />
         Data de nascimento: <input size="16" maxlength="164" name="data_nasc" value="' . $data_nasc . '" /><br /><br />';
                print "<img src='{$img}' /><br />";
                print "<input type=\"hidden\" name=\"cod_cliente\" value=\"".$cod_cliente."\">";
                print 'Captcha: <input size="15" maxlength="6" name="captcha" id="captcha" autofocus/><br/>
         <input type="submit" />
      </form>';
            }
            ?>
        </div>
    </body>
</html>
