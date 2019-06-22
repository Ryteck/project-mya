<?php

class Usuario {
    
    private $conexao;
    
    function __construct() {
        $this->conexao = Conexao::getInstance();
    }
    
    public function copiarImg($arquivo, $id){
        $tmpName = $arquivo['tmp_name'];
        $nome = $arquivo['name'];
        $extensao = pathinfo($nome , PATHINFO_EXTENSION);
        $novoNome = sha1($id . $nome) . '.' . $extensao;

        $dir = '../img/';
        move_uploaded_file($tmpName, $dir . $novoNome);

        $this->conexao->getConnection()->query("UPDATE usuario SET foto = '".$novoNome."' WHERE ID=".$id);
    }

    public function logar($login, $senha){

        $logado = false;

        $conexao = Conexao::getInstance();

        $resultado = $conexao->getConnection()->query("SELECT * FROM usuario WHERE usuario = '$login' AND senha = '$senha'") or die ($conexao->getConnection()->error);

        if (mysqli_num_rows ($resultado) == 1) {
           
            $dados = mysqli_fetch_assoc($resultado);

            session_destroy();

            session_start();
            $_SESSION["ID"] = $dados["id"];
            $_SESSION["nome"] = $dados["nome"];
            $_SESSION["usuario"] = $dados["usuario"];
            $_SESSION["log"] = "ativo";
            $_SESSION["foto"] = $dados["foto"];
            $logado = true;


        }

        return $logado;

    }

    public function salvar($nome, $usuario, $senha, $arquivo){
        
        $this->conexao->getConnection();
        
        $this->conexao->getConnection() ->query("INSERT INTO usuario (nome, usuario, senha) VALUES ('$nome', '$usuario', '$senha')") or die($this->conexao->getConnection()->error);
        
        $id = $this->conexao->getConnection()->insert_id;

        $this->copiarImg($arquivo, $id);

    }

    public function salvarAdmin($nome, $usuario, $senha, $arquivo){
        
        $this->conexao->getConnection();
        
        $this->conexao->getConnection() ->query("INSERT INTO usuario (nome, usuario, senha) VALUES ('$nome', '$usuario', '$senha')") or die($this->conexao->getConnection()->error);
        
        $id = $this->conexao->getConnection()->insert_id;

        $this->copiarImg($arquivo, $id);

    }

    public function selecionarTodos (){

    	$resultado = $this->conexao->getConnection() ->query("SELECT * FROM usuario") or die($this->conexao->getConnection()->error);
        return $resultado;
    	
    }

    public function selecionarUsuario($id){

        $resultado = $this->conexao->getConnection() ->query("SELECT * FROM usuario WHERE id=".$id) or die($this->conexao->getConnection()->error);
        return $resultado;

    }

    public function excluir ($id){

        $caminhoImg = mysqli_fetch_row($this->conexao->getConnection()->query("SELECT foto FROM usuario WHERE ID=$id")) or die ($this->conexao->getConnection()->error);

        unlink('../img/'.$caminhoImg[0]);

        $this->apagarFotos($id);

        $this->conexao->getConnection()->query("DELETE FROM usuario WHERE id=$id") or die($this->conexao->getConnection()->error);

    }
 
    public function alterar($id, $nome, $usuario, $senha, $imagem){

        $conexao = Conexao::getInstance();

       $this->conexao->getConnection() ->query("UPDATE usuario SET nome='".$nome."', usuario='".$usuario."', senha='".$senha."' WHERE id=".$id) or die($this->conexao->getConnection()->error);

       if($imagem['name'] != null){

        $caminhoImg = mysqli_fetch_row($this->conexao->getConnection()->query("SELECT foto FROM usuario WHERE ID=$id")) or die($this->conexao->getConnection()->error);

        unlink('../img/'.$caminhoImg[0]);

        $this->copiarImg($imagem, $id);

       }
        
        $this->logar($usuario, $senha);

    }

    public function alterarAdmin($id, $nome, $usuario, $senha, $imagem){

       $this->conexao->getConnection() ->query("UPDATE usuario SET nome='".$nome."', usuario='".$usuario."', senha='".$senha."' WHERE id=".$id) or die($this->conexao->getConnection()->error);

       if($imagem['name'] != null){

        $caminhoImg = mysqli_fetch_row($this->conexao->getConnection()->query("SELECT foto FROM usuario WHERE ID=$id")) or die($this->conexao->getConnection()->error);

        unlink('../img/'.$caminhoImg[0]);

        $this->copiarImg($imagem, $id);

       }

       if ($nome == admin) {
        
        $this->logar($usuario, $senha);

       }

    }

    public function apagarFotos($id){

        $resultado = $this->conexao->getConnection() ->query("SELECT * FROM imagem WHERE idusuario=$id") or die($this->conexao->getConnection()->error);

        foreach ($resultado as $linha) {
                $nome = $linha['nome_arquivo'];
                unlink('../fotos/'.$nome);
            }
    }

    public function contarUSU(){

        $resultado = mysqli_fetch_row($this->conexao->getConnection() ->query("SELECT COUNT(id) FROM usuario")) or die($this->conexao->getConnection()->error);

    return $resultado[0];

    }

}

?>