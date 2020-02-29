<?php
Class Utilisateur{
    private $db;
    private $insert;
    private $connect;
    private $select;
    private $update;
    private $delete;
    private $selectByEmail;
    private $updateRole;
    
    public function __construct($db) {
        $this->db = $db;
        $this->insert = $db->prepare("insert into utilisateur(email, mdp, identifiant, idRole) values(:email, :mdp, :identifiant, :idRole)");
        $this->connect = $db->prepare("select email, idRole, mdp from utilisateur where email=:email or identifiant=:identifiant");
        $this->select = $db->prepare("select * from utilisateur u inner join role r on u.idRole=r.id order by idRole, identifiant");
        $this->update = $db->prepare("update utilisateur set email=:email, mdp=:mdp, identifiant=:identifiant, idRole=:idRole where email=:email");
        $this->delete = $db->prepare("delete from utilisateur where email=:email");
        $this->selectByEmail = $db->prepare("select * from utilisateur u inner join role r on u.idRole=r.id where email=:email or identifiant=:email");
        $this->updateRole = $db->prepare("update utilisateur set idRole=:idRole where identifiant=:identifiant");
    }
    
    public function insert($email, $mdp, $identifiant, $role){ 
        $r = true;
        $this->insert->execute(array(':email'=>$email, ':mdp'=>$mdp, ':identifiant'=>$identifiant, ':idRole'=>$role));
        if ($this->insert->errorCode()!=0){
             print_r($this->insert->errorInfo());  
             $r=false;
        }
        return $r;
    }
    
    public function connect($connexion){  
        $unUtilisateur = $this->connect->execute(array(':email'=>$connexion, 'identifiant'=>$connexion));
        if ($this->connect->errorCode()!=0){
             print_r($this->connect->errorInfo());  
        }
        return $this->connect->fetch();
    }
    
    public function select(){
        $liste = $this->select->execute();
        if ($this->select->errorCode()!=0){
             print_r($this->select->errorInfo());  
        }
        return $this->select->fetchAll();
    }
    
    public function update($email,$mdp, $identifiant, $idRole){
        $r = true;
        $this->update->execute(array(':email'=>$email,':mdp'=>$mdp, ':identifiant'=>$identifiant, ':idRole'=>$idRole));
        if ($this->update->errorCode()!=0){
             print_r($this->update->errorInfo());  
             $r=false;
        }
        return $r;
    }
    
    public function delete($email){
        $r = true;
        $this->delete->execute(array(':email'=>$email));
        if ($this->delete->errorCode()!=0){
             print_r($this->delete->errorInfo());  
             $r=false;
        }
        return $r;
    }
    
    public function selectByEmail($email){
        $liste = $this->selectByEmail->execute(array(':email'=>$email));
        if ($this->selectByEmail->errorCode()!=0){
             print_r($this->selectByEmail->errorInfo());  
        }
        return $this->selectByEmail->fetch();
    }
    
    public function updateRole($idRole, $identifiant){
        $r = true;
        $this->updateRole->execute(array(':idRole'=>$idRole, ':identifiant'=>$identifiant));
        if ($this->updateRole->errorCode()!=0){
             print_r($this->updateRole->errorInfo());  
             $r=false;
        }
        return $r;
    }
}
?>