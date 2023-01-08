<html>
	<head>
		<!--Import do JQuery-->
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js" >
		</script>

		<!--****Validações do form no JS:****-->
		<script type="text/javascript" src="includes/validacoes.js"></script>

		<!--CSS básico do sistema-->
		<link rel="stylesheet" href="includes/styles.css"/>

		<!--Scripts e CSSs para o calendário datepicker-->
			<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.css">
	    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.css">
	    <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.js"></script>
	    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
		<!--Fim dos CSSs e scripts do datepicker-->

		<link rel="shortcut icon" href="img/mae_fav.ico"/>

		<title>MAE: Agendamento de visitas</title>
	</head>
	<body>
		<?php
		  require_once('classes/Session.php');

			include 'classes/Agendamento.php';
		  include 'classes/Usuario.php';
			include 'classes/Horarios.php';

		  //Inicia a sessão para armazenar as vagas
		  session_start();
		  $session = new Session;
		  $session->validaSessao();

			//Define data atual e data limite para a solicitação
			date_default_timezone_set('America/Sao_Paulo');
			$hoje = date('Y-m-d');
			$dataMax = new DateTime();
			$dataMax = new DateTime('+3 month');

			//INCLUI O CABEÇALHO BÁSICO DO FORMULÁRIO
		  include_once 'includes/areaForm.php';

			//Pega os dados da session
		  //******SÓ PODE VER SE ESTIVER LOGADO
			if(isset($_SESSION["usuario"])){
				$us = new Usuario();
				$us = $_SESSION["usuario"];
?>
				<div id="bemVindo">
					<div id="bemVindoMsg">Bem-vindo(a), <a href="formEditarUsuario.php?usId=<?php echo $us->getIdUsuario();?>">
						<?php echo $us->getNomeUsuario();?></a>.
					</div>
					<div id="bemVindoSair"><a href="actionSair.php">Sair</a></div>
				</div>
				<!-- Adicionado apenas no index porque não funcionou após os includes -->
				<div id="espacoDiv"></div>
<?php
			}
			//Verifica se tem mensagens para exibir
	    if(isset($_GET["msg"])){
				//Mensagem de atualização efetuada
	      if($_GET["msg"] == "upd"){
	        if(isset($_GET["agAlt"])){
	          $agNum = $_GET["agAlt"];
	          $agAlt = new Agendamento();
	          $agAlt = $agAlt->retornaAgendamentoPorId($agNum);
	          $agNum = $agAlt->getAgNum();
	          $msg = "<p class='msgSucesso'><img src='img/sucesso2.png'>&nbsp;&nbsp;&nbsp;Agendamento
	            <strong>$agNum</strong> atualizado com sucesso.&nbsp;&nbsp;&nbsp;
	            <a href='index.php' target='_self'><strong>X</strong></a></p>";
	        }
	      }
	      //Mensagem de erro na atualização
	      if($_GET["msg"] == "erroUpd"){
	        if(isset($_GET["agAlt"])){
	          $agNum = $_GET["agAlt"];
	          $agAlt = new Agendamento();
	          $agAlt = $agAlt->retornaAgendamentoPorId($agNum);
	          $agNum = $agAlt->getAgNum();
	          $msg = "<p class='msgErro'><img src='img/erro1.png'>&nbsp;&nbsp;&nbsp;Ocorreu um erro
	            ao atualizar o agendamento <strong>$agNum</strong>. Por favor, repita a operação ou
	            entre em contato com o suporte.&nbsp;&nbsp;&nbsp;
	            <a href='index.php' target='_self'><strong>X</strong></a></p>";
	        }
	      }
				//Mensagem de cancelamento Efetuado
				if($_GET["msg"] == "canc"){
	        if(isset($_GET["agAlt"])){
	          $agNum = $_GET["agAlt"];
	          $agAlt = new Agendamento();
	          $agAlt = $agAlt->retornaAgendamentoPorId($agNum);
	          $agNum = $agAlt->getAgNum();
	          $msg = "<p class='msgSucesso'><img src='img/sucesso2.png'>&nbsp;&nbsp;&nbsp;Agendamento
	            <strong>$agNum</strong> cancelado com sucesso.&nbsp;&nbsp;&nbsp;
	            <a href='index.php' target='_self'><strong>X</strong></a></p>";
	        }
	      }
				//Mensagem de erro no cancelamento
			 if($_GET["msg"] == "erroCanc"){
				 if(isset($_GET["agAlt"])){
					 $agNum = $_GET["agAlt"];
					 $agAlt = new Agendamento();
					 $agAlt = $agAlt->retornaAgendamentoPorId($agNum);
					 $agNum = $agAlt->getAgNum();
					 $msg = "<p class='msgErro'><img src='img/erro1.png'>&nbsp;&nbsp;&nbsp;Ocorreu um erro
						 ao cancelar o agendamento <strong>$agNum</strong>. Por favor, repita a operação ou
						 entre em contato com o suporte.&nbsp;&nbsp;&nbsp;
						 <a href='index.php' target='_self'><strong>X</strong></a></p>";
				 }
			 }
			 //Mensagem de erro no cancelamento
			if($_GET["msg"] == "erroHUpd"){
				if(isset($_GET["hAlt"])){
					$hNum = $_GET["hAlt"];
					$hAlt = new Horario();
					$hAlt = $hAlt->retornaPorId($hNum);
					$periodo = $hAlt->getPeriodo();
					$msg = "<p class='msgErro'><img src='img/erro1.png'>&nbsp;&nbsp;&nbsp;Ocorreu um erro
						ao atualizar o horário: <strong>$periodo</strong>. Por favor, repita a operação ou
						entre em contato com o suporte.&nbsp;&nbsp;&nbsp;
						<a href='index.php' target='_self'><strong>X</strong></a></p>";
				}
			}

			 // erroHUpd, hAlt
?>
				<div id="areaMsgs">
					<!--Exibe mensagem recebida por $_GET-->
					<p><?php echo $msg;?></p>
				</div>
			<?php } ?>
			<div class="tituloPag">
				<p>Agende sua visita ao MAE Paranaguá</p>
			</div>
			<form action="formSolicitante.php" method="post" id="formIndex">
				<div id="campoData">
					<label for="dia">Data da visita:</label><br/>
						<input type="text" name="dia" id="diaInput" data-date-format='yyyy-mm-dd' value="<?php echo $hoje;?>"
							class="form-control datepicker" title="Selecione a data da visita" required>
							<br/>
				</div>
				<input type="hidden" name="dataMax" value="<?php echo $dataMax->format('Y-m-d');?>"/>
				<div id="botoesForm">
					<input type="submit" id="btnProximo" value="Próximo >" title="Avance para informar os detalhes"
						alt="Avance para informar os detalhes"/>
				</div>
			</form>
		</div>
	</body>
	<!--Script 	que desabilita as segundas-feiras no calendário-->
		<script type="text/javascript">
		    $('.datepicker').datepicker({
					startDate: new Date(),
					maxDate : '+3m',
					dateFormat: 'Y-m-d',
		      daysOfWeekDisabled: [1],
					orientation: "bottom"
		    });
			</script>
	<!--Fim do script-->
</html>
