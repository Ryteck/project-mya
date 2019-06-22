<?php
include 'php/Conexao.php';
include 'php/Usuario.php';
    
$logado = true;

$cadastrar = true;

$usuario = new Usuario();

session_start();
if (isset($_SESSION["log"])) {

    if ($_SESSION["nome"] == "admin") {

        header("location:./paginas/pagina_usuario_admin.php");
    }else{

    header("location:./paginas/pagina_usuario.php");
}
}

if (isset($_POST['entrar'])) {
    $login = $_POST['login'];
    $senha = $_POST['senha'];

    $logado = $usuario->logar($login, sha1($senha));

    if($logado){
        

        if($login == "admin"){
            header("location:./paginas/pagina_usuario_admin.php");
        }
        else
        {
            header("location:./paginas/pagina_usuario.php");  
        }

    }

}


if(isset($_POST['cadastrar'])){

$nome = $_POST ['nome'];
$login = $_POST ['login'];
$senha = sha1($_POST ['senha']);
$csenha = sha1($_POST ['c-senha']);
$imagem = null;

if ($senha == $csenha) {

$usuario->salvar($nome, $login, $senha, $imagem);

}else{

$cadastrar = false;

}

}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>PROJECT MYA</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="css/wallpaper.css">
    <link rel = "shortcut icon" type = "imagem/x-icon" href = "imgp/ico.ico"/>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</head>
<body>

<div class="pos-f-t">
  <div class="collapse" id="navbarToggleExternalContent">
    <div class="bg-dark p-4">
      <h5 class="text-white h4">PROJETO MYA</h5>
      <span class="text-muted">O proheto MYA permite aos usuários amazenarem suas fotos online, de forma simples e segura.</span>
    </div>
  </div>
  <nav class="navbar navbar-dark bg-dark">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
      INFORMAÇÕES
    </button>
  </nav>
</div>

    <br><br><br>

    <div class="container">

        <ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true" style='color: #000000'>Home</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="logar-tab" data-toggle="tab" href="#logar" role="tab" aria-controls="logar" aria-selected="false" style='color: #000000'>Logar</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="cadastrar-tab" data-toggle="tab" href="#cadastrar" role="tab" aria-controls="cadastrar" aria-selected="false" style='color: #000000'>Cadastrar</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="termos-tab" data-toggle="tab" href="#termos" role="tab" aria-controls="termos" aria-selected="false" style='color: #000000'>Termos</a>
  </li>
</ul>
<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">


    <br><br>
    <center><h2>Welcome to project</h2></center>
    <br>
    <center><img src="imgp/mya.png" alt="mya"></center>
    <br><br>

    <div id="carouselExampleFade" class="carousel slide carousel-fade" data-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img class="d-block w-100" src="imgp/car(1).jpg" alt="First slide">
    </div>
    <div class="carousel-item">
      <img class="d-block w-100" src="imgp/car(2).jpg" alt="Second slide">
    </div>
    <div class="carousel-item">
      <img class="d-block w-100" src="imgp/car(3).jpg" alt="Third slide">
    </div>
    <div class="carousel-item">
      <img class="d-block w-100" src="imgp/car(4).jpg" alt="Fourth slide">
    </div>
    <div class="carousel-item">
      <img class="d-block w-100" src="imgp/car(5).jpg" alt="Fifth slide">
    </div>
    <div class="carousel-item">
      <img class="d-block w-100" src="imgp/car(6).jpg" alt="Sixth slide">
    </div>
  </div>
  <a class="carousel-control-prev" href="#carouselExampleFade" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">ANTERIOR</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleFade" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">PROXIMO</span>
  </a>
</div>


  </div>
  <div class="tab-pane fade" id="logar" role="tabpanel" aria-labelledby="logar-tab">
      
<br><br>

<form action="" method="POST" class="was-validated">
        <?php

        if ($logado == false) {
            echo "<p style='color:red;'> Login ou senha invalidos </p>";
        }

        ?>
        <div class="form-group">
        <label>Login</label><br>
        <input type="TEXT" name="login" class="form-control" placeholder="Seu nome de usuario" required/>
        <div class="invalid-feedback">Escreva seu login</div>
        <div class="valid-feedback">Obrigado</div>
        </div>
        <div class="form-group">
        <label>Senha</label><br>
        <input type="PASSWORD" name="senha" class="form-control" placeholder="Sua senha" required/>
        <div class="invalid-feedback">Escreva sua senha</div>
        <div class="valid-feedback">Obrigado</div>
        </div>
        <input type="SUBMIT" name="entrar" class="btn btn-success"/>
        <input type="RESET" name="apagar" class="btn btn-danger"/>
        

    </form>

  </div>
  <div class="tab-pane fade" id="cadastrar" role="tabpanel" aria-labelledby="cadastrar-tab">
    
<br><br>

<form action="" method="POST" class="was-validated">

  <?php

        if ($cadastrar == false) {
            echo "<p style='color:red;'> Senhas diferentes </p>";
        }

        ?>

  <div class="form-group">
            <label>Nome</label>
            <br>
            <input type="TEXT" name="nome" class="form-control" placeholder="Digite seu nome" required/>
            <div class="invalid-feedback">Digite seu nome</div>
            <div class="valid-feedback">Obrigado</div>
          </div>
          <div class="form-group">
            <label>Usuario</label>
            <br>
            <input type="TEXT" name="login" class="form-control" placeholder="Escolha seu nome de usuario" required/>
            <div class="invalid-feedback">Digite um login</div>
            <div class="valid-feedback">Obrigado</div>
          </div>
            <div class="form-group">
            <label>Senha</label>
            <br>
            <input type="PASSWORD" name="senha" class="form-control" placeholder="Escolha sua senha" required/>
            <div class="invalid-feedback">Digite uma senha</div>
            <div class="valid-feedback">Obrigado</div>
          </div>
          <div class="form-group">
            <label>Confirmar senha</label>
            <br>
            <input type="PASSWORD" name="c-senha" class="form-control" placeholder="Escolha sua senha" required/>
            <div class="invalid-feedback">Digite a mesma senha</div>
            <div class="valid-feedback">Obrigado</div>
          </div>
          <div class="form-group">
            <div class="custom-control custom-checkbox mb-3">
            <input type="checkbox" class="custom-control-input" name="termos" id="customControlValidation1" required>
            <label class="custom-control-label" for="customControlValidation1">Aceito os termos e condições do site</label>
            <div class="invalid-feedback">Aceite para cadastrar</div>
            <div class="valid-feedback">Obrigado</div>
            </div>
          </div>
          <input type="SUBMIT" name="cadastrar"/ class="btn btn-success">
        <input type="RESET" name="apagar" class="btn btn-danger"/>
</form>

  </div>

<div class="tab-pane fade" id="termos" role="tabpanel" aria-labelledby="termos-tab">
    
<br><br>

Nenhum, faça o que quiser não estou nem ai, só não me responsabilizo por perda de fotos ou contas.

  </div>

</div>
</div>

<br><br>

</body>
</html>