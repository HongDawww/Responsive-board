create table comment(
    comment_no int unsigned not null primary key auto_increment,
    b_no int unsigned not null,
    comment_depth int unsigned default 0,
    comment_content text not null,
    comment_id varchar(20) not null,
    comment_pw varchar(128) not null
);

