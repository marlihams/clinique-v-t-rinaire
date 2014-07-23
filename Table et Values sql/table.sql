CREATE TYPE MoyenPayement AS ENUM ('CB', 'espece', 'cheque','virement'); --OK

create table Prestation( /* OK */ 
 	intitule varchar primary key 
 );
 

create table Consultation( /*OK */
	intitule varchar references Prestation(intitule),
	primary key (intitule)
);

create table Intervention( --OK
	intitule varchar references Prestation(intitule),
	primary key (intitule)
);




create table PrixConsultation( -- OK
	consultation varchar references Consultation(intitule),
	espece varchar references Espece(nomEspece),
	prix decimal(6,2),
	primary key (consultation, espece)
);


create table PrixIntervention( -- OK
	intervention varchar references Intervention(intitule),
	race varchar ,
	espece varchar,
	prix decimal(6,2),
	primary key ( intervention, race, espece) , 
	foreign key (race, espece) references Race(nomRace, nomEspece)
);



create table RendezVous( --OK
	ID integer primary key,
	veterinaireID integer references Veterinaire(veterinaireID) not null,
	nomAnimal varchar not null ,
	telProprio varchar(10) not null , 
	date timestamp not null,  
	--intitule varchar references Prestation(intitule),  
	foreign key(nomAnimal, telProprio) references Animal(nom, telProprio),
	unique( veterinaireID, nomAnimal, telProprio, date)
	
);

create table RendezVous_Prestation(--OK
	intitule varchar references Prestation(intitule), 
	RendezVous integer references RendezVous(ID),
	primary key(intitule, RendezVous)
);


create table Veterinaire( -- OK
	veterinaireID integer references Employe(employeID), 
	primary key (veterinaireID)
);


create view vVeterinaire (ID, nom , prenom) --OK
as select ( V.veterinaireID, E.nom, E.prenom)
from Veterinaire V, Employe E
where V.veterinaireID = E.employeID;


create table Employe( -- OK
	employeID integer primary key,
	nom varchar not null, 
	prenom varchar not null 
);


create table Ordonnance( -- OK
	ordonnanceID varchar primary key, 
	veterinaireID integer references Veterinaire(veterinaireID) not null,
	nomAnimal varchar not null,
	telProprio varchar(10) not null, 
	foreign key (telProprio, nomAnimal) references Animal(telProprio, nom)
);



create table Produit( -- OK
	nomProduit varchar primary key,
	prixProduit decimal(6,2),
	quantiteDispo integer
);



create table Medicament(--OK
	nomMedicament varchar references Produit(nomProduit),
	primary key(nomMedicament)
);


create view vMedicament (nom , prix, quantite) --OK
as select M.nomMedicament, P.prixProduit, P.quantiteDispo
from Medicament M, Produit P
where M.nomMedicament = P.nomProduit;


create table Race( /* OK */
	nomRace varchar,
	nomEspece varchar references Espece(nomEspece),
	primary key (nomRace, nomEspece)
);


create table Espece( /* OK */
	nomEspece varchar primary key
);



create table Client( -- OK
	telephone varchar(10) primary key, 
	nom varchar, 
	prenom varchar
);


create table Animal( --OK
	telProprio varchar(10) references Client(telephone), 
	nom varchar, 
	race varchar not null,
	espece varchar not null,
	poids integer, 
	sexe char(1) check(sexe='F' or sexe='M'), 
	dateNaissance date, 
	nationalID integer,
	primary key( telProprio, nom), 
	foreign key(race,espece) references Race(nomRace, nomEspece)
);


create table Facture( --OK
	factureID integer primary key, 
	dateEdition date, 
	datePayement date, 
	moyenPayement MoyenPayement, 
	telClient varchar(10) references Client(telephone) not null, 
	editeur integer references Employe(employeID) not null,
	prix decimal(6,2)
);

create table VenteProduit( --OK
	nomProduit varchar references Produit(nomProduit), 
	factureID integer references Facture(factureID), 
	qteAchetee integer, 
	remise float, 
	primary key (nomProduit, factureID)
);

create table VentePrestation( --OK
	intitule varchar references Prestation(intitule), 
	factureID integer references Facture(factureID), 
	remise float,
	primary key( intitule, factureID)
);


create table Refere( --OK
	ordonnanceID varchar references Ordonnance(ordonnanceID), 
	factureID integer references Facture(factureID),
	primary key(ordonnanceID,factureID)
);



create table Prescription( --OK
	ordonnanceID varchar references Ordonnance(ordonnanceID), 
	nomMedicament varchar references Medicament(nomMedicament), 
	qtePrescrite integer, 
	instructions varchar, 
	primary key (ordonnanceID, nomMedicament)
);


