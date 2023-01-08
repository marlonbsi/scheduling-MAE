/*Tentativa de validação do formAgendamento*/

/*Validação do campo Solicitante*/
function testaNome(elementoNome) {
	nome = elementoNome.value;
	if (nome.length < 4 || nome.length > 60 || nome == null){
		return elementoNome.style.color = "#a00";
	}else{
		var regex = '[^a-zA-Z éúíóáÉÚÍÓÁèùìòàçÇÈÙÌÒÀõãñÕÃÑêûîôâÊÛÎÔÂëÿüïöäËYÜÏÖÄ]+';
		if(nome.match(regex)) {
			return elementoNome.style.color = "#a00";
		}else{
			return elementoNome.style.color = "#1a323b";
		}
	}
}

/*Validação do campo Email*/
function testaEmail(elementoEmail) {
	email = elementoEmail.value;
	if (email.length < 6 || email.length > 80 || email == null){
		return elementoEmail.style.color = "#a00";
	}else{
		var regex = '[^a-zA-Z0-9@.]+';
		if(email.match(regex)) {
			return elementoEmail.style.color = "#a00";
		}else{
			return elementoEmail.style.color = "#1a323b";
		}
	}
}

/*Validação do campo numPessoas*/
function testaNumPessoas(elementoNum) {
	num = elementoNum.value;
	if(num < 1 || num > 15){
		//alert("Número de pessoas inválido!");
		return elementoNum.style.color = "#a00";
	}else{
		return elementoNum.style.color = "#1a323b";
	}
}

/*Validação do campo horario*/
function testaHorario(elementoHorario) {
	h = elementoHorario.value;
	if(elementoHorario < 0 || elementoHorario > 10){
		//alert("Você deve selecionar um horário da lista!");
		return elementoHorario.style.color = "#a00";
	}else{
		return elementoHorario.style.color = "#1a323b";
	}
}

/*Montagem do input "contato" que pode receber um email ou um telefone*/
function displayRadioValue() {
	var ele = document.getElementsByName('tipoContato');
	var val = ele.displayRadioValue;
	for(i = 0; i < ele.length; i++) {
		if(ele[0].checked){
			document.getElementById("campoContato").innerHTML
				= "<input type='text' name='contato' id='campoEmail' maxlength='60' tabindex='4' onblur='testaEmail(formAgendamento.contato);' autofocus required>";
		} else{
			document.getElementById("campoContato").innerHTML
				= "<input type='text' name='contato' id='campoTelefone' maxlength='20' tabindex='4' onkeypress=\"$(this).mask('(00) 000000000')\" onblur='testaTelefone(formAgendamento.contato);' autofocus required>";
		}
	}
}
