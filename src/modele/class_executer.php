<?php
class executer{
    private $db;
    private $select;
    private $insert;
    private $update;
    private $delete;
    private $selectById;
    
    public function __construct($db) {
        $this->db = $db;
        $this->select =$db->prepare("select * from executer inner join poste on executer.ipPoste=poste.adresseIP inner join commande on executer.idCommande=commande.id");
        $this->insert = $db->prepare("insert into executer(ipPoste, idCommande) values(:ipPoste, :idCommande)");
        $this->update = $db->prepare("update executer set ipPoste=:ipPoste, idCommande=:idCommande");
        $this->delete = $db->prepare("delete from executer where ipPoste=:ipPoste and idCommande=:idCommande");
        $this->selectById = $db->prepare("select * from executer inner join poste on executer.ipPoste=poste.adresseIP inner join commande on executer.idCommande=commande.id where ipPoste=:ipPoste and idCommande=:idCommande");
    }
    
    public function select(){
        $this->select->execute();
        if ($this->select->errorCode()!=0){
             print_r($this->select->errorInfo());  
        }
        return $this->select->fetchAll();
    }
    
    public function insert($ipPoste, $idCommande){
        $r = true;
        $this->insert->execute(array(':ipPoste'=>$ipPoste, ':idCommande'=>$idCommande));
        if ($this->insert->errorCode()!=0){
             print_r($this->insert->errorInfo());  
             $r=false;
        }
        return $r;
    }
        
    public function update($ipPoste, $idCommande){
       $r = true;
       $this->update->execute(array(':ipPoste'=>$ipPoste,':idCommande'=>$idCommande));
       if ($this->update->errorCode()!=0){
             print_r($this->update->errorInfo());
             $r=false;
       }
        
       return $r;
    }
    
    
    public function Delete($ipPoste, $idCommande){
        $r = true;
        $this->delete->execute(array(':ipPoste'=>$ipPoste,':idCommande'=>$idCommande));
        if ($this->delete->errorCode()!=0){
             print_r($this->delete->errorInfo());  
             $r=false;
        }
        return $r;
    } 
    
    public function selectById($ipPoste, $idCommande){
        $this->selectById->execute(array('ipPoste'=>$ipPoste, 'idCommande'=>$idCommande));
        if ($this->selectById->errorCode()!=0){
             print_r($this->selectById->errorInfo());  
        }
        return $this->selectById->fetch();
    }
}


 
    