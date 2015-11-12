<?php

$recipients = 'comercial@trainning.com.br';
//$recipients = '#';

try {
    require './phpmailer/PHPMailerAutoload.php';

    preg_match_all("/([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)/", $recipients, $addresses, PREG_OFFSET_CAPTURE);

    if (!count($addresses[0])) {
        die('MF001');
    }

    if (preg_match('/^(127\.|192\.168\.)/', $_SERVER['REMOTE_ADDR'])) {
        die('MF002');
    }

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
        die('MF004');
    }

    if (isset($_POST['email'])) {
        $template = str_replace(
            ["<!-- #{FromState} -->", "<!-- #{FromEmail} -->"],
            ["Email:", $_POST['email']],
            $template);
    }else{
        die('MF003');
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

    $mail = new PHPMailer();
    $mail->From = $_SERVER['SERVER_ADDR'];
    $mail->FromName = $_SERVER['SERVER_NAME'];

    foreach ($addresses[0] as $key => $value) {
        $mail->addAddress($value[0]);
    }

    $mail->CharSet = 'utf-8';
    $mail->Subject = $subject;
    $mail->MsgHTML($template);

    if (isset($_FILES['attachment'])) {
        foreach ($_FILES['attachment']['error'] as $key => $error) {
            if ($error == UPLOAD_ERR_OK) {
                $mail->AddAttachment($_FILES['attachment']['tmp_name'][$key], $_FILES['Attachment']['name'][$key]);
            }
        }
    }
	
	
	
	
	
	
	
	
	

    $mail->send();



include "/conexao.php";	
$nome = $_POST['name'];
$email = $_POST['email'];
$telefone = $_POST['phone'];
$msg = $_POST['message'];

	
	
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
	
	
	
	
	
	

    die('MF000');
} catch (phpmailerException $e) {
    die('MF254');
} catch (Exception $e) {
    die('MF255');
}

?>