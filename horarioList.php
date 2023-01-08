<?php
  include_once 'includes/head.php';

  include 'classes/Horarios.php';

  //INCLUI O CABEÇALHO BÁSICO DO FORMULÁRIO
  include_once 'includes/areaForm.php';

  //******SÓ PODE VER SE ESTIVER LOGADO
  if(isset($_SESSION["usuario"])){
    if($us->getIdUsuario() == 1){ //Liberado apenas para o super usuário

      //Verifica se tem mensagens para exibir
      if(isset($_GET["msg"])){
        $h = new Horario();
        //Mensagem de atualização efetuada
        if($_GET["msg"] == "upd"){
          if(isset($_GET["hAlt"])){
            $idHAlt = $_GET["hAlt"];
            $periodo = $h->retornaHorarioString($idHAlt);
            $msg = "<p class='msgSucesso'><img src='img/sucesso2.png'>&nbsp;&nbsp;&nbsp;Horário
              atualizado com sucesso <strong>$periodo</strong>.&nbsp;&nbsp;&nbsp;
              <a href='horarioList.php' target='_self'><strong>X</strong></a></p>";
          }
        }
        //Mensagem de atualização não efetuada
        if($_GET["msg"] == "erroUpd"){
          if(isset($_GET["hAlt"])){
            $idHAlt = $_GET["hAlt"];
            $periodo = $h->retornaHorarioString($idHAlt);
            $msg = "<p class='msgErro'><img src='img/erro1.png'>&nbsp;&nbsp;&nbsp;Não foi possível
            atualizar o horário <strong>$periodo</strong>. Por favor, entre em contato com o suporte.
            &nbsp;&nbsp;&nbsp;<a href='horarioList.php' target='_self'><strong>X</strong></a></p>";
          }
        }
      }

      //Inclui a saudação/edição de cadastro e área de mensagens
      include_once 'includes/bemVindo.php';
      //Cria o objeto Usuário
      $hLista = new Horario();
      // Busca de registros no BD
      $result = $hLista->listAll();
?>
        <div class="tituloPag">
          <div id="tituloH">
            <p>Horários de visitação</p>
          </div>
          <div id="linkNovoH">
            <a href="formConfigHorario.php"><img src="img/clockAdd.png" alt="Novo Horário"
              title="Novo Horário">
              <figcaption>Novo</figcaption>
            </a>
          </div>
        </div>
<?php if($result <> null){ ?>
        <table id="tbAgendamentos">
          <!--Cabeçalho da tabela-->
          <tr class="trH">
            <th>ENTRADA</th>
            <th>PERÍODO</th>
            <th>VAGAS</th>
            <th>AÇÕES</th>
          </tr>
<?php
        //Iterações que organizam os registros do BD em linhas da tabela
        $cont = 0;
        while($dado = $result->fetch_array()) {
          $entrada = $dado['h_ent'];
          $periodo = $dado['h_per'];
          $vagas = $dado['h_vagas'];
          $ativo = $dado['h_ativo'];

          //if que formata a saída do valor "ativo" do horário
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
            <td class="tdEntrada"><?php echo $entrada; ?></td>
            <td class="tdPeriodo"><?php echo $periodo; ?></td>
            <td class="tdVagas"><?php echo $vagas; ?></td>
            <td class="tdAcoesH">
              <center>
                <?php if($ativo == "SIM"){ ?>
                  <!--Direciona para a ação de desativação do horário-->
                  <a href="ativarHorarioAction.php?hId=<?php echo $dado['h_id'];?>"
                    onClick="return confirm('Deseja realmente desativar o horário <?php echo $dado['h_per'];?>?')">
                      <img src="img/on1.png" class="btnAcoes" id="btnOff" alt="Desativar Horário" title="Desativar Horário"/>
                  </a>
                <?php } else { ?>
                  <!--Direciona para a ação de ativação do horário-->
                  <a href="ativarHorarioAction.php?hId=<?php echo $dado['h_id'];?>"
                    onClick="return confirm('Deseja realmente ativar o horário <?php echo $dado['h_per'];?>?')">
                      <img src="img/off1.png" class="btnAcoes" id="btnOn" alt="Desativar Horário" title="Desativar Horário"/>
                  </a>
                <?php } ?>
                <!--Direciona para a ação de exclusão do horário-->
                <a href="excluirHorarioAction.php?hId=<?php echo $dado['h_id'];?>"
                  onClick="return confirm('Deseja realmente excluir o horário <?php echo $dado['h_per'];?>?')">
                    <img src="img/btnCancelar.png" class="btnAcoes btnExcluirH" alt="Excluir Horário" title="Excluir Horário"/>
                </a>
                <!--Direciona para a ação de edição do horário-->
                <a href="formEditarHorario.php?hId=<?php echo $dado['h_id'];?>">
    								<img src="img/btnEdit.png" class="btnAcoes btnEdit" alt="Editar Horário" title="Editar Horário"/>
                </a>
              </center>
            </td>
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
