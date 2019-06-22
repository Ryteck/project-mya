<?php

class Foto {
    
    private $conexao;
    
    function __construct() {
        $this->conexao = Conexao::getInstance();
    }

public function visualizar($id){

    $resultado = $this->conexao->getConnection() ->query("SELECT * FROM imagem WHERE id = '$id'") or die($this->conexao->getConnection()->error);
    return $resultado;

}

public function gerarIMG($arquivo, $iduser){

$tmpName = $arquivo['tmp_name'];
$nome = $arquivo['name'];
$extensao = pathinfo($nome , PATHINFO_EXTENSION);
$novoNome = sha1($id . $nome) . '.' . $extensao;

$dir = '../fotos/';
move_uploaded_file($tmpName, $dir . $novoNome);

return $novoNome;

}

public function deletarIMG($id){

    $caminhoImg = mysqli_fetch_row($this->conexao->getConnection()->query("SELECT nome_arquivo FROM imagem WHERE ID=$id")) or die($this->conexao->getConnection()->error);

        unlink('../fotos/'.$caminhoImg[0]);

        $this->conexao->getConnection()->query("DELETE FROM imagem WHERE id=$id") or die($this->conexao->getConnection()->error);

}

public function contarIMG($iduser){

$resultado = mysqli_fetch_row($this->conexao->getConnection() ->query("SELECT COUNT(nome_arquivo) FROM imagem WHERE idusuario = '$iduser'")) or die($this->conexao->getConnection()->error);

return $resultado[0];

}

public function alterarIMG($arquivo, $iduser, $nome, $id){

    $this->conexao->getConnection() ->query("UPDATE imagem SET nome='".$nome."' WHERE id=".$id) or die($this->conexao->getConnection()->error);

$caminhoImg = mysqli_fetch_row($this->conexao->getConnection()->query("SELECT nome_arquivo FROM imagem WHERE ID=$id")) or die($this->conexao->getConnection()->error);

        unlink('../fotos/'.$caminhoImg[0]);

        $novoNome = $this->gerarIMG($arquivo, $iduser);

        $this->conexao->getConnection()->query("UPDATE imagem SET nome_arquivo = '".$novoNome."' WHERE ID=".$id);

}

public function visualizarAllIMG($iduser){

    $resultado = $this->conexao->getConnection() ->query("SELECT * FROM imagem WHERE idusuario = '$iduser'") or die($this->conexao->getConnection()->error);
    return $resultado;
    
}

public function inserirIMG($nome, $arquivo, $id){

    $this->conexao->getConnection();

    $imgnome = $this->gerarIMG($arquivo, $id);

    $this->conexao->getConnection() ->query("INSERT INTO imagem (idusuario, nome, nome_arquivo) VALUES ('$id', '$nome', '$imgnome')") or die($this->conexao->getConnection()->error);
    
}

}

?>