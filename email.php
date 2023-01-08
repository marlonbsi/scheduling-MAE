<?php
  include_once 'includes/head.php';
  
  include "agendamento/PHPMailer-master/PHPMailerAutoload.php";
  require_once("PHPMailer-master/class.phpmailer.php");

  $Email = new PHPMailer();
  $Email->SetLanguage("br");
  $Email->IsMail();
  $Email->IsHTML(true);

  $Email->IsSMTP();

  $Email->Host = "smtp2.ufpr.br";

  $Email->Port = 25;

  echo "<br/><br/>Tudo pronto antes de enviar o email!<br/>";

  $Email->From = "marlon@ufpr.br";
  $Email->FromName = "Sistema";
  $Email->AddAddress("marlon@ufpr.br");
  $Email->Subject = "Fale Conosco";

  echo "<br/><br/>Tudo pronto antes de enviar o email!<br/>";

  $body = "Conteúdo do email";

  echo "<br/><br/>Tudo pronto antes de enviar o email!<br/>";

  $Email->MsgHTML($body);
  $Email->AltBody = "Para conseguir essa e-mail corretamente,
    use um visualizador de e-mail com suporte a HTML";

    echo "<br/><br/>Tudo pronto antes de enviar o email!<br/>";

  $Email->WordWrap = 50;

  $Email->Send();

  echo "Enviou <br/>";

  /*
  if(!$Email->Send()) {
    echo A mensagem não foi enviada.";
    // echo Mensagem de erro: " . $Email->ErrorInfo;
  } else {
    echo "Mensagem enviada!";
  }

  */

  /*Devmedia.com.br/enviando-e-mail-com-o-phpmailer/9642*/


  // $mail = new PHPMailer();

  /*homehost.com.br/blog/tutoriais/php/enviar-email-php-*/

  // Método de envio
  // $mail->IsSMTP();

  // Enviar por SMTP
  // $mail->Host = "smtp2.ufpr.br";

  // Você pode alterar este parametro para o endereço de SMTP do seu provedor
  // $mail->Port = 25;

  // Usar autenticação SMTP (obrigatório)
  // $mail->SMTPAuth = false;

  // Usuário do servidor SMTP (endereço de email)
  // obs: Use a mesma senha da sua conta de email
  // $mail->Username = 'marlon@ufpr.br';
  // $mail->Password = '$chn3id3R';

  // Configurações de compatibilidade para autenticação em TLS
  // $mail->SMTPOptions = array( 'ssl' => array( 'verify_peer' => false, 'verify_peer_name' => false, 'allow_self_signed' => true ) );

  // Você pode habilitar esta opção caso tenha problemas. Assim pode identificar mensagens de erro.
  // $mail->SMTPDebug = 0;

  // Define o remetente
  // Seu e-mail
  // $mail->From = "marlon@ufpr.br";

  // Seu nome
  // $mail->FromName = "Sistema de agendamento MAE";

  // Define o(s) destinatário(s)
  // $mail->AddAddress('marlonbsi@gmail.com', 'Marlon');

  // Opcional: mais de um destinatário
  // $mail->AddAddress('fulano@email.com');

  // Opcionais: CC e BCC
  // $mail->AddCC('joana@provedor.com', 'Joana');
  // $mail->AddBCC('roberto@gmail.com', 'Roberto');

  // Definir se o e-mail é em formato HTML ou texto plano
  // Formato HTML . Use "false" para enviar em formato texto simples ou "true" para HTML.
  // $mail->IsHTML(true);

  // Charset (opcional)
  // $mail->CharSet = 'UTF-8';

  // Assunto da mensagem
  // $mail->Subject = "Seu agendamento";

  // Corpo do email
  // $mail->Body = 'Informações sobre seu agendamento no MAE UFPR';

  // Opcional: Anexos
  // $mail->AddAttachment("/home/usuario/public_html/documento.pdf", "documento.pdf");

  // var_dump($mail);

  // echo "<br/><br/>Tudo pronto antes de enviar o email!<br/>";

  // $mail->Send();

  // echo "<br/>Mensagem enviada!<br/>";

?>
