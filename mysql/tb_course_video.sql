create table tb_course_video(
    id INT AUTO_INCREMENT NOT NULL,
    name VARCHAR(30) NOT NULL,
    video_addr VARCHAR(100) NOT NULL,
    course_id INT NOT NULL,
    order_index INT NOT NULL,

    PRIMARY KEY(id)
)
