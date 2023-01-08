<?php
  include_once 'includes/head.php';

  //INCLUI O CABEÇALHO BÁSICO DO FORMULÁRIO
  include_once 'includes/areaForm.php';

  $location = "location='loginAdm.php'";

  //******SÓ PODE VER SE ESTIVER LOGADO
  if(isset($_SESSION["usuario"])){
    if($us->getIdUsuario() == 1){ //Liberado apenas para o super usuário
      $location = "location='horarioList.php'";
      //Inclui a saudação/edição de cadastro e área de mensagens
      include_once 'includes/bemVindo.php';
?>
      <div class="tituloPag">
        <p>Inclusão de Horário</p>
      </div>
      <form action="configHorarioAction.php" name="formHorario" method="post">
        <div class="campoForm">
          <div class="campoForm2">
            <label for="horarioEntrada">Selecione o horário de entrada: </label>
              <select name="horarioEntrada" id="horarioEntrada" tabindex="1" required>
                <option value="07:00">07:00</option>
                <option value="07:30">07:30</option>
                <option value="08:00">08:00</option>
                <option value="08:30">08:30</option>
                <option value="09:00">09:00</option>
                <option value="09:30">09:30</option>
                <option value="10:00">10:00</option>
                <option value="10:30">10:30</option>
                <option value="11:00">11:00</option>
                <option value="11:30">11:30</option>
                <option value="12:00">12:00</option>
                <option value="12:30">12:30</option>
                <option value="13:00">13:00</option>
                <option value="13:30">13:30</option>
                <option value="14:00">14:00</option>
                <option value="14:30">14:30</option>
                <option value="15:00">15:00</option>
                <option value="15:30">15:30</option>
                <option value="16:00">16:00</option>
                <option value="16:30">16:30</option>
                <option value="17:00">17:00</option>
                <option value="17:30">17:30</option>
                <option value="18:00">18:00</option>
                <option value="18:30">18:30</option>
                <option value="19:00">19:00</option>
                <option value="19:30">19:30</option>
              </select><br/>
          </div>
          <div class="campoForm2">
            <label for="horarioDuracao">Selecione a duração: </label>
              <select name="horarioDuracao" id="horarioDuracao" tabindex="2" required>
                <option value="15">15 min</option>
                <option value="30">30 min</option>
                <option value="60" selected="selected">1 hora</option>
                <option value="90">1h 30min</option>
                <option value="120">2 horas</option>
                <option value="150">2h 30min</option>
                <option value="180">3 horas</option>
              </select><br/>
          </div>
        </div>
        <div id="espacoDivForm"></div>
        <div class="campoForm">
          <div class="campoForm2">
            <label for="horarioVagas">Número de vagas: </label><br/>
              <input type="number" name="horarioVagas" id="horarioVagas" min="1" max="100" tabindex="3" value="15" required/><br/><br/>
          </div>
        </div>
        <div id="botoesForm">
          <input type="submit" value="Cadastrar" id="btnSolicitar" tabindex="4"/><br/>
          <input type="button" value="<< Voltar" id="btnVoltar" onClick=<?php echo $location;?> tabindex="5"/>
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
