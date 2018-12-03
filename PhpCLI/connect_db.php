<?php

$directory = getcwd()."/"; // Obtient le dossier 

$result = shell_exec("crontab -l | grep 'connect_db.php' "); // On ajoute le résultat dans $result
if(!empty($grep)){ // Si $grep est vide
	shell_exec("crontab < <(crontab -l; echo '5 * * * * /home/cli/connect_db' "); // Ajout dans crontab du script à exécuter
}
try{
    $config['serveur']='localhost'; // Adresse du serveur de BDD
    $config['login'] = 'root'; // Identifiant de connexion à la BDD
    $config['mdp'] ='btsinfo'; // Mot de passe de la BDD
    $config['bd'] = 'Ansible'; // Nom de la BDD
    $conn = new PDO('mysql:host='.$config['serveur'].';dbname='.$config['bd'],$config['login'],$config['mdp']); // Connexion à la BDD
}
catch(Exception $e){ // Si on attrape une erreur alors
  $conn = NULL; // On met la variable de connexion à null
  echo "\n*****Erreur de Connexion*****\n\n"; // On affiche une erreur
}

echo "\n*****Connecté*****\n\n"; // Affiche que nous sommes connectés à la base de donnée

if($conn != null){ // On vérifie que la connexion est différente de null
    require_once($directory."getData.php"); // Importe le fichier getData.php
    getData::addPoste($conn); // Appel à la fonction addPoste du fichier getData.php
    getData::getTasks($conn); // Appel à la fonction getTasks du fichier getData.php
}

?> 
