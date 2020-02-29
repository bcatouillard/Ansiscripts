<?php
function actionAccueil($twig){
    echo $twig->render('index.html.twig', array());
}

function actionConnexion($twig,$db){
    $form = array();
    if (isset($_POST['btConnecter'])){
        $form['valide'] = true;
        $connexion = $_POST['identifiant'];
        $form['identifiant']=$connexion;
        $inputPassword = $_POST['inputPassword'];
        $utilisateur = new Utilisateur($db);
        $unUtilisateur = $utilisateur->connect($connexion);
        if ($unUtilisateur!=null) {
            if(!password_verify($inputPassword,$unUtilisateur['mdp'])){
                $form['valide'] = false;
                $form['message'] = 'Login ou mot de passe incorrect';
            }else{
                $utilisateur = new Utilisateur($db);
                $p = $utilisateur->selectByEmail($connexion);
                $pseudo = $p['identifiant']; 
                echo $pseudo;
                $_SESSION['login'] = $pseudo;
                $_SESSION['role'] = $unUtilisateur['idRole'];
                header("Location:index.php");
                exit;
            }
        }else{
            $form['valide'] = false;
            $form['message'] = 'Login ou mot de passe incorrect';
        }
     }
     echo $twig->render('connexion.html.twig', array('form'=>$form));
}

function actionDeconnexion($twig){
    session_unset();
    session_destroy();
    header("Location:index.php");
    exit;
}

function actionInscription($twig,$db){
    $form = array();
    $role = new Role($db);
    $liste = $role->select();
    $form['roles']=$liste;
    if (isset($_POST['btInscrire'])){
        $inputEmail = $_POST['inputEmail'];
        $inputPassword = $_POST['inputPassword'];
        $inputPassword2 =$_POST['inputPassword2'];
        $identifiant = $_POST['identifiant'];
        $role = $_POST['role'];
        $form['valide'] = true;
        if ($inputPassword!=$inputPassword2)
        {
            $form['valide'] = false;  
            $form['message'] = 'Les mots de passe sont différents';
        }else{
            $utilisateur = new Utilisateur($db); 
            $exec = $utilisateur->insert($inputEmail, password_hash($inputPassword,PASSWORD_DEFAULT), $identifiant, $role);
            if (!$exec){
                $form['valide'] = false;  
                $form['message'] = 'Problème d\'insertion dans la table utilisateur ';  
            }
        }
        $form['identifiant'] = $identifiant;
        $form['role'] = $role;
    }
    echo $twig->render('inscription.html.twig', array('form'=>$form)); 
}


function actionMaintenance($twig){   
    echo $twig->render('maintenance.html.twig', array());
}
?>

