<?php
  include_once 'includes/head.php';

  $location = "location='usuarioList.php'";

  //INCLUI O CABEÇALHO BÁSICO DO FORMULÁRIO
  include_once 'includes/areaForm.php';

  //Pega os dados da session
  //******SÓ PODE VER SE ESTIVER LOGADO
  if(isset($_SESSION["usuario"])){
    //Inclui a saudação/edição de cadastro e área de mensagens
    include_once 'includes/bemVindo.php';
    if($us->getIdUsuario() == 1){ //Liberado apenas para o super usuário
      if(isset($_GET['usId'])){
        $id = $_GET['usId'];
        if($id > 1){ //Não pode bloquear o super usuário
          $usAlt = new Usuario();
          $usAlt = $usAlt->retornaPorId($id);
          if($usAlt <> null){
            if($usAlt->getAtivo() > 0){
              $usAlt->setAtivo(0);
            } else {
              $usAlt->setAtivo(1);
            }
            $usAlt->update($us->getIdUsuario());
          } else {
            echo "<p class='msgErro'><img src='img/erro1.png'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;O usuário
              informado não é válido.<br/><br/>
                <div id='botoesForm'>
                  <input type='button' value='<< Voltar' id='btnVoltar' onClick=\"$location\" tabindex='1'>
                </div>
              </div>"	;
          }
        } else{ //Se for o super usuário
          echo "<p class='msgErro'><img src='img/erro1.png'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Não é possível
            ativar/bloquear o usuário MAE.<br/><br/>
              <div id='botoesForm'>
                <input type='button' value='<< Voltar' id='btnVoltar' onClick=\"$location\" tabindex='1'>
              </div>
            </div>"	;
        }
      } else { //Se não informou id
        echo "<p class='msgErro'><img src='img/erro1.png'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;É necessário selecionar
          um usuário para concluir a operação.<br/><br/>
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
