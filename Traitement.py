#!/usr/bin/env python3
#Code ecrit par Thomas Raynaud et Thomas Mirbey
#On importe les modules json et mysql.connector qui sont necessaires pour le programme
import json
import mysql.connector

#----------------------------------------------------

#On definit les differentes valeurs utiles
#pour se connecter a la Base De Donnees

mydb = mysql.connector.connect(
  host="localhost",
  user="zgeorge",
  password="ZA12*$za",
  database="zgeorge_02"
)

#----------------------------------------------------

#On ouvre le fichier en le renommant f
#et on charge son contenu
with open('SAEedited.json') as f:
   data = json.load(f)

#----------------------------------------------------

#Cette fonction permet d'executer les fonctions SQL
#On met cette fonction dans une variable qu'on appellera
#pour executer les actions
mycursor = mydb.cursor()
print(type(data))

#----------------------------------------------------

#On recupere la sous chaine 0 (data[0]) de la variable data
#puis on recupere la sous-chaine Informations de cette chaine (data[0]["Informations"])
#enfin, on recupere la sous-chaine de la sous-chaine Informations (data[0]["Informations"]['Nom'])
nom=data[0]["Informations"]['Nom']
prenom=data[0]["Informations"]['Prenom']
age=str(data[0]["Informations"]['Age'])
mail=str(data[0]["Informations"]['Mail'])
telephone=str(data[0]["Informations"]['Telephone'])
numufc=data[0]["Informations"]['NumUFC']
groupert=data[0]["Informations"]['GroupeRT']
adressedomicile=str(data[0]["Informations"]['Adresses']['AdresseDomicile'])
numerodepartement=str(data[0]["Informations"]['Adresses']['NoDep'])
nomville=data[0]["Informations"]['Adresses']['NomVille']
nomville2=data[0]["Informations"]['Adresses']['NomVille2']

#----------------------------------------------------

nomutilisateur=data[1]["Data"]['NomUtilisateur']
mdp=data[1]["Data"]['MDP']

#----------------------------------------------------

immatriculation=data[2]["Vehicule"]['Immatriculation']
modele=data[2]["Vehicule"]['Modele']
vin=data[2]["Vehicule"]['VIN']
assurance=data[2]["Vehicule"]['Assurance']
controletechnique=data[2]["Vehicule"]['ControleTechnique']
NEPH=data[2]["Vehicule"]['NEPH']
noplaces=data[2]["Vehicule"]['NoPlaces']
nopoints=data[2]["Vehicule"]['NoPoints']

#----------------------------------------------------

typedeplacement=data[3]["Deplacement"]['TypeDeplacement']
nbrparticipants=data[3]["Deplacement"]['NbrParticipants']
participation=data[3]["Deplacement"]['Participation']
butdeplacement=data[3]["Deplacement"]['ButDeplacement']

#----------------------------------------------------

lieudebut=data[3]["Deplacement"]['LieuDebut']
lieufin=data[3]["Deplacement"]['LieuFin']
etape1=data[3]["Deplacement"]['Etape1']
etape2=data[3]["Deplacement"]['Etape2']
etape3=data[3]["Deplacement"]['Etape3']
heuredebut=data[3]["Deplacement"]['HeureDebut']
#heurefin=data[3]["Source_Destination"]['HeureFin']
#duree=data[4]["Source_Destination"]['Duree']

#----------------------------------------------------

groupe=data[4]["GroupeIUT"]["Groupe"]
#sousgroupe=data[4]["GroupeIUT"]["Sous_Groupe"]
lundideb=data[4]["GroupeIUT"]["EDT"]["Lundi"]["HeureDebut"]
lundifin=data[4]["GroupeIUT"]["EDT"]["Lundi"]["HeureFin"]
mardideb=data[4]["GroupeIUT"]["EDT"]["Mardi"]["HeureDebut"]
mardifin=data[4]["GroupeIUT"]["EDT"]["Mardi"]["HeureFin"]
mercredideb=data[4]["GroupeIUT"]["EDT"]["Mercredi"]["HeureDebut"]
mercredifin=data[4]["GroupeIUT"]["EDT"]["Mercredi"]["HeureFin"]
jeudideb=data[4]["GroupeIUT"]["EDT"]["Jeudi"]["HeureDebut"]
jeudifin=data[4]["GroupeIUT"]["EDT"]["Jeudi"]["HeureFin"]
vendredideb=data[4]["GroupeIUT"]["EDT"]["Vendredi"]["HeureDebut"]
vendredifin=data[4]["GroupeIUT"]["EDT"]["Vendredi"]["HeureFin"]

#----------------------------------------------------

#On definit la premiere partie de la requete SQL qui va etre executee
inserl = 'INSERT INTO Student(FirstName,Name,Age,Mail,Phone,Home,Department,City1,City2,Registration,NumUFC,GroupRT) VALUES ("'
#Puis on ajoute les variables a la requete
inser2=prenom+'","'+nom+'","'+age+'","'+mail+'","'+telephone+'","'+numufc+'","'+adressedomicile+'","'+numerodepartement+'","'+nomville+'","'+nomville2+'","'+numufc+'","'+groupe+'");'

#Et on fusionne les chaines de caractere pour avoir une requete complete
inser3=inserl+inser2
print(inser3)
#On execute la requete inser3
mycursor.execute(inser3)

#On envoie la requete en se connectant a la Base De Donnees
mydb.commit()

#Et on affiche un message
print(mycursor.rowcount, "record(s) added in Etudiant")

#----------------------------------------------------
