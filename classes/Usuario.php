<?php
	require_once('Connection.php');

	class Usuario{

		//****Atributos:****

		private $idUsuario;
		private $nomeUsuario;
		private $emailUsuario;
		private $senhaUsuario;
		private $ativo;
		private $excluido;

		public $connection;

		//****Constructor****
		public function __construct() {
			$this->connection = new Connection();
		}

		//****Getters e Setters:****

		public function setIdUsuario($id){
			$this->idUsuario = $id;
		}
		public function getIdUsuario(){
			return $this->idUsuario;
		}

    public function setNomeUsuario($nome){
			if(!empty($nome)){
				if(strlen($nome) > 4 && strlen($nome) < 60){
					$regex = "/^[A-Za-z éúíóáÉÚÍÓÁèùìòàçÇÈÙÌÒÀõãñÕÃÑêûîôâÊÛÎÔÂëÿüïöäËYÜÏÖÄ]+$/";
    			if(preg_match($regex, $nome)){
						//Prepara o valor em letras maiúsculas para gravar no BD
						$nome = mb_strtoupper($nome, 'UTF-8');
						$this->nomeUsuario = trim($nome);
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
		public function getNomeUsuario(){
			return $this->nomeUsuario;
		}

    public function setEmailUsuario($email){
			if(!empty($email)){
				if(strlen($email) > 8 && strlen($email) < 80){
					if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
						//Prepara o valor em letras minúsculas para gravar no BD
						$email = strtolower($email);
						$this->emailUsuario = trim($email);
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
		public function getEmailUsuario(){
			return $this->emailUsuario;
		}

		/*Verifica se a senha tem pelo menos 1 número, 1 letra e 1 caractere especial
			antes de setar com md5*/
    public function setSenhaUsuario($senha){
			$letras = preg_match('@[A-Za-z]@', $senha);
			$numeros = preg_match('@[0-9]@', $senha);
			$especial = preg_match('@[\W]@', $senha);
			if(!$letras || !$numeros || !$especial || strlen($senha) < 8) {
			  return false;
			} else {
				$this->senhaUsuario = md5($senha);
				return true;
			}
		}
		public function getSenhaUsuario(){
			return $this->senhaUsuario;
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

		public function logar($email, $senha){
			$query = "SELECT operadorId, ativo
				FROM ag_operador
				WHERE emailOperador = '$email' AND senhaOperador = '$senha' AND excluido = 0;";
			$verifica = mysqli_query($this->connection->conn, $query);
	      if (mysqli_num_rows($verifica) <= 0){
	        return false;
	      } else{
	        $row = mysqli_fetch_array($verifica);
					$ativo = $row['ativo'];
					if($ativo > 0){
						$idUsuario = $row['operadorId'];
						$us = $this->retornaPorId($idUsuario);
						$_SESSION["usuario"] = $us;
						$_SESSION["idUsuario"] = $idUsuario;
						return true;
					} else{
	          die();
						return false;
	        }
      }
		}

		public function toString(){
			echo
			"Operador: ".$this->getNomeUsuario().
			"<br/>Email: ".$this->getEmailUsuario().
			"<br/>Ativo: ".$this->getAtivo().
			"<br/>Excluído: ".$this->getExcluido();
		}

		public function listAll(){
			$query = "SELECT o.operadorId as o_id, o.nomeOperador as o_nome, o.emailOperador as o_email,
				o.ativo as o_ativo
			FROM ag_operador as o
			WHERE excluido = 0
			ORDER BY o_nome, o_id;";
			$result = mysqli_query($this->connection->conn, $query);
			if (($result <> null) && ($result->num_rows <= 0)) {
				$result = null;
			}
			return $result;
			$this->connection->closeConn($this->connection);
		}

		public function insert(){
			if($this->connection){
				/*$queryEmail procura se o email já está cadastrado para evitar registros em duplicidade*/
				$queryEmail = "SELECT emailOperador
					FROM ag_operador
					WHERE emailOperador = '$this->emailUsuario';";
				$result = mysqli_query($this->connection->conn, $queryEmail);
				$row = mysqli_fetch_array($result);
				$result = $row['emailOperador'];
				/*Se o email não estiver cadastrado, prossegue com o insert*/
				if (($result == null)) {
					$query ="INSERT INTO ag_operador VALUES (0, '$this->nomeUsuario', '$this->emailUsuario', '$this->senhaUsuario',
						$this->ativo, $this->excluido);";
					mysqli_query($this->connection->conn, $query);
					echo "<p class='msgSucesso'><img src='img/sucesso2.png'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Novo usuário
						cadastrado. Email: <strong>$this->emailUsuario</strong><br/></p>
						<div id='botoesForm'>
							<input type='button' value='<< Voltar' id='btnVoltar' onClick=location='usuarioList.php' tabindex='1'/>
						</div>
					</div>";
					$this->connection->closeConn($this->connection);
				} else {
					echo "<p class='msgErro'><img src='img/erro1.png'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Já existe um usuário
						cadastrado com o email $this->emailUsuario.</p>
							<div id='botoesForm'>
								<input type='button' value='<< Voltar' id='btnVoltar' onClick='window.history.go(-1)' tabindex='1'/>
							</div>
						</div>";
						$this->connection->closeConn($this->connection);
				}
			} else{
				echo "<p class='msgErro'><img src='img/erro1.png'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Erro de conexão com o banco de
				dados ao inserir usuário</p>";
			}
		}

		public function update($idUsuarioLogado){
			$query ="UPDATE ag_operador
				SET nomeOperador = '$this->nomeUsuario', emailOperador = '$this->emailUsuario',
					ativo = $this->ativo
				WHERE operadorId = '$this->idUsuario';";
			//Se o comando foi executado com sucesso no BD:
			if(mysqli_query($this->connection->conn, $query)){
				if($idUsuarioLogado == 1){
					//Direciona para a lista de usuários se o logado for MAE
					header("Location: usuarioList.php?msg=upd&usAlt=$this->idUsuario");
				} else {
					//Direciona para a lista de agendamentos se o logado for outro
					header("Location: agendamentoList.php?msg=updUs&usAlt=$this->idUsuario");
				}
			//Se o comando falhou no BD, direciona para a lista com parâmetros da msg de erro
			} else {
				if($idUsuarioLogado == 1){
					//Direciona para a lista de usuários se o logado for MAE
					header("Location: usuarioList.php?msg=erroUpd&usAlt=$this->idUsuario");
				} else {
					//Direciona para a lista de agendamentos se o logado for outro
					header("Location: agendamentoList.php?msg=erroUpdUs&usAlt=$this->idUsuario");
				}
			}
			$this->connection->closeConn($this->connection);
		}

		public function updateSenha($idUsuarioLogado){
			$query ="UPDATE ag_operador
				SET nomeOperador = '$this->nomeUsuario', emailOperador = '$this->emailUsuario',
					senhaOperador = '$this->senhaUsuario', ativo = $this->ativo
				WHERE operadorId = '$this->idUsuario';";
			//Se o comando foi executado com sucesso no BD:
			if(mysqli_query($this->connection->conn, $query)){
				if($idUsuarioLogado == 1){
					//Direciona para a lista de usuários se o logado for MAE
					header("Location: usuarioList.php?msg=upd&usAlt=$this->idUsuario");
				} else {
					//Direciona para a lista de agendamentos se o logado for outro
					header("Location: agendamentoList.php?msg=updUs&usAlt=$this->idUsuario");
				}
			//Se o comando falhou no BD, direciona para a lista com parâmetros da msg de erro
			} else {
				if($idUsuarioLogado == 1){
					//Direciona para a lista de usuários se o logado for MAE
					header("Location: usuarioList.php?msg=erroUpd&usAlt=$this->idUsuario");
				} else {
					//Direciona para a lista de agendamentos se o logado for outro
					header("Location: agendamentoList.php?msg=erroUpdUs&usAlt=$this->idUsuario");
				}
			}
			$this->connection->closeConn($this->connection);
		}

		public function delete(){
			$query = "UPDATE ag_operador
								SET ativo = 0, excluido = 1
								WHERE operadorId = '$this->idUsuario';";
			//Se o comando foi executado com sucesso no BD:
			if(mysqli_query($this->connection->conn, $query)){
				header("Location: usuarioList.php?msg=del&usAlt=$this->idUsuario");
			//Se o comando falhou no BD, direciona para a lista com parâmetros da msg de erro
			} else {
				header("Location: usuarioList.php?msg=erroDel&usAlt=$this->idUsuario");
			}
			$this->connection->closeConn($this->connection);
		}

		public function retornaPorId($id){
			$us = new Usuario();
			$query = "SELECT *
								FROM ag_operador
								WHERE operadorId = $id;";
			$result = mysqli_query($this->connection->conn, $query);
			$row = mysqli_fetch_array($result);

			$us->setIdUsuario($row['operadorId']);
			$us->setNomeUsuario($row['nomeOperador']);
			$us->setEmailUsuario($row['emailOperador']);
			$us->setSenhaUsuario($row['senhaOperador']);
			$us->setAtivo($row['ativo']);
			$us->setExcluido($row['excluido']);

			if (($result <> null) && ($result->num_rows > 0)) {
				//Retorna um objeto do tipo Agendamento com seus dados
				return $us;
			} else {
				return null;
			}
			$this->connection->closeConn($this->connection);
		}


  }
