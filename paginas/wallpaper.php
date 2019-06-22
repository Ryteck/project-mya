<?php
        include '../php/Conexao.php';
        include '../php/Usuario.php';
        include '../php/Foto.php';
         session_start();
        if ($_SESSION["log"] !='ativo') {

    header("location:../index.php");

}

if ($_SESSION["nome"] == "admin") {

        header("location:./pagina_usuario_admin.php");
    }

        if(isset($_GET['sair'])){
            session_destroy();
            header("location:../index.php");
        }
        $usuario = new Usuario();
        $foto = new Foto;
        $iden = $_SESSION['ID'];

        $wall = array();

$imagem = $foto->visualizarAllIMG($iden);

$local = array();
        
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Teste</title>
        <script type="text/javascript" src="../js/bootstrap.js"></script>
	<link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="../css/wallpaper.css">
       <link rel = "shortcut icon" type = "imagem/x-icon" href = "../imgp/ico.ico"/>
        <script>

                var loadFile = function (event) {
                    var output = document.getElementById('output');
                    output.src = URL.createObjectURL(event.target.files[0]);
                }

        </script>

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

    <style type="text/css"> 
    background-repeat:no-repeat;
    background-size:initial;
    </style>

    <script>

        <?php

$num = 0;


foreach ($imagem as $key) {

        echo "function img".$num." () {\n";

        echo "document.getElementById('trocar').src='../fotos/".$key['nome_arquivo']."';\n";

        echo "}\n";

$num ++;

}
        ?>

        </script>

    </head>
    
    <body>
        
<div class="pos-f-t">
  <div class="collapse" id="navbarToggleExternalContent">
    <div class="bg-dark p-4">
      <h5 class="text-white h4">Bem Vindo</h5>
      <span class="text-muted">Usuario: </span><?php echo $_SESSION["usuario"]; ?>
    </div>
  </div>
  <nav class="navbar navbar-dark bg-dark">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
      INFORMAÇÕES
    </button>
    <form class="form-inline">
    <button class="btn btn-sm btn-outline-secondary" type="button"><a href="pagina_usuario.php" style='color: #ffffff'>Home</a></button>
    -
    <button class="btn btn-sm btn-outline-secondary" type="button"><a href="pagina_usuario_alterar.php" style='color: #ffffff'>Editar</a></button>
    -
    <button class="btn btn-outline-success" type="button"><a href="pagina_usuario.php?sair=true" style='color: #ffffff'>Sair</a></button>
  </form>
  </nav>
</div>

<br>
<br>
<br>

<div class="row">

    <div class="col">

<h2>Escolha a foto</h2>

<br>
<br>

<ul>

<?php  

$num = 0;

foreach ($imagem as $key) {

        echo "<li class='media'>";
        echo "<img class='mr-3' src='../fotos/".$key['nome_arquivo']."' width='80' height='45' onclick='img".$num."();'>";
        echo "<div class='media-body'>";
        echo "<h5 class='mt-0 mb-1'>".$key['nome']."</h5>";
        echo "</div>";
        echo "</li>";
        echo "<br>";

$num ++;

}

?> 

</ul>

</div>

<div class="col-10">      
    
<img src="../imgp/sem-foto.png" width='1200' height='675' id="trocar"> 

</div>

</div>

<br><br><br>


    </body>
</html>