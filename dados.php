<?php

$captcha = $_POST['g-recaptcha-response'];

$secret = "6LcXx9waAAAAACrxN864H30WpyWlTatczgilAUFT";

//html 6LcXx9waAAAAAH17SCvwD5V9OLxk8MVEHVPtDz9w

$response = json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secret."&response=" . $captcha . "&remoteip=" . $_SERVER['REMOTE_ADDR']), TRUE);


if($response["success"]==true){

error_reporting(0);

$nome = utf8_encode ($_POST['nome']);
$email = utf8_encode ($_POST['email']);
$telefone = utf8_encode ($_POST['telefone']);
$mensagem = utf8_encode ($_POST['mensagem']);


require 'PHPMailer/PHPMailerAutoload.php';

$mail = new PHPMailer;
$mail->isSMTP();

//config serv esses dados fiquei de conferir 
$mail->Host = "ect.ufrn.br";
$mail->Port = "2222";
$mail->SMTPSecure = "tls";
$mail->SMTPAuth = "true";
$mail->Username = "daect@ect.ufrn.br";
$mail->Password = ""; //senha apenas colocar quando for colcoar no servidor porque é a senha do e-mail



//config msg
$mail->setFrom($mail->Username, "SITE DAECT.UFRN.BR");
$mail->addAddress('daect@ect.ufrn.br');
$mail->Subject = "CONTATO PELO SITE";

//a partir daqui podemos criar um html pra vim pra o e-mail do DA bem formato e-mail marketing
$conteudo_email = "
                            <b>Nome: </b> $nome <br>
                            <b>E-mail: </b> $email <br>
                            <b>Telefone: </b> $telefone <br>
                            <b>Mensagens: </b> $mensagem <br>

                         
";





$mail->isHTML(true);
$mail->Body = $conteudo_email;


if($mail->send()){

    $message = "Mensagem enviada com sucesso! Logo mais entraremos em contato.";
    echo "<script type='text/javascript'>alert('$message');</script>";
    echo "<script type='text/javascript'> window.location.replace('index.php');</script>";
    

}else{
    $message = "Erro ao enviar e-mail. Tente novamente!";
    echo "<script type='text/javascript'>alert('$message'. $mail->ErrorInfo;);</script>";
    echo "<script type='text/javascript'> window.location.replace('index.php#contato');</script>";
 

}


//fim de verificacao
}else{
  $message = "Erro de verificação. É necessaria clicar no botão NÃO SOU UM ROBÔ";
  echo "<script type='text/javascript'>alert('$message');</script>";
  echo "<script type='text/javascript'> window.location.replace('index.php#contato');</script>";
 

}

