<?php


include "/conexao.php";	
$nome = $_POST['name'];
$email = $_POST['email'];
$telefone = $_POST['phone'];
$msg = $_POST['message'];


$recipients = 'webmaster@trainning.com.br';
//$recipients = '#';


    $template = file_get_contents('rd-mailform.tpl');

    if (isset($_POST['form-type'])) {
        switch ($_POST['form-type']){
            case 'contact':
                $subject = 'Uma mensagem do seu visitante';
                break;
            case 'subscribe':
                $subject = 'Assinar pedido';
                break;
            case 'order':
                $subject = 'Solicitação de pedido';
                break;
            default:
                $subject = 'Uma mensagem do seu visitante';
                break;
        }
    }else{
        
    }

    if (isset($_POST['email'])) {
        $template = str_replace(
            ["<!-- #{FromState} -->", "<!-- #{FromEmail} -->"],
            ["Email:", $_POST['email']],
            $template);
    }else{
      
    }

    if (isset($_POST['message'])) {
        $template = str_replace(
            ["<!-- #{MessageState} -->", "<!-- #{MessageDescription} -->"],
            ["Mensagem:", $_POST['message']],
            $template);
    }

    preg_match("/(<!-- #{BeginInfo} -->)(.|\n)+(<!-- #{EndInfo} -->)/", $template, $tmp, PREG_OFFSET_CAPTURE);
    foreach ($_POST as $key => $value) {
        if ($key != "email" && $key != "message" && $key != "form-type" && !empty($value)){
            $info = str_replace(
                ["<!-- #{BeginInfo} -->", "<!-- #{InfoState} -->", "<!-- #{InfoDescription} -->"],
                ["", ucfirst($key) . ':', $value],
                $tmp[0][0]);

            $template = str_replace("<!-- #{EndInfo} -->", $info, $template);
        }
    }

    $template = str_replace(
        ["<!-- #{Subject} -->", "<!-- #{SiteName} -->"],
        [$subject, $_SERVER['SERVER_NAME']],
        $template);

    

    // ENVIA PARA CONSULTOR TRAINNING
$headers = "MIME-Version: 1.1\r\n";
$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
$headers .= "Reply-To: $nome <".$email.">\r\n"; // Reply-To
$assunto = $nome_proximo_vendedor." - Cadastro Black Friday";
$envio = mail("webmaster@trainning.com.br", "$assunto", "$template", $headers);
 
	
	



	
	
$sql_carrossel = "SELECT * FROM recebe_vendedores where tipo ='outros' ORDER BY id DESC Limit 1";
$res_carrossel = mysqlexecuta($idcon,$sql_carrossel);

$nome_ultimo_vendedor = mysql_result($res_carrossel,0,"ultimo_vendedor");	 

if ($nome_ultimo_vendedor == "Mario") {

	$nome_proximo_vendedor = "Roberta";
}
elseif ($nome_ultimo_vendedor == "Roberta") {
	$nome_proximo_vendedor = "Marcela";
}
elseif ($nome_ultimo_vendedor == "Marcela") {
	$nome_proximo_vendedor = "Sandra";
}
elseif ($nome_ultimo_vendedor == "Sandra") {
	$nome_proximo_vendedor = "Joyce";
	
}
elseif ($nome_ultimo_vendedor == "Joyce") {
	$nome_proximo_vendedor = "Thais";
}
elseif ($nome_ultimo_vendedor == "Thais") {
	$nome_proximo_vendedor = "Mario";
}

$sql_carrossel_update = "UPDATE recebe_vendedores set ultimo_vendedor = '".$nome_proximo_vendedor."' where id = '1'";
$res_carrossel_update = mysqlexecuta($idcon,$sql_carrossel_update);

$sql_insert = "INSERT INTO recebe_info_curso (nome, email, telefone, msg, data, vendedor) Values ('$nome', '$email', '$telefone', '$msg', '".date("j/n/Y")."', '$nome_proximo_vendedor') ";
$res_insert  = mysqlexecuta($idcon,$sql_insert);
	
	$strurl = $_POST['strurl'];

if($strurl){
	
}
else {
$strurl = "inscreva-se.php"	;
}
?>
<script type="text/javascript">alert('Cadastrado no Black Friday, agora INSCREVA-SE no curso desejado.'); location = '<?php echo $strurl; ?>'</script>


