<?php
require_once './db/DB.php';


/**
 * Description of Mural
 * Class para guardar e ler mensagens da BD
 * @author pedro
 */
class Mural {
    private $db;
    public function __construct() {
        $this->db = new DB();
    }
    
    public function getMuralUsers() {
        return $this->db->query("SELECT * from cad_utilizadores where mural=1 and ativo=1 AND tipo IN('Analista', 'Administrador', 'Gestor', 'GExterno')");
    }
    
    /**
     * 
     * @param type $userId
     * @return type
     */
    public function getMsg($userId) {
        return $this->db->query("SELECT M.*, U.nome AS userorigem, U1.nome AS userdestino FROM mural M "
        . " INNER JOIN cad_utilizadores U ON U.id=M.origem "
        . " INNER JOIN cad_utilizadores U1 ON U1.id=M.destino "
        . " WHERE  (M.destino=:user OR M.origem=:user) AND (DATEDIFF(DATE(NOW()),DATE(M.dataenvio))<5) ORDER BY M.dataenvio", array('user'=>$userId));
    }

    /**
     * 
     * @param type $origem
     * @param type $destino
     * @param type $assunto
     * @return type
     */
    public function sendMsg( $origem, $destino, $assunto) {
        return $this->db->query("INSERT INTO mural(origem, destino, assunto, dataenvio, status) VALUES(:origem, :destino, :assunto, NOW(), 0 ) ", 
                array(':origem'=>$origem, ':destino'=>$destino, ':assunto'=>$assunto));
    }    
}
