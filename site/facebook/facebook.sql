create table Membres(
    idMembre  int,
    Email varchar(30),
    Motdepasse varchar(10),
    Nom varchar(30),
    DateNaissance Date
);

insert into Membres value(1,'sariaka@gmail.com','bleu','Sariaka','2001-03-12');
insert into Membres value(1,'mahery@gmail.com','rouge','Mahery','2003-08-27');
insert into Membres value(2,'sarobidy@gmail.com','jaune','Sarobidy','2004-06-11');
insert into Membres value(3,'rija@gmail.com','vert','Rija','1977-06-30');
insert into Membres value(1,'nivo@gmail.com','bleu','Nivo','1977-11-08');

create table Amis(
    idMembre1 int,
    idMembre2 int,
    DateHeureDemande date,
    DateHeureAcceptation date
);
insert into Amis value(1,2,'2024-03-13','2024-04-14');
insert into Amis value(2,4,'2022-12-23','2023-03-18');
insert into Amis value(3,1,'2024-01-10','2024-03-04');

create table Publications(
    idPublication int,
    DateHeurePublication date,
    TextePublication varchar(30),
    TypeAffichage varchar(10),
);
insert into Publications value(1,'23-03-2024','hello everyone,i am hungry and angry','public');
insert into Publications value(2,'19-04-2022','hello everybody,je suis etudiante a itu','amis');


create table Commentaires(
    idCommentaires int,
    DateHeureCommentaires date,  
    TexteCommentaire varchar(30),
    idPublication int
);
insert into Commentaires value(1,'2024-03-29','hi,be happy',1);
insert into Commentaires value(2,'2022-09-30','hello',2);
insert into Commentaires value(3,'2022-11-24','hello',2);
insert into Commentaires value(4,'2024-04-09','hi,eat me XD',1);
insert into Commentaires value(5,'2024-05-11','eat cassava',1);


