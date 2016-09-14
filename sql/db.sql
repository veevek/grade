-- Drop the existing DB, if it exists
DROP DATABASE IF EXISTS grades;

-- Create a new DB for storing Grades
CREATE DATABASE grades CHARACTER SET utf8 COLLATE utf8_general_ci;

-- Switch to it
USE grades;

-- Create a user
GRANT SELECT, INSERT, UPDATE, DELETE
	ON grades.*
	TO 'gradesUser'@'localhost'
	IDENTIFIED BY 'AxBkAJwMYCFj3RaGypHG'; -- this is a nice hard-to-guess password

-- DDL to create the tables
CREATE TABLE student (
	studentid VARCHAR(10) PRIMARY KEY,
	password VARCHAR(80)
);

CREATE TABLE course (
	id INT PRIMARY KEY AUTO_INCREMENT,
	name VARCHAR(30) 
);

CREATE TABLE grade (
	code VARCHAR(2) PRIMARY KEY,
	description VARCHAR(50)
);

CREATE TABLE achievement (
	studentid VARCHAR(10),
	courseid INT,
	year INT,
	semester INT,
	gradecode VARCHAR(2),
	PRIMARY KEY (studentid, courseid, year, semester),
	FOREIGN KEY (studentid)
		REFERENCES student(studentid),
	FOREIGN KEY (courseid)
		REFERENCES course(id),
	FOREIGN KEY (gradecode)
		REFERENCES grade(code)
);

--
-- DML to create some records
--

-- Courses
INSERT INTO
	course (id, name)
VALUES
	(1, 'Web Technology'),
	(2, 'Programming 1'),
	(3, 'Programming 2'),
	(4, 'Networking');


-- Students
INSERT INTO student
	(studentid, password)
VALUES
	-- These are all hashed versions of "password" using PHP's crypt() function
	-- generated using the following code
	--    $salt = '$2y$07$' . base64_encode(openssl_random_pseudo_bytes(32));
	--    echo crypt('password', $salt);
	('admin', '$2y$07$xdfN4i29zUiuyL/y7iIMCehCMhqOEGe7eHFJeEuYuFMAisKgHJG5e'),
	('555001', '$2y$07$59db781ce66ed4866ee6$.0qBmxOhqw8jiP.00LzxqYYeBTqxIIYm'),
	('555002', '$2y$07$2a474a0e661be3e226d7$.B4AT6biXTy.JtM3BOeFBbQ.mokm2DHK'),
	('555003', '$2y$07$d4afbb69b046db8da9ad$.mZ5PKmgLoofPDUFogLFjm5Wa4gFSwDq');


-- Grades
INSERT INTO grade
	(code, description)
VALUES
	('XF', 'Didn\t show up'),
	('F', 'Failed'),
	('P', 'Passed'),
	('C', 'Credit'),
	('D', 'Distinction'),
	('HD', 'High Distinction');


-- Achievements / grades earned
INSERT INTO achievement
	(studentid, courseid, year, semester, gradecode)
VALUES
	('555001', 2, 2013, 1, 'D'),
	('555001', 3, 2013, 2, 'D'),
	('555001', 1, 2014, 1, 'F'),
	('555001', 1, 2014, 2, 'C'),
	('555001', 4, 2014, 2, 'HD'),

	('555002', 2, 2012, 2, 'XF'),
	('555002', 2, 2013, 1, 'C'),
	('555002', 3, 2013, 2, 'P'),
	('555002', 4, 2014, 2, 'P'),

	('555003', 2, 2012, 1, 'D'),
	('555003', 3, 2012, 2, 'HD'),
	('555003', 1, 2013, 1, 'HD'),
	('555003', 4, 2013, 2, 'C');

