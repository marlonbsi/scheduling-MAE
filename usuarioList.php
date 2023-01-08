<?php
  include_once 'includes/head.php';

  //INCLUI O CABEÇALHO BÁSICO DO FORMULÁRIO
  include_once 'includes/areaForm.php';

  //******SÓ PODE VER SE ESTIVER LOGADO
  if(isset($_SESSION["usuario"])){
    if($us->getIdUsuario() == 1){ //Liberado apenas para o super usuário

      //Verifica se tem mensagens para exibir
      if(isset($_GET["msg"])){
        //Mensagem de cancelamento efetuado
        if($_GET["msg"] == "upd"){
          if(isset($_GET["usAlt"])){
            $idUsAlt = $_GET["usAlt"];
            $usAlt = new Usuario();
            $usAlt = $usAlt->retornaPorId($idUsAlt);
            $emailUs = $usAlt->getEmailUsuario();
            $msg = "<p class='msgSucesso'><img src='img/sucesso2.png'>&nbsp;&nbsp;&nbsp;O cadastro do
              usuário <strong>$emailUs</strong> foi atualizado com sucesso.&nbsp;&nbsp;&nbsp;
              <a href='usuarioList.php' target='_self'><strong>X</strong></a></p>";
          }
        }
        //Mensagem de cancelamento não efetuado
        if($_GET["msg"] == "erroUpd"){
          if(isset($_GET["usAlt"])){
            $idUsAlt = $_GET["usAlt"];
            $usAlt = new Usuario();
            $usAlt = $usAlt->retornaPorId($idUsAlt);
            $emailUs = $usAlt->getEmailUsuario();
            $msg = "<p class='msgErro'><img src='img/erro1.png'>&nbsp;&nbsp;&nbsp;Ocorreu um erro ao
              atualizar o cadastro do usuário <strong>$emailUs</strong>. Para maiores informações, contate o
              suporte.&nbsp;&nbsp;&nbsp;
              <a href='usuarioList.php' target='_self'><strong>X</strong></a></p>";
          }
        }
        //Mensagem de cancelamento efetuado
        if($_GET["msg"] == "del"){
          if(isset($_GET["usAlt"])){
            $idUsAlt = $_GET["usAlt"];
            $usAlt = new Usuario();
            $usAlt = $usAlt->retornaPorId($idUsAlt);
            $emailUs = $usAlt->getEmailUsuario();
            $msg = "<p class='msgSucesso'><img src='img/sucesso2.png'>&nbsp;&nbsp;&nbsp;O usuário
              <strong>$emailUs</strong> foi excluído com sucesso.&nbsp;&nbsp;&nbsp;
              <a href='usuarioList.php' target='_self'><strong>X</strong></a></p>";
          }
        }
        //Mensagem de cancelamento não efetuado
        if($_GET["msg"] == "erroDel"){
          if(isset($_GET["usAlt"])){
            $idUsAlt = $_GET["usAlt"];
            $usAlt = new Usuario();
            $usAlt = $usAlt->retornaPorId($idUsAlt);
            $emailUs = $usAlt->getEmailUsuario();
            $msg = "<p class='msgErro'><img src='img/erro1.png'>&nbsp;&nbsp;&nbsp;Ocorreu um erro ao
              excluir o usuário <strong>$emailUs</strong>. Para maiores informações, contate o suporte.
              &nbsp;&nbsp;&nbsp;<a href='usuarioList.php' target='_self'><strong>X</strong></a></p>";
          }
        }
      }
      //Inclui a saudação/edição de cadastro e área de mensagens
      include_once 'includes/bemVindo.php';
      //Cria o objeto Usuário
      $usLista = new Usuario();
      //Busca de registros no BD
      $result = $usLista->listAll();
?>
        <div class="tituloPag">
          <div id="tituloOp">
            <p>Usuários do Sistema</p>
          </div>
          <div id="linkNovoOp">
            <a href="formConfigUsuario.php"><img src="img/novoUsuario.png" alt="Novo Usuário"
              title="Novo Usuário">
              <figcaption>Novo</figcaption>
            </a>
          </div>
        </div>
<?php if($result <> null){ ?>
        <table id="tbAgendamentos">
          <!--Cabeçalho da tabela-->
          <tr class="trH">
            <th>NOME</th>
            <th>EMAIL</th>
            <th>ATIVO</th>
            <th>AÇÕES</th>
          </tr>
    <?php
          //Iterações que organizam os registros do BD em linhas da tabela
          $cont = 0;
          while($dado = $result->fetch_array()) {
            $nome = $dado['o_nome'];
            $email = $dado['o_email'];
            $ativo = $dado['o_ativo'];

            //if que formata a saída do valor "ativo" do operador
            if($ativo == 1){
              $ativo = "SIM";
            } else {
              $ativo = "NÃO";
            }

            //If que formata a tabela com a classe CSS variando a cada linha
            if($cont % 2 ==0){
              $cssClass = "trA";
            } else{
              $cssClass = "trB";
            }
            $cont++;
    ?>
            <!--Linhas/colunas da tabela-->
            <tr class=<?php echo $cssClass;?>>
              <td class="tdNomeOperador"><?php echo $nome; ?></td>
              <td class="tdEmailOperador"><?php echo $email; ?></td>
              <td class="tdAtivo"><?php echo $ativo; ?></td>
              <td class="tdAcoesUs">
                <center>
<?php           if($ativo == "SIM"){ ?>
                  <!--Direciona para a ação de desativação do usuário-->
                  <a href="ativarUsuarioAction.php?usId=<?php echo $dado['o_id'];?>"
                    onClick="return confirm('Deseja realmente bloquear o usuário <?php echo $dado['o_email'];?>?')">
                      <img src="img/on1.png" class="btnAcoes" id="btnOff" alt="Bloquear Usuário" title="Bloquear Usuário"/>
                  </a>
<?php           } else { ?>
                  <!--Direciona para a ação de ativação do usuário-->
                  <a href="ativarUsuarioAction.php?usId=<?php echo $dado['o_id'];?>"
                    onClick="return confirm('Deseja realmente ativar o usuário <?php echo $dado['o_email'];?>?')">
                      <img src="img/off1.png" class="btnAcoes" id="btnOn" alt="Ativar Usuário" title="Ativar Usuário"/>
                  </a>
<?php           } ?>
                <!--Direciona para a ação de exclusão do usuário-->
                <a href="excluirUsuarioAction.php?usId=<?php echo $dado['o_id'];?>"
                  onClick="return confirm('Deseja realmente excluir o usuário <?php echo $dado['o_email'];?>?')">
                    <img src="img/btnCancelar.png" class="btnAcoes btnExcluirUs" alt="Excluir Usuário" title="Excluir Usuário"/>
                </a>
                <!--Direciona para a ação de edição do usuário-->
                <a href="formEditarUsuario.php?usId=<?php echo $dado['o_id'];?>">
    								<img src="img/btnEdit.png" class="btnAcoes btnEdit" alt="Editar Horário" title="Editar Horário"/>
                </a>
              </center>
              </td>
            </tr>
  <?php
          } // Fecha o while
          echo "</table>";
        } //Fecha o if($result <> null)
      } else { //Se não é super user
        echo "<p class='msgErro'><img src='img/erro1.png'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Apenas o super usuário pode
          acessar essa página.<br/><br/>
            <div id='botoesForm'>
              <input type='button' value='<< Voltar' id='btnVoltar' onClick=location='index.php' tabindex='1'>
            </div>
          </div>"	;
      }
    } else {
    echo "<p class='msgErro'><img src='img/erro1.png'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Você precisa estar logado para
      acessar essa página.<br/><br/>
        <div id='botoesForm'>
          <input type='button' value='<< Voltar' id='btnVoltar' onClick=location='loginAdm.php' tabindex='1'>
        </div>
      </div>"	;
  }
?>
    </div>
  </body>
</html>
