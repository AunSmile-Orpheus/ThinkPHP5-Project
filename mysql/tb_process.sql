create table tb_process(
    process_id int not null auto_increment,
    content text,
    jobs text,
    name varchar(30),
    PRIMARY KEY(process_id)
)   
