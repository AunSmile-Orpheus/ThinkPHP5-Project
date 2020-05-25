create table tb_process_course(
    id int not null auto_increment,
    process_id INT not null,
    term_index INT not null,
    course_id INT not null,
    PRIMARY KEY(id)
)   
