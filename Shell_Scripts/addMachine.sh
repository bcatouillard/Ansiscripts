#!/bin/bash

if [ $# -ne 3 ] #Récupération du nombre de parametre + verification quelle y sont
then
  echo "Utilisation : $0 <IP> <Mot de passe> <Nom de la machine>"
else
  echo "Communication avec la nouvelle machine.. "
  ping $1 -c 1
  if [ $? -eq 0  ] #Si la dernière commande ses correctement executer...
  then
    echo "Envoie de la clé privée vers la nouvelle machine... "
    ./co.sh $1 $2
    echo "Ajout de la machine vers le fichier hosts de ansible.... "
    echo "$3 ansible_host=$1">>/etc/ansible/hosts
    echo "done"
  else
    echo "La machine: $3, n'est pas sur le réseaux !"
  fi
fi
