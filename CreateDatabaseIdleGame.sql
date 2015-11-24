CREATE DATABASE idlegame;
USE idlegame;
CREATE TABLE users (
    id bigint not null auto_increment primary key,
    username varchar(15),
    password varchar(15),
    login DATETIME,
    PRIMARY KEY(username)
);

CREATE TABLE button_amounts (
        username varchar(15),
        button_1 int not null,
        button_2 int not null,
        button_3 int not null,
        button_4 int not null,
        button_5 int not null,
);
insert into users(username, password) values('admin', 'admin');
