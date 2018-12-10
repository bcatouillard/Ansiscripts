<?php
Class Commande{
    private $db;
    private $select;
    private $insert;
    private $update;
    private $delete;
    
    public function __construct($db) {
        $this->db = $db;
        $this->select = $db->prepare("select * from commande");
        $this->selectByID = $db->prepare("select * from commande WHERE id=:id");
        $this->insert = $db->prepare("insert into commande (descriptif, cmd) values(:descriptif, :cmd)");
        $this->update = $db->prepare("update commande set descriptif=:descriptif, cmd=:cmd where id=:id");
        $this->delete = $db->prepare("delete from commande where id=:id");
    }
    
    public function select(){
        $liste = $this->select->execute();
        if ($this->select->errorCode()!=0){
             print_r($this->select->errorInfo());  
        }
        return $this->select->fetchAll();
    }
    
    public function selectByID($id)
    {
        $this->selectByID->execute(array(':id'=>$id));
        if ($this->selectByID->errorCode()!=0){
             print_r($this->selectByID->errorInfo());  
        }
        return $this->selectByID->fetch();
    }
    
    public function insert($descriptif, $cmd){ 
        $r = true;
        $this->insert->execute(array(':descriptif'=>$descriptif, ':cmd'=>$cmd));
        if ($this->insert->errorCode()!=0){
             print_r($this->insert->errorInfo());  
             $r=false;
        }
        return $r;
    }
    
    public function update($descriptif,$cmd, $id){
        $r = true;
        $this->update->execute(array(':descriptif'=>$descriptif,':cmd'=>$cmd, ':id'=>$id));
        if ($this->update->errorCode()!=0){
             print_r($this->update->errorInfo());  
             $r=false;
        }
        return $r;
    }
    
    public function delete($id){
        $r = true;
        $this->delete->execute(array(':id'=>$id));
        if ($this->delete->errorCode()!=0){
             print_r($this->delete->errorInfo());  
             $r=false;
        }
        return $r;
    }
}
?>