CREATE TABLE classes(  
	id INT NOT NULL,     
	title VARCHAR(50) NOT NULL,     
	price INT NOT NULL,     
	PRIMARY KEY(id) 
);

CREATE TABLE students (  
	firstName VARCHAR (30) NOT NULL,
	lastName VARCHAR(30) NOT NULL,    
	phone VARCHAR(10) NOT NULL,     
	PRIMARY KEY (firstName, lastName, phone) 
);

CREATE TABLE class_signups(  
classID INT NOT NULL,    
firstName VARCHAR(30) NOT NULL,      
lastName VARCHAR(30) NOT NULL,     
phone VARCHAR(10) NOT NULL,     
PRIMARY KEY(classID, firstName, lastName, phone),     
FOREIGN KEY (classID) REFERENCES classes(id),     
FOREIGN KEY (firstName, lastName, phone) REFERENCES students(firstName, lastName, phone) 
);