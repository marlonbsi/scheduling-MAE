<div id="areaForm">
  <div id="btnMenu">

<?php if(isset($_SESSION["usuario"])){
        $idUsuario = $_SESSION["idUsuario"];
        if ($idUsuario == 1){ ?>
          <!-- CABEÇALHO DEFINIDO PARA SUPER USUÁRIO -->
          <div id="linkAdm">
              <a href="actionSair.php" target="_self"><img src="img/logout1.png" id="btnLogout"
                alt="Sair" title="Sair"/>
                <figcaption>Sair</figcaption>
              </a>
          </div>
          <div id="linkAcoes">
              <a href="config.php" target="_self"><img src="img/configuracoes1.png" id="btnRegistro"
                alt="Configurações do sistema" title="Configurações do sistema"/>
                <figcaption>Configurações do sistema</figcaption>
              </a>
          </div>
<?php   } else { ?>
          <!-- CABEÇALHO DEFINIDO PARA USUÁRIO LOGADO -->
          <div id="linkAdm">
              <a href="actionSair.php" target="_self"><img src="img/logout1.png" id="btnLogout"
                alt="Sair" title="Sair"/>
                <figcaption>Sair</figcaption>
              </a>
          </div>
          <div id="linkAcoes">
              <a href="formRegistro.php" target="_self"><img src="img/novo2.png" id="btnRegistro"
                alt="Registrar visita" title="Registrar visita"/>
                <figcaption>Registrar visita</figcaption>
              </a>
          </div>
          <div id="linkLista">
              <a href="agendamentoList.php" target="_self"><img src="img/lista1.png" id="btnLista"
                alt="Lista de agendamentos" title="Lista de agendamentos"/>
                <figcaption>Lista de agendamentos</figcaption>
              </a>
          </div>
          <div id="linkAgenda">
              <a href="index.php" target="_self"><img src="img/agenda1.png" id="btnAgenda"
                alt="Agendar uma Visita" title="Agendar uma Visita"/>
                <figcaption>Agendar uma Visita</figcaption>
              </a>
          </div>
<?php   }
      } else { ?>
        <!-- CABEÇALHO DEFINIDO PARA SOLICITANTE -->
        <div id="linkAdm">
            <a href="loginAdm.php" target="_self"><img src="img/login5.png" id="btnLogin"
              alt="Login Adm" title="Login Adm"/>
              <figcaption>Login Adm</figcaption>
            </a>
        </div>
        <div id="linkAcoes">
            <a href="formAlterarAg.php" target="_self"><img src="img/btnEdit.png" id="btnCancel"
              alt="Alterar um Agendamento" title="Alterar um agendamento"/>
              <figcaption>Alterar um Agendamento</figcaption>
            </a>
        </div>
<?php } ?>
  </div>
