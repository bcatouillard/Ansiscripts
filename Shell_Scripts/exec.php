<?php
  $liste = array();
  $id = 0;

  //Variable url des documents/scripts
  $docUrlPoste = "/var/www/html/donnee.xml"; //fichier xml des postes
  $docUrlCmd = "/var/www/html/donnee.xml";  //fichier xml des commandes
  $urlScript = "/home/cli/script"; //dossier des scripts


  $doc = new DOMDocument();

  $doc->formatOutput = TRUE;

  //changement de dossier pour l'execution des script
  $ph = getcwd();  //Permets de recupérer le dossier dans le quel ce situe ce script php
  chdir($ph.'/../script'); //A remplacer par $urlScript


//XML : Poste a ajouter

  $doc->load( $docUrlPoste );


  $poste = $doc->getElementsByTagName("Poste");

  foreach($poste as $poste)
  {
    $liste[$id]['ip'] = $poste->getElementsByTagName('IP')->item(0)->nodeValue;
    $liste[$id]['nom'] = $poste->getAttribute('nom');

    $ip = $liste[$id]['ip']; $nom = $liste[$id]['nom'];

   //Execution du script d'ajout

    //Execution du script
    $output = shell_exec('./addMachine.sh '.$ip.' btsinfo '.$nom.'');

    //Affichage des sortie (DEBUGAGE)
    echo $output;

    $id++;
  }


//XML : Commande a executer


  $doc->load( $docUrlCmd );

  $cmd = $doc->getElementsByTagName("Commande");


  foreach($cmd as $cmd)
  {
     //Recuperation des donnees
     $nom = $cmd->getAttribute('nom');
     $commande = $cmd->$getElementsByTagName('cmd')->item(0)->nodeValue;


     // '' au niveau de $commande important pour avoir que 2 parametre

     $output = shell_exec("./exeCmd ".$nom."  '".$commande."'");
     echo $output;
  }


  return $liste;  //peut-être utile a une future mise en place de fichiers logs...
?>
