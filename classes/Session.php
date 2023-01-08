<?php
	class Session{

		//Inicia a sessão
		public function inicia(){
			session_start();
			$_SESSION['ultima_atividade'] = time();
			echo $_SESSION['ultima_atividade'];
		}

		public function validaSessao(){
			if (isset($_SESSION['ultima_atividade']) && (time() - $_SESSION['ultima_atividade'] > 1800)) {
				session_unset();     // unset $_SESSION
				session_destroy();   // destruindo session data
			} else{
				$_SESSION['ultima_atividade'] = time();
			}
		}

		//Destrói a sessão
		public function destroy() {
			session_unset();
			session_destroy();
		}
	}
?>
