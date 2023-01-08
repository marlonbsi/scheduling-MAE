<?php
	require_once('Connection.php');

	class Horario{

		//****Atributos:****
		private $idHorario;
		private $entrada;
		private $duracao;
		private $periodo;
		private $vagasHorario;
		private $ativo;
		private $excluido;

		public $connection;

		//****Constructor****
		public function __construct() {
			$this->connection = new Connection();
		}

		//****Getters e Setters:****
		public function setIdHorario($id){
			$this->idHorario = $id;
		}
		public function getIdHorario(){
			return $this->idHorario;
		}

		public function setEntrada($entrada){
			if(strlen($entrada) > 4){
				$h = substr($entrada, 0, 2);
				$m = substr($entrada, 3, 4);
				if(($h >= 0 && $h < 24) && ($m >= 0 && $m < 60)){
					$this->entrada = $entrada;
					return true;
				} else {
					return false;
				}
			}
		}
		public function getEntrada(){
			return $this->entrada;
		}

		public function setDuracao($duracao){
			if($duracao > 14 && $duracao < 181){
				$this->duracao = $duracao;
				return true;
			} else {
				return false;
			}
		}
		public function getDuracao(){
			return $this->duracao;
		}

		public function setPeriodo($per){
			if(strlen($per) >= 12){
				$this->periodo = $per;
				return true;
			} else {
				return false;
			}
		}
		public function getPeriodo(){
			return $this->periodo;
		}

		public function setVagasHorario($vagas){
			if(($vagas > 0) && ($vagas < 101)){
				$this->vagasHorario = $vagas;
				return true;
			} else {
				return false;
			}
		}
		public function getVagasHorario(){
			return $this->vagasHorario;
		}

		public function setAtivo($ativo){
			$this->ativo = $ativo;
			return true;
		}
		public function getAtivo(){
			return $this->ativo;
		}

		public function setExcluido($excluido){
			$this->excluido = $excluido;
			return true;
		}
		public function getExcluido(){
			return $this->excluido;
		}

		//****Outros Métodos:****

		public function toString(){
			echo "Horário: ".$this->getPeriodo().". Vagas: <strong>".$this->getVagasHorario()."</strong>";
		}

		//Retorna todos os horários ativos cadastrados no BD:
		public function select(){
			if($this->connection){
        $query = "SELECT *
					FROM ag_horarios
					WHERE excluido = 0 AND ativo = 1
					ORDER BY entrada;";
				return mysqli_query($this->connection->conn, $query);
				$this->connection->closeConn($this->connection);
			}
		}

		//Insere um registro de agendamento no BD
		public function insert(){
			if($this->connection){
				$query ="INSERT INTO ag_horarios VALUES (0, '$this->entrada', $this->duracao, '$this->periodo',
					$this->vagasHorario, $this->ativo, $this->excluido)";
				mysqli_query($this->connection->conn, $query);
				echo "<p class='msgSucesso'><img src='img/sucesso2.png'/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Novo
					horário cadastrado com sucesso.<br/>";
				$this->toString();
				echo "</p>
						<div id='botoesForm'>
							<input type='button' value='<< Voltar' id='btnVoltar' onClick=location='horarioList.php' tabindex='1'/>
						</div>
					</div>";
				$this->connection->closeConn($this->connection);
			} else {
				echo "<p class='msgErro'><img src='img/erro1.png'/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Erro de conexão com o banco de
					dados ao inserir agendamento</p>";
			}
		}

		//Função que exibe a lista de horários cadastrados para administração do sistema
		public function listAll(){
			$query = "SELECT h.horarioId as h_id, h.entrada as h_ent, h.periodo as h_per,
				h.vagasHorario as h_vagas, h.ativo as h_ativo, h.excluido as h_ex
			FROM ag_horarios as h
			WHERE h.excluido = 0
			ORDER BY h_ent;";
			$result = mysqli_query($this->connection->conn, $query);
			if (($result <> null) && ($result->num_rows <= 0)) {
				$result = null;
			}
			return $result;
			$this->connection->closeConn($this->connection);
		}

		public function update(){
			$query ="UPDATE ag_horarios
				SET entrada = '$this->entrada', duracao = $this->duracao, periodo = '$this->periodo',
					vagasHorario = $this->vagasHorario, ativo = $this->ativo
				WHERE horarioId = $this->idHorario;";
			//Se o comando foi executado com sucesso no BD:
			if(mysqli_query($this->connection->conn, $query)){
				header("Location: horarioList.php?msg=upd&hAlt=$this->idHorario");
				} else {
					header("Location: index.php?msg=erroHUpd&hAlt=$this->idAgendamento");
			}
			$this->connection->closeConn($this->connection);
		}

		public function delete(){
			$query = "UPDATE ag_horarios
								SET ativo = 0, excluido = 1
								WHERE horarioId = '$this->idHorario';";
			//Se o comando foi executado com sucesso no BD:
			if(mysqli_query($this->connection->conn, $query)){
				header("Location: horarioList.php?msg=del&hAlt=$this->idHorario");
			//Se o comando falhou no BD, direciona para a lista com parâmetros da msg de erro
			} else {
				header("Location: horarioList.php?msg=erroDel&hAlt=$this->idHorario");
			}
			$this->connection->closeConn($this->connection);
		}

		//Retorna a quantidade de reservas por horário no dia selecionado:
		public function retornaReservas($data, $hora){
			if($this->connection){
        $query = "select sum(ag_agendamento.numPessoas) as soma
			    from ag_agendamento
			    where ag_agendamento.dia = '$data' and
						ag_agendamento.horario = $hora and
						ag_agendamento.estado = 'agendado';";
				$result = mysqli_query($this->connection->conn, $query);
				$row = mysqli_fetch_assoc($result);
				$reservas = $row['soma'];
				return $reservas;
			} else{
				die();
			}
		}

		//Retorna a quantidade de vagas por horário cadastrado
		public function retornaVagas(){
			if($this->connection){
        $query = "SELECT horarioId, vagasHorario
			    FROM ag_horarios
					WHERE excluido = 0 AND ativo = 1
					ORDER BY entrada;";
				$result = mysqli_query($this->connection->conn, $query);
				if (($result <> null) && ($result->num_rows >= 0)) {
					return $result;
				}
				$this->connection->closeConn($this->connection);
			} else{
				die();
			}
		}

		//Retorna período em String com base no id
		public function retornaHorarioString($id){
			if($this->connection){
				$query = "select periodo
					from ag_horarios
					where horarioId = $id;";
				$result = mysqli_query($this->connection->conn, $query);
				$row = mysqli_fetch_array($result);
				$result = $row['periodo'];
				if (($result <> null) && ($result->num_rows >= 0)) {
					return $result;
				} else{
					return null;
				}
			} else {
				die();
			}
		}

		//Retorna duracao em String com base no id
		public function retornaDuracaoString($id){
			if($this->connection){
				$query = "select duracao
					from ag_horarios
					where horarioId = $id;";
				$result = mysqli_query($this->connection->conn, $query);
				$row = mysqli_fetch_array($result);
				$result = $row['duracao'];
				if (($result <> null) && ($result->num_rows >= 0)) {
					if ($result == 15){ $result = "15 min"; }
					if ($result == 30){ $result = "30 min"; }
					if ($result == 60){ $result = "1 hora"; }
					if ($result == 90){ $result = "1h 30min"; }
					if ($result == 120){ $result = "2 horas"; }
					if ($result == 150){ $result = "2h 30min"; }
					if ($result == 180){ $result = "3 horas"; }
					return $result;
				} else{
					return null;
				}
			} else {
				die();
			}
		}

		//Retorna um horário a partir do id informado
		public function retornaPorId($id){
			$h = new Horario();
			$query = "SELECT *
								FROM ag_horarios
								WHERE horarioId = $id;";
			$result = mysqli_query($this->connection->conn, $query);
			$row = mysqli_fetch_array($result);

			$h->setIdHorario($row['horarioId']);
			$h->setEntrada($row['entrada']);
			$h->setDuracao($row['duracao']);
			$h->setPeriodo($row['periodo']);
			$h->setVagasHorario($row['vagasHorario']);
			$h->setAtivo($row['ativo']);
			$h->setExcluido($row['excluido']);

			if (($result <> null) && ($result->num_rows > 0)) {
				//Retorna um objeto do tipo Agendamento com seus dados
				return $h;
			} else {
				return null;
			}
			$this->connection->closeConn($this->connection);
		}

		//Retorna o maior número de vagas cadastrado para limitar o input do form
		public function retornaMaximoDeVagas(){
			if($this->connection){
        $query = "SELECT MAX(vagasHorario) as maximo from ag_horarios;";
				$result = mysqli_query($this->connection->conn, $query);
				$row = mysqli_fetch_assoc($result);
				$max = $row['maximo'];
				return $max;
			} else{
				die();
			}
		}

	}

?>
