<?php
function  getPage($db){
    $lesPages['accueil'] = "actionAccueil;0";
    $lesPages['connexion'] = "actionConnexion;0";
    $lesPages['deconnexion'] = "actionDeconnexion;0";
    $lesPages['inscription'] = "actionInscription;0";
    $lesPages['maintenance'] = "actionMaintenance";
    
    
    //panel admin
        //utilisateur
    $lesPages['utilisateurs'] = "actionUtilisateurs;1";
            //ModifUsers
    $lesPages['utilisateur-modif'] = "actionUtilisateurModif;1";   
        //Poste
            //Liste
    $lesPages['postes'] = "actionPoste;1";
            //Modif
    $lesPages['modifposte'] = "actionModPoste;1";
        //Commandes
    $lesPages['commandes'] = "actionCommandes;1";
    $lesPages['commande-modif'] = "actionModCommande;1";
        //Exécution de commande
    $lesPages['executer']= "actionExecuter;1";
    $lesPages['executer-modif']="actionModifExecuter;1";
    
    $contenu = $lesPages['accueil']; 
    
    if ($db!=null)
    {
        if(isset($_GET['page']))
        {
            $page = $_GET['page']; 
        }else{
            
            $page = 'accueil';
        }
        if (!isset($lesPages[$page]))
        {
            $page = 'accueil'; 
        }
        
        $explose = explode(";",$lesPages[$page]);
        $role = $explose[1];
        if ($role != 0)
        {
            if(isset($_SESSION['login']))
            {  
                if(isset($_SESSION['role']))
                {    
                    if($role!=$_SESSION['role'])
                    {
                        $contenu = 'actionAccueil';  
                    }else{
                        $contenu = $explose[0]; 
                    }
                }else{
                    $contenu = 'actionAccueil';   
                }
            }else{
                $contenu = 'actionAccueil';  
            }
        }else{
            $contenu = $explose[0];
        }
    }else{
        
        $contenu = $lesPages['maintenance'];
    }
    return $contenu; 
}
?>