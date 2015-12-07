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
        cash int not null,
        codeDollars int not null,
        linesPer int not null,
        totalLines int not null,
        counter int not null,
        speed int not null,
        coffee int not null,
        time_ int not null
);
