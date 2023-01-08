<?php
  include_once 'includes/head.php';

  //INCLUI O CABEÇALHO BÁSICO DO FORMULÁRIO
  include_once 'includes/areaForm.php';

  $location = "location='index.php'";

  //Verifica se tem mensagens para exibir
  if(isset($_GET["msg"])){
    //Mensagem de sucesso
    if($_GET["msg"] == "success"){
      if(isset($_GET["agNum"])){
        $agNum = $_GET["agNum"];
        $msg = "<p class='msgSucesso'><img src='img/sucesso2.png'>&nbsp;&nbsp;&nbsp;Agendamento
          <strong>$agNum</strong> cancelado com sucesso.&nbsp;&nbsp;&nbsp;
          <a href='formAlterarAg.php' target='_self'><strong>X</strong></a></p>";
      }
    }
    //Mensagem de cancelamento não efetuado
    if($_GET["msg"] == "erroNum"){
      if(isset($_GET["agNum"])){
        $agNum = $_GET["agNum"];
        $msg = "<p class='msgErro'><img src='img/erro1.png'>&nbsp;&nbsp;&nbsp;Agendamento
          <strong>$agNum</strong> não foi encontrado.&nbsp;&nbsp;&nbsp;
          <a href='formAlterarAg.php' target='_self'><strong>X</strong></a></p>";
      }
    }
  }

  //******SÓ PODE VER SE ESTIVER LOGADO
  if(isset($_SESSION["usuario"])){
    $location = "location='agendamentoList.php'";
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
?>
    <div class="tituloPag">
      <p>Alterar Agendamento</p>
    </div>
      <!-- <form action="cancelarAgendamentoAction.php" method="post"> -->
      <form action="formEditarAgendamento.php" method="post">
        <div class="campoForm">
          <label for="codigo">Código do Agendamento: </label><br/>
            <input type="text" name="codigo" id="campoCodigo" maxlength="7" size="7" tabindex="1"
              required/><br/><br/>
        </div>
        <div id="botoesForm">
          <input type="submit" value="Alterar" id="btnSolicitar" tabindex="2"/><br/>
          <input type="button" value="<< Voltar" id="btnVoltar" onClick=<?php echo $location;?> tabindex="3">
        </div>
      </form>
    </div>
<?php
  // }
?>
</body>
</html>
