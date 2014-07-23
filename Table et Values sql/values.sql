/* MODIFIER AVEC ENUM DANS FACTURE ET PRIX */
/* Prestation OK*/
insert into Prestation(intitule) values ('sterilisation'),('castration');
insert into Prestation(intitule) values ('soin dentaire'), ('traitement de la peau');

/* Consultation OK*/
insert into Consultation(intitule) values('soin dentaire'),('traitement de la peau'),('sterilisation'),('castration');

/* PrixConsultation OK*/
insert into PrixConsultation(consultation, espece, prix) values('soin dentaire','Chien',20.00);
insert into PrixConsultation(consultation, espece, prix) values('soin dentaire','Chat',20.00);
insert into PrixConsultation(consultation, espece, prix) values ('sterilisation','Chat', 39.00);
insert into PrixConsultation(consultation, espece, prix) values ('traitement de la peau','Chat', 30.00);

/* Intervention  OK*/
insert into Intervention(intitule) values('soin dentaire'),('traitement de la peau'),('sterilisation'),('castration');

/*PrixIntervention OK*/
insert into PrixIntervention(intervention, race, espece, prix) values('soin dentaire','Labrador','Chien',15.00);
insert into PrixIntervention(intervention,race, espece, prix) values('soin dentaire','Persan', 'Chat',10.00);
insert into PrixIntervention(intervention,race, espece, prix) values ('sterilisation','Siamois','Chat', 99.00);
insert into PrixIntervention(intervention,race, espece, prix) values ('sterilisation','Ragdoll','Chat', 79.00);
insert into PrixIntervention(intervention,race, espece, prix) values ('traitement de la peau','Maine Coon','Chat', 39.00);
insert into PrixIntervention(intervention,race, espece, prix) values ('soin dentaire','Maine Coon','Chat', 29.00);
insert into PrixIntervention(intervention,race, espece, prix) values ('traitement de la peau','Siamois','Chat', 19.00);
/*Employe OK*/
insert into Employe(employeID, nom, prenom) values(1,'Foucault','Gerard'),(2,'Durand','Catherine');
insert into Employe(employeID,nom,prenom) values(3,'Stuart','Fanny');


/*Veterinaire OK*/
insert into Veterinaire(veterinaireID) values(1),(2);

/*Produit OK*/
insert into Produit(nomProduit, prixProduit, quantiteDispo) values('Croquette canine, 1.5kg', 25.90, 13); 
insert into Produit(nomProduit, prixProduit, quantiteDispo) values('Science Plan, Croquette canine, 3kg', 49.90, 6); 
insert into Produit(nomProduit, prixProduit, quantiteDispo) values('Science Plan, Croquette feline, 1.5kg', 20.90, 8); 
insert into Produit(nomProduit, prixProduit, quantiteDispo) values('Science Plan, Croquette feline, 3kg', 40.90, 7); 
insert into Produit(nomProduit, prixProduit, quantiteDispo) values('Science Plan, Croquette canine, 3kg', 49.90, 6); 
insert into Produit(nomProduit, prixProduit, quantiteDispo) values('Science Plan, Croquette feline, 1.5kg', 20.90, 8); 
insert into Produit(nomProduit, prixProduit, quantiteDispo) values('Brosse ˆ poils', 05.90, 6); 
insert into Produit(nomProduit, prixProduit, quantiteDispo) values('Vermifuge', 03.90, 16);
insert into Produit(nomProduit, prixProduit, quantiteDispo) values('Anti-puce', 06.90, 11);

/*Medicament OK*/
insert into Medicament(nomMedicament)values('Vermifuge'),('Anti-puce');


/* Espece OK*/
insert into Espece(nomEspece) values('Chien'),('Chat'),('Hamster'),('Lapin');


/* Race OK*/
insert into Race(nomRace, nomEspece) values('Siamois','Chat'),('Persan','Chat'),('Maine Coon','Chat'),('Ragdoll','Chat'),('Labrador','Chien'),('Boxer','Chien'),('Caniche','Chien'),('Berger Allemand','Chien');

