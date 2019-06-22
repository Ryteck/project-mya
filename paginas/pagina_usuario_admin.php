<?php
        include '../php/Conexao.php';
        include '../php/Usuario.php';
        include '../php/Foto.php';
         session_start();
        if ($_SESSION["log"] !='ativo') {

    header("location:../index.php");

}
if ($_SESSION["nome"] != "admin") {

        header("location:./pagina_usuario.php");
    }
        if(isset($_GET['sair'])){
            session_destroy();
            header("location:../index.php");
        }
        $usuario = new Usuario();
        $usuarios = $usuario->selecionarTodos();
        $foto = new Foto();

        $nome = null;
        $login = null;
        $senha = null;
        $foti = "../imgp/sem-foto.png";
        $apagadmin = false;

        if(isset($_POST['enviar'])){
            $nome = $_POST ['nome'];
            $login = $_POST ['usuario'];
            $senha = sha1($_POST ['senha']);
            $imagem = $_FILES['imagem'];

            if(isset($_GET['alterar'])) {

                $id = $_GET['alterar'];

                $usuario->alterarAdmin($id, $nome, $login, $senha, $imagem);

            }else{

                $usuario->salvarAdmin($nome, $login, $senha, $imagem);

            }

            header("location:pagina_usuario_admin.php");
         
        }

        if(isset($_GET['excluir'])){
            $id = $_GET['excluir'];

            if ($id == 1) {

                $apagadmin = true;
              
            }
            else
            {
            $excluse = $usuario->selecionarUsuario($id);

            foreach ($excluse as $linha) {
                $login = $linha['usuario'];
            }

            $usuario->excluir($id);

            header("location:pagina_usuario_admin.php");
          }
        }

        if(isset($_GET['alterar'])){
            $id = $_GET['alterar'];
            $alterarUsuario = $usuario->selecionarUsuario($id);

            foreach ($alterarUsuario as $linha) {
                $nome = $linha['nome'];
                $login = $linha['usuario'];
                $senha = $linha['senha'];
                $foti = $linha['foto'];
            }

        }

        $nusus = $usuario->contarUSU();
        
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>ADMIN</title>
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

                if (confirm('Deseja realmente \nexcluir esse usuario ?')){

                    window.location.href = 'pagina_usuario_admin.php?excluir=' + id;

                }
            }
             function alterar(id) {
                window.location.href = 'pagina_usuario_admin.php?alterar=' + id;

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
      <span class="text-muted">Usuario: </span><?php echo $_SESSION["nome"]; ?>
       <br>
      <span class="text-muted">Fotos: </span>O admin possui apenas a foto de perfil.
       <br>
       <span class="text-muted">Usuarios cadastrados: </span><?php  echo $nusus; ?>
       <br>
      <span class="text-muted">OBS: </span> O admin não pode inserir fotos ao site, porem ele tem acesso total ao banco de dados dos usuários, podendo modificá-los ou exclui-los.
    </div>
  </div>
  <nav class="navbar navbar-dark bg-dark">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
      INFORMAÇÕES
    </button>
    <form class="form-inline">
    <button class="btn btn-outline-success" type="button"><a href="pagina_usuario_admin.php?sair=true" style='color: #ffffff'>Sair</a></button>
  </form>
  </nav>
</div>




        <div class="container">
           
            <br><br><br>

            <center>

            <?php  


            if ($apagadmin == true) {
              echo "<p style='color:red;'> O admin não pode ser apagado </p> <br><br><br>";
            }


            ?>

            <h2>Seja bem vindo <?php echo $_SESSION["nome"]; ?> </h2> 

            <br>

            <?php echo "<img src='../img/".$_SESSION["foto"]."' width='320' height='180'/>"; ?>

           </center>

             <br><br><br>

        <h2> Usuarios cadastrados </h2>

        <table class="table table-striped table-dark">
  <thead class="thead-dark">
    <tr>
      <th scope="col">#</th>
      <th scope="col">Avatar</th>
      <th scope="col">Nome</th>
      <th scope="col">Usuario</th>
      <th scope="col">Excluir</th>
      <th scope="col">Alterar</th>
    </tr>
  </thead>
  <tbody>
    <?php

    $num = 0;

    foreach($usuarios as $linha) {

        

        $num++;

        echo "<tr>";

        echo "<th scope='row'>".$num."</th>";

        echo "<td><img src='../img/".$linha['foto']."' width='80' height='45'></dh>";

        echo "<td><button type='button' class='btn btn-info'>".$linha['nome']."</button></td>";

        echo "<td><button type='button' class='btn btn-info'>".$linha['usuario']."</button></td>";

        echo "<td>"."<button type='button' class='btn btn-success'><a href='javascript:excluir(".$linha['id'].")' style='color: #ffffff'> Excluir</a></button>"."</td>";

        echo "<td>"."<button type='button' class='btn btn-success'><a href='javascript:alterar(".$linha['id'].")' style='color: #ffffff'> Alterar</a></button>"."</td>";

        echo "</tr>";
    }

    ?>
  </tbody>
</table>

<br><br>

<hr>

<br><br>

<h2> Editar usuarios </h2>

<br><br>
            
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
                <img id="output" width="100" src="../img/<?php echo $foti; ?>">
                 <div class="form-group">
            <label>Nome</label>
            <input type="TEXT" name="nome" value="<?php echo $nome; ?>" class="form-control" required/>
            <div class="invalid-feedback">Digite o nome</div>
            <div class="valid-feedback">Obrigado</div>
        </div>
         <div class="form-group">
            <label>Usuario</label>
            <input type="TEXT" name="usuario" value="<?php echo $login; ?>" class="form-control" required/>
            <div class="invalid-feedback">Digite o login</div>
            <div class="valid-feedback">Obrigado</div>
        </div>
         <div class="form-group">
            <label>Senha</label>
            <input type="PASSWORD" name="senha" value="" class="form-control" required/>
            <div class="invalid-feedback">Digite uma senha</div>
            <div class="valid-feedback">Obrigado</div>
        </div>
        <input type="SUBMIT" name="enviar" class="btn btn-success"/>
        <input type="RESET" name="apagar" class="btn btn-danger"/>
        </form>

<br><br>

        </div>
    </body>
</html>