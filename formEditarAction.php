<?php
	include_once 'includes/head.php';

	include 'classes/Agendamento.php';

	$ag = new Agendamento();

	$erroCampo = "ok";
	$vs;
	$h;
	$location = "location='index.php'";
	$op = 1;

	//INCLUI O CABEÇALHO BÁSICO DO FORMULÁRIO
  include_once 'includes/areaForm.php';

	//Pega os dados da session
  if(isset($_SESSION["usuario"])){
		$op = $us->getIdUsuario();
    $location = "location='agendamentoList.php'";
		//Inclui a saudação/edição de cadastro e área de mensagens
    include_once 'includes/bemVindo.php';
	}

	$ag->setOperador($op);

	//Verifica o preenchimento dos campos conforme ordem do form
  if(isset($_POST["agId"])){
    $ag->setIdAgendamento($_POST["agId"]);
  }

	//Campo horário: input hidden
  if(isset($_POST["horario"])){
		$h = $_POST["horario"];
		if($h > 0){
			$ag->setHorario($h);
		}	else{
			$erroCampo = "horario";
		}
	}

	/*Valida o contato com base no valor do radio button do form*/
	$tipoContato = "email";
	if(isset($_POST["contato"]) && isset($_POST["tipoContato"])){
		$contato = $_POST["contato"];
		$tipoContato = $_POST["tipoContato"];
		if($tipoContato == "email"){
			if(!$ag->setEmailContato($contato)){
				$erroCampo = "contato";
			}
		} else {
			if(!$ag->setTelefoneContato($contato)){
				$erroCampo = "contato";
			}
		}
	} else{
		$erroCampo = "contato";
	}

	/*Pega as vagas constantes no agendamento que está sendo editado. Elas serão usadas para liberar
		espaço na quantidade anterior na posição do array de vagas armazenado na session, possibilitando
		nova validação.*/
	if(isset($_POST["numPessoasPrev"])){
		$numPessoasPrev = $_POST["numPessoasPrev"];
	} else{
		$erroCampo = "numPessoasPrev";
	}

	// Campo numPessoas
	if(isset($_POST["numPessoas"])){
		$num = $_POST["numPessoas"];
		//Verifica vagas armazenadas na sessão
		if(isset($_SESSION["vg"])){
			//Verifica o id do horário selecionado
			if(isset($_SESSION["idsH"])){
				$idsH = $_SESSION["idsH"];
				$max = sizeof($idsH);
				for($i = 0; $i < $max; $i++){
					if($idsH[$i] == $h){ $idH = $i; }
				}
			}
			$vs = $_SESSION["vg"];
			$h = $ag->getHorario()-1;
			//Valida no setNumPessoas a disponibilidade
			if(!$ag->setNumPessoas($num, $vs[$idH])){
				$erroCampo = "disponibilidade";
			}
			$_SESSION["vg"] = null;
		}
	} else{
		$erroCampo = "numPessoas";
	}

	//Campo termos
	if(isset($_POST["termos"])){
		$ag->setTermos(1);
	} else{
		$erroCampo = "termos";
	}

	// Se nenhum campo deu problema, atualiza
	if($erroCampo == "ok"){
			$ag->update();
	} else{
		//SE ALGUM CAMPO DEU ERRO, EXIBE A MENSAGEM COM BASE NO CAMPO QUE DEU O ERRO
		if($erroCampo == "vazio"){
			echo "<p class='msgErro'><img src='img/erro1.png'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Por favor, preencha
				todos os campos para continuar.</p>
					<div id='botoesForm'>
						<input type='button' value='<< Voltar' id='btnVoltar' onClick=\"$location\" tabindex='1'>
					</div>
				</div>"	;
		}
		if($erroCampo == "contato"){
			echo "<p class='msgErro'><img src='img/erro1.png'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Valor inválido para o
				campo Contato.</p>
					<div id='botoesForm'>
						<input type='button' value='<< Voltar' id='btnVoltar' onClick=\"$location\" tabindex='1'>
					</div>
				</div>"	;
		}
		if($erroCampo == "numPessoas"){
			echo "<p class='msgErro'><img src='img/erro1.png'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Número de pessoas inválido
				para o horário.</p>
					<div id='botoesForm'>
						<input type='button' value='<< Voltar' id='btnVoltar' onClick=\"$location\" tabindex='1'>
					</div>
				</div>"	;
		}
		if($erroCampo == "numPessoasPrev"){
			echo "<p class='msgErro'><img src='img/erro1.png'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ocorreu um erro de validação,
				você deve repetir a operação.</p>
					<div id='botoesForm'>
						<input type='button' value='<< Voltar' id='btnVoltar' onClick=\"$location\" tabindex='1'>
					</div>
				</div>"	;
		}
		if($erroCampo == "disponibilidade"){
			if(!is_null($vs[$idH])){
				echo "<p class='msgErro'><img src='img/erro1.png'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Só existem $vs[$idH]
					vagas para o horário desejado.</p>
						<div id='botoesForm'>
							<input type='button' value='<< Voltar' id='btnVoltar' onClick=\"$location\" tabindex='1'>
						</div>
					</div>"	;
			} else{
				echo "<p class='msgErro'><img src='img/erro1.png'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Você deve voltar ao
					formulário para repetir a operação.</p>
						<div id='botoesForm'>
							<input type='button' value='<< Voltar' id='btnVoltar' onClick=\"$location\" tabindex='1'>
						</div>
					</div>"	;
			}
		}
		if($erroCampo == "termos"){
			echo "<p class='msgErro'><img src='img/erro1.png'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Você deve concordar com as
				regras para prosseguir.</p>
					<div id='botoesForm'>
						<input type='button' value='<< Voltar' id='btnVoltar' onClick=\"$location\" tabindex='1'>
					</div>
				</div>"	;
		}
	} //Fim se algum campo deu erro
	$ag->closeConnection();
?>
