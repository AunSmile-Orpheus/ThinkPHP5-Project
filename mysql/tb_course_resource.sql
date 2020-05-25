create table tb_course_resource(
    id INT AUTO_INCREMENT NOT NULL,
    name VARCHAR(30) NOT NULL,
    resource_addr VARCHAR(100) NOT NULL,
    course_id INT NOT NULL,

    PRIMARY KEY(id)
)
