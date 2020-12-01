<?php //Conexão e inicio da Sessão
//CONEXÃO COM O BANCO DE DADOS
include_once 'db_connect.php';

//SESSÃO
session_start();
?>

<?php //Validações, limpeza e inserção de dados
$confirmacao = 0;
if (isset($_POST['enviar-dados'])) {

	//TRATAMENTO DO CAMPO 'NOME'
	if(!empty($nome = $_POST['nome'])){
		$nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS); 
		
		if ($nome = filter_input(INPUT_POST, 'nome', FILTER_VALIDATE_INT) 
			or $nome = filter_input(INPUT_POST, 'nome', FILTER_VALIDATE_FLOAT)) {
			echo "<li>o campo deve ter apenas letras: ".$nome."</li>";
		}
		 else{
		 	 $nome = $_POST['nome'];
	  	     echo "<li>Campo inserido corretamente: ".$nome."</li>";
	  	     $confirmacao = $confirmacao + 1;
	    }
	}
	else{
		echo "<li>O campo deve estar preenchido: ".$nome."</li>";
	}
	//FIM DO TRATAMENTO DO CAMPO 'NOME'

	//TRATAMENTO DO CAMPO 'SOBRENOME'
	if(!empty($sobrenome = $_POST['sobrenome'])){
		$sobrenome = filter_input(INPUT_POST, 'sobrenome', FILTER_SANITIZE_SPECIAL_CHARS); 
		
		if ($sobrenome = filter_input(INPUT_POST, 'sobrenome', FILTER_VALIDATE_INT,) 
			or $sobrenome = filter_input(INPUT_POST, 'sobrenome', FILTER_VALIDATE_FLOAT)) {
			echo "<li>o campo deve ter apenas letras: ".$sobrenome."</li>";
		}
		 else{
		 	 $nome = $_POST['nome'];
	  	     echo "<li>Campo inserido corretamente: ".$sobrenome."</li>";
	  	     $confirmacao = $confirmacao + 1;
	    }
	}
	else{
		echo "<li>O campo deve estar preenchido: ".$sobrenome."</li>";
	}
	//FIM DO TRATAMENTO DO CAMPO 'SOBRENOME'

	//TRATAMENTO DO CAMPO 'IDADE'
	if (!empty($idade = $_POST['idade'])) {
		$idade = filter_input(INPUT_POST, 'idade',FILTER_SANITIZE_NUMBER_INT);

		if (!filter_var($idade, FILTER_VALIDATE_INT)) {
			echo "<li>a idade precisa ser um numero inteiro: ".$idade."</li>";
		}
		else{
			echo "<li>Idade cadastrada com sucessso: ".$idade."</li>";
			$confirmacao = $confirmacao + 1;
		}
	}
	else{
		echo "<li>o campo deve estar preenchido</li>";
	}
	//FIM DO TRATAMENTO DO CAMPO 'IDADE'

	//TRATAMENTO DO CAMPO 'EMAIL'
	if (!empty($email = $_POST['email'])) {
		$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			echo "<li>email incorreto: ".$email."</li>";
		}
		else{
			echo "<li>email cadastrado com sucesso: ".$email."</li>";
			$confirmacao = $confirmacao + 1;
		}
	}
	else{
		echo "<li>campo email precisa ser preenchido".$email."</li>";
	}
	//FIM DO TRATAMENTO DO CAMPO 'EMAIL'

	//TRATAMENTO DO CAMPO 'SENHA'
	if (!empty($senha = $_POST['senha'])) {
		$confirmacao = $confirmacao + 1;
	}
	else{
		echo "<li>o campo senha deve estar preenchido</li>";
	}
	//FIM DO TRATAMENTO DO CAMPO 'SENHA'

    //ATRIBUIÇÃO FINAL DOS DADOS DO USUARIO
	if ($confirmacao == 5) {
		$nome = mysqli_escape_string($connect, $_POST['nome']);
		$sobrenome = mysqli_escape_string($connect, $_POST['sobrenome']);
		$idade = mysqli_escape_string($connect, $_POST['idade']);
		$email = mysqli_escape_string($connect, $_POST['email']);
		$senha = mysqli_escape_string($connect, md5($_POST['senha']));

		$sql = "INSERT INTO Colaboradores (nome, sobrenome, idade, email, senha) 
		        VALUES ('$nome', '$sobrenome', '$idade', '$email', '$senha')";
		if (mysqli_query($connect, $sql)) {
			$_SESSION['logado'] = true;
			header('location: index.php?');
		}
		else{
			header('location: index.php?');
		}
	}
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Cadastro</title>
</head>
<body>
<div>
	<hr>
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
		Nome: <input type="text" name="nome"><br><br>
		Sobrenome: <input type="text" name="sobrenome"><br><br>
		Idade: <input type="text" name="idade"><br><br>
		E-mail: <input type="text" name="email"><br><br>
		Senha: <input type="password" name="senha"><br><br>
		<button type='submit' name='enviar-dados'>Cadastrar</button>
	</form>
</div>
</body>
</html>
