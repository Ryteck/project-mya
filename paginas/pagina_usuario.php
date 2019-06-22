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
        $foto = new Foto();

        $fotos = $foto->visualizarAllIMG($_SESSION['ID']);

        $nome = null;

        $fotoapg = "../imgp/sem-foto.png";

 if(isset($_GET['alterar'])){
            $id = $_GET['alterar'];
            $alterar = $foto->visualizar($id);

            foreach ($alterar as $linha) {
                $nome = $linha['nome'];
                $fotoapg = $linha['nome_arquivo'];
            }

        } 

        if(isset($_POST['enviar'])){

            $imagem = $_FILES['imagem'];
            $nome = $_POST['nome'];

            if(isset($_GET['alterar'])) {

               $idfoto = $_GET['alterar'];
                $foto->alterarIMG($imagem, $_SESSION['ID'], $nome, $idfoto);

                }else{

                $foto->inserirIMG($nome, $imagem, $_SESSION["ID"]);

            }

            header("location:pagina_usuario.php");

            }
         

        if(isset($_GET['excluir'])){
            $id = $_GET['excluir'];

            $foto->deletarIMG($id);

            header("location:pagina_usuario.php");
        }

        $nfotos = $foto->contarIMG($_SESSION["ID"]);   
        
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Perfil</title>
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

                if (confirm('Deseja realmente \nexcluir essa foto ?')){

                    window.location.href = 'pagina_usuario.php?excluir=' + id;

                }
            }
             function alterar(id) {
                window.location.href = 'pagina_usuario.php?alterar=' + id;

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
       <br>
      <span class="text-muted">Fotos: </span><?php  echo $nfotos; ?>
       <br>
      <span class="text-muted">OBS: Pagina para gerenciar imagens</span>
    </div>
  </div>
  <nav class="navbar navbar-dark bg-dark">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
      INFORMAÇÕES
    </button>
    <form class="form-inline">
    <button class="btn btn-sm btn-outline-secondary" type="button"><a href="wallpaper.php" style='color: #ffffff'>Visualizar</a></button>
    -
    <button class="btn btn-sm btn-outline-secondary" type="button"><a href="pagina_usuario_alterar.php" style='color: #ffffff'>Editar</a></button>
    -
    <button class="btn btn-outline-success" type="button"><a href="pagina_usuario.php?sair=true" style='color: #ffffff'>Sair</a></button>
  </form>
  </nav>
</div>
        
        <div class="container">
           
            <br><br><br>

            <center>

            <h2>Seja bem vindo <?php echo $_SESSION["nome"]; ?> </h2> 

            <br>

            <?php echo "<img src='../img/".$_SESSION["foto"]."' width='320' height='180'/>"; ?>

        </center>

             <br><br><br>

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
                <img id="output" width="100" src="../fotos/<?php echo $fotoapg; ?>"">
<br><br>
                
                <label>Nome</label>
            <input type="TEXT" name="nome" value="<?php echo $nome; ?>" class="form-control" required/>
            <div class="invalid-feedback">Digite o nome da imagem</div>
            <div class="valid-feedback">Obrigado</div>

            <br><br>

                <input type="SUBMIT" name="enviar" class="btn btn-success"/>

            </form>

            <br><br><br>

        <h2> Fotos cadastradas </h2>

        <table class="table table-striped table-dark">
  <thead class="thead-dark">
    <tr>
      <th scope="col">#</th>
      <th scope="col">Foto</th>
      <th scope="col">Nome</th>
      <th scope="col">Baixar</th>
      <th scope="col">Excluir</th>
      <th scope="col">Alterar</th>
    </tr>
  </thead>
  <tbody>
    <?php

    $num = 0;

    foreach($fotos as $linha) {

        

        $num++;

        echo "<tr>";

        echo "<th scope='row'>".$num."</th>";

        echo "<td><img src='../fotos/".$linha['nome_arquivo']."' width='80' height='45'></td>";

        echo "<td><button type='button' class='btn btn-info'>".$linha['nome']."</button></td>";

        echo "<td>"."<button type='button' class='btn btn-success'><a download=".$linha['nome']." href='../fotos/".$linha['nome_arquivo']."' title='ImageName' style='color: #ffffff'>Baixar</a></button>"."</td>";

        echo "<td>"."<button type='button' class='btn btn-success'><a href='javascript:excluir(".$linha['id'].")' style='color: #ffffff'> Excluir</a></button>"."</td>";

        echo "<td>"."<button type='button' class='btn btn-success'><a href='javascript:alterar(".$linha['id'].")' style='color: #ffffff'> Alterar</a></button>"."</td>";

        echo "</tr>";

    }

    ?>
  </tbody>
</table>

<br><br>

<hr>

        </div>
    </body>
</html>