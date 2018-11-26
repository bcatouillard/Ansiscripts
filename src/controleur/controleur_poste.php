<?php

function actionPoste($twig, $db){  
    $poste = new Poste($db);
    $fonction = new Fonction($db);
    
    $liste = array();
    $form = array();
    
    if( isset($_POST['btMod']) )
    {
        if($_POST['fonc'] == "null")
        {
            header("Location: index.php?page=fonctions");
        }
        
        $fonc = $_POST['fonc'];
        $nom = $_POST['nom'];
        $ip = $_POST['ip'];
        
        $exec = $poste->insert($ip, $nom, $fonc);
        
        if(!$exec)
        {
            $form['valide'] = false;
            $form['message'] = "Erreur lors de l'Ajout de la machine ".$nom;
        }
    }
    
    //Supp
    if( isset($_GET['supp']) )
    {
        $form['valide'] = true;
        $form['message'] = "la machine : ".$_GET['supp']." a bien était supprimée";
            
        $exec = $poste->delete($_GET['supp']);
        
        if(!$exec)
        {
            $form['valide'] = false;
            $form['message'] = "erreur lors de la suppresion";
        }
    }
    
    
    //Liste
    $liste['poste'] = $poste->select();
    $liste['fonction'] = $fonction->select(); 
    
    echo $twig->render('postes.html.twig', array('liste'=>$liste, 'form'=>$form));
}

function actionModPoste($twig, $db)
{
    $poste = new Poste($db);
    $fonction = new Fonction($db);
    
    $form = array();
    

    if( isset($_GET['ip']) )
    {
        $form['ip'] = $_GET['ip'];
    }
    
    //Modification
    if(isset($_POST['btModifier']))
    {
        $ip = $_POST['ip'];
        $nom = $_POST['nom'];
        $idFonc = $_POST['fonc'];
        
        $exec = $poste->update($ip, $nom, $idFonc, $form['ip']);
        
        $form['ip'] = $ip;
        
        if(!$exec)
        {
            $form['valide'] = false;
            $form['message'] = "Erreur lors de la modification du poste";
        }else{
            $form['valide'] = true;
            $form['message'] = "Modification réussi";
        }
    }
    
    
    //Recup des donnees via BdD
    if( isset($form['ip']) )
    {
        $unPoste = $poste->selectByID($form['ip']); 
        $form['fonction'] = $fonction->select();
        
        $form['poste'] = $unPoste;
        $form['valide'] = true;
        
        if ($unPoste==null)
        {           
            $form['message'] = 'Poste incorrect';  
            $form['valide'] = false;
        }
    }
    
    echo $twig->render('poste-modif.html.twig', array('form' =>$form));
}
?>