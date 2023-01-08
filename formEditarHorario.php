<?php
  include_once 'includes/head.php';

  include 'classes/Horarios.php';

  //INCLUI O CABEÇALHO BÁSICO DO FORMULÁRIO
  include_once 'includes/areaForm.php';

  $location = "location='agendamentoList.php'";

  //******SÓ PODE VER SE ESTIVER LOGADO
  if(isset($_SESSION["usuario"])){
    //Inclui a saudação/edição de cadastro e área de mensagens
    include_once 'includes/bemVindo.php';
    //Verifica se a data do form anterior foi enviada por POST ou por GET se veio da lista
    if(isset($_GET["hId"])){
      $id = $_GET["hId"];
      $hAlt = new Horario();
      $hAlt = $hAlt->retornaPorId($id);
      if($hAlt <> null){
        //Liberado apenas para o super usuário ou para o próprio do cadastro
        if($us->getIdUsuario() == 1){
            $location = "location='horarioList.php'";
            $duracaoString = $hAlt->retornaDuracaoString($id);
?>
          <div class="tituloPag">
            <p>Editar dados do Horário</p>
          </div>
          <form action="editarHorarioAction.php" name="formHorario" method="post">
            <div class="campoForm">
              <div class="campoForm2">
                <label for="horarioEntrada">Selecione o horário de entrada: </label>
                  <select name="horarioEntrada" id="horarioEntrada" tabindex="1" required>
                    <option value="<?php echo $hAlt->getEntrada(); ?>"><?php echo $hAlt->getEntrada(); ?></option>
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
                    <option value="<?php echo $hAlt->getDuracao(); ?>" selected="selected"><?php echo $duracaoString; ?></option>
                    <option value="15">15 min</option>
                    <option value="30">30 min</option>
                    <option value="60">1 hora</option>
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
                  <input type="number" name="horarioVagas" id="horarioVagas" min="1" max="100" tabindex="3"
                    value="<?php echo $hAlt->getVagasHorario(); ?>" required/><br/><br/>
              </div>
            </div>
            <input type="hidden" name="id" value="<?php echo $hAlt->getIdHorario();?>"/>
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
        echo "<p class='msgErro'><img src='img/erro1.png'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;O horário informado não foi
          encontrado.</p>
            <div id='botoesForm'>
              <input type='button' value='<< Voltar' id='btnVoltar' onClick=\"$location\" tabindex='1'/>
            </div>
          </div>"	;
      }// Fim se retornou um usuário válido pela busca por id
    } else {
      echo "<p class='msgErro'><img src='img/erro1.png'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Para acessar essa função é
        necessário selecionar um horário.</p>
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
