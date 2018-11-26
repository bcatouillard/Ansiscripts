<?php

$directory = getcwd()."/";

$result = shell_exec("crontab -l | grep 'connect_db.php' ");
if(!empty($grep)){
	shell_exec("crontab < <(crontab -l; echo '5 * * * * /home/cli/connect_db' ");
}

$conn = new mysqli("localhost","root","btsinfo", "Ansible");

if($conn->connect_error){
	die("ERREUR: Impossible de se connecter : " . $conn->connect_error);
}

echo "\n*****Connecté*****\n\n";

require_once($directory."getData.php");
addPoste($conn);
getTasks($conn);

$conn->close();
?>
