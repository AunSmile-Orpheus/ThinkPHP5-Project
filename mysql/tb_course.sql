create table tb_course(
    id INT AUTO_INCREMENT NOT NULL,
    cname VARCHAR(30) NOT NULL,
    grade INT NOT NULL,
    stu_time INT NOT NULL,
    teacher_id INT NOT NULL,
    process_id INT NOT NULL,
    content TEXT,
    use_book VARCHAR(50),
    position VARCHAR(50),
    PRIMARY KEY(id)
)