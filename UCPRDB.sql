CREATE DATABASE IF NOT EXISTS UCPRDB;
USE UCPRDB;

DROP TABLE IF EXISTS coursesTaken;
DROP TABLE IF EXISTS enrolled;
DROP TABLE IF EXISTS student;
DROP TABLE IF EXISTS prerequisites;
DROP TABLE IF EXISTS courseSection;
DROP TABLE IF EXISTS course;
DROP TABLE IF EXISTS departmentAdmin;
DROP TABLE IF EXISTS professor;
DROP TABLE IF EXISTS department;
DROP TABLE IF EXISTS user;

CREATE TABLE user (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    user_name VARCHAR(100) NOT NULL,
    user_pass VARCHAR(255) NOT NULL,
    user_role ENUM('student', 'professor', 'd_admin', 'admin') NOT NULL
);

CREATE TABLE department (
    d_id INT AUTO_INCREMENT PRIMARY KEY,
    d_name varchar(255),
    d_code varchar(4) NOT NULL,
    d_email varchar(255),
    d_phone BIGINT,
    d_address varchar(255),
    d_school varchar(127) NOT NULL
);

CREATE TABLE departmentAdmin (
    da_id INT PRIMARY KEY,
    d_id INT NOT NULL UNIQUE,
    FOREIGN KEY (da_id) REFERENCES user(user_id),
    FOREIGN KEY (d_id) REFERENCES department(d_id)
);

CREATE TABLE student (
    std_id INT PRIMARY KEY,
    std_name varchar(127) NOT NULL,
    std_number BIGINT UNIQUE, 
    std_major varchar(127), -- csv string
    std_yearofstudy int NOT NULL,
    std_email varchar(127) NOT NULL,
    FOREIGN KEY (std_id) REFERENCES user(user_id)
);

CREATE TABLE course (
    c_name varchar(127) NOT NULL, 
    c_id varchar(15) PRIMARY KEY,
    c_department INT,
    c_sharedwith VARCHAR(63), -- csv string 
    c_connectedlab VARCHAR(15),
    FOREIGN KEY (c_department) REFERENCES department(d_id)
);

CREATE TABLE prerequisites (
    c_id varchar(15),
    pr_id varchar(15),
    PRIMARY KEY (c_id, pr_id),
    FOREIGN KEY (c_id) REFERENCES course(c_id),
    FOREIGN KEY (pr_id) REFERENCES course(c_id)
);

CREATE TABLE professor (
    p_id INT PRIMARY KEY,
    p_name VARCHAR(127), 
    p_email varchar(127) NOT NULL,
    p_department INT,
    p_office varchar(127),
    FOREIGN KEY (p_id) REFERENCES user(user_id),
    FOREIGN KEY (p_department) REFERENCES department(d_id)
);

CREATE TABLE coursesTaken (
    std_id INT,
    c_id varchar(15),
    PRIMARY KEY (std_id, c_id),
    FOREIGN KEY (std_id) REFERENCES student(std_id),
    FOREIGN KEY (c_id) REFERENCES course(c_id)
);

CREATE TABLE enrolled (
    std_id INT,
    c_id varchar(15),
    PRIMARY KEY (std_id, c_id),
    FOREIGN KEY (std_id) REFERENCES student(std_id),
    FOREIGN KEY (c_id) REFERENCES course(c_id)
);

CREATE TABLE courseSection (
    s_id varchar(15) NOT NULL,
    s_course VARCHAR(15) NOT NULL,
    s_loc varchar(127),
    s_professor varchar (127),
    s_days varchar(10), 
    s_start varchar(10), -- enter as '00:00' format on 24hr clock
    s_duration varchar(10), 
    PRIMARY KEY (s_id, s_course),
    FOREIGN KEY (s_course) REFERENCES course(c_id)
);

CREATE USER IF NOT EXISTS 'course_db_user'@'localhost' IDENTIFIED BY '1234';
GRANT SELECT, INSERT, UPDATE, DELETE, FILE ON *.* TO 'course_db_user'@'localhost';

-- insert into will be written below, will start with examples

insert into user(user_name, user_pass, user_role) VALUES
    ('superadmin', '*****', 'admin');

insert into department (d_name, d_code, d_email, d_phone, d_address, d_school) VALUES
    ('Jodrey School Of Computer Science', 'COMP', 'cs@acadiau.ca', 9025851331, '13 University ave. Wolfville', 'Acadia University'),
    ('Department of Mathematics and Statistics', 'MATH', 'mathstats@acadiau.ca', 9025851382, '12 University Ave. Wolfville', 'Acadia University'),
    ('Manning School Of Business', 'BUSI', NULL, 9025851356, '24 University ave. Wolfville', 'Acadia University');

insert into course (c_name, c_id, c_department, c_sharedwith, c_connectedlab) VALUES
    ('Database Management Systems', 'COMP-3753', 1, '[FA-01]', NULL),
    ('Data Structures and Algorithms', 'COMP-2113', 1, NULL, NULL),
    ('Discrete Mathematics', 'MATH-1413', 2, NULL, NULL),
    ('Matrix Algebra', 'MATH-1323', 2, NULL, NULL),
    ('Translators', 'COMP-3703', 1, NULL, NULL);

insert into prerequisites(c_id, pr_id) VALUES
    ('COMP-3753', 'COMP-2113'),
    ('COMP-3753', 'MATH-1413'),
    ('COMP-3753', 'MATH-1323');
