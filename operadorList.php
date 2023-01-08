<?php
  include_once 'includes/head.php';

  include 'classes/Connection.php';
  include 'classes/Operador.php';
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

      if($usId == 1){ //Liberado apenas para o super usuário

        //Cria o objeto Operador
        $op = new Operador();
        //Busca de registros no BD
        $result = $op->listAll();

        if($result <> null){
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
            <div id="tituloOp">
              <p>Usuários do Sistema</p>
            </div>
            <div id="linkNovoOp">
              <a href="formConfigOperador.php"><img src="img/novoOperador1.png">
                <figcaption>Novo</figcaption>
              </a>
            </div>
          </div>

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
                <td class="tdAcoes">
                  <center>
                  <!--Direciona para a ação de cancelamento do agendamento-->
                  <a href="#?agId=<?php echo $dado['o_id'];?>"
                    onClick="return confirm('Deseja realmente bloquear o operador <?php echo $dado['o_email'];?>?')">
                      <img src="img/btnCancelar.png" class="btnAcoes"/>
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
