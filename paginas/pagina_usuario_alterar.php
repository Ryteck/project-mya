<?php
        include '../php/Conexao.php';
        include '../php/Usuario.php';
         session_start();
        if ($_SESSION["log"] !='ativo') {

    header("location:../index.php");

}

if ($_SESSION["nome"] == "admin") {

        header("location:pagina_usuario_admin.php");
    }
        if(isset($_GET['sair'])){
            session_destroy();
            header("location:../index.php");
        }

        $usuario = new Usuario();

        $id = $_SESSION["ID"];

        if(isset($_POST['enviar'])){
            $nome = $_POST ['nome'];
            $login = $_POST ['usuario'];
            $senha = sha1($_POST ['senha']);
            $imagem = $_FILES['imagem'];

                $usuario->alterar($id, $nome, $login, $senha, $imagem);

 
            header("location:pagina_usuario.php");
         
        }

        if(isset($_GET['excluir'])){
            $iduser = $_GET['excluir'];

            $usuario->excluir($iduser);

            session_destroy();

            header("location:../index.php");
        }

            $alterarUsuario = $usuario->selecionarUsuario($id);

           foreach ($alterarUsuario as $linha) {
                $nome = $linha['nome'];
                $login = $linha['usuario'];
                $senha = $linha['senha'];
                $foto = $linha['foto'];
            }     
        
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>ALTERAR</title>
        <script type="text/javascript" src="../js/bootstrap.js"></script>
	<link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="../css/wallpaper.css">
       <link rel = "shortcut icon" type = "imagem/x-icon" href = "../imgp/ico.ico"/>
        <script>

                var loadFile = function (event) {
                    var output = document.getElementById('output');
                    output.src = URL.createObjectURL(event.target.files[0]);
                }

            function excluir(id){

                if (confirm('Deseja realmente \nexcluir sua conta ?')){

                    window.location.href = 'pagina_usuario_alterar.php?excluir=' + id;

                }
            }

        </script>

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

    </head>
    <body>
        <div class="pos-f-t">
  <div class="collapse" id="navbarToggleExternalContent">
    <div class="bg-dark p-4">
      <h5 class="text-white h4">Bem Vindo</h5>
      <span class="text-muted">Usuario: </span><?php echo $_SESSION["usuario"]; ?>
    </div>
  </div>
  <?php echo 'teste'; die();?>
  <nav class="navbar navbar-dark bg-dark">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
      INFORMAÇÕES
    </button>
    <form class="form-inline">
    <button class="btn btn-sm btn-outline-secondary" type="button"><a href="wallpaper.php" style='color: #ffffff'>Visualizar</a></button>
    -
    <button class="btn btn-sm btn-outline-secondary" type="button"><a href="pagina_usuario.php" style='color: #ffffff'>Home</a></button>
    -
    <button class="btn btn-outline-success" type="button"><a href="pagina_usuario.php?sair=true" style='color: #ffffff'>Sair</a></button>
  </form>
  </nav>
</div>
        
        <div class="container">
                    
            <? php echo $_SESSION["nome"];?>
            
            <br>
            <form action="" method="POST" enctype="multipart/form-data" class="was-validated">
            <label for="imagem">Selecione uma imagem JPG ou PNG</label>
            <br>
            <input  type="file"
                    name="imagem"
                    id="imagem"
                    file-accept="jpg png"
                    onchange="loadFile(event)"
                    required>
                <br><br>
                <img id="output" width="100" src="../img/<?php echo $foto; ?>">
            <div class="form-group">
            <label>Nome</label>
            <br>
            <input type="TEXT" name="nome" value="<?php echo $nome; ?>" class="form-control" required/>
            <div class="invalid-feedback">Digite um nome</div>
            <div class="valid-feedback">Obrigado</div>
            </div>
            <div class="form-group">
            <label>Usuario</label>
            <br>
            <input type="TEXT" name="usuario" value="<?php echo $login; ?>" class="form-control" required/>
            <div class="invalid-feedback">Digite um nome de usuario</div>
            <div class="valid-feedback">Obrigado</div>
            </div>
            <div class="form-group">
            <label>Senha</label>
            <input type="PASSWORD" name="senha" value="" class="form-control" required/>
            <div class="invalid-feedback">Digite uma senha</div>
            <div class="valid-feedback">Obrigado</div>
            </div>
            <input type="SUBMIT" name="enviar" class="btn btn-success"/>
            <input type="RESET" name="apagar" class="btn btn-warning"/>
        </form>

<br>

        <button type='button' class='btn btn-danger'><a href='javascript:excluir(<?php echo $id ?>)' style='color: #ffffff'> Excluir</a></button>
            
        </div>
    </body>
</html>