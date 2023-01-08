<?php
  include_once 'includes/head.php';

  include 'classes/Agendamento.php';
  include 'classes/Horarios.php';

  //INCLUI O CABEÇALHO BÁSICO DO FORMULÁRIO
  include_once 'includes/areaForm.php';

  $location = "location='index.php'";

  $erroCampo = "ok";

  //Pega os dados da session
  //******SÓ PODE VER SE ESTIVER LOGADO
  if(isset($_SESSION["usuario"])){
    $location = "location='agendamentoList.php'";
    //Inclui a saudação/edição de cadastro e área de mensagens
    include_once 'includes/bemVindo.php';
  } else {
?>
    <div id="areaMsgs">
      <!--Exibe mensagem recebida por $_GET-->
      <p><?php echo $msg;?></p>
    </div>
<?php
  }
?>
    <div class="tituloPag">
      <p>Editar dados do Agendamento</p>
    </div>
<?php
//Verifica se a data do form anterior foi enviada por POST ou por GET se veio da lista
  if(isset($_GET["agId"]) || isset($_POST["codigo"])){
    $ag = new Agendamento();
    $h = new Horario();
    if(isset($_GET["agId"])){
      $agId = $_GET["agId"];
      if(!$ag->isAgendamento($agId)){
        $erroCampo = "agInvalido";
      }
    }
    if(isset($_POST["codigo"])){
      $agCod = $_POST["codigo"];
      $agId = $ag->retornaIdPorCodigo($agCod);
      if($agId < 1000){
        $erroCampo = "agInvalido";
      } else {
        $ag = $ag->retornaAgendamentoPorId($agId);
        date_default_timezone_set('America/Sao_Paulo');
        $hoje = strtotime(date("Y-m-d"));
        if (strtotime($ag->getDia()) < $hoje){
          $erroCampo = "agAnterior";
        }
      }
    }
    if($erroCampo == "ok"){
      $ag = $ag->retornaAgendamentoPorId($agId);

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
        $qtd = $vagas[$i] - $h1->retornaReservas($ag->getDia(), $idsArray[$i]);
        $vagas[$i] = $qtd;
      }

      /*Armazena os arrays com vagas disponíveis e ids de horários na Session*/
      $_SESSION["vg"] = $vagas;
      $_SESSION["idsH"] = $idsArray;

      $h = $h->retornaHorarioString($ag->getHorario());
      $isEmail = true;
      if(preg_match('/[0-9]/', $ag->getEmailContato())){
        $isEmail = false;
      }
  ?>
      <form action="formEditarAction.php" method="post">
        <div class="campoForm">
          <div class="campoForm2">
            <label for="dia">Data da visita:</label><br/>
              <input type="text" name="dia" id="diaInput2" data-date-format='yyyy-mm-dd'
                value="<?php echo $ag->getDia();?>"	class="disabled" readonly>
                <br/><br/>
          </div>
          <div class="campoForm2">
            <label for="horario">Horário: </label><br/>
              <input type="text" name="horarioDisabled" id="horarioInput2" value="<?php echo $h;?>"	class="disabled" readonly>
                <br/><br/>
          </div>
        </div>
        <div class="campoForm">
          <label for="solicitante">Solicitante: </label><br/>
            <input type="text" name="solicitante" value="<?php echo $ag->getSolicitante(); ?>"
              class="disabled" readonly /><br/><br/>
        </div>
        <div class="campoForm">
          <label for="contato">Contato: </label>
      <?php       if($isEmail){ ?>
              <input type="radio" name="tipoContato"  value="email" onclick="displayRadioValue()" checked tabindex="1">Email
              <input type="radio" name="tipoContato" value="tel" onclick="displayRadioValue()" tabindex="2">Telefone<br/>
      <?php       } else { ?>
              <input type="radio" name="tipoContato"  value="email" onclick="displayRadioValue()" tabindex="1">Email
              <input type="radio" name="tipoContato" value="tel" onclick="displayRadioValue()" checked tabindex="2">Telefone<br/>
      <?php       } ?>
            <div id="campoContato">
              <input type='text' name='contato' id='campoEmail' maxlength='60' tabindex='3' autofocus
                value="<?php echo $ag->getEmailContato();?>" onblur='testaEmail(formAgendamento.contato);' required>
            </div><br/>
        </div>
        <div class="campoForm">
          <div class="campoForm2">
            <div class="campoNum">
              <label for="numPessoas">Número de pessoas: </label><br/>
                <input type="number" name="numPessoas" min="1" max="<?php echo $maxVagas;?>" value="<?php echo $ag->getNumPessoas();?>"
                  onblur="testaNumPessoas(formAgendamento.numPessoas);" tabindex="4" required/><br/>
                  <div class="formObs">
                    (Grupos de no máximo <?php echo $maxVagas;?> pessoas por horário)
                  </div><br/>
            </div>
          </div>
          <div class="campoForm2">
            <div class="campoTermos">
              <input type="checkbox" name="termos" id="inputTermos" checked tabindex="5" required/><label for="termos">
                Concordo com as regras abaixo</label><br/>
            </div>
          </div>
        </div>
        <div class="campoForm">
          <div class="campoTermos">
            <div id="txtTermos">
              <h3>Regras de Acesso ao Museu - Prevenção à Covid-19:</h3>
              <p>Medidas preventivas:	</p>
              <ul>
                <li>Será aferida a temperatura dos visitantes com termômetros infravermelhos, sem
                  contato. Pessoas com febre não poderão entrar no museu.</li>
                <li>É obrigatório o uso de máscara por todas as pessoas maiores de 3 anos durante
                  toda a visita, inclusive nos espaços abertos. O próprio visitante deve levar sua
                  máscara, que deve estar bem ajustada ao rosto.</li>
                <li>Álcool gel está disponibilizado nos espaços do museu. Nos banheiros há água e
                  sabonete para que os visitantes higienizem as mãos sempre que precisar.</li>
                <li>Não é permitido o consumo de alimentos e bebidas dentro dos espaços expositivos.
                  O consumo de água é permitido apenas nos espaços abertos, como o claustro.</li>
                <li>Caso tenha tido contato com alguém com Covid ou apresente sintomas como tosse,
                  coriza, cansaço, febre, dor de garganta, perda de olfato ou paladar ou diarreia,
                  não venha ao museu.</li>
                <li>Toda a equipe do museu passa por aferição de temperatura e por controle diário e
                  acompanhamento de sintomas de Covid.</li>
              </ul>
            </div><br/><br/>
          </div>
        </div>

        <input type="hidden" name="horario" value="<?php echo $ag->getHorario();?>"/>
        <input type="hidden" name="numPessoasPrev" value="<?php echo $ag->getNumPessoas();?>"/>
        <input type="hidden" name="agId" value="<?php echo $ag->getIdAgendamento();?>"/>

        <div id="botoesForm">
          <input type="submit" value="Alterar" id="btnAlterar" tabindex="6"/><br/>
          <input type="button" value="Cancelar Agendamento" id="btnCancelar"
            onclick="location.href='cancelarAgendamentoAction.php?agId=<?php echo $ag->getIdAgendamento();?>';" tabindex="7"/>
          <br/>
          <input type="button" value="<< Voltar" id="btnVoltar" onClick=<?php echo $location;?> tabindex="8">
        </div>
      </form>
<?php
    } else {
      if($erroCampo == "agInvalido"){
        echo "<p class='msgErro'><img src='img/erro1.png'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;O código informado não
          corresponde a um agendamento válido.</p>
            <div id='botoesForm'>
              <input type='button' value='<< Voltar' id='btnVoltar' onClick=location='index.php' tabindex='1'>
            </div>
          </div>"	;
      }
      if($erroCampo == "agAnterior"){
        echo "<p class='msgErro'><img src='img/erro1.png'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Não é possível alterar
          um agendamento anterior <strong>$agCod</strong>.</p>
            <div id='botoesForm'>
              <input type='button' value='<< Voltar' id='btnVoltar' onClick='window.history.go(-1)' tabindex='1'>
            </div>
          </div>"	;
      }
    }
  } else {
    echo "<p class='msgErro'><img src='img/erro1.png'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Não é possível
      acessar essa função sem indicar um agendamento.</p>
        <div id='botoesForm'>
          <input type='button' value='<< Voltar' id='btnVoltar' onClick=location='index.php' tabindex='1'>
        </div>
      </div>"	;
  }
?>
    </div>
  </body>
</html>
