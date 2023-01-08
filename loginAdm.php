<?php
  include_once 'includes/head.php';

  include 'classes/Agendamento.php';

  //******SÓ PODE VER SE ESTIVER LOGADO
  if(isset($_SESSION["usuario"])){
    header("location:javascript://history.go(-1)");
  } else {
    //INCLUI O CABEÇALHO BÁSICO DO FORMULÁRIO
    include_once 'includes/areaForm.php';
?>

      <div class="tituloPag">
        <p>Faça seu login no sistema de agendamento:</p>
      </div>
      <form action="actionLogin.php" method="post" name="formLogin">
        <div class="campoForm">
          <label for="email">Email:</label><br/>
            <input type="text" id="campoEmail" name="email" tabindex="1" required/><br/><br/>
          <label for="senha">Senha:</label><br/>
            <input type="password" id="campoSenha" name="senha" tabindex="2" required/><br/><br/>

          <div id="botoesForm">
            <input type="submit" name="entrar" value="Fazer Login" id="btnEntrar" tabindex="3"/><br/>
            <input type="button" value="<< Voltar" id="btnVoltar" onClick="location='index.php'" tabindex="4">
          </div>
    		</form>
      </div>
  	</body>
  </html>
<?php
  }
?>
