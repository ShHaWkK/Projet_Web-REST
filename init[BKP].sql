
CREATE TABLE USERS(
    id_users INT AUTO_INCREMENT,
    role INT NOT NULL,
    PRIMARY KEY(id_users)
);

CREATE TABLE APARTMENT(
    id_apartement INT,
    place INT NOT NULL,
    address VARCHAR(50) NOT NULL,
    complement_address VARCHAR(50),
    availability LOGICAL NOT NULL,
    price_night DECIMAL(15,2) NOT NULL,
    area INT NOT NULL,
    id_users INT NOT NULL,
    PRIMARY KEY(id_apartement),
    FOREIGN KEY(id_users) REFERENCES USERS(id_users)
);

CREATE TABLE RESERVATION(
    id_reservation INT,
    date_entry DATE NOT NULL,
    date_exit DATE NOT NULL,
    price_stay DECIMAL(15,2) NOT NULL,
    id_users INT NOT NULL,
    PRIMARY KEY(id_reservation),
    FOREIGN KEY(id_users) REFERENCES USERS(id_users)
);

CREATE TABLE TO_BOOK(
    id_apartement INT,
    id_reservation INT,
    PRIMARY KEY(id_apartement, id_reservation),
    FOREIGN KEY(id_apartement) REFERENCES APARTMENT(id_apartement),
    FOREIGN KEY(id_reservation) REFERENCES RESERVATION(id_reservation)
);