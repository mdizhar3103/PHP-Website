drop database if exists tutorials;
create database tutorials;
use tutorials;

create table usersinfo(uid int not null primary key auto_increment,
name varchar(100) not null,
email varchar(100) not null) engine = innodb;

create table tutorials(
    tid int not null primary key auto_increment,
    title varchar(250) not null,
    author varchar(100) not null,
    created date,
    ratings int,
    retired boolean) engine = innodb;

create table enrolled(
    tid int not null,
    uid int not null,
    foreign key (tid) references tutorials(tid),
    foreign key (uid) references usersinfo(uid)
);

insert into usersinfo values(99, 'Mohd Izhar', 'izhar@gmail.com'), 
(100, 'Homer Simpson', 'homer@gmail.com'),
(101, 'John Doe', 'john@gmail.com'),
(102, 'Jane Smith', 'jane@gmail.com'),
(103, 'Henry Higgins', 'henry@gmail.com');

insert into tutorials values
(null, 'Linux Find Command', 'Mohd Izhar','2021-03-31' ,10, false),
(null, 'Linux Wild Cards', 'Izhar Ahmad', '2021-05-25',20, false),
(null, 'Linux Networking Commands', 'Solomon','2021-07-27' ,25, false),
(null, 'Linux Processes Commands', 'Mohd Izhar','2021-09-10' ,5, false);

-- create user adminuser, password: passwordadmin
CREATE USER 'adminuser'@'localhost' IDENTIFIED BY 'passwordadmin';
GRANT SELECT,INSERT,UPDATE,DELETE ON tutorials.* TO 'adminuser'@'localhost';