<?php
	include_once 'includes/head.php';

	include 'classes/Agendamento.php';

	$ag = new Agendamento();
	/*valor padrão para a disponibilidade. Alterado com o valor do array de vagas por horário
		armazenado na session*/
	$erroCampo = "ok";
	$vs;
	$h;
	$location = "location='index.php'";
	$op = 1;
	$usId = 0;

	//INCLUI O CABEÇALHO BÁSICO DO FORMULÁRIO
  include_once 'includes/areaForm.php';

	if(isset($_SESSION["usuario"])){
		//Inclui a saudação/edição de cadastro e área de mensagens
		include_once 'includes/bemVindo.php';
		$location = "location='agendamentoList.php'";
		$op = $us->getIdUsuario();
		$usId = $us->getIdUsuario();
	} else {
?>
		<div id="areaMsgs">
			<!--Exibe mensagem recebida por $_GET-->
			<p><?php echo $msg;?></p>
		</div>
<?php
	}
	if($usId == 1){
		echo "<p class='msgErro'><img src='img/erro1.png'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Esse usuário não está
			autorizado a executar essa operação.</p>
				<div id='botoesForm'>
					<input type='button' value='<< Voltar' id='btnVoltar' onClick=location='index.php' tabindex='1'>
				</div>
			</div>"	;
	} else {
		$ag->setOperador($op);

		//Verifica o preenchimento dos campos conforme ordem do form

		//Campo dia input hidden do formulário:
		if(isset($_POST["dia"])){
			$d = $_POST["dia"];
			$_POST["dia"] = null;
			if(!$ag->setDia($d)){
				$erroCampo = "dia";
			}
		} else{
			$erroCampo = "vazio";
		}

		//Campo solicitante:
		if(isset($_POST["solicitante"])){
			$sol = $_POST["solicitante"];
			if(!$ag->setSolicitante($sol)){
				$erroCampo = "solicitante";
			}
		} else{
			$erroCampo = "vazio";
		}

		//Campo contato: valida o tipo de contato com base no valor do radio button do form
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

		// Campo horário
		if(isset($_POST["horario"])){
			$h = $_POST["horario"];
			if($h > 0){
				$ag->setHorario($h);
			}	else{
				$erroCampo = "horario";
			}
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

		// Campo termos
		if(isset($_POST["termos"])){
			$ag->setTermos(1);
		} else{
			$erroCampo = "termos";
		}

		//Campos de preenchimento automático durante o cadastro
		$ag->setEstadoAgendamento("agendado");
		$ag->setAgNum();


		if($erroCampo == "ok"){
			//Se nenhum campo deu problema, insere
			// $ag->toString();
			$ag->insert();
			echo "<div id='botoesForm'>
						<input type='button' value='<< Voltar' id='btnVoltar' onClick=\"$location\" tabindex='1'>
					</div>
				</div>"	;
		} else{
			//SE ALGUM CAMPO DEU PROBLEMA:
			if($erroCampo == "vazio"){
				echo "<p class='msgErro'><img src='img/erro1.png'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Por favor, preencha
					todos os campos para continuar.</p>
						<div id='botoesForm'>
							<input type='button' value='<< Voltar' id='btnVoltar' onClick=\"$location\" tabindex='1'>
						</div>
					</div>"	;
			}
			if($erroCampo == "solicitante"){
				echo "<p class='msgErro'><img src='img/erro1.png'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Valor inválido para o
					campo Solicitante.</p>
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
			if($erroCampo == "horario"){
				echo "<p class='msgErro'><img src='img/erro1.png'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Você deve selecionar um
					horário para a visita.</p>
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
		} //FIM-SE ALGUM CAMPO DEU PROBLEMA
	} //Fim se não é super Usuário
	$ag->closeConnection();
?>
