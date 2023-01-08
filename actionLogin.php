<?php
  include_once 'includes/head.php';

  if(isset($_POST["entrar"])){
    $entrar = $_POST['entrar'];

    if(isset($_POST["email"])){
      $email = $_POST['email'];
  	}

    if(isset($_POST["senha"])){
      $senha = md5($_POST['senha']);
  	}
  }

  if (isset($entrar)) {

    $usLogin = new Usuario();
    if($usLogin->logar($email, $senha)){
      if(isset($_SESSION["idUsuario"])){
        $idUsuario = $_SESSION["idUsuario"];
        if($idUsuario == 1){
          header("Location: config.php");
        } else {
          header("Location: agendamentoList.php");
        }
      }

    } else {
      echo"<script language='javascript' type='text/javascript'>
      alert('Login e/ou senha incorretos');window.location
      .href='loginAdm.php';</script>";
      // header("Location: index.php");
    }
  }

?>
