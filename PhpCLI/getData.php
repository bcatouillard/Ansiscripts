<?php
Class getData {
    function getTasks($conn){
            $type = "Commandes"; // Type de donnée souhaitée
            $directory = getcwd()."/fichiers/tasks/"; // Répertoire où se trouve nos fichiers de données
            $filename = "cmd.xml"; // Nom du fichier où l'on va stocké nos données
            $query = "SELECT ipPoste, poste.nom, commande.cmd FROM executer inner join commande on executer.idCommande=commande.id inner join poste on executer.ipPoste=poste.adresseIP;";
            // Requête des données souhaitées
            getData::xmlConvert($conn, $directory, $filename, $query, $type); // Appel à la fonction xmlConvert
    }

    function addPoste($conn){
            $type = "Poste"; // Type de donnée souhaitée
            $directory = getcwd()."/fichiers/postes/"; // Répertoire où se trouve nos fichiers de données
            $filename = "poste.xml"; // Nom du fichier où l'on va stocké nos données
            $query = "SELECT adresseIP, nom FROM poste"; // Requête des données souhaitées
            getData::xmlConvert($conn, $directory, $filename, $query, $type); // Appel à la fonction xmlConvert
    }

    function xmlConvert($conn, $directory, $filename, $query, $type){
            	$result =  $conn->query($query); // Exécute la requête
            	$data = $result->fetchAll(); // Récupère tout les résultats et les stocke dans la variable $data
		
                $xml = new DOMDocument(); // Création d'un objet DOMDocument
                $xml->formatOutput = TRUE;
                
                if($data != null){ // On vérifie que le tableau n'est pas nul
                    $xml_type = $xml->createElement($type); // On crée un Element dans notre fichier XML qui correspond au type de donnée
                    if($type == "Postes"){ // On vérifie si le type vaut Postes
                        foreach ($data as $key => $value) {
                            $xml_poste = $xml->createElement("Poste"); // On crée un Element pour un Poste
                            $xml_poste->setAttribute( "nom", $value['nom'] ); // On lui attribue le nom du Poste
                            $xml_ip = $xml->createElement("adresseIP", $value['adresseIP']); // On crée un Element qui sera l'adresse IP
                            $xml_poste->appendChild($xml_ip); // On ajoute l'adresse IP du poste à $xml_poste 
                            $xml_type->appendChild($xml_poste); // On ajoute $xml_poste à $xml_type
                            $xml->appendChild($xml_type); // On ajoute $xml_type au fichier xml
                        }
                    } else{ // Si $type ne vaut pas Postes alors
                        foreach ($data as $key => $value) {
                            $xml_cmd = $xml->createElement("Commande"); // On crée un Element pour une commande
                            $xml_cmd->setAttribute( "cmd", $value['cmd'] ); // On lui ajoute la commande en attribut
                            $xml_ip = $xml->createElement("adresseIP", $value['ipPoste']); // On crée l'Element qui contient l'adresse IP
                            $xml_cmd->appendChild($xml_ip); // On ajoute l'ip à la commande
                            $xml_type->appendChild($xml_cmd); // On ajoute la commande au type
                            $xml->appendChild($xml_type); // Enfin on ajoute la commande au fichier XML
                        }
                    }
                    
                    if(!is_dir($directory)){ // Si notre dossier n'existe pas alors
                                shell_exec("mkdir $directory"); // On le crée
                    }
                    
                    $xml->save($directory.$filename); // On enregistre le fichier XML dans le dossier avec son nom
                }
    }
}
?>