/*Client OK*/
insert into Client(telephone,nom,prenom) values('0685135043', 'Vannier','Lucie'),('0675781610','Martret','Olivier');
insert into Client(telephone,nom,prenom) values('0678543842','Safran','Jerome');

/* Animal OK*/
insert into Animal(telProprio, nom, race, espece, poids,sexe,dateNaissance, nationalID) values('0685135043', 'Indie', 'Maine Coon', 'Chat', 5, 'F', '2013-04-14', 23567865);
insert into Animal(telProprio, nom, race, espece, poids,sexe,dateNaissance, nationalID) values('0675781610', 'Fidji', 'Siamois', 'Chat', 4, 'F', '2012-03-19', 23567834);


/* Rendez-vous OK*/
insert into RendezVous(ID, veterinaireID, nomAnimal, telProprio, date) values(1,2, 'Indie', '0685135043', '2014-06-02 14:00:00');
insert into RendezVous(ID, veterinaireID, nomAnimal, telProprio, date) values(2,1, 'Fidji', '0675781610', '2014-06-12 16:00:00');
insert into RendezVous(ID, veterinaireID, nomAnimal, telProprio, date) values(3,1, 'Fidji', '0675781610', '2012-06-12 17:00:00');

insert into RendezVous_Prestation(intitule, RendezVous) values ('soin dentaire',1),('traitement de la peau',2),('traitement de la peau',3);

/* Facture OK*/
insert into Facture(factureID, dateEdition, moyenPayement, telClient, editeur) values(1,'2014-05-20', 'CB', '0685135043', 3);
insert into Facture(factureID, dateEdition, moyenPayement, telClient, editeur) values(2,'2014-05-20', 'cheque', '0675781610', 3);
insert into Facture(factureID, dateEdition, moyenPayement, telClient, editeur) values(3,'2014-05-20', 'CB', '0685135043', 3);
insert into Facture(factureID, dateEdition, moyenPayement, telClient, editeur) values(4,'2014-05-20', 'cheque', '0675781610', 3);

/*VentePrestation OK*/
insert into VentePrestation(intitule, factureID, remise) values('soin dentaire', 1, 0.1);
insert into VentePrestation(intitule, factureID, remise) values('traitement de la peau', 2, 0.1);

/*VenteProduit OK*/
insert into VenteProduit(nomProduit, factureID,qteAchetee, remise) values('Croquette canine, 1.5kg', 3,1, 0.1);
insert into VenteProduit(nomProduit, factureID,qteAchetee, remise) values('Brosse ˆ poils', 4, 1,0.1);

/* Ordonnance OK*/
insert into Ordonnance(ordonnanceID, veterinaireID, nomAnimal, telProprio) values (1, 1, 'Indie', '0685135043'),(2,2,'Fidji', '0675781610');

/*Refere OK*/ 
insert into Refere(ordonnanceID,factureID) values(1,1),(2,2);

/*Prescription OK*/
insert into Prescription(ordonnanceID,nomMedicament,qtePrescrite,instructions)values(1,'Vermifuge', 3, 'Donnez un comprime tous les 3 mois');
insert into Prescription(ordonnanceID,nomMedicament,qtePrescrite,instructions)values(2,'Anti-puce', 1, 'A disposer au bas de la nuque');


/* UPDATE A METTRE A JOUR*/

UPDATE Facture SET prix = PI.prix + PC.prix
from PrixIntervention PI, PrixConsultation PC, Facture F, Animal A, VentePrestation VP
WHERE f.telClient=A.telProprio AND PI.race=A.race AND PI.espece=A.espece AND PC.espece=A.espece AND VP.factureID=F.factureID AND VP.intitule=PI.intervention AND VP.intitule=PC.consultation;


grant all privileges on dbnf17p072.* to nf17p054@tuxa.sme.utc identified by 'qiVp9DeH';

