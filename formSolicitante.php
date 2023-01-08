<?php
	include_once 'includes/head.php';

	include 'classes/Horarios.php';

	//INCLUI O CABEÇALHO BÁSICO DO FORMULÁRIO
	include_once 'includes/areaForm.php';

	//Verifica se a data do form anterior foi enviada por post
	if(!isset($_POST["dia"])){
		echo "<p class='msgErro'><img src='img/erro1.png'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;É necessário
			selecionar uma data válida.</p>
				<div id='botoesForm'>
					<input type='button' value='<< Voltar' id='btnVoltar' onClick=location='index.php' tabindex='1'>
				</div>
			</div>"	;
	}else{
		$data = $_POST["dia"];
		$dm = $_POST["dataMax"];
		//Verifica se a data está num intervalo menor que 3 meses
		if($data > $dm){
			echo "<p class='msgErro'><img src='img/erro1.png'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Por favor, selecione
				uma data com menos de 3 meses de intervalo para agendar a visita.</p>
					<div id='botoesForm'>
						<input type='button' value='<< Voltar' id='btnVoltar' onClick=location='index.php' tabindex='1'>
					</div>
				</div>"	;
		} else{
			$usId = 0;

		  //Só pode ver se estiver logado
			if(isset($_SESSION["usuario"])){
				$usId = $us->getIdUsuario();
				//Inclui a saudação/edição de cadastro e área de mensagens
	      include_once 'includes/bemVindo.php';
			} else {
?>
				<div id="areaMsgs">
					<!--Exibe mensagem recebida por $_GET-->
					<p><?php echo $msg;?></p>
				</div>
<?php
			}
			//Verifica se a data não é uma segunda-feira
			$diasemana = array('1', '2', '3', '4', '5', '6', '7');
			// Varivel que recebe o dia da semana (0 = Domingo, 1 = Segunda ...)
			$diasemana_numero = date('w', strtotime($data));
			if($diasemana_numero == 1){
				echo "<p class='msgErro'><img src='img/erro1.png'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;O MAE não abre para
					o público às segundas-feiras. Por favor, selecione outra data.</p>
						<div id='botoesForm'>
							<input type='button' value='<< Voltar' id='btnVoltar' onClick=location='index.php' tabindex='1'>
						</div>
					</div>"	;
			} else{
				if($usId == 1){
					echo "<p class='msgErro'><img src='img/erro1.png'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Esse usuário não está
						autorizado a executar essa operação.</p>
							<div id='botoesForm'>
								<input type='button' value='<< Voltar' id='btnVoltar' onClick=location='index.php' tabindex='1'>
							</div>
						</div>"	;
				} else {
					//BUSCA DE HORÁRIOS DISPONÍVEIS PARA O DIA SELECIONADO:
					//Objeto que vai pegar todos os horários cadastrados no BD
					$h = new Horario();
					$h = $h->select();

					//Objeto que vai pegar as vagas disponíveis por horário no dia selecionado anteriormente
					$h1 = new Horario();
					$vgs = $h1->retornaVagas(); //$vgs = Vagas do dia
					$idsArray = array(); //$idsArray = ids dos horários que podem ter buracos por exclusão
					$vagas = array(); // $vagas  = máximo de vagas por horário
					$maxVagas = $h1->retornaMaximoDeVagas(); //busca o maior número de vagas cadastrado no BD para limitar o input

					while($dado = $vgs->fetch_array()) {
            array_push($idsArray, $dado['horarioId']);
						array_push($vagas, $dado['vagasHorario']);
					}

					$tamanhoArray = sizeof($vagas);
					$qtd = 0;

					for($i = 0; $i < $tamanhoArray; $i++){
						$qtd = $vagas[$i] - $h1->retornaReservas($data, $idsArray[$i]);
						$vagas[$i] = $qtd;
					}

					/*Armazena os arrays com vagas disponíveis e ids de horários na Session*/
					$_SESSION["vg"] = $vagas;
					$_SESSION["idsH"] = $idsArray;

					//ISSO SÓ OCORRE SE O if(!isset($_POST["dia"])){ FOR FALSE
			?>
						<div class="tituloPag">
							<p>Agende sua visita ao MAE Paranaguá</p>
						</div>
						<form action="formSolicitanteAction.php" method="post" name="formAgendamento">
							<div class="campoForm">
								<label for="solicitante">Solicitante: </label><br/>
									<input type="text" name="solicitante" maxlength="60" tabindex="1"
										onblur="testaNome(formAgendamento.solicitante);" autofocus required/><br/><br/>
							</div>
							<div class="campoForm">
								<label for="contato">Contato: </label>
									<input type="radio" name="tipoContato"  value="email" onclick="displayRadioValue()" checked tabindex="2">Email
									<input type="radio" name="tipoContato" value="tel" onclick="displayRadioValue()" tabindex="3">Telefone<br/>
									<div id="campoContato">
							      <input type='text' name='contato' id='campoEmail' maxlength='60' tabindex='4'
											onblur='testaEmail(formAgendamento.contato);' required>
							    </div><br/>
							</div>
							<div class="campoForm">
								<label for="horario">Horário: </label><br/>
									<select name="horario" onblur="testaHorario(formAgendamento.horario);" tabindex="5" required>
						 				<option value="0">
											<?php
												if ($h){
													echo "--Selecione o horário--";
												} else{
													echo "--Não foi possível conectar com o BD--";
												}
											?>
										</option>
										<?php
										//Preenchimento do Select
											if ($h) {
												$indice = 0;
												while ($row = mysqli_fetch_array($h)){
													if ($vagas[$indice] < 1){
														//No caso de não haver vagas, desabilita a opção 'DISABLED'
														echo "<option value=".$row['horarioId']." disabled>"
															.$row['periodo']." - LOTADO</option>'";
													} else{
														//Preenche a option indicando o total de vagas disponíveis
														echo "<option value=".$row['horarioId'].">"
															.$row['periodo']." - ".$vagas[$indice]." vagas</option>'";
													}
													$indice++;
												}
											}
											?>
									</select><br/><br/>
								</div>
							<div class="campoForm">
								<div class="campoForm2">
									<div class="campoNum">
										<label for="numPessoas">Número de pessoas: </label><br/>
											<input type="number" name="numPessoas" min="1" max="<?php echo $maxVagas;?>" tabindex="6"
												onblur="testaNumPessoas(formAgendamento.numPessoas);" required/><br/>
												<div class="formObs">
													(Grupos de no máximo <?php echo $maxVagas;?> pessoas por horário)
												</div><br/>
									</div>
								</div>
								<div class="campoForm2">
									<div class="campoTermos">
											<input type="checkbox" name="termos" id="inputTermos" checked tabindex="7" required/><label for="termos">
													Concordo com as regras abaixo</label><br/>
									</div>
								</div>
							</div>
							<div class="campoForm">
								<div class="campoTermos">
									<div id="txtTermos">
										<h3>Regras de Acesso ao Museu - Prevenção à Covid-19:</h3>
										<p>Medidas preventivas:	</p>
										<ul>
											<li>Será aferida a temperatura dos visitantes com termômetros infravermelhos, sem
												contato. Pessoas com febre não poderão entrar no museu.</li>
											<li>É obrigatório o uso de máscara por todas as pessoas maiores de 3 anos durante
												toda a visita, inclusive nos espaços abertos. O próprio visitante deve levar sua
												máscara, que deve estar bem ajustada ao rosto.</li>
											<li>Álcool gel está disponibilizado nos espaços do museu. Nos banheiros há água e
												sabonete para que os visitantes higienizem as mãos sempre que precisar.</li>
											<li>Não é permitido o consumo de alimentos e bebidas dentro dos espaços expositivos.
												O consumo de água é permitido apenas nos espaços abertos, como o claustro.</li>
											<li>Caso tenha tido contato com alguém com Covid ou apresente sintomas como tosse,
												coriza, cansaço, febre, dor de garganta, perda de olfato ou paladar ou diarreia,
												não venha ao museu.</li>
											<li>Toda a equipe do museu passa por aferição de temperatura e por controle diário e
												acompanhamento de sintomas de Covid.</li>
										</ul>
									</div><br/><br/>
								</div>
							</div>

							<!--Form envia em campo hidden a data escolhida e estado do pedido-->
							<input type="hidden" name="dia" value="<?php echo $data;?>"/>

							<div id="botoesForm">
								<input type="submit" value="Solicitar" id="btnSolicitar" tabindex="8"/><br/>
								<?php
									//******INCLUIR VALIDAÇÃO, SÓ PODE VER SE ESTIVER LOGADO
									$location = "location='index.php'";
								  if(isset($_SESSION["usuario"])){
										$location = "location='agendamentoList.php'";
									}
									echo "<input type='button' value='<< Voltar' id='btnVoltar' onClick=\"$location\" tabindex='9'>";
								?>
							</div>
						</form>
					</div>
<?php
				} //Se não for o super usuário
			} //fim da validação de segunda-feira
		} //fim da validação do intervalo de 3 meses
	} //fim da validação do isset($_POST["data"])
?>
	</body>
</html>
