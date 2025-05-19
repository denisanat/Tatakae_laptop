DROP TABLE IF EXISTS laptops;
CREATE TABLE IF NOT EXISTS laptops (
	id SERIAL PRIMARY KEY,
	name VARCHAR(50) UNIQUE NOT NULL,
	price REAL,
	release_date DATE,
	page_score REAL,
	user_score REAL,
	site_link VARCHAR(255),
	image_link VARCHAR(255),

	-- hardware
	model SMALLINT,
	processor SMALLINT,
	graphics_card SMALLINT,
	memory SMALLINT,
	storage SMALLINT,
	display SMALLINT,
	camera SMALLINT,
	battery SMALLINT,
	power_supply SMALLINT,
	wifi SMALLINT
);

DROP TABLE IF EXISTS hardware;
CREATE TABLE IF NOT EXISTS hardware (
	id SERIAL PRIMARY KEY,
	hardware_type SMALLINT NOT NULL,
	name VARCHAR(255) NOT NULL,
	score REAL 
);

DROP TABLE IF EXISTS user_scores;
CREATE TABLE IF NOT EXISTS user_scores (
	id SERIAL PRIMARY KEY,
	user_id INTEGER NOT NULL,
	laptop_id INTEGER NOT NULL,
	score SMALLINT NOT NULL
);

DROP TABLE IF EXISTS messages;
CREATE TABLE IF NOT EXISTS messages (
	id SERIAL PRIMARY KEY,
	user_id INTEGER NOT NULL,
	is_response BOOLEAN NOT NULL,
	target_id INTEGER NOT NULL,
	message TEXT
);

SELECT * FROM laptops WHERE model = 1;

SELECT * FROM hardware;

SELECT * FROM users;

SELECT * FROM user_scores;

SELECT * FROM messages;

INSERT INTO messages(user_id, is_response, target_id, message)
VALUES
(1, false, 2, 'Hello World!');

INSERT INTO hardware(hardware_type, name)
VALUES (1, 'Lenovo ThinkPad'),
(2, 'AMD Ryzen™ 5 7535HS'),
(3, 'Integrated'),
(2, '13th Generation Intel® Core™ i5-1345U');

INSERT INTO laptops(name, model, price, processor, graphics_card)
VALUES ('ThinkPad X1 Carbon Gen 13 Aura Edition', 1, 1550.45, 2, 3),
('ThinkPad X1 Carbon Gen 11 Intel', 1, 1790.99, 4, 3);

INSERT INTO laptops(name)
VALUES ('laptop #2'),('laptop #3'),('laptop #4'),('laptop #5'),('laptop #6'),
('laptop #7'),('laptop #8'),('laptop #9'),('laptop #10'),('laptop #11'),('laptop #12'),
('laptop #13'),('laptop #14'),('laptop #15'),('laptop #16'),('laptop #17'),('laptop #18');

INSERT INTO laptops(name, model)
VALUES ('lap #1', 1), ('lap #2', 1), ('lap #3', 1), ('lap #4', 1), ('lap #5', 1),
 ('lap #6', 1), ('lap #7', 1), ('lap #8', 1), ('lap #9', 1), ('lap #10', 1), ('lap #11', 1);