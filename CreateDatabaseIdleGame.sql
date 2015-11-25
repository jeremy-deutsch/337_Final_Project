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
        button_1 int not null,
        button_2 int not null,
        button_3 int not null,
        button_4 int not null,
        button_5 int not null
);

CREATE TABLE currency (
    username varchar(15),
    money_amount int not null,
    line_amount int not null
);
