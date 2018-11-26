<?php

function actionCommandes($twig, $db)
{
    $commande = new Commande($db);
    
    $liste = array();
    $form = array();
    
    if( isset($_POST['btAjout']) )
    {
        
        $cmd = $_POST['cmd'];
        $descriptif = $_POST['descriptif'];
        
        $exec = $commande->insert($descriptif, $cmd);
        
        if(!$exec)
        {
            $form['valide'] = false;
            $form['message'] = "Erreur lors de l'Ajout de la commande ".$cmd;
        }
    }
    
    //Supp
    if( isset($_GET['supp']) )
    {
        $form['valide'] = true;
        $form['message'] = "la commande : ".$_GET['supp']." a bien était supprimée";
            
        $exec = $commande->delete($_GET['supp']);
        
        if(!$exec)
        {
            $form['valide'] = false;
            $form['message'] = "erreur lors de la suppresion";
        }
    }
    
    $liste['commande'] = $commande->select();
    
    echo $twig->render('commandes.html.twig', array('liste'=>$liste));
}

function actionModCommande($twig, $db)
{
    $commande = new Commande($db);

    $form = array();
    

    if( isset($_GET['id']) )
    {
        $form['id'] = $_GET['id'];
      
    }
    
    //Modification
    if(isset($_POST['btModifier']))
    {
        $descriptif = $_POST['descriptif'];
        $cmd = $_POST['cmd'];
                
        $id= $form['id'];
        
        $exec = $commande->update($descriptif, $cmd,$id);
        

        
        if(!$exec)
        {
            $form['valide'] = false;
            $form['message'] = "Erreur lors de la modification de la commande";
        }else{
            $form['valide'] = true;
            $form['message'] = "Modification réussi";
        }
    }
    
    if( isset($form['id']) )
    {
        $uneCommande = $commande->selectByID($form['id']); 
        
        $form['commande'] = $uneCommande;
        $form['valide'] = true;
        
        if ($uneCommande==null)
        {           
            $form['message'] = 'Commande incorrect';  
            $form['valide'] = false;
        }
    }
    
    echo $twig->render('commande-modif.html.twig', array('form' =>$form));    
}

?>