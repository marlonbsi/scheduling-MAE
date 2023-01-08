<?php
  include_once 'includes/head.php';

  $location = "location='usuarioList.php'";

  //INCLUI O CABEÇALHO BÁSICO DO FORMULÁRIO
  include_once 'includes/areaForm.php';

  //******SÓ PODE VER SE ESTIVER LOGADO
  if(isset($_SESSION["usuario"])){
    //Inclui a saudação/edição de cadastro e área de mensagens
    include_once 'includes/bemVindo.php';
    $location = "location='agendamentoList.php'";
    $usAlt = new Usuario();
    $erroCampo = "ok";
    if(isset($_POST["id"])){
      $id = $_POST["id"];
      $usAlt = $usAlt->retornaPorId($id);
      if($usAlt <> null){
        if(($us->getIdUsuario() == 1) || ($us->getIdUsuario() == $usAlt->getIdUsuario())){
          if ($us->getIdUsuario() == 1) {
            $location = "location='agendamentoList.php'";
          }

          if(isset($_POST["ativo"])){
            $ativo = $_POST["ativo"];
            $usAlt->setAtivo($ativo);
          }

          if(isset($_POST["nome"])){
        		$nome = $_POST["nome"];
        		if(!$usAlt->setNomeUsuario($nome)){
        			$erroCampo = "nome";
        		}
        	} else{
        		$erroCampo = "vazio";
        	}

          if(isset($_POST["email"])){
        		$email = $_POST["email"];
        		if(!$usAlt->setEmailUsuario($email)){
        			$erroCampo = "email";
        		}
        	} else{
        		$erroCampo = "vazio";
        	}

          if(isset($_POST["senha"]) && isset($_POST["confSenha"])){
        		$senha = $_POST["senha"];
            $confSenha = $_POST["confSenha"];
            if($senha <> null){
              if($senha == $confSenha){
                if(!$usAlt->setSenhaUsuario($senha)){
            			$erroCampo = "senha";
            		}
              } else {
                $erroCampo = "senhasDiferentes";
              }
            } else {
              $senha = "manter";
            }
        	} else{
            $senha = "manter";
        	}

          if($erroCampo == "ok"){
            if ($senha == "manter"){
              $usAlt->update($us->getIdUsuario());
            } else {
              echo "chegou updateSenha";
              $usAlt->updateSenha($us->getIdUsuario());
            }
          } else { // Fim se erroCampo não estiver OK
            if($erroCampo == "vazio"){
        			echo "<p class='msgErro'><img src='img/erro1.png'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Por favor, preencha
        				todos os campos para continuar.</p>
        					<div id='botoesForm'>
        						<input type='button' value='<< Voltar' id='btnVoltar' onClick=\"$location\" tabindex='1'/>
        					</div>
        				</div>"	;
        		}
        		if($erroCampo == "nome"){
        			echo "<p class='msgErro'><img src='img/erro1.png'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Valor inválido para o
        				campo Nome.</p>
        					<div id='botoesForm'>
        						<input type='button' value='<< Voltar' id='btnVoltar' onClick=\"$location\" tabindex='1'/>
        					</div>
        				</div>"	;
        		}
            if($erroCampo == "email"){
        			echo "<p class='msgErro'><img src='img/erro1.png'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Valor inválido para o
        				campo Email.</p>
        					<div id='botoesForm'>
        						<input type='button' value='<< Voltar' id='btnVoltar' onClick=\"$location\" tabindex='1'/>
        					</div>
        				</div>"	;
        		}
            if($erroCampo == "senha"){
        			echo "<p class='msgErro'><img src='img/erro1.png'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Você deve informar uma
                senha	com pelo menos 8 caracteres contendo pelo menos 1 letra, 1 número e 1 caractere especial
                (ex: !@#$%&?*+-/).</p>
        					<div id='botoesForm'>
        						<input type='button' value='<< Voltar' id='btnVoltar' onClick='window.history.go(-1)' tabindex='1'/>
        					</div>
        				</div>"	;
        		}
            if($erroCampo == "senhasDiferentes"){
        			echo "<p class='msgErro'><img src='img/erro1.png'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;As senhas informadas são
                diferentes. Por favor, repita a operação..</p>
        					<div id='botoesForm'>
        						<input type='button' value='<< Voltar' id='btnVoltar' onClick='window.history.go(-1)' tabindex='1'/>
        					</div>
        				</div>"	;
        		}
          } // Fim do else para erroCampo="ok"
        } else { // Se não é o usuário MAE ou o dono do cadastro
          echo "<p class='msgErro'><img src='img/erro1.png'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Você não tem autorização
            para alterar o cadastro informado.</p>
              <div id='botoesForm'>
                <input type='button' value='<< Voltar' id='btnVoltar' onClick=\"$location\" tabindex='1'/>
              </div>
            </div>"	;
        } // Fim Se não é o usuário MAE ou o dono do cadastro
      } else { // Se não retornou usuário da busca por id
        echo "<p class='msgErro'><img src='img/erro1.png'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;O usuário informado não foi
          encontrado.</p>
            <div id='botoesForm'>
              <input type='button' value='<< Voltar' id='btnVoltar' onClick=\"$location\" tabindex='1'/>
            </div>
          </div>"	;
      } // Fim se não retornou usuário da busca por id
    } else { //Se não foi enviado o id por $_POST
      echo "<p class='msgErro'><img src='img/erro1.png'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Para acessar essa função é
        necessário selecionar um usuário.</p>
          <div id='botoesForm'>
            <input type='button' value='<< Voltar' id='btnVoltar' onClick=\"$location\" tabindex='1'/>
          </div>
        </div>"	;
    } //Fim Se não foi enviado o id por $_POST
  } else { // Fim se não tem usuário logado
    echo "<p class='msgErro'><img src='img/erro1.png'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Você não tem autorização para
      acessar essa função.</p>
        <div id='botoesForm'>
          <input type='button' value='<< Voltar' id='btnVoltar' onClick=\"$location\" tabindex='1'/>
        </div>
      </div>"	;
  }// Fim se tem usuário logado
?>
    </div>
  </body>
</html>
