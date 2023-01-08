<?php
  include_once 'includes/head.php';

  //INCLUI O CABEÇALHO BÁSICO DO FORMULÁRIO
  include_once 'includes/areaForm.php';

  $location = "location='loginAdm.php'";

  //******SÓ PODE VER SE ESTIVER LOGADO
  if(isset($_SESSION["usuario"])){
    if($us->getIdUsuario() == 1){ //Liberado apenas para o super usuário
      $location = "location='usuarioList.php'";
      //Inclui a saudação/edição de cadastro e área de mensagens
      include_once 'includes/bemVindo.php';
?>
      <div class="tituloPag">
        <p>Cadastro de novo Usuário</p>
      </div>
      <form action="configUsuarioAction.php" name="formUsuario" method="post">
        <div class="campoForm">
          <label for="nome">Nome do Usuário: </label>
            <input type="text" name="nome" id="campoNomeUs" maxlength="60" tabindex="1"
              onblur='testaNome(formUsuario.nome);' autofocus required/> <br/><br/>
        </div>
        <div class="campoForm">
          <label for="email">Email do Usuário: </label>
            <input type="text" name="email" id="campoEmail" maxlength="60" tabindex="2"
              onblur="testaEmail(formUsuario.email);" required /><br/><br/>
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
          <input type="button" value="<< Voltar" id="btnVoltar" onClick=<?php echo $location;?> tabindex="6"/>
        </div>
      </form>
<?php
    } else { // Se estiver logado e não for SU
      echo "<p class='msgErro'><img src='img/erro1.png'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Apenas o super usuário pode
        acessar essa página.<br/><br/>
          <div id='botoesForm'>
            <input type='button' value='<< Voltar' id='btnVoltar' onClick=\"$location\" tabindex='1'/>
          </div>
        </div>"	;
    }
  } else { //Se não estiver logado
    echo "<p class='msgErro'><img src='img/erro1.png'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Você precisa estar logado para
      acessar essa página.<br/><br/>
        <div id='botoesForm'>
          <input type='button' value='<< Voltar' id='btnVoltar' onClick=\"$location\" tabindex='1'/>
        </div>
      </div>"	;
  }
?>
      </div>
    </body>
  </html>
