CREATE TABLE USERS(
   id_users SERIAL PRIMARY KEY,
   role INT NOT NULL,
   pseudo VARCHAR(50) NOT NULL,
   user_index INT NOT NULL DEFAULT 1,
   apikey VARCHAR(50)
);

CREATE TABLE APARTMENT(
   id_apartement SERIAL PRIMARY KEY,
   place INT NOT NULL,
   address VARCHAR(50) NOT NULL,
   complement_address VARCHAR(50),
   availability BOOLEAN NOT NULL,
   price_night DECIMAL(15,2) NOT NULL,
   area INT NOT NULL,
   apartment_index INT NOT NULL DEFAULT 1,
   id_users INT NOT NULL,
   FOREIGN KEY(id_users) REFERENCES USERS(id_users)
);

CREATE TABLE RESERVATION(
   id_reservation SERIAL PRIMARY KEY,
   date_entry DATE NOT NULL,
   date_exit DATE NOT NULL,
   price_stay DECIMAL(15,2) NOT NULL,
   etat INT NOT NULL DEFAULT 1,
   id_users INT NOT NULL,
   FOREIGN KEY(id_users) REFERENCES USERS(id_users)
);

CREATE TABLE TO_BOOK(
   id_apartement INT,
   id_reservation INT,
   PRIMARY KEY(id_apartement, id_reservation),
   FOREIGN KEY(id_apartement) REFERENCES APARTMENT(id_apartement),
   FOREIGN KEY(id_reservation) REFERENCES RESERVATION(id_reservation)
);

INSERT INTO USERS (role) VALUES (1), (2), (3), (4), (1), (2), (3), (4), (4), (4);

INSERT INTO APARTMENT (place, address, complement_address, availability, price_night, area, id_users) 
VALUES (1, '123 Main Street', 'Apt 101', TRUE, 150.00, 100, 1), 
       (2, '456 Elm Street', 'Apt 202', TRUE, 200.00, 120, 2), 
       (3, '789 Oak Street', 'Apt 303', FALSE, 100.00, 80, 3), 
       (4, '012 Pine Street', 'Apt 404', TRUE, 180.00, 150, 5), 
       (5, '345 Cedar Street', 'Apt 505', FALSE, 120.00, 90, 6), 
       (6, '678 Maple Street', 'Apt 606', TRUE, 220.00, 130, 7), 
       (7, '901 Birch Street', 'Apt 707', TRUE, 170.00, 110, 3), 
       (8, '234 Walnut Street', 'Apt 808', FALSE, 130.00, 70, 7), 
       (9, '567 Cherry Street', 'Apt 909', TRUE, 250.00, 140, 3), 
       (10, '890 Sycamore Street', 'Apt 1010', FALSE, 110.00, 100, 2);

INSERT INTO RESERVATION (date_entry, date_exit, price_stay, id_users) 
VALUES ('2023-12-01', '2023-12-08', 500.00, 3), 
       ('2023-12-02', '2023-12-09', 600.00, 4), 
       ('2023-12-03', '2023-12-10', 700.00, 7), 
       ('2023-12-04', '2023-12-11', 800.00, 8), 
       ('2023-12-05', '2023-12-12', 900.00, 9), 
       ('2023-12-06', '2023-12-13', 1000.00, 10), 
       ('2023-12-07', '2023-12-14', 1100.00, 3), 
       ('2023-12-08', '2023-12-15', 1200.00, 4), 
       ('2023-12-09', '2023-12-16', 1300.00, 8), 
       ('2023-12-10', '2023-12-17', 1400.00, 10);


INSERT INTO TO_BOOK (id_apartement, id_reservation) 
VALUES (1, 1), (2, 2), (3, 3), (4, 4), (5, 5), (6, 6), (7, 7), (8, 8), (9, 9), (10, 10);