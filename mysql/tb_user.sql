create table tb_course(
    username varchar(20) NOT NULL,
    password varchar(20),
    openid varchar(20),
    type int,
    PRIMARY KEY(username),
    UNIQUE KEY(username, password, openid)
)   