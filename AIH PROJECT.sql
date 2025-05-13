CREATE DATABASE SmartBusSchedulerDB;

CREATE DATABASE IF NOT EXISTS SmartBusSchedulerDB;

DROP DATABASE SmartBusSchedulerDB;

DROP DATABASE IF EXISTS SmartBusSchedulerDB;

USE SmartBusSchedulerDB;

CREATE TABLE Bus(
bus_id INT PRIMARY KEY,
capacity INT NOT NULL
);

CREATE TABLE Route(
route_id VARCHAR(50) PRIMARY KEY,
route_length DOUBLE,
start_point VARCHAR(50) NOT NULL,
end_point VARCHAR(50) NOT NULL,
estimated_time_travelled TIME NOT NULL,
date DATE
); 


CREATE TABLE Schedule(
schedule_id VARCHAR(50) PRIMARY KEY,
route_id VARCHAR(50) UNIQUE NOT NULL,
bus_id INT UNIQUE NOT NULL,
FOREIGN KEY (route_id) REFERENCES Route(route_id),
FOREIGN KEY (bus_id) REFERENCES Bus(bus_id)
);

CREATE TABLE Passenger(
passenger_id VARCHAR(50) PRIMARY KEY,
name VARCHAR(50),
phonenumber BIGINT UNIQUE NOT NULL,
email_id VARCHAR(100) UNIQUE NOT NULL
);

CREATE TABLE Ticket(
ticket_id VARCHAR(100) PRIMARY KEY,
date DATE,
seat VARCHAR(25),
amount BIGINT,
passenger_id VARCHAR(50),
schedule_id VARCHAR(50),
route_id VARCHAR(50),
FOREIGN KEY (passenger_id) REFERENCES Passenger(passenger_id),
FOREIGN KEY (schedule_id) REFERENCES Schedule(schedule_id),
FOREIGN KEY (route_id) REFERENCES Route(route_id)
);


CREATE TABLE Employee(
employee_id VARCHAR(50) PRIMARY KEY,
employee_name VARCHAR(50) NOT NULL,
email VARCHAR(100),
dob YEAR NOT NULL,
department VARCHAR(50) NOT NULL,
designation VARCHAR(50),
route_id VARCHAR(50),
bus_time TIME,
total_hours INT,
FOREIGN KEY(route_id) REFERENCES Route(route_id)
);

INSERT INTO Bus
(bus_id,capacity)
VALUES
(001,35),
(002,5),
(003,1),
(004,7),
(005,2),
(006,4),
(007,4),
(008,50),
(009,50),
(010,3),
(011,0),
(012,61),
(013,19),
(014,37),
(015,3),
(016,11),
(017,21),
(018,22),
(019,18),
(020,13);

INSERT INTO Route
(route_id,route_length,start_point,end_point,estimated_time_travelled)
VALUES
(8,22.0,'Badar Pur Border','Noida Phase-II Phool Mandi',30),
('8A',22.0,'Nehru Place Terminal','Noida Phase-II Phool Mandi',45),
(17,30.5,'Old Delhi Rly. Station','Ramjan Pur Village',25),
(19,28.6,'Nizamuddin Rly. Station','Jahangir Puri E-Blk.',30),
('19A',17.0,'Palika Kendra','Jahangir Puri E-Blk',40),
('19B',18.0,'Jama Masjid','Jahangir Puri E-Blk.',35),
(26,17.0,'Dr.Mukherjee Nagar Bandh','Sewa Nagar Railway Xing',15),
(33,18.0,'Bhajan Pura','Noida Sector-43 (Police Chowki Sadar Pur)',50),
('33EXT',19.0,'Bhajan Pura','Noida Phase-II Phool Mandi',30),
('33A',31.6,'Badar Pur Khadar Shank No. 27','Noida Sector-43 (Police Chowki Sadar Pur)',25),
('33C',31.6,'Chauhan Patti','Anand Vihar ISBT',45),
(34,40.0,'Mehrauli Terminal','Noida Sec-32',42),
('34A',25.0,'Lado Sarai Terminal','Mayur Vihar Phase-III, Paper Market',38),
(39,34.0,'Jheel','Tri Nagar Jai Mata Mkt. / Anand Parvat',44),
('39A',35.0,'Anand Vihar ISBT','Tri Nagar Jai Mata Mkt.',52),
('47A',23.6,'Inder Puri JJ Cly.','C.W.Shop -II / Tehkhand',55),
(73,23.9,'Anand Vihar ISBT','Tilak Nagar / H.N.Shaheed Pawan Sahni Chowk',20),
(78,31.2,'Azad pur Terminal','Inder Puri Krishi Kunj',40),
('85',29.4,'Anand Vihar ISBT','Punjabi Bagh (T)',25),
('85EXT',14.6,'Anand Vihar ISBT','West Enclave',40);


INSERT INTO Schedule
(schedule_id,route_id,bus_id)
VALUES
(001,8,001),
(002,'8A',002),
(003,17,003),
(004,19,004),
(005,'19A',005),
(006,'19B',006),
(007,26,007),
(008,33,008),
(009,'33EXT',009),
(010,'33A',010),
(011,'33C',011),
(012,34,012),
(013,'34A',013),
(014,39,014),
(015,'39A',015),
(016,'47A',016),
(017,73,017),
(018,78,018),
(019,85,019),
(020,'85EXT',020);

INSERT INTO Passenger
(passenger_id,name,phonenumber,email_id)
VALUES
(001,'Ramesh',9653426726,'ramesh@gmail.com');

INSERT INTO Ticket
(ticket_id,date,seat,amount,passenger_id,schedule_id,route_id)
VALUES
('DBS-123456','2024-08-20','A12',50,001,016,'47A');

INSERT INTO Employee
(employee_id,employee_name,email,dob,department,designation,route_id,bus_time,total_hours)
VALUES
();

SELECT*FROM Bus;

SELECT*FROM Route;

SELECT*FROM Schedule;

SELECT*FROM Ticket;

ALTER TABLE Ticket
MODIFY ticket_id VARCHAR(50) PRIMARY KEY;

SHOW TABLES;