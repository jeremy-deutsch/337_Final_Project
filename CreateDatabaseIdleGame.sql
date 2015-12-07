CREATE DATABASE idlegame;
USE idlegame;
CREATE TABLE users (
    username varchar(15),
    password varchar(256),
    login DATETIME,
    PRIMARY KEY(username)
);

CREATE TABLE button_amounts (
        username varchar(15),
        lines_ int not null,
        hands_ int not null,
        cups_ int not null,
        seconds_ int not null,
        money_ int not null
);
