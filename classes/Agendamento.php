<?php
	require_once('Connection.php');

	class Agendamento{

		//****Atributos:****

		private $idAgendamento;
		private $numPessoas;
		private $agNum;
		private $dia;
		private $horario;
		private $estadoAgendamento;
		private $termos;
		private $solicitante;
		private $emailContato;
		private $operador;

		public $connection;

		//****Constructor****
		public function __construct() {
			$this->connection = new Connection();
		}

		//****Getters e Setters:****

		public function setIdAgendamento($id){
			$this->idAgendamento = $id;
		}
		public function getIdAgendamento(){
			return $this->idAgendamento;
		}

		// Valida a disponibilidade antes de atribuir o valor
		public function setNumPessoas($num, $disponiveis){
			if($num <= $disponiveis){
				$this->numPessoas = $num;
				return true;
			}else{
				return false;
			}
		}
		//Acrescentada para setar com dados do BD
		private function setNumPessoasBD($num){
			$this->numPessoas = $num;
		}
		public function getNumPessoas(){
			return $this->numPessoas;
		}

		//Gera automaticamente o número com base nas regras definidas na função e no último
		//registro de agendamento no BD.
		public function setAgNum(){
			$query = "SELECT MAX(agendamentoId)
			FROM ag_agendamento;";
			$letras = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N',
				'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z' );
			$la = $letras[rand(0, 25)];
			$lb = $letras[rand(0, 25)];
			$result = mysqli_query($this->connection->conn, $query);
			$row = mysqli_fetch_array($result);
			$maxId = $row[0] + 1;
			if ($maxId < 1000){
				$maxId = 1000;
			}
			$this->agNum = "$la".$maxId."$lb";
		}
		//Acrescentada para setar com dados do BD
		private function setAgNumBD($agNum){
			$this->agNum = $agNum;
		}
		public function getAgNum(){
			return $this->agNum;
		}

		public function setDia($d){
			date_default_timezone_set('America/Sao_Paulo');
			$hoje = strtotime(date("Y-m-d"));
			$dataMax = strtotime('+3 month');
			if ((strtotime($d) >= $hoje) && (strtotime($d) <= $dataMax)){
				$this->dia = $d;
				return true;
			} else {
				return false;
			}
		}
		public function getDia(){
			return $this->dia;
		}

		public function setHorario($h){
			$this->horario = $h;
		}
		public function getHorario(){
			return $this->horario;
		}

		public function setEstadoAgendamento($estado){
			$this->estadoAgendamento = $estado;
		}
		public function getEstadoAgendamento(){
			return $this->estadoAgendamento;
		}

		public function setTermos($termos){
			$this->termos = $termos;
		}
		public function getTermos(){
			return $this->termos;
		}

		public function setSolicitante($sol){
			if(!empty($sol)){
				if(strlen($sol) > 4 && strlen($sol) < 60){
					$regex = "/^[A-Za-z éúíóáÉÚÍÓÁèùìòàçÇÈÙÌÒÀõãñÕÃÑêûîôâÊÛÎÔÂëÿüïöäËYÜÏÖÄ]+$/";
    			if(preg_match($regex, $sol)){
						//Prepara o valor em letras maiúsculas para gravar no BD
						$sol = mb_strtoupper($sol, 'UTF-8');
						$this->solicitante = trim($sol);
						return true;
					} else {
						return false;
					}
				} else{
					return false;
				}
			} else{
				return false;
			}
		}
		public function getSolicitante(){
			return $this->solicitante;
		}

		public function setEmailContato($email){
			if(!empty($email)){
				if(strlen($email) > 8 && strlen($email) < 80){
					if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
						//Prepara o valor em letras minúsculas para gravar no BD
						$email = strtolower($email);
						$this->emailContato = trim($email);
						return true;
					} else{
						return false;
					}
				}else{
					return false;
				}
			}else{
				return false;
			}
		}
		public function setTelefoneContato($tel){
			if(!empty($tel)){
				if(strlen($tel) > 12 && strlen($tel) < 16){
					$regex = "/^(\([0-9]{2}\) ([0-9]{9}|[0-9]{8}))$/";
					if(preg_match($regex, $tel)){
						$this->emailContato = $tel;
						return true;
					} else{
						return false;
					}
				} else{
					return false;
				}
			} else{
				return false;
			}
		}
		public function getEmailContato(){
			return $this->emailContato;
		}

		public function setOperador($op){
			$this->operador = $op;
		}
		public function getOperador(){
			return $this->operador;
		}

		//****Outros Métodos:****

		public function toString(){
			echo
			"<p>Solicitante: ".$this->getSolicitante().
			"<br/>Número: ".$this->getAgNum().
			"<br/>Pessoas: ".$this->getNumPessoas().
			"<br/>Data: ".$this->getDia().
			"<br/>Horário: ".$this->getHorario().
			"<br/>Estado: ".$this->getEstadoAgendamento().
			"<br/>Termos: ".$this->getTermos().
			"<br/>Operador: ".$this->getOperador().
			"<br/>Email: ".$this->getEmailContato()."</p>";
		}

		//Insere um registro de agendamento no BD
		public function insert(){
			if($this->connection){
				$query ="INSERT INTO ag_agendamento VALUES (0, '$this->agNum', $this->numPessoas, '$this->dia', $this->horario,
					'$this->estadoAgendamento', '$this->termos', '$this->solicitante', '$this->emailContato', $this->operador )";
				mysqli_query($this->connection->conn, $query);
				echo "<p class='msgSucesso'><img src='img/sucesso2.png'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Novo registro
					cadastrado, código: <strong>$this->agNum</strong><br/><br/>Anote esse código para poder acompanhar/cancelar
					seu agendamento.</p>";
				$this->connection->closeConn($this->connection);
			} else{
				echo "<p>Erro de conexão com o banco de dados ao inserir agendamento</p>";
			}
		}

		public function update(){
			$query ="UPDATE ag_agendamento
				SET emailContato = '$this->emailContato', numPessoas = $this->numPessoas, operador = $this->operador
				WHERE agendamentoId = '$this->idAgendamento';";
			//Se o comando foi executado com sucesso no BD:
			if(mysqli_query($this->connection->conn, $query)){
				//Direciona para a lista com parâmetros da msg de atualização se for adm:
				if($this->operador > 1){ //Significa que é adm e não é SU (1)
					header("Location: agendamentoList.php?msg=upd&agAlt=$this->idAgendamento");
					//Direciona para index com parâmetros da msg de atualização se for adm:
				} else {
					header("Location: index.php?msg=upd&agAlt=$this->idAgendamento");
				}
			//Se o comando falhou no BD, direciona para a lista com parâmetros da msg de erro
			} else {
				if($this->operador > 1){ //Significa que é adm
					header("Location: agendamentoList.php?msg=erroUpd&agAlt=$this->idAgendamento");
				} else {
					header("Location: index.php?msg=erroUpd&agAlt=$this->idAgendamento");
				}
			}
			$this->connection->closeConn($this->connection);
		}

		//Busca os registros futuros com estado "agendado" para exibir na lista
		public function listAll(){
			//Define data atual para buscar registros que ainda não foram concluídos
			$hoje = date('Y-m-d');
			$query = "SELECT a.agendamentoId as a_id, a.agendamentoNum as a_agNum, a.numPessoas as a_num,
				a.dia as a_dia, a.horario as a_h, a.estado as a_est,	a.solicitante as a_sol,
				a.emailContato as a_email, a.operador as a_op,	h.horarioId as h_id, h.entrada as h_ent,
				op.operadorId as op_id, op.nomeOperador as op_nome
			FROM ag_agendamento as a
				inner join ag_horarios as h on a.horario = h.horarioId
				inner join ag_operador as op on a.operador = op.operadorId
			WHERE a.estado = 'agendado' and a.dia >= '$hoje'
			ORDER BY a_dia, h_id, a_id";
			$result = mysqli_query($this->connection->conn, $query);
			if (($result <> null) && ($result->num_rows <= 0)) {
				$result = null;
			}
			return $result;
			$this->connection->closeConn($this->connection);
		}

		//Cancela um agendamento constante na lista de agendados
		public function cancelar($id){
			$query ="UPDATE ag_agendamento
				SET estado = 'cancelado'
				WHERE agendamentoId = '$id';";
			if(mysqli_query($this->connection->conn, $query)){
				return true;
			}else{
				return false;
			}
			$this->connection->closeConn($this->connection);
		}

		//Retorna o agendamento pelo id informado
		public function retornaAgendamentoPorId($id){
			$ag = new Agendamento();
			$query = "SELECT *
								FROM ag_agendamento
								WHERE agendamentoId = $id;";
			$result = mysqli_query($this->connection->conn, $query);
			$row = mysqli_fetch_array($result);

			$ag->setIdAgendamento($row['agendamentoId']);
			$ag->setNumPessoasBD($row['numPessoas']);
			$ag->setAgNumBD($row['agendamentoNum']);
			$ag->setDia($row['dia']);
			$ag->setHorario($row['horario']);
			$ag->setEstadoAgendamento($row['estado']);
			$ag->setTermos($row['termos']);
			$ag->setSolicitante($row['solicitante']);

			$contato = $row['emailContato'];
			//Verifica se o contato foi criado com telefone ou com email para passar pelos sets sem problemas
			//Retorna true se a string possuir um número, ou seja, é um telefone
			if(preg_match('/[0-9]/', $contato)){
				$ag->setTelefoneContato($contato);
			} else{
				$ag->setEmailContato($contato);
			}
			$ag->setOperador($row['operador']);

			if (($result <> null) && ($result->num_rows > 0)) {
				//Retorna um objeto do tipo Agendamento com seus dados
				return $ag;
			}
			$this->connection->closeConn($this->connection);
		}

		//Retorna o id do agendamento pelo código informado
		public function retornaIdPorCodigo($cod){
			$query = "SELECT agendamentoId
								FROM ag_agendamento
								WHERE agendamentoNum = '$cod';";
			$result = mysqli_query($this->connection->conn, $query);
			$row = mysqli_fetch_array($result);
			$result = $row['agendamentoId'];
			// echo "Pegou: $query, $result<br/>";
			if (($result <> null) && ($result->num_rows >= 0)) {
				//Retorna o id encontrado
				return $result;
			} else{
				// $result = -1;
				return -1;
			}
			$this->connection->closeConn($this->connection);
		}

		//Verifica se corresponde a um agendamento existente
		public function isAgendamento($id){
			$query = "SELECT agendamentoId
								FROM ag_agendamento
								WHERE agendamentoId = $id;";
			$result = mysqli_query($this->connection->conn, $query);

			if (($result <> null) && ($result->num_rows > 0)) {
				return true;
			} else{
				return false;
			}
		}

		//Calcula quantidade de pessoas por dia com base na data
		public function retornaTotalPessoasDia($dia){
			$query = "SELECT sum(ag_agendamento.numPessoas) as totalDia
								FROM ag_agendamento
								WHERE ag_agendamento.dia = '$dia' AND ag_agendamento.estado = 'agendado';";
			$result = mysqli_query($this->connection->conn, $query);
			$row = mysqli_fetch_array($result);
			$result = $row['totalDia'];
			return $result;
		}

		//Retorna o total de pessoas em lista de horário no dia
		public function retornaPessoasPorHorario($dia){
			$query = "SELECT a.horario AS h_id, h.periodo AS h_per, SUM(a.numPessoas) AS pes
								FROM ag_agendamento AS a
								INNER JOIN ag_horarios AS h ON a.horario = h.horarioId
								WHERE a.dia = '$dia' AND a.estado = 'agendado'
								GROUP BY a.horario;";
			$result = mysqli_query($this->connection->conn, $query);
			if (($result <> null) && ($result->num_rows <= 0)) {
				$result = null;
			}
			return $result;
			$this->connection->closeConn($this->connection);
		}

		//Calcula quantidade de pessoas por dia com base na data
		public function retornaTotalPessoasMes($mesAno){
			$mes = substr("$mesAno", -2);
			$ano = substr("$mesAno", 0, -3);
			$query = "SELECT sum(a.numPessoas) as totalMes
								FROM ag_agendamento as a
								WHERE MONTH(a.dia) = '$mes' AND YEAR(a.dia) = '$ano' AND a.estado = 'agendado';";
			$result = mysqli_query($this->connection->conn, $query);
			$row = mysqli_fetch_array($result);
			$result = $row['totalMes'];
			return $result;
		}

		//Retorna o total de pessoas em lista de dias no mes
		public function retornaPessoasPorDia($mesAno){
			$mes = substr("$mesAno", -2);
			$ano = substr("$mesAno", 0, -3);
			$query = "SELECT a.dia AS dia, SUM(a.numPessoas) AS pes
								FROM ag_agendamento AS a
								WHERE MONTH(dia)='$mes' AND YEAR(dia)='$ano' AND a.estado='agendado'
								GROUP BY dia;";
			$result = mysqli_query($this->connection->conn, $query);
			if (($result <> null) && ($result->num_rows <= 0)) {
				$result = null;
			}
			return $result;
			$this->connection->closeConn($this->connection);
		}

		//Calcula quantidade de pessoas por dia com base na data
		public function retornaTotalPessoasPorIntervalo($inicio, $fim){
			$query = "SELECT sum(a.numPessoas) as totalIntervalo
								FROM ag_agendamento as a
								WHERE dia < '$fim' AND dia > '$inicio' AND a.estado='agendado';";
			$result = mysqli_query($this->connection->conn, $query);
			$row = mysqli_fetch_array($result);
			$result = $row['totalIntervalo'];
			return $result;
		}

		//Retorna o total de pessoas em lista por intervalo
		public function retornaPessoasPorIntervalo($inicio, $fim){
			$query = "SELECT a.dia AS dia, SUM(a.numPessoas) AS pes
				FROM ag_agendamento AS a
				WHERE dia < '$fim' AND dia > '$inicio' AND a.estado='agendado'
				GROUP BY dia;";
			$result = mysqli_query($this->connection->conn, $query);
			if (($result <> null) && ($result->num_rows <= 0)) {
				$result = null;
			}
			return $result;
			$this->connection->closeConn($this->connection);
		}
	}
?>
