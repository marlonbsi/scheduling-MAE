<?php
  include_once 'includes/head.php';

  include 'classes/Agendamento.php';

  //INCLUI O CABEÇALHO BÁSICO DO FORMULÁRIO
  include_once 'includes/areaForm.php';

  $ag = new Agendamento();

  if(isset($_GET['agId'])){
    $agId = $_GET['agId'];
    //Pega os dados da session
    //******SÓ PODE VER SE ESTIVER LOGADO
    if(isset($_SESSION["usuario"])){
      //Inclui a saudação/edição de cadastro e área de mensagens
      include_once 'includes/bemVindo.php';
      if($ag->cancelar($agId)){
        header("location:agendamentoList.php?msg=canc&agAlt=$agId");
      } else {
        header("location:agendamentoList.php?msg=erroCanc&agAlt=$agId");
      }
    } else {
      if($ag->cancelar($agId)){
        header("location:index.php?msg=canc&agAlt=$agId");
      } else {
        header("location:index.php?msg=erroCanc&agAlt=$agId");
      }
    }
  } else{
    echo "<p class='msgErro'><img src='img/erro1.png'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Não é possível
      acessar essa função sem indicar um agendamento.</p>
        <div id='botoesForm'>
          <input type='button' value='<< Voltar' id='btnVoltar' onClick=location='index.php' tabindex='1'>
        </div>
      </div>"	;
  }
?>
