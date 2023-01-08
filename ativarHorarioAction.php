<?php
  include_once 'includes/head.php';

  include 'classes/Horarios.php';

  $location = "location='horarioList.php'";

  //INCLUI O CABEÇALHO BÁSICO DO FORMULÁRIO
  include_once 'includes/areaForm.php';

  //Pega os dados da session
  //******SÓ PODE VER SE ESTIVER LOGADO
  if(isset($_SESSION["usuario"])){
    //Inclui a saudação/edição de cadastro e área de mensagens
    include_once 'includes/bemVindo.php';
    if($us->getIdUsuario() == 1){ //Liberado apenas para o super usuário
      if(isset($_GET['hId'])){
        $id = $_GET['hId'];
        $hAlt = new Horario();
        $hAlt = $hAlt->retornaPorId($id);
        echo $hAlt->toString();
        if($hAlt <> null){
          if($hAlt->getAtivo() > 0){
            $hAlt->setAtivo(0);
          } else {
            $hAlt->setAtivo(1);
          }
          $hAlt->update();
        } else {
          echo "<p class='msgErro'><img src='img/erro1.png'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;O horário
            informado não é válido.<br/><br/>
              <div id='botoesForm'>
                <input type='button' value='<< Voltar' id='btnVoltar' onClick=\"$location\" tabindex='1'>
              </div>
            </div>"	;

        }
      } else { //Se não informou id
        echo "<p class='msgErro'><img src='img/erro1.png'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;É necessário selecionar
          um horário para concluir a operação.<br/><br/>
            <div id='botoesForm'>
              <input type='button' value='<< Voltar' id='btnVoltar' onClick=\"$location\" tabindex='1'>
            </div>
          </div>"	;
      }
    }else { //Se não é super user
      echo "<p class='msgErro'><img src='img/erro1.png'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Apenas o super usuário pode
        acessar essa página.<br/><br/>
          <div id='botoesForm'>
            <input type='button' value='<< Voltar' id='btnVoltar' onClick=\"$location\" tabindex='1'>
          </div>
        </div>"	;
    }
  }else { //Se não estiver logado
  echo "<p class='msgErro'><img src='img/erro1.png'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Você precisa estar logado para
    acessar essa página.<br/><br/>
      <div id='botoesForm'>
        <input type='button' value='<< Voltar' id='btnVoltar' onClick=\"$location\" tabindex='1'>
      </div>
    </div>"	;
}
?>
    </div>
  </body>
</html>
