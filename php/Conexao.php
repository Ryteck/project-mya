<?php

class Conexao {
    private $host = "";
    private $usuario = "";
    private $senha = "";
    private $bd = "";
    
    private static $_instance;
            
    public static function getInstance() {
    
        if (!self::$_instance){
            self::$_instance = new self();  
        }
        return self::$_instance;
        }
  
        private function __construct(){
            
            $this->_connection = new mysqli($this->host, 
                    $this->usuario, $this->senha, $this->bd);
        
            if (mysqli_connect_error()) {
                
                trigger_error("Erro MySQL: " . mysql_connect_error(),
                        E_USER_ERROR);
                
               }else{
                   //echo "CONECTOU!!!";
               }
               
            
    }
    
    private function __clone() {
       
    }
    
    public function  getConnection(){
        return $this->_connection;
    }
}

?>