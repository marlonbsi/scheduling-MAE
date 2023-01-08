<?php
  include_once 'includes/head.php';

  //INCLUI O CABEÇALHO BÁSICO DO FORMULÁRIO
  include_once 'includes/areaForm.php';

  $location = "location='loginAdm.php'";

  //******SÓ PODE VER SE ESTIVER LOGADO
  if(isset($_SESSION["usuario"])){
    //Inclui a saudação/edição de cadastro e área de mensagens
    include_once 'includes/bemVindo.php';

    if($us->getIdUsuario() == 1){ //Liberado apenas para o super usuário
      $location = "location='usuarioList.php'";

      //Cria o objeto Usuário
      $usCad = new Usuario();
      //Inicia sempre inativado e não-excluído
      $usCad->setAtivo(0);
      $usCad->setExcluido(0);

      $erroCampo = "ok";

      if(isset($_POST["nome"])){
    		$nome = $_POST["nome"];
    		if(!$usCad->setNomeUsuario($nome)){
    			$erroCampo = "nome";
    		}
    	} else{
    		$erroCampo = "vazio";
    	}

    	if(isset($_POST["email"])){
    		$email = $_POST["email"];
        if(!$usCad->setEmailUsuario($email)){
    			$erroCampo = "email";
    		}
    	} else{
    		$erroCampo = "vazio";
    	}

      if(isset($_POST["senha"]) && isset($_POST["confSenha"])){
    		$senha = $_POST["senha"];
        $confSenha = $_POST["confSenha"];

        if($senha == $confSenha){
          if(!$usCad->setSenhaUsuario($senha)){
      			$erroCampo = "senha";
      		}
        } else {
          $erroCampo = "senhasDiferentes";
        }
    	} else{
    		$erroCampo = "vazio";
    	}

      $location = "location='usuarioList.php'";

      if($erroCampo == "ok"){
        $usCad->insert();
      } else{
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

    } else { //Se não é super user
        echo "<p class='msgErro'><img src='img/erro1.png'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Apenas o super usuário pode
          acessar essa página.<br/><br/>
            <div id='botoesForm'>
              <input type='button' value='<< Voltar' id='btnVoltar' onClick=location='index.php' tabindex='1'/>
            </div>
          </div>"	;
    }
  } else { // Fim se não tem usuário logado
    echo "<p class='msgErro'><img src='img/erro1.png'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Você precisa estar logado para
      acessar essa página.<br/><br/>
        <div id='botoesForm'>
          <input type='button' value='<< Voltar' id='btnVoltar' onClick=location='loginAdm.php' tabindex='1'/>
        </div>
      </div>"	;
  }
?>
    </div>
  </body>
</html>
