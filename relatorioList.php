<?php
  include_once 'includes/head.php';

  //INCLUI O CABEÇALHO BÁSICO DO FORMULÁRIO
  include_once 'includes/areaForm.php';

  //******SÓ PODE VER SE ESTIVER LOGADO
  if(isset($_SESSION["usuario"])){
    if($us->getIdUsuario() == 1){ //Liberado apenas para o super usuário
      //Define data atual e data limite para a solicitação
			date_default_timezone_set('America/Sao_Paulo');
			$hoje = date('Y-m-d');
      $mesAtual = date('Y-m');
      //Inclui a saudação/edição de cadastro e área de mensagens
      include_once 'includes/bemVindo.php';
?>
        <div class="tituloPag">
          <p>Relatórios do Sistema</p>
        </div>
        <div id="listaRelatorios">
          <div class="linhaTipoRelatorio">
            <div class="tipoRelatorio">Visitantes por dia:</div>
            <form class="relatoriosForm" action="relVisitantesDia.php" method="post">
              <div class="labelRelatorio"><label for="dia">Data: </label></div>
              <input type="date" name="dia" class="relCampoInput" data-date-format='yyyy-mm-dd'
                value="<?php echo $hoje;?>" title="Selecione a data desejada" required />
              <input type="submit" class="btnConsultar" value="Consultar" title="Consultar relatório"
    						alt="Consultar relatório"/>
            </form>
          </div>
          <div class="linhaTipoRelatorio">
            <div class="tipoRelatorio">Visitantes por mês:</div>
            <form class="relatoriosForm" action="relVisitantesMes.php" method="post">
              <div class="labelRelatorio"><label for="dia">Mês: </label></div>
              <input type="month" name="mes" class="relCampoInput" min="2022-01"
                value="<?php echo $mesAtual;?>" title="Selecione o mês desejado" required>
              <input type="submit" class="btnConsultar" value="Consultar" title="Consultar relatório"
    						alt="Consultar relatório"/>
            </form>
          </div>
          <div class="linhaTipoRelatorio">
            <div class="tipoRelatorio">Intervalo específico:</div>
            <form class="relatoriosForm" action="relVisitantesIntervalo.php" method="post">
              <div class="labelRelatorio"><label for="dia">Intervalo: </label></div>
              <input type="date" name="inicio" class="relCampoInput2" data-date-format='yyyy-mm-dd'
                title="Selecione a data de início" required /> &nbsp; até &nbsp;
              <input type="date" name="fim" class="relCampoInput2" data-date-format='yyyy-mm-dd'
                value="<?php echo $hoje;?>" title="Selecione a data limite" required />
              <input type="submit" class="btnConsultar" value="Consultar" title="Consultar relatório"
    						alt="Consultar relatório"/>
            </form>
          </div>
          <p></p>
          <div id="espacoDiv"></div>
        </div>
<?php
      } else { //Se não é super user
        echo "<p class='msgErro'><img src='img/erro1.png'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Apenas o super usuário pode
          acessar essa página.<br/><br/>
            <div id='botoesForm'>
              <input type='button' value='<< Voltar' id='btnVoltar' onClick=location='index.php' tabindex='1'>
            </div>
          </div>"	;
      }
    } else {
    echo "<p class='msgErro'><img src='img/erro1.png'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Você precisa estar logado para
      acessar essa página.<br/><br/>
        <div id='botoesForm'>
          <input type='button' value='<< Voltar' id='btnVoltar' onClick=location='loginAdm.php' tabindex='1'>
        </div>
      </div>"	;
  }
?>
    </div>
  </body>
</html>
