<?php
  include_once 'includes/head.php';

  include 'classes/Agendamento.php';

  //INCLUI O CABEÇALHO BÁSICO DO FORMULÁRIO
  include_once 'includes/areaForm.php';

  $erroCampo = "ok";
  $ag = new Agendamento();

  //******SÓ PODE VER SE ESTIVER LOGADO
  if(isset($_SESSION["usuario"])){
    if($us->getIdUsuario() == 1){ //Liberado apenas para o super usuário
      if(isset($_POST["inicio"])){
        $dataInicio = $_POST["inicio"];
        if(isset($_POST["fim"])){
          $dataFim = $_POST["fim"];
          $totalPessoas = $ag->retornaTotalPessoasPorIntervalo($dataInicio, $dataFim);
          if($totalPessoas < 1){
            $totalPessoas = 0;
          }
          $listaDeDias = $ag->retornaPessoasPorIntervalo($dataInicio, $dataFim);
          $dataFormatadaInicio = date("d/m/Y", strtotime($dataInicio));
          $dataFormatadaFim = date("d/m/Y", strtotime($dataFim));
?>
      <div class="tituloPag">
        <p>Relatório de visitantes por intervalo</p>
      </div>
<?php if($listaDeDias <> null){ ?>
        <div class="tituloRel">
          <p>Quantidade de visitantes do intervalo <?php echo $dataFormatadaInicio." até ".$dataFormatadaFim.": <strong>".$totalPessoas."</strong>";?></p>
        </div>
        <table id="tbAgendamentos">
          <!--Cabeçalho da tabela-->
          <tr class="trH">
            <th>DATA</th>
            <th>VISITANTES</th>
          </tr>
<?php     //Iterações que organizam os registros do BD em linhas da tabela
          $cont = 0;
          while($dado = $listaDeDias->fetch_array()) {
            $dia = $dado['dia'];
            $dia = date("d/M/Y", strtotime($dia));
            $pessoas = $dado['pes'];

            //If que formata a tabela com a classe CSS variando a cada linha
            if($cont % 2 ==0){
              $cssClass = "trA";
            } else{
              $cssClass = "trB";
            }
            $cont++;
?>
            <!--Linhas/colunas da tabela-->
            <tr class=<?php echo $cssClass;?>>
              <td class="tdData"><center><?php echo $dia; ?></center></td>
              <td class="tdVisitantes"><center><?php echo $pessoas; ?></center></td>
            </tr>
<?php     //Iterações que organizam os registros do BD em linhas da tabela
          }
        }
          echo "</table>";
          echo "<div id='botoesForm'>
              <input type='button' value='<< Voltar' id='btnVoltar' onClick=location='relatorioList.php' tabindex='1'>
            </div>";
        } else { //Se não selecionou data inicial
          echo "<p class='msgErro'><img src='img/erro1.png'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Você deve selecionar a
            data inicial e final para gerar o relatório<br/><br/>
              <div id='botoesForm'>
                <input type='button' value='<< Voltar' id='btnVoltar' onClick=location='index.php' tabindex='1'>
              </div>
            </div>"	;
        }
      } else { //Se não selecionou data inicial
        echo "<p class='msgErro'><img src='img/erro1.png'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Você deve selecionar a
          data inicial e final para gerar o relatório<br/><br/>
            <div id='botoesForm'>
              <input type='button' value='<< Voltar' id='btnVoltar' onClick=location='index.php' tabindex='1'>
            </div>
          </div>"	;
      }
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
