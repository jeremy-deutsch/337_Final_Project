CREATE DATABASE idlegame;
USE idlegame;
CREATE TABLE users (
    id bigint not null auto_increment primary key,
    username varchar(15),
    password varchar(15),
    login DATETIME
);
CREATE TABLE button_amounts (
        button_1 int not null,
        button_2 int not null,
        button_3 int not null,
        button_4 int not null,
        button_5 int not null
)
