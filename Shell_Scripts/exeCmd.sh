#!/bin/bash

if [ $# -ne 2 ]
then
  echo "Utilisation : $0 <Nom/IP de la machine> '<Commande>'"
else
  ansible $1 -a "$2"
fi
