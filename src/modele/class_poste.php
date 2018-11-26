<?php
Class Poste{
    private $db;
    private $select;
    private $selectByID;
    private $insert;
    private $update;
    private $delete;
    
    public function __construct($db) 
    {
        $this->db = $db;
        $this->select = $db->prepare("select * from poste p inner join fonction f on p.idFonction = f.id order by p.nom, p.adresseIP");
        $this->selectByID = $db->prepare("select * from poste WHERE adresseIP=:id");
        
        $this->insert = $db->prepare("insert into poste(adresseIP, nom, idFonction) values(:adresseIP, :nom, :idFonction)");
        
        $this->update = $db->prepare("UPDATE poste SET adresseIP=:adresseIP, nom=:nom, idFonction=:idFonction WHERE adresseIP=:currentIP");
        
        $this->delete=$db->prepare("delete from poste where adresseIP=:adresseIP");
    }
    
    
    public function selectByID($id)
    {
        $this->selectByID->execute(array(':id'=>$id));
        if ($this->selectByID->errorCode()!=0){
             print_r($this->selectByID->errorInfo());  
        }
        return $this->selectByID->fetch();
    }
    
    
    public function select()
    {
        $this->select->execute();
        if ($this->select->errorCode()!=0){
             print_r($this->select->errorInfo());  
        }
        return $this->select->fetchAll();
    }
    
    
    
    public function insert($adresseIP, $nom, $idFonction)
    { 
        $r = true;
        $this->insert->execute(array(':adresseIP'=>$adresseIP, ':nom'=>$nom, ':idFonction'=>$idFonction));
        if ($this->insert->errorCode()!=0){
             print_r($this->insert->errorInfo());  
             $r=false;
        }
        return $r;
    }
    
    
    public function update($adresseIP,$nom, $idFonction, $cIP)
    {
        $r = true;
        
        $this->update->execute(array(':adresseIP'=>$adresseIP,':nom'=>$nom, ':idFonction'=>$idFonction, ':currentIP'=>$cIP));
        
        if ($this->update->errorCode()!=0){
             print_r($this->update->errorInfo());
             $r=false;
        }
        
        return $r;
    }
    
    
    public function delete($adresseIP)
    {
        $r = true;
        $this->delete->execute(array(':adresseIP'=>$adresseIP));
        if ($this->delete->errorCode()!=0)
        {
             print_r($this->delete->errorInfo());  
             $r=false;
        }
        return $r;
    }
}
?>