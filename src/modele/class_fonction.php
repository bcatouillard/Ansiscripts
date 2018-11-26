<?php
Class Fonction{
    private $db;
    private $select;
    private $insert;
    private $update;
    private $delete;
    
    public function __construct($db) {
        $this->db = $db;
        $this->select = $db->prepare("select * from fonction");
    }
    
    public function select(){
        $this->select->execute();
        if ($this->select->errorCode()!=0){
             print_r($this->select->errorInfo());  
        }
        return $this->select->fetchAll();
    }
}
?>