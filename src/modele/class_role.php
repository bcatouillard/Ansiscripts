<?php
Class Role{
    private $db;
    private $select;
    private $insert;
    
    public function __construct($db){
        $this->db = $db;
        $this->select = $db->prepare("select * from role");
        $this->insert = $db->prepare("insert into role(libelle) values(:libelle)");
    }
    
    public function select(){
        $liste = $this->select->execute();
        if ($this->select->errorCode()!=0){
             print_r($this->select->errorInfo());  
        }
        return $this->select->fetchAll();
    }
    
    public function insert($libelle){ 
        $r = true;
        $this->insert->execute(array(':libelle'=>$libelle));
        if ($this->insert->errorCode()!=0){
             print_r($this->insert->errorInfo());  
             $r=false;
        }
        return $r;
    }
}
?>