<?php
  include_once 'includes/head.php';

  include 'classes/Horarios.php';

  $location = "location='usuarioList.php'";

  //INCLUI O CABEÇALHO BÁSICO DO FORMULÁRIO
  include_once 'includes/areaForm.php';

  //******SÓ PODE VER SE ESTIVER LOGADO
  if(isset($_SESSION["usuario"])){
    //Inclui a saudação/edição de cadastro e área de mensagens
    include_once 'includes/bemVindo.php';
    $location = "location='horarioList.php'";
    $hAlt = new Horario();
    $erroCampo = "ok";
    if(isset($_POST["id"])){
      $id = $_POST["id"];
      $hAlt = $hAlt->retornaPorId($id);
      if($hAlt <> null){
        if(isset($_POST["horarioEntrada"])){
      		$horarioEntrada = $_POST["horarioEntrada"];
      		if(!$hAlt->setEntrada($horarioEntrada)){
      			$erroCampo = "horarioEntrada";
      		}
      	} else{
      		$erroCampo = "vazio";
      	}

        if(isset($_POST["horarioDuracao"])){
      		$horarioDuracao = $_POST["horarioDuracao"];
          // Soma os minutos informados em $duracao à entrada
          $saida = strtotime("$horarioEntrada + $horarioDuracao minutes");
          // Formata o resultado
          $saidaFormatada = date("H:i",$saida);
          //Concatena as strings
          $periodo = $horarioEntrada." às ".$saidaFormatada;
      		if(!$hAlt->setDuracao($horarioDuracao)){
      			$erroCampo = "horarioDuracao";
      		}
          if(!$hAlt->setPeriodo($periodo)){
            $erroCampo = "periodo";
          }
      	} else{
      		$erroCampo = "vazio";
      	}

        if(isset($_POST["horarioVagas"])){
      		$horarioVagas = $_POST["horarioVagas"];
      		if(!$hAlt->setVagasHorario($horarioVagas)){
      			$erroCampo = "horarioVagas";
      		}
      	} else{
      		$erroCampo = "vazio";
      	}

        if($erroCampo == "ok"){
          $hAlt->update();
        } else { // Fim se erroCampo não estiver OK
          if($erroCampo == "vazio"){
      			echo "<p class='msgErro'><img src='img/erro1.png'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Por favor, preencha
      				todos os campos para continuar.</p>
      					<div id='botoesForm'>
      						<input type='button' value='<< Voltar' id='btnVoltar' onClick=\"$location\" tabindex='1'/>
      					</div>
      				</div>"	;
      		}
      		if($erroCampo == "horarioEntrada"){
      			echo "<p class='msgErro'><img src='img/erro1.png'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Valor inválido para o
      				campo Entrada.</p>
      					<div id='botoesForm'>
      						<input type='button' value='<< Voltar' id='btnVoltar' onClick=\"$location\" tabindex='1'/>
      					</div>
      				</div>"	;
      		}
          if($erroCampo == "horarioDuracao"){
      			echo "<p class='msgErro'><img src='img/erro1.png'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Valor inválido para o
      				campo Duração.</p>
      					<div id='botoesForm'>
      						<input type='button' value='<< Voltar' id='btnVoltar' onClick=\"$location\" tabindex='1'/>
      					</div>
      				</div>"	;
      		}
          if($erroCampo == "horarioVagas"){
            echo "<p class='msgErro'><img src='img/erro1.png'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Valor inválido para o
      				campo Vagas.</p>
      					<div id='botoesForm'>
      						<input type='button' value='<< Voltar' id='btnVoltar' onClick=\"$location\" tabindex='1'/>
      					</div>
      				</div>"	;
      		}
        } // Fim do else para erroCampo="ok"
      } else { // Se não retornou horário da busca por id
        echo "<p class='msgErro'><img src='img/erro1.png'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;O horário informado não foi
          encontrado.</p>
            <div id='botoesForm'>
              <input type='button' value='<< Voltar' id='btnVoltar' onClick=\"$location\" tabindex='1'/>
            </div>
          </div>"	;
      } // Fim se não retornou horário da busca por id
    } else { //Se não foi enviado o id por $_POST
      echo "<p class='msgErro'><img src='img/erro1.png'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Para acessar essa função é
        necessário selecionar um usuário.</p>
          <div id='botoesForm'>
            <input type='button' value='<< Voltar' id='btnVoltar' onClick=\"$location\" tabindex='1'/>
          </div>
        </div>"	;
    } //Fim Se não foi enviado o id por $_POST
  } else { // Fim se não tem usuário logado
    echo "<p class='msgErro'><img src='img/erro1.png'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Você não tem autorização para
      acessar essa função.</p>
        <div id='botoesForm'>
          <input type='button' value='<< Voltar' id='btnVoltar' onClick=\"$location\" tabindex='1'/>
        </div>
      </div>"	;
  }// Fim se tem usuário logado
?>
    </div>
  </body>
</html>
