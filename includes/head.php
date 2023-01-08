<html>
	<head>
		<!--Import do JQuery-->
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js" >
		</script>

		<!--****Validações do form no JS:****-->
		<script type="text/javascript" src="includes/validacoes.js"></script>

		<!--CSS básico do sistema-->
		<link rel="stylesheet" href="includes/styles.css"/>

		<!--Scripts para as máscaras nos campos-->
		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
		<!--Fim dos CSSs e scripts do datepicker-->

		<link rel="shortcut icon" href="img/mae_fav.ico"/>

		<title>MAE: Agendamento de visitas</title>
	</head>
	<body>
		<?php
			require_once('classes/Session.php');
			include 'classes/Usuario.php';

			//Inicia a sessão para armazenar as vagas
		  session_start();
		  $session = new Session;
		  $session->validaSessao();

			//Pega os dados da session
		  //Só permite a usuários logados a visualização da lista
		  if(isset($_SESSION["usuario"])){
		    $us = new Usuario();
				$us = $_SESSION["usuario"];
			}
		?>
