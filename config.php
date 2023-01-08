<?php
  include_once 'includes/head.php';

  include 'classes/Horarios.php';

  //INCLUI O CABEÇALHO BÁSICO DO FORMULÁRIO
  include_once 'includes/areaForm.php';

  //******SÓ PODE VER SE ESTIVER LOGADO
  if(isset($_SESSION["usuario"])){
    if($us->getIdUsuario() == 1){ //Liberado apenas para o super usuário
      //Inclui a saudação/edição de cadastro e área de mensagens
      include_once 'includes/bemVindo.php';
?>
      <div class="tituloPag">
        <p>Configurações do Sistema de Agendamento</p>
      </div>
      <div id="configLinks">
        <div class="configBtns">
          <center><a href="usuarioList.php"><img src="img/user1.png" class="btnConfiguracoes"
            alt="Configurações de usuário" title="Configurações de usuário">
            <figcaption>Configurações de usuário</figcaption></a></center>
        </div>
        <div class="configBtns">
          <center><a href="horarioList.php"><img src="img/clock1.png" class="btnConfiguracoes"
            alt="Configurações de horário" title="Configurações de horário">
            <figcaption>Configurações de horário</figcaption></a></center>
        </div>
        <div class="configBtns">
          <center><a href="relatorioList.php"><img src="img/report1.png" class="btnConfiguracoes"
            alt="Relatórios do sistema" title="Relatórios do sistema">
            <figcaption>Relatórios do sistema</figcaption></a></center>
        </div>
      </div>
<?php
    } else{ // Se estiver logado e não for SU
?>
      <p class='msgErro'><img src='img/erro1.png'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Apenas o super usuário
        pode acessar essa página.<br/><br/>
      </p>
      <div id="botoesForm">
        <input type="button" value="<< Voltar" id="btnVoltar" onClick=location='index.php' tabindex="1">
      </div>
<?php
    }
  } else{ //Se não estiver logado
?>
    <p class='msgErro'><img src='img/erro1.png'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Você não tem permissão
      para acessar essa página.<br/><br/>
    </p>
    <div id="botoesForm">
      <input type="button" value="<< Voltar" id="btnVoltar" onClick=location='index.php' tabindex="1">
    </div>
<?php
  }
?>
    </div>
  </body>
</html>
