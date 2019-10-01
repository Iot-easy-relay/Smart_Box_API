# **Smart_Box_API**


#### ********* **Comment utiliser l'API** ********


**_______La Pré Affectation**__________ 

**En entrées** :  

    ` 
    idCommune
    idColis
    longueurColis
    largeurColis
    hauteurColis`
    

**Exemple d'URL**: GET

http://localhost/AP_Preaffectation.php?idCommune=1601&idColis=1&longeurColis=13&largeurColis=14&hauteurColis=15

En sortie : 
Id Box et id Colis en cas de réussite
` {
    "idBox": "1",
    "idCasier": "1"
}`

Message d’erreur en cas d’échec 

`{"Message" : "Aucune box n est disponible"}`


**_______________Mise à jour**______________ 

**En entrée** : 

        `idActeur
        IdOpération (0=>Dépôt, 1=>Retrait)
        idBox
        idCasier
        idColis `
**Exemple d'URL**:  GET

http://localhost/API_MaJ.php?idActeur=1&idOperation=0&idBox=3&idCasier=1&idColis=1

**En sortie:** 
Vide en cas de réussite
Message d’erreur en cas d’échec 
`{
    "Message" : "Erreur lors de la mise à jour"
}`

**_________Etat Casier :**_________

**En entrée:** 

` idCasier : required`

**Exemple d'URL** : GET
 http://localhost/API/Etat_casier.php?idCasier=17

**En sortie:**
L'API retourne la liste des box de ce casier,
si le casier n'existe pas, elle retourne vide
si le box est vide :

 `{"idBox": "1","etatBox": "0" }`
 
si le box est plein:    
 ` {
 "idActeur": "1998", 
 "idBox": "3",
  "idCasier": "17",
   "idColis": "88",
    "idOperation": "1", 
    "dateOperation": "2019-09-09"
    }
`
