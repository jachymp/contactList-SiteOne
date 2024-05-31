CREATE TABLE Persons (
                         ID int NOT NULL AUTO_INCREMENT,
                         NAME varchar(50),
                         SURNAME varchar(100) NOT NULL,
                         PRIMARY KEY (ID)
);

CREATE TABLE Types (
                       ID int NOT NULL AUTO_INCREMENT,
                       NAME varchar(50),
                       PRIMARY KEY (ID)
);

CREATE TABLE Numbers (
                         ID int NOT NULL AUTO_INCREMENT,
                         PHONE_NUMBER varchar(15),
                         PERSON_ID int,
                         TYPE_ID int,
                         PRIMARY KEY (ID),
                         FOREIGN KEY (PERSON_ID) REFERENCES Persons(ID),
                         FOREIGN KEY (TYPE_ID) REFERENCES Types(ID)
);

INSERT into Persons(NAME, SURNAME)
values ('Jan', 'Stary');

INSERT into Persons(NAME, SURNAME)
values ('Anna', 'Vedlejsi');

INSERT into Types(NAME)
values ('Prace');

INSERT into Types(NAME)
values ('Domov');

INSERT into Numbers(PHONE_NUMBER, PERSON_ID, TYPE_ID)
values ('666111222', 1, 1);

INSERT into Numbers(PHONE_NUMBER, PERSON_ID, TYPE_ID)
values ('333222555', 1, 2);

INSERT into Numbers(PHONE_NUMBER, PERSON_ID, TYPE_ID)
values ('111234566', 2, 1);