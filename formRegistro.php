<?php
  include_once 'includes/head.php';

  include 'classes/Horarios.php';

  //INCLUI O CABEÇALHO BÁSICO DO FORMULÁRIO
  include_once 'includes/areaForm.php';

  $usId = 0;

  //Só pode ver se estiver logado
  if(isset($_SESSION["usuario"])){
    //Inclui a saudação/edição de cadastro e área de mensagens
    include_once 'includes/bemVindo.php';
    $usId = $us->getIdUsuario();

    if($usId == 1){
  		echo "<p class='msgErro'><img src='img/erro1.png'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Esse usuário não está
  			autorizado a executar essa operação.</p>
  				<div id='botoesForm'>
  					<input type='button' value='<< Voltar' id='btnVoltar' onClick=location='index.php' tabindex='1'>
  				</div>
  			</div>"	;
  	} else {
      //Define data atual e data limite para a solicitação
      $hoje = date('Y-m-d');
      $dataMax = new DateTime();
      $dataMax = new DateTime('+2 month');

      $h = new Horario();
      $h = $h->select();

      //Objeto que vai pegar as vagas disponíveis por horário no dia
      $h1 = new Horario();
      
      //Objeto que vai pegar as vagas disponíveis por horário no dia selecionado anteriormente
      $h1 = new Horario();
      $vgs = $h1->retornaVagas(); //$vgs = Vagas do dia
      $idsArray = array(); //$idsArray = ids dos horários que podem ter buracos por exclusão
      $vagas = array(); // $vagas  = máximo de vagas por horário
      $maxVagas = $h1->retornaMaximoDeVagas(); //busca o maior número de vagas cadastrado no BD para limitar o input

      while($dado = $vgs->fetch_array()) {
        array_push($idsArray, $dado['horarioId']);
        array_push($vagas, $dado['vagasHorario']);
      }

      $tamanhoArray = sizeof($vagas);
      $qtd = 0;

      for($i = 0; $i < $tamanhoArray; $i++){
        $qtd = $vagas[$i] - $h1->retornaReservas($data, $idsArray[$i]);
        $vagas[$i] = $qtd;
      }

      /*Armazena os arrays com vagas disponíveis e ids de horários na Session*/
      $_SESSION["vg"] = $vagas;
      $_SESSION["idsH"] = $idsArray;
    ?>
      <div class="tituloPag">
        <p>Registro de visitantes - MAE</p>
      </div>
        <form action="formSolicitanteAction.php" method="post">
          <div class="campoForm">
            <label for="dia">Data da visita: </label>
              <input type="date" name="dia" id="diaInput" value="<?php echo $hoje;?>"
                class="disabled" readonly/> <br/><br/>
          </div>
          <div class="campoForm">
            <label for="solicitante">Solicitante: </label><br/>
              <input type="text" name="solicitante" maxlength="60" tabindex="1"
                onblur="testaNome(formAgendamento.solicitante);" autofocus required/><br/><br/>
          </div>
          <div class="campoForm">
            <label for="contato">Contato: </label>
              <input type="radio" name="tipoContato" value="email" onclick="displayRadioValue()" checked tabindex="2">Email
              <input type="radio" name="tipoContato" value="tel" onclick="displayRadioValue()" tabindex="3">Telefone<br/>
              <div id="campoContato">
                <input type='text' name='contato' id='campoEmail' maxlength='60' tabindex='4'
                  onblur='testaEmail(formAgendamento.contato);' required>
              </div><br/>
          </div>
          <div class="campoForm">
            <div class="campoForm2">
              <label for="horario">Horário: </label>
                <select name="horario" onblur="testaHorario(formAgendamento.horario);"
                  id="horarioInputReg" tabindex="5" autofocus required>
                  <option value="0">
                    <?php
                      if ($h){
                        echo "--Selecione o horário--";
                      } else{
                        echo "--Não foi possível conectar com o BD--";
                      }
                    ?>
                  </option>
                  <?php
                  //Preenchimento do Select
                    if ($h) {
                      $indice = 0;
                      while ($row = mysqli_fetch_array($h)){
                        if ($vagas[$indice] < 1){
                          //No caso de não haver vagas, desabilita a opção 'DISABLED'
                          echo "<option value=".$row['horarioId']." disabled>"
                            .$row['periodo']." - LOTADO</option>'";
                        } else{
                          //Preenche a option indicando o total de vagas disponíveis
                          echo "<option value=".$row['horarioId'].">"
                            .$row['periodo']." - ".$vagas[$indice]." vagas</option>'";
                        }
                        $indice++;
                      }
                    }
                    ?>
                </select><br/><br/>
            </div>
            <div class="campoForm2">
              <label for="numPessoas">Número de pessoas: </label>
                <input type="number" name="numPessoas" min="1" max="<?php echo $maxVagas;?>" id="numPessoasInputReg"
                  onblur="testaNumPessoas(formAgendamento.numPessoas);" tabindex="6" required/>
                <div class="formObs">
                  (Grupos de no máximo <?php echo $maxVagas;?> pessoas por horário)
                </div><br/><br/>
            </div>
          </div>
            <!--Form envia em campo hidden o estado do pedido e os termos que devem ser apresentador pelo usuário
              que recebe o visitante-->
            <input type="hidden" name="estado" value="agendado"/>
            <input type="hidden" name="termos" value="on"/>

            <div id="botoesForm">
              <input type="submit" value="Registrar" id="btnSolicitar" tabindex="7"/><br/>
              <input type="button" value="<< Voltar" id="btnVoltar" onClick=location='agendamentoList.php' tabindex="8">
            </div>
        </form>
  <?php
    }
  } else{ // Fim se está logado
  ?>
    <p class='msgErro'><img src='img/erro1.png'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Apenas usuários logados podem acessar
      essa página.<br/><br/>
      <a href="loginAdm.php" target="_self">Clique aqui</a> para fazer seu login.
    </p>
  <?php
  }
  ?>
    </div>
  </body>
</html>
