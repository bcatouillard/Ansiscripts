// Script permettant la récupération des commandes à faire sur nos machines.
<?php
function getTasks($conn){
    $directory = "/home/cli/fichiers/"; // Variable à laquelle on associe le répertoire concernant les fichiers concernant les postes et commandes à effectuées.
    $filename = "cmd.json";
    $query = "SELECT ipPoste, poste.nom, commande.cmd FROM executer inner join commande on executer.idCommande=commande.id inner join poste on executer.ipPoste=poste.adresseIP;"; // Variable à laquelle on associe la requête
    jsonParsing($conn, $directory, $filename, $query); // On appelle la fonction jsonParsing
}

function addPoste($conn){
    $directory = "/home/cli/postes/"; // Variable à laquelle on associe le répertoire concernant les fichiers des postes
    $filename = "poste.json"; // Variable à laquelle on associe le nom du fichier
    $query = "SELECT adresseIP, nom FROM poste"; // Variable à laquelle on associe la requête
    jsonParsing($conn, $directory, $filename, $query); // On appelle la fonction jsonParsing
}

function jsonParsing($conn, $directory, $filename, $query){
    $result = $conn->query($query); // On asssocie à la variable $result le résultat de la requête
    $ligne = $result->fetch_assoc(); // La variable $ligne récupère la valeur de $result mais sous forme d'un tableau associatif
    
    if(!is_dir($directory)){ // On vérifie si le répertoire où l'on va mettre nos fichiers existe
        shell_exec("mkdir $directory"); // S'il n'existe pas on le crée 
    }
    
    $json = json_encode($ligne); // On encode nos résultats de la requête en JSON
    shell_exec("echo $json >>". $directory.$filename); // On l'écrit dans un fichier
}
?>