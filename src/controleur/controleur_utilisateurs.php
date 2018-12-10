<?php

function actionUtilisateurs($twig, $db){
    $form = array(); 
    $utilisateur = new Utilisateur($db);
    $liste = $utilisateur->select();
        if(isset($_GET['rank'])){
            if(isset($_GET['pseudo'])){
                if($_GET['rank'] == "up"){
                    $user = $utilisateur->selectByEmail($_GET['pseudo']);
                    $role = $user['idRole']-1;
                    $exec = $utilisateur->updateRole($role, $_GET['pseudo']);
                    if(!$exec){
                        $form['valide'] = false;
                        $form['message'] = "Problème de modification du rôle";
                    }
                    else{
                        header("Location:index.php?page=utilisateurs");
                        exit;
                    }
                }
                else{
                    $user = $utilisateur->selectByEmail($_GET['pseudo']);
                    $role = $user['idRole']+1;
                    $exec = $utilisateur->updateRole($role, $_GET['pseudo']);
                    if(!$exec){
                        $form['valide'] = false;
                        $form['message'] = "Problème de modification du rôle";
                    }
                    else{
                        header("Location:index.php?page=utilisateurs");
                        exit;
                    }
                }
            }
        }
        if(isset($_GET['email'])){
            $exec=$utilisateur->delete($_GET['email']);
            if (!$exec){
                $form['suppression'] = false;
                $form['valide'] = false;  
                $form['message'] = 'Problème de suppression dans la table utilisateur'; 
            }
            else{
                header("Location:index.php?page=utilisateurs");
                exit;
            } 
        }
    echo $twig->render('utilisateur.html.twig', array('liste'=>$liste));
}

function actionUtilisateurModif($twig, $db){
    $form = array();
    if(isset($_GET['email'])){
        $utilisateur = new Utilisateur($db);
        $unUtilisateur = $utilisateur->selectByEmail($_GET['email']);  
        if ($unUtilisateur!=null){           
            $role = new Role($db);
            $form["roles"] = $role->select();
            $form['utilisateur'] = $unUtilisateur;
            $form['valide'] = true;
        }
        else{
            $form['message'] = 'Utilisateur incorrect';  
            $form['valide'] = false;
        }
    }
    if(isset($_POST['btModifier'])){
            $utilisateur = new Utilisateur($db);
            $email = $_POST['inputEmail'];
            $identifiant = $_POST['inputIdentifiant'];
            $mdp = $_POST['inputMdp'];
            $mdp2 = $_POST['inputMdp2'];
            $role = $_POST['role'];
            if(!empty($mdp)){
                if($mdp == $mdp2){
                    $exec=$utilisateur->update($email, password_hash($mdp,PASSWORD_DEFAULT), $identifiant, $role);
                    if(!$exec){
                        $form['conclure'] = false;  
                        $form['message'] = 'Échec de la modification'; 
                    }
                    else{
                        $form['conclure'] = true;  
                        $form['message'] = 'Modification réussie';   
                    }
                }
                else{
                    $form['conclure'] = false;
                    $form['message'] = 'Mot de passe non identiques';   
                }
            }
            else{
                $form['conclure'] = false;
                $form['message'] = 'Mot de passe vide';   
            }
        }
    
    echo $twig->render('utilisateur-modif.html.twig', array('form'=>$form));
}

?>