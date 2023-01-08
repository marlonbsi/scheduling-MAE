<?php
  include_once 'includes/head.php';

  include 'classes/Agendamento.php';

  //INCLUI O CABEÇALHO BÁSICO DO FORMULÁRIO
  include_once 'includes/areaForm.php';

  //Só permite a usuários logados a visualização da lista
  if(isset($_SESSION["usuario"])){

    //Verifica se tem mensagens para exibir
    if(isset($_GET["msg"])){
      //Mensagem de cancelamento efetuado
      if($_GET["msg"] == "canc"){
        if(isset($_GET["agAlt"])){
          $agNum = $_GET["agAlt"];
          $agAlt = new Agendamento();
          $agAlt = $agAlt->retornaAgendamentoPorId($agNum);
          $agNum = $agAlt->getAgNum();
          $msg = "<p class='msgSucesso'><img src='img/sucesso2.png'>&nbsp;&nbsp;&nbsp;Agendamento
            <strong>$agNum</strong> cancelado com sucesso.&nbsp;&nbsp;&nbsp;
            <a href='agendamentoList.php' target='_self'><strong>X</strong></a></p>";
        }
      }
      //Mensagem de cancelamento não efetuado
      if($_GET["msg"] == "erroCanc"){
        if(isset($_GET["agAlt"])){
          $agNum = $_GET["agAlt"];
          $agAlt = new Agendamento();
          $agAlt = $agAlt->retornaAgendamentoPorId($agNum);
          $agNum = $agAlt->getAgNum();
          $msg = "<p class='msgErro'><img src='img/erro1.png'>&nbsp;&nbsp;&nbsp;Agendamento
            <strong>$agNum</strong> não pôde ser cancelado. Por favor, repita a operação ou
            entre em contato com o suporte.&nbsp;&nbsp;&nbsp;
            <a href='agendamentoList.php' target='_self'><strong>X</strong></a></p>";
        }
      }
      //Mensagem de atualização efetuada
      if($_GET["msg"] == "upd"){
        if(isset($_GET["agAlt"])){
          $agNum = $_GET["agAlt"];
          $agAlt = new Agendamento();
          $agAlt = $agAlt->retornaAgendamentoPorId($agNum);
          $agNum = $agAlt->getAgNum();
          $msg = "<p class='msgSucesso'><img src='img/sucesso2.png'>&nbsp;&nbsp;&nbsp;Agendamento
            <strong>$agNum</strong> atualizado com sucesso.&nbsp;&nbsp;&nbsp;
            <a href='agendamentoList.php' target='_self'><strong>X</strong></a></p>";
        }
      }
      //Mensagem de erro na atualização
      if($_GET["msg"] == "erroUpd"){
        if(isset($_GET["agAlt"])){
          $agNum = $_GET["agAlt"];
          $agAlt = new Agendamento();
          $agAlt = $agAlt->retornaAgendamentoPorId($agNum);
          $agNum = $agAlt->getAgNum();
          $msg = "<p class='msgErro'><img src='img/erro1.png'>&nbsp;&nbsp;&nbsp;Ocorreu um erro
            ao atualizar o agendamento <strong>$agNum</strong>. Por favor, repita a operação ou
            entre em contato com o suporte.&nbsp;&nbsp;&nbsp;
            <a href='agendamentoList.php' target='_self'><strong>X</strong></a></p>";
        }
      }
      //Mensagem de atualização no cadastro do usuário
      if($_GET["msg"] == "updUs"){
        if(isset($_GET["usAlt"])){
          $idUsAlt = $_GET["usAlt"];
          $usAlt = new Usuario();
          $usAlt = $usAlt->retornaPorId($idUsAlt);
          $emailUs = $usAlt->getEmailUsuario();
          $msg = "<p class='msgSucesso'><img src='img/sucesso2.png'>&nbsp;&nbsp;&nbsp;O cadastro do
            usuário <strong>$emailUs</strong> foi atualizado com sucesso.&nbsp;&nbsp;&nbsp;
            <a href='agendamentoList.php' target='_self'><strong>X</strong></a></p>";
        }
      }
      //Mensagem de erro na atualização no cadastro do usuário
      if($_GET["msg"] == "erroUpdUs"){
        if(isset($_GET["usAlt"])){
          $idUsAlt = $_GET["usAlt"];
          $usAlt = new Usuario();
          $usAlt = $usAlt->retornaPorId($idUsAlt);
          $emailUs = $usAlt->getEmailUsuario();
          $msg = "<p class='msgErro'><img src='img/erro1.png'>&nbsp;&nbsp;&nbsp;Ocorreu um erro ao
            atualizar o cadastro do usuário <strong>$emailUs</strong>. Para maiores informações, contate o
            suporte.&nbsp;&nbsp;&nbsp;
            <a href='agendamentoList.php' target='_self'><strong>X</strong></a></p>";
        }
      }
    }

    //Inclui a saudação/edição de cadastro e área de mensagens
    include_once 'includes/bemVindo.php';

    $ag = new Agendamento();

    //variáveis que formatam a tabela indicando classes CSS trA, trB
    $ultimoDia = null;
    $cssClass = "trA";
    $mudouData = 0;

    //Busca de registros no BD
    $result = $ag->listAll();

    if($result <> null){
    ?>

        <div class="tituloPag">
          <p>Próximos Agendamentos:</p>
        </div>

        <table id="tbAgendamentos">
          <!--Cabeçalho da tabela-->
          <tr class="trH">
            <th>NÚMERO</th>
            <th>HORÁRIO</th>
            <th>PES</th>
            <th>SOLICITANTE</th>
            <th>CONTATO</th>
            <th>AÇÕES</th>
          </tr>

          <?php
            //Iterações que organizam os registros do BD em linhas da tabela
            $cont = 0;
        		while($dado = $result->fetch_array()) {
        			$dia = $dado['a_dia'];
              $numero = $dado['a_agNum'];
        			$h = $dado['h_ent'];
        			$pessoas = $dado['a_num'];
        			$solicitante = $dado['a_sol'];
        			$email = $dado['a_email'];

              //Verifica se é o primeiro registro para exibir a linha com a data
              if(is_null($ultimoDia)){
                $ultimoDia = $dia;
      ?>
                <!-- Exibe a linha com a data -->
                <tr class="trDia">
                  <td colspan="6" class="tdDia">---<?php echo date('d/M',strtotime($dia)); ?>---</td>
                </tr>
      <?php
              }
              // Verifica se o dia trocou para exibir nova linha com a data
              if($ultimoDia <> $dia){
                $mudouData++;
                $ultimoDia = $dia;
      ?>
                <!-- Exibe a linha com a data -->
                <tr class="trDia">
                  <td colspan="6" class="tdDia">---<?php echo date('d/M',strtotime($dia)); ?>---</td>
                </tr>
      <?php
              }
              //Aplica formatação linha a linha na tabela para melhor visualização
              if($cont % 2 ==0){
                $cssClass = "trA";
              } else{
                $cssClass = "trB";
              }
              $cont++;
      ?>
            <!--Linhas/colunas da tabela-->
            <tr class=<?php echo $cssClass;?>>
              <td class="tdNum"><?php echo $numero; ?></td>
              <td class="tdHora"><?php echo $h; ?></td>
              <td class="tdPessoas"><?php echo $pessoas; ?></td>
              <td><?php echo $solicitante; ?></td>
              <td class="tdEmail"><?php echo $email; ?></td>
              <td class="tdAcoes">
                <center>
                <!--Direciona para a ação de cancelamento do agendamento-->
                <a href="cancelarAgendamentoAction.php?agId=<?php echo $dado['a_id'];?>"
    							onClick="return confirm('Deseja realmente cancelar o agendamento <?php echo $dado['a_agNum'];?>?')">
    								<img src="img/btnCancelar.png" class="btnAcoes"/>
                </a>
                <!--Direciona para a ação de edição do agendamento-->
                <a href="formEditarAgendamento.php?agId=<?php echo $dado['a_id'];?>">
    								<img src="img/btnEdit.png" class="btnAcoes btnEdit"/>
                </a>
              </center>
              </td>
            </tr>

      <?php
          } //Fim do while que itera preenchendo a tabela
      ?>
        </table>
    <?php
      //fim do if($result <> null){ - Se o result estiver vazio entra no else
      } else{ //SE NÃO TIVER NADA NO $result
    ?>
      <div class="tituloPag">
        <p>Próximos Agendamentos:</p>
      </div>
      <p class='msgErro'><img src='img/erro1.png'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Não existem agendamentos futuros!
        <br/><br/>
      </p>
  <?php
      }
  } else{ //SE NÃO ESTIVER LOGADO
  ?>
      <p class='msgErro'><img src='img/erro1.png'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Apenas usuários logados podem acessar
        essa página.<br/><br/>
        <a href="loginAdm.php" target="_self">Clique aqui</a> para fazer seu login.
      </p>
  <?php
    } //Fecha o else que exibe erro de usuário não logado
  ?>
  <!--Fecha a div aberta em includes/areaForm.php -->
  </div>
</body>
</html>
