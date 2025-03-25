
CREATE DATABASE IF NOT EXISTS UCPRDB
USE UCPRDB

DROP TABLE IF EXISTS student;
DROP TABLE IF EXISTS course;
DROP TABLE IF EXISTS department;
DROP TABLE IF EXISTS courseSection;
DROP TABLE IF EXISTS professor;

CREATE TABLE student (
    std_name varchar(127) NOT NULL,
    std_id BIGINT PRIMARY KEY,
    std_major varchar(127), -- csv string
    std_coursestaken JSON, -- JSON storage
    std_yearofstudy int NOT NULL,
    std_email varchar(127) NOT NULL,
    std_enrolled JSON -- JSON Storage
)

CREATE TABLE department (
    d_name varchar(255) PRIMARY KEY,
    d_code varchar(4) NOT NULL,
    d_email varchar(255),
    d_phone BIGINT,
    d_address varchar(255),
    d_school varchar(127) NOT NULL
)

CREATE TABLE course (
    c_name varchar(127) NOT NULL,
    c_id varchar(15) PRIMARY KEY,
    c_department varchar(255) REFERENCES department (d_name),
    c_sections JSON NOT NULL, -- needs to be JSON for flexibility
    c_prerequisites JSON, -- might be better to be child table, currently child table is not made 
    c_sharedwith VARCHAR(63), -- csv string 
    c_connectedlab VARCHAR(15)
)

CREATE TABLE professor (
    p_name VARCHAR(127) PRIMARY KEY, 
    p_email varchar(127) NOT NULL,
    p_department VARCHAR(127), -- csv string
    p_office varchar(127)
)

CREATE TABLE courseSection (
    s_id varchar(15) NOT NULL,
    s_course VARCHAR(15) NOT NULL,
    s_loc varchar(127),
    s_professor varchar (127),
    s_days JSON, -- might change to csv string
    s_start TIME, -- enter as '00:00' format on 24hr clock
    s_end TIME, 
    PRIMARY KEY (s_id, s_course)
    FOREIGN KEY (s_course) REFERENCES course(c_id)
)

--insert into will be written below, will start with examples

insert into student (std_name, std_id, std_major,std_coursestaken,std_yearofstudy,std_email,std_email)
VALUES ('Tye States', 400300326, 'Computer Science','[MATH-1013,MATH-1023,MATH-1323,COMP-1113,MATH-1413,COMP-1123,FRAN-1213,
                                                    HIST-1423,POLS-1403,FRAN-1223,BUSI-1013,MATH-1253,COMP-2203,COMP-2113,
                                                    COMP-2663,COMP-2903,COMP-2103,COMP-2103,ECON-1123,PHIL-1423,PSYC-1013,PHYS-1513,
                                                    COMP-3613,COMP-3403,COMP-3343]', 3, '0300326s@acadiau.ca', '[BUSI-2033,COMP-3033,COMP-3703,
                                                    COMP-3753,MATH-2253]');


insert into department (d_name,d_code,d_email,d_phone,d_address,d_school)
VALUES('Jodrey School Of Computer Science', 'COMP', 'cs@acadiau.ca', 9025851331, '13 University ave. Wolfville', 'Acadia University');

insert into department (d_name,d_code,d_email,d_phone,d_address,d_school)
VALUES('Manning School Of Business', 'BUSI', NULL, 9025851356, '24 University ave. Wolfville', 'Acadia University');

insert into course (c_name, c_id, c_department, c_sections, c_prerequisites, c_sharedwith, c_connectedlab)
VALUES('Database Management Systems', 'COMP-3753', 'Jodrey School Of Computer Science', '[FA-01]', '[COMP-2113,MATH-1413,MATH-1323]', NULL, NULL);

insert into professor(p_name,p_email,p_department,p_office)
VALUES('Dr. Elhadi Shakshuki', 'elhadi.shakshuki@acadiau.ca', '[Jodrey School Of Computer Science]', 'Carnegie Hall 313');

insert into courseSection(s_id,s_course,s_loc,s_professor,s_days,s_start,s_end)
VALUES('FA-01', 'COMP-3753', 'BAC 142', 'Dr. Elhadi Shakshuki', '[t,th]', '9:30', '10:50');