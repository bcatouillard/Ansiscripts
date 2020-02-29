<?php

function actionTypes($twig, $db)
{
    $form = array();
    $types = new Types($db);
        
    if( isset($_POST['btAdd']) )
    {
        $libelle = $_POST['inputLibelle'];
        
        $exec = $types->insert($libelle);
    }
    

    $liste = $types->select();
    echo $twig->render('types.html.twig', array('form'=>$form,'liste'=>$liste));
}

function actionModifType($twig, $db)
{
    $form = array();
    
    if( isset($_GET['id']) )
    {
        $types = new Types($db);
        
        $unTypes = $types->selectByID($_GET['id']);  
        if ($unTypes!=null)
        {
            $form['type'] = $unTypes;
        }else{
            $form['message'] = 'Type incorrect';  
        }
    }else{
        if(isset($_POST['btModifier']))
        {
            $types = new Types($db);
            $libelle = $_POST['libelle'];
            $id = $_POST['id'];
            
            $exec=$types->update($id,$libelle);
            
            if(!$exec)
            {
                $form['valide'] = false;  
                $form['message'] = 'Échec de la modification'; 
            }else{
                $form['valide'] = true;  
                $form['message'] = 'Modification réussie';  
            }
        }else{
            $form['message'] = 'Type non précisé';  
        }
    }
    
    
    echo $twig->render('modifType.html.twig', array('form'=>$form));
}
?>

