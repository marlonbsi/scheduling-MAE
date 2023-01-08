<?php

  include_once 'includes/head.php';
  include 'classes/Agendamento.php';
  require_once('classes/Horarios.php');
  require_once('classes/Session.php');


  //INCLUI O CABEÇALHO BÁSICO DO FORMULÁRIO
  include_once 'includes/areaForm.php';

  //Inicia a sessão para armazenar as vagas
  session_start();
  $session = new Session;
  $session->validaSessao();

  //Verifica se tem mensagens para exibir
  if(isset($_GET["msg"])){
    //Mensagem de sucesso
    if($_GET["msg"] == "success"){
      if(isset($_GET["agNum"])){
        $agNum = $_GET["agNum"];
        $msg = "<p class='msgSucesso'><img src='img/sucesso2.png'>&nbsp;&nbsp;&nbsp;Agendamento
          <strong>$agNum</strong> cancelado com sucesso.&nbsp;&nbsp;&nbsp;
          <a href='formCancelarAg.php' target='_self'><strong>X</strong></a></p>";
      }
    }
    //Mensagem de cancelamento não efetuado
    if($_GET["msg"] == "erroNum"){
      if(isset($_GET["agNum"])){
        $agNum = $_GET["agNum"];
        $msg = "<p class='msgErro'><img src='img/erro1.png'>&nbsp;&nbsp;&nbsp;Agendamento
          <strong>$agNum</strong> não foi encontrado.&nbsp;&nbsp;&nbsp;
          <a href='formCancelarAg.php' target='_self'><strong>X</strong></a></p>";
      }
    }
?>
    <div id="bemVindo">
        <div id="bemVindoMsg"></div>
        <div id="bemVindoSair"></div>
    </div>
    <div id="areaMsgs">
      <!--Exibe mensagem recebida por $_GET-->
      <p><?php echo $msg;?></p>
    </div>
<?php
  }
?>
    <div class="tituloPag">
      <p>Cancelar Agendamento</p>
    </div>
      <form action="cancelarAgendamentoAction.php" method="post">
        <div class="campoForm">
          <label for="codigo">Código do Agendamento: </label><br/>
            <input type="text" name="codigo" id="campoCodigo" maxlength="7" size="7" tabindex="1"
              required/><br/><br/>
        </div>
        <div id="botoesForm">
          <input type="submit" value="Cancelar" id="btnSolicitar" tabindex="2"/><br/>
          <?php
            //******INCLUIR VALIDAÇÃO, SÓ PODE VER SE ESTIVER LOGADO
            $location = "location='index.php'";
            if(isset($_SESSION["usNome"]) && isset($_SESSION["usEmail"])){
              $location = "location='agendamentoList.php'";
            }
            echo "<input type='button' value='<< Voltar' id='btnVoltar' onClick=\"$location\" tabindex='3'>";
          ?>
        </div>
      </form>
    </div>
<?php
  // }
?>
</body>
</html>
