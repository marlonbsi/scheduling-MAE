<?php
  include_once 'includes/head.php';

  require_once('classes/Session.php');

  //Inicia a sessão para armazenar as vagas
  session_start();
  $session = new Session;
  $session->validaSessao();

  //INCLUI O CABEÇALHO BÁSICO DO FORMULÁRIO
  include_once 'includes/areaForm.php';

  if(isset($_SESSION["usId"])){
    $usId = $_SESSION["usId"];

    //Pega os dados da session
    //******INCLUIR VALIDAÇÃO, SÓ PODE VER SE ESTIVER LOGADO
    if(isset($_SESSION["usNome"]) && isset($_SESSION["usEmail"])){
  		$usNome = $_SESSION["usNome"];
      $usEmail = $_SESSION["usEmail"];
?>
      <div id="bemVindo">
          <div id="bemVindoMsg">Bem-vindo(a), <?php echo $usNome;?></div>
          <div id="bemVindoSair"><a href="actionSair.php">Sair</a></div>
      </div>
      <div id="areaMsgs">
        <!--Exibe mensagem recebida por $_GET-->
        <p><?php echo $msg;?></p>
      </div>
      <div class="tituloPag">
        <p>Cadastro de novo Operador</p>
      </div>
        <form action="formConfigOperadorAction.php" name="formOperador" method="post">
          <div class="campoForm">
            <label for="nome">Nome do Operador: </label>
              <input type="text" name="nome" id="campoNomeOp" maxlength="60" tabindex="1"
                onblur='testaNome(formOperador.nome);' autofocus required/> <br/><br/>
          </div>
          <div class="campoForm">
            <label for="email">Email do Operador: </label>
              <input type="text" name="email" id="campoEmail" maxlength="60" tabindex="2"
                onblur="testaEmail(formOperador.email);" required /><br/><br/>
          </div>
          <div class="campoForm">
            <div class="campoForm2">
              <label for="senha">Senha:</label><br/>
                <input type="password" id="campoSenha2" name="senha" tabindex="3" required/><br/><br/>
            </div>
            <div class="campoForm2">
              <label for="confSenha">Confirmar Senha:</label><br/>
                <input type="password" id="confSenha2" name="confSenha" tabindex="4" required/><br/><br/>
            </div>
          </div>
          <div id="botoesForm">
            <input type="submit" value="Cadastrar" id="btnSolicitar" tabindex="5"/><br/>
            <input type="button" value="<< Voltar" id="btnVoltar" onClick="window.history.go(-1)" tabindex="6" />
          </div>
        </form>
<?php
    }
  }
?>
      </div>
    </body>
  </html>
