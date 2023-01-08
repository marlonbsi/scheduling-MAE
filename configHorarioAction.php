<?php
  include_once 'includes/head.php';

  include 'classes/Horarios.php';

  //INCLUI O CABEÇALHO BÁSICO DO FORMULÁRIO
  include_once 'includes/areaForm.php';

  $location = "location='loginAdm.php'";

  //******SÓ PODE VER SE ESTIVER LOGADO
  if(isset($_SESSION["usuario"])){
    //Inclui a saudação/edição de cadastro e área de mensagens
    include_once 'includes/bemVindo.php';
    echo "<div class='tituloPag'> <p>Inclusão de Horário</p> </div>";

    if($us->getIdUsuario() == 1){ //Liberado apenas para o super usuário
      $location = "location='horarioList.php'";

      //Cria o objeto Usuário
      $hCad = new Horario();
      //Horários cadastrados iniciam ativos
      $hCad->setAtivo(1);
      $hCad->setExcluido(0);

      $erroCampo = "ok";

      if(isset($_POST["horarioEntrada"])){
        $entrada = $_POST["horarioEntrada"];
        if(!$hCad->setEntrada($entrada)){
          $erroCampo = "entrada";
        }
      } else{
        $erroCampo = "vazio";
      }

      if(isset($_POST["horarioDuracao"])){
        $duracao = $_POST["horarioDuracao"];
        // Soma os minutos informados em $duracao à entrada
        $saida = strtotime("$entrada + $duracao minutes");
        // Formato o resultado
        $saidaFormatada = date("H:i",$saida);
        //Concatena as strings
        $periodo = $entrada." às ".$saidaFormatada;
        if(!$hCad->setDuracao($duracao)){
          $erroCampo = "horarioDuracao";
        }
        if(!$hCad->setPeriodo($periodo)){
          $erroCampo = "periodo";
        }
      } else{
        $erroCampo = "vazio";
      }

      if(isset($_POST["horarioVagas"])){
        $vagas = $_POST["horarioVagas"];
        if(!$hCad->setVagasHorario($vagas)){
          $erroCampo = "vagas";
        }
      } else{
        $erroCampo = "vazio";
      }

      if($erroCampo == "ok"){
        $hCad->insert();
      } else{
        if($erroCampo == "vazio"){
    			echo "<p class='msgErro'><img src='img/erro1.png'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Por favor, preencha
    				todos os campos para continuar.</p>
    					<div id='botoesForm'>
    						<input type='button' value='<< Voltar' id='btnVoltar' onClick=\"$location\" tabindex='1'/>
    					</div>
    				</div>"	;
    		}
      }
    }
  }
?>
