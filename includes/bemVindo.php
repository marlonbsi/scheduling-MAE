<div id="bemVindo">
  <div id="bemVindoMsg">Bem-vindo(a), <a href="formEditarUsuario.php?usId=<?php echo $us->getIdUsuario();?>">
    <?php echo $us->getNomeUsuario();?></a>.
  </div>
  <div id="bemVindoSair"><a href="actionSair.php">Sair</a></div>
</div>
<div id="areaMsgs">
  <!--Exibe mensagem recebida por $_GET-->
  <p><?php echo $msg;?></p>
</div>
