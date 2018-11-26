<?php
function getTasks($conn){
    $type = "Commandes";
    $directory = getcwd()."/fichiers/tasks/";
    $filename = "cmd.xml";
    $query = "SELECT ipPoste, poste.nom, commande.cmd FROM executer inner join commande on executer.idCommande=commande.id inner join poste on executer.ipPoste=poste.adresseIP;";
    xmlConvert($conn, $directory, $filename, $query, $type);
}

function addPoste($conn){
    $type = "Poste";
    $directory = getcwd()."/fichiers/postes/";
    $filename = "poste.xml";
    $query = "SELECT adresseIP, nom FROM poste";
    xmlConvert($conn, $directory, $filename, $query, $type);
}

function xmlConvert($conn, $directory, $filename, $query, $type){
	$result =  $conn->query($query);
	$data = $result->fetch_assoc();
	$xml = new SimpleXMLElement('<'.$type.'/>');
	foreach ($data as $key => $value) {
		$xml->addChild($key, $value);
	}
	if(!is_dir($directory)){
	    shell_exec("mkdir $directory");
	}
	$file = fopen($directory.$filename, 'w');
	fwrite($file, $xml->asXML());
	fclose($file);
        
}
?>
