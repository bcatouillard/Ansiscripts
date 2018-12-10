<?php
function actionExecuter($twig, $db){
    $poste = new Poste($db);
    $listeposte = $poste->select();
    $cmd = new Commande($db);
    $listecmd = $cmd->select();
    $executer = new Executer($db);
    $liste = $executer->select();
    if(isset($_POST['btAjouter'])){
        $cmd = $_POST['commande'];
        $poste = $_POST['poste'];
        $exec = $executer->insert($poste, $cmd);
        if(!$exec){
            $form['valide'] = false;
            $form['message'] = "Erreur lors de l'insertion ";
        }
        header("Location:index.php?page=executer");
        exit;
    }
    if( isset($_GET['supp'])){
        $form['valide'] = true;
        $form['message'] = "Commande à exécuter supprimée";
        $exec = $poste->delete($_GET['supp'], $_GET['sup']);
        if(!$exec){
            $form['valide'] = false;
            $form['message'] = "Erreur lors de la suppression";
        }
    }
    echo $twig->render('executer.html.twig', array('liste'=>$liste,'poste'=>$listeposte,'commande'=>$listecmd));
}

function actionModifExecuter($twig,$db){
    $executer = new Executer($db);
    $poste = new Poste($db);
    $cmd = new Commande($db);
    $form=array();
    if(isset($_GET['ip']) && isset($_GET['cmd'])){
        $listeposte = $poste->select();
        $listecmd = $cmd->select();
        $cmdsEffectue = $executer->selectByID($_GET['ip'], $_GET['cmd']);
        $form['cmdeffect'] = $cmdsEffectue;
        if(isset($_POST['btModifier'])){
            $ip = $_POST['ip'];
            $cmd = $_POST['cmd'];
        }
    }
    echo $twig->render('executer-modif.html.twig', array('form'=>$form, 'commande'=>$listecmd, 'poste'=>$listeposte));
}
