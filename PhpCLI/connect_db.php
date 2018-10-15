<?php

$directory = "/home/cli/"; // On associe à une variable le répertoire où se situe l'ensemble des scripts

$result = shell_exec("grep 'connect_db.php' /etc/crontab"); // Vérifie si dans le fichier crontab on a le script de connexion à la base de donnée

if(!empty($result)){ // On vérifie si le résultat est vide
    shell_exec("echo '05 * * * * root php /home/cli/connect_db.php"); // Alors on ajoute la connexion à la base de donnée dans le crontab qui sera effectué toutes les 5 minutes.
}

$conn = new mysqli("localhost", "root", "btsinfo", "Ansible"); //On initialise une variable avec les identifiants afin de permettre la connexion à la base de donnée.

if($conn->connect_error){ // On vérifie si la connexion fonctionne ou non
    die("Erreur : Impossible de se connecter : " . $conn->connect_error); // Ferme le script et affiche les erreurs de connexion
}

// Sinon on est connecté

require_once($directory."get_tasks.php"); // On exécute le script qui s'occupera de récupérer les différentes commandes à effectuer sur les postes.

getTasks($conn); // On fait appel à la fonction se trouvant dans le fichier importé précédemment en lui transmettant la connexion à la base de donnée.

$conn->close(); // On ferme la connexion à la base de donnée.

?>