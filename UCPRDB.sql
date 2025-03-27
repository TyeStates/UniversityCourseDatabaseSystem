CREATE DATABASE IF NOT EXISTS UCPRDB;
USE UCPRDB;

DROP TABLE IF EXISTS coursesTaken;
DROP TABLE IF EXISTS enrolled;
DROP TABLE IF EXISTS student;
DROP TABLE IF EXISTS prerequisites;
DROP TABLE IF EXISTS courseSection;
DROP TABLE IF EXISTS course;
DROP TABLE IF EXISTS department;
DROP TABLE IF EXISTS professor;

CREATE TABLE student (
    std_name varchar(127) NOT NULL,
    std_id BIGINT PRIMARY KEY,
    std_major varchar(127), -- csv string
    std_yearofstudy int NOT NULL,
    std_email varchar(127) NOT NULL
);

CREATE TABLE department (
    d_name varchar(255) PRIMARY KEY,
    d_code varchar(4) NOT NULL,
    d_email varchar(255),
    d_phone BIGINT,
    d_address varchar(255),
    d_school varchar(127) NOT NULL
);

CREATE TABLE course (
    c_name varchar(127) NOT NULL, 
    c_id varchar(15) PRIMARY KEY,
    c_department varchar(255),
    c_sharedwith VARCHAR(63), -- csv string 
    c_connectedlab VARCHAR(15),
    FOREIGN KEY (c_department) REFERENCES department(d_name)
);

CREATE TABLE prerequisites (
    c_id varchar(15),
    pr_id varchar(15),
    PRIMARY KEY (c_id, pr_id),
    FOREIGN KEY (c_id) REFERENCES course(c_id),
    FOREIGN KEY (pr_id) REFERENCES course(c_id)
);

CREATE TABLE professor (
    p_name VARCHAR(127) PRIMARY KEY, 
    p_email varchar(127) NOT NULL,
    p_department VARCHAR(127), -- csv string
    p_office varchar(127)
);

CREATE TABLE coursesTaken (
    std_id BIGINT,
    c_id varchar(15),
    PRIMARY KEY (std_id, c_id),
    FOREIGN KEY (std_id) REFERENCES student(std_id),
    FOREIGN KEY (c_id) REFERENCES course(c_id)
);

CREATE TABLE enrolled (
    std_id BIGINT,
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
    s_days JSON, -- might change to csv string
    s_start TIME, -- enter as '00:00' format on 24hr clock
    s_end TIME, 
    PRIMARY KEY (s_id, s_course),
    FOREIGN KEY (s_course) REFERENCES course(c_id)
);

CREATE USER IF NOT EXISTS 'course_db_user'@'localhost' IDENTIFIED BY '1234';
GRANT SELECT, INSERT, UPDATE, DELETE, FILE ON *.* TO 'course_db_user'@'localhost';

-- insert into will be written below, will start with examples

insert into student (std_name, std_id, std_major, std_yearofstudy, std_email) VALUES 
    ('Tye States', 400300326, 'Computer Science', 3, '0300326s@acadiau.ca');

insert into department (d_name,d_code,d_email,d_phone,d_address,d_school) VALUES
    ('Jodrey School Of Computer Science', 'COMP', 'cs@acadiau.ca', 9025851331, '13 University ave. Wolfville', 'Acadia University'),
    ('Department of Mathematics and Statistics', 'MATH', 'mathstats@acadiau.ca', 9025851382, '12 University Ave. Wolfville', 'Acadia University');

insert into department (d_name,d_code,d_email,d_phone,d_address,d_school) VALUES
    ('Manning School Of Business', 'BUSI', NULL, 9025851356, '24 University ave. Wolfville', 'Acadia University');

insert into course (c_name, c_id, c_department, c_sharedwith, c_connectedlab) VALUES
    ('Database Management Systems', 'COMP-3753', 'Jodrey School Of Computer Science', '[FA-01]', NULL),
    ('Data Structures and Algorithms', 'COMP-2113', 'Jodrey School Of Computer Science', NULL, NULL),
    ('Discrete Mathematics', 'MATH-1413', 'Department of Mathematics and Statistics', NULL, NULL),
    ('Matrix Algebra', 'MATH-1323', 'Department of Mathematics and Statistics', NULL, NULL),
    ('Translators', 'COMP-3703', 'Jodrey School Of Computer Science', NULL, NULL);

insert into professor(p_name,p_email,p_department,p_office) VALUES
    ('Dr. Elhadi Shakshuki', 'elhadi.shakshuki@acadiau.ca', '[Jodrey School Of Computer Science]', 'Carnegie Hall 313');

insert into courseSection(s_id,s_course,s_loc,s_professor,s_days,s_start,s_end) VALUES
    ('FA-01', 'COMP-3753', 'BAC 142', 'Dr. Elhadi Shakshuki', '["t","th"]', '9:30', '10:50');

insert into prerequisites(c_id, pr_id) VALUES
    ('COMP-3753', 'COMP-2113'),
    ('COMP-3753', 'MATH-1413'),
    ('COMP-3753', 'MATH-1323');

insert into coursesTaken(std_id, c_id) VALUES
    (400300326, 'MATH-1413'),
    (400300326, 'MATH-1323'),
    (400300326, 'COMP-2113');

insert into enrolled(std_id, c_id) VALUES
    (400300326, 'COMP-3703'),
    (400300326, 'COMP-3753');
