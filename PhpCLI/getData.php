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
            	$result =  $conn->query($query);
            	$data = $result->fetchAll();
		
                $xml = new DOMDocument();
                $xml->formatOutput = TRUE;
                
                if($data != null){
                    $xml_type = $xml->createElement($type);
                    if($type == "Postes"){
                        foreach ($data as $key => $value) {
                            $xml_poste = $xml->createElement("Poste");
                            $xml_poste->setAttribute( "nom", $value['nom'] );
                            $xml_ip = $xml->createElement("adresseIP", $value['adresseIP']);
                            $xml_poste->appendChild($xml_ip);
                            $xml_type->appendChild($xml_poste);
                            $xml->appendChild($xml_type);
                        }
                    } else{
                        foreach ($data as $key => $value) {
                            var_dump($value);
                            $xml_cmd = $xml->createElement("Commande");
                            $xml_cmd->setAttribute( "cmd", $value['cmd'] );
                            $xml_ip = $xml->createElement("adresseIP", $value['ipPoste']);
                            $xml_cmd->appendChild($xml_ip);
                            $xml_type->appendChild($xml_cmd);
                            $xml->appendChild($xml_type);
                        }
                    }
                    
                    if(!is_dir($directory)){
                                shell_exec("mkdir $directory");
                    }
                    
                    $xml->save($directory.$filename);
                }
    }
}
?>

