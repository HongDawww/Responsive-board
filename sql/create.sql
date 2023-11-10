CREATE DATABASE bbs;

USE bbs;

create table bbs (
    b_no int unsigned not null primary key auto_increment,
    b_subject varchar(100) not null,
    b_content text not null,
    b_date datetime not null,
    b_hit int unsigned not null default 0,
    b_id varchar(20) not null,
    b_pw varchar(50) not null
);
