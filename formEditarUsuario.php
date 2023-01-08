<?php
  include_once 'includes/head.php';

  //INCLUI O CABEÇALHO BÁSICO DO FORMULÁRIO
  include_once 'includes/areaForm.php';

  $location = "location='agendamentoList.php'";

  //******SÓ PODE VER SE ESTIVER LOGADO
  if(isset($_SESSION["usuario"])){
    //Inclui a saudação/edição de cadastro e área de mensagens
    include_once 'includes/bemVindo.php';
    //Verifica se a data do form anterior foi enviada por POST ou por GET se veio da lista
    if(isset($_GET["usId"])){
      $id = $_GET["usId"];
      if($id > 1){ //Não pode alterar os dados do super usuário
        $usAlt = new Usuario();
        $usAlt = $usAlt->retornaPorId($id);
        if($usAlt <> null){
          //Liberado apenas para o super usuário ou para o próprio do cadastro
          if(($us->getIdUsuario() == 1) || ($us->getIdUsuario() == $usAlt->getIdUsuario())){
            if ($us->getIdUsuario() == 1) {
              $location = "location='usuarioList.php'";
            }
?>
            <div class="tituloPag">
              <p>Editar dados do Usuário</p>
            </div>
            <form action="editarUsuarioAction.php" method="post">
              <div class="campoForm">
                <label for="nome">Nome do Usuário: </label>
                  <input type="text" name="nome" id="campoNomeUs" value="<?php echo $usAlt->getNomeUsuario(); ?>"
                    maxlength="60" tabindex="1" onblur='testaNome(formUsuario.nome);' autofocus required/>
                <br/><br/>
              </div>
              <div class="campoForm">
                <label for="email">Email do Usuário: </label>
                  <input type="text" name="email" id="campoEmail" value="<?php echo $usAlt->getEmailUsuario(); ?>"
                    maxlength="60" tabindex="2" onblur="testaEmail(formUsuario.email);" required /><br/><br/>
              </div>
              <div class="campoForm">
                <div class="campoForm2">
                  <label for="senha">Nova Senha:</label><br/>
                    <input type="password" id="campoSenha2" name="senha" tabindex="3"/><br/><br/>
                </div>
                <div class="campoForm2">
                  <label for="confSenha">Confirmar Senha:</label><br/>
                    <input type="password" id="confSenha2" name="confSenha" tabindex="4"/><br/><br/>
                </div>
              </div>
              <div class="campoForm">
                <div class="formObs">
                  (Para manter a senha atual, deixe os campos Nova Senha e Confirmar Senha em branco.)
                </div><br/>
              </div>

              <input type="hidden" name="id" value="<?php echo $usAlt->getIdUsuario();?>"/>
              <input type="hidden" name="ativo" value="<?php echo $usAlt->getAtivo();?>"/>
              <div id="botoesForm">
                <input type="submit" value="Alterar" id="btnSolicitar" tabindex="5"/><br/>
                <input type="button" value="<< Voltar" id="btnVoltar" onClick=<?php echo $location;?> tabindex="6"/>
              </div>
            </form>
<?php
          } else {
            echo "<p class='msgErro'><img src='img/erro1.png'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Você não tem autorização
              para alterar o cadastro informado.</p>
                <div id='botoesForm'>
                  <input type='button' value='<< Voltar' id='btnVoltar' onClick=\"$location\" tabindex='1'/>
                </div>
              </div>"	;
          } // Fim se o usuário é MAE ou o dono do cadastro
        } else {
          echo "<p class='msgErro'><img src='img/erro1.png'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;O usuário informado não foi
            encontrado.</p>
              <div id='botoesForm'>
                <input type='button' value='<< Voltar' id='btnVoltar' onClick=\"$location\" tabindex='1'/>
              </div>
            </div>"	;
        }// Fim se retornou um usuário válido pela busca por id
      } else {
        echo "<p class='msgErro'><img src='img/erro1.png'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Não é possível alterar o
          cadastro do usuário MAE. Para fazer a alteração, contate o suporte.</p>
            <div id='botoesForm'>
              <input type='button' value='<< Voltar' id='btnVoltar' onClick=\"$location\" tabindex='1'/>
            </div>
          </div>"	;
      }// Fim se não está alterando o super usuário
    } else {
      echo "<p class='msgErro'><img src='img/erro1.png'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Para acessar essa função é
        necessário selecionar um usuário.</p>
          <div id='botoesForm'>
            <input type='button' value='<< Voltar' id='btnVoltar' onClick=\"$location\" tabindex='1'/>
          </div>
        </div>"	;
    }// Fim se tinha id na variável $_GET
  } else {
    echo "<p class='msgErro'><img src='img/erro1.png'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Você não tem autorização para
      acessar essa função.</p>
        <div id='botoesForm'>
          <input type='button' value='<< Voltar' id='btnVoltar' onClick=\"$location\" tabindex='1'/>
        </div>
      </div>"	;
  }// Fim se tem algum usuário logado
?>
    </div>
  </body>
</html>
