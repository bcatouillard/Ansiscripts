<?php

$conn = new mysqli("localhost", "root", "btsinfo", "Ansible"); //On initialise une variable avec les identifiants afin de permettre la connexion à la base de donnée.

if($conn->connect_error){ // On vérifie si la connexion fonctionne ou non
    die("Erreur : Impossible de se connecter : " . $conn->connect_error // Ferme le script et affiche les erreurs de connexion
}

// Sinon on est connecté

$directory = "/home/cli/"; // On associe à une variable le répertoire où se situe l'ensemble des scripts

include($directory.".php") // On exécute le script qui s'occupera de récupérer les différentes commandes à effectuer sur les postes.

$conn->close(); // On ferme la connexion à la base de donnée.

?>