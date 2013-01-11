DROP TABLE IF EXISTS scores;
DROP TABLE IF EXISTS earns;
DROP TABLE IF EXISTS achievement;
DROP TABLE IF EXISTS player;
DROP TABLE IF EXISTS game;

CREATE TABLE game (
	id INT AUTO_INCREMENT NOT NULL,
	name VARCHAR (50),
	publisher VARCHAR (50),
	releaseDate DATE,
	rating VARCHAR (2),
	PRIMARY KEY (id)
)
ENGINE = InnoDB,
COMMENT = 'Table to hold game information'
;

CREATE TABLE player (
	id INT AUTO_INCREMENT NOT NULL,
	firstName VARCHAR (30),
	lastName VARCHAR (30),
	sex VARCHAR (6),
	picture VARCHAR (50),
	PRIMARY KEY (id)
)
ENGINE = InnoDB,
COMMENT = 'Table to hold the player information'
;

CREATE TABLE achievement (
		id INT AUTO_INCREMENT NOT NULL,
		gameId INT NOT NULL,
		name VARCHAR (50),
		description VARCHAR (100),
		points INT,
		PRIMARY KEY (id),
		FOREIGN KEY (gameId) REFERENCES game (id) ON DELETE CASCADE ON UPDATE CASCADE
)
ENGINE = InnoDB,
COMMENT = 'List of achievements associated with specified games'
;

CREATE TABLE earns (
	playerId INT NOT NULL,
	achievementId INT NOT NULL,
	dateEarned DATE,
	remark VARCHAR (50),
	PRIMARY KEY (playerId, achievementId),
	FOREIGN KEY (playerId) REFERENCES player (id) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY (achievementId) REFERENCES achievement (id) ON DELETE CASCADE ON UPDATE CASCADE
)
COMMENT = 'Association between individual players and achievements'
;

CREATE TABLE scores (
	playerId INT NOT NULL,
	gameId INT NOT NULL,
	score INT,
	PRIMARY KEY (playerId, gameID),
	FOREIGN KEY (playerId) REFERENCES player (id) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY (gameId) REFERENCES game (id) ON DELETE CASCADE ON UPDATE CASCADE
)
COMMENT = 'Record of a player score for a specified game'
;

INSERT INTO player (firstName, lastName, sex) VALUES ("Ramon", "Lawrence", "Male");
INSERT INTO player (firstName, lastName, sex) VALUES ("Patricia", "Lasserre", "Female");
INSERT INTO player (firstName, lastName, sex) VALUES ("Yves", "Lucet", "Male");
INSERT INTO player (firstName, lastName, sex) VALUES ("Yong", "Gao", "Male");
INSERT INTO player (firstName, lastName, sex) VALUES ("Bowen", "Hui", "Female");
INSERT INTO player (firstName, lastName, sex) VALUES ("Alan", "Paeth", "Male");
INSERT INTO player (firstName, lastName, sex) VALUES ("Jodie", "Foster", "Female");

UPDATE player SET picture = "./img/players/1.jpg" WHERE id = 1;
UPDATE player SET picture = "./img/players/2.jpg" WHERE id = 2;
UPDATE player SET picture = "./img/players/3.jpg" WHERE id = 3;
UPDATE player SET picture = "./img/players/4.jpg" WHERE id = 4;
UPDATE player SET picture = "./img/players/5.jpg" WHERE id = 5;
UPDATE player SET picture = "./img/players/7.jpg" WHERE id = 7;

INSERT INTO game (name, publisher, releaseDate, rating) VALUES ("Pacifist Pigs", "Back Bacon Inc.", "2010-04-01", "EC");
INSERT INTO game (name, publisher, releaseDate, rating) VALUES ("Nuke Dukem", "NorKor", "1000-01-01", "M");
INSERT INTO game (name, publisher, releaseDate, rating) VALUES ("Civilization MMXIII", "MayanIncAl", "2012-12-20", "T");
INSERT INTO game (name, publisher, releaseDate, rating) VALUES ("Numbers with Enemies", "VengeanceIsBestServed Productions", "2012-01-02", "T");
INSERT INTO game (name, publisher, releaseDate, rating) VALUES ("Draw Nothing", "BlankPage", "2012-06-31", "E");

INSERT INTO achievement (gameId, name, description, points) VALUES (1, "FIRST!", "Played the game for the first time.", 5);
INSERT INTO achievement (gameId, name, description, points) VALUES (2, "FIRST!", "Played the game for the first time.", 5);
INSERT INTO achievement (gameId, name, description, points) VALUES (3, "FIRST!", "Played the game for the first time.", 5);
INSERT INTO achievement (gameId, name, description, points) VALUES (4, "FIRST!", "Played the game for the first time.", 5);
INSERT INTO achievement (gameId, name, description, points) VALUES (5, "FIRST!", "Played the game for the first time.", 5);
INSERT INTO achievement (gameId, name, description, points) VALUES (1, "FINISH HIM!", "Completed the game.", 9005);
INSERT INTO achievement (gameId, name, description, points) VALUES (2, "FINISH HIM!", "Completed the game.", 9005);
INSERT INTO achievement (gameId, name, description, points) VALUES (3, "FINISH HIM!", "Completed the game.", 9005);
INSERT INTO achievement (gameId, name, description, points) VALUES (4, "FINISH HIM!", "Completed the game.", 9005);
INSERT INTO achievement (gameId, name, description, points) VALUES (5, "FINISH HIM!", "Completed the game.", 9005);
INSERT INTO achievement (gameId, name, description, points) VALUES (1, "Benign Birds", "Signed peace treaty with Angry Birds.", 50);
INSERT INTO achievement (gameId, name, description, points) VALUES (1, "Wolfless", "Signed peace treaty with the Big Bad Wolf", 50);
INSERT INTO achievement (gameId, name, description, points) VALUES (1, "Saved the Bacon", "Signed all peace treaties.", 5000);
INSERT INTO achievement (gameId, name, description, points) VALUES (2, "Nuke Dukem", "Put Dukem in the microwave oven.", 375);
INSERT INTO achievement (gameId, name, description, points) VALUES (3, "Apocalypse", "Survived to 2013 as the Mayans.", 2013);
INSERT INTO achievement (gameId, name, description, points) VALUES (3, "Armageddon", "Destroyed the world", 0);
INSERT INTO achievement (gameId, name, description, points) VALUES (3, "World Domination", "Came, Saw, Conquered!", 10000);
INSERT INTO achievement (gameId, name, description, points) VALUES (5, "Draw Nothing", "Drew nothing in the game.", 10);
INSERT INTO achievement (gameId, name, description, points) VALUES (5, "Draw Something", "Drew something in the game.", -10);
INSERT INTO achievement (gameId, name, description, points) VALUES (5, "ESP", "Drew nothing in the game and opponent guessed correctly.", 10000);

INSERT INTO scores (playerId, gameId, score) VALUES (1, 1, 14110);
INSERT INTO scores (playerId, gameId, score) VALUES (1, 2, 9385);
INSERT INTO scores (playerId, gameId, score) VALUES (1, 3, 21023);
INSERT INTO scores (playerId, gameId, score) VALUES (1, 4, 9010);
INSERT INTO scores (playerId, gameId, score) VALUES (1, 5, 19010);

INSERT INTO earns (playerId, achievementId, dateEarned, remark) VALUES (1, 1, "2012-12-20", "I did it!");
INSERT INTO earns (playerId, achievementId, dateEarned, remark) VALUES (1, 2, "2012-12-20", "I did it!");
INSERT INTO earns (playerId, achievementId, dateEarned, remark) VALUES (1, 3, "2012-12-20", "I did it!");
INSERT INTO earns (playerId, achievementId, dateEarned, remark) VALUES (1, 4, "2012-12-20", "I did it!");
INSERT INTO earns (playerId, achievementId, dateEarned, remark) VALUES (1, 5, "2012-12-20", "I did it!");
INSERT INTO earns (playerId, achievementId, dateEarned, remark) VALUES (1, 6, "2012-12-20", "I did it!");
INSERT INTO earns (playerId, achievementId, dateEarned, remark) VALUES (1, 7, "2012-12-20", "I did it!");
INSERT INTO earns (playerId, achievementId, dateEarned, remark) VALUES (1, 8, "2012-12-20", "I did it!");
INSERT INTO earns (playerId, achievementId, dateEarned, remark) VALUES (1, 9, "2012-12-20", "I did it!");
INSERT INTO earns (playerId, achievementId, dateEarned, remark) VALUES (1, 10, "2012-12-20", "I did it!");
INSERT INTO earns (playerId, achievementId, dateEarned, remark) VALUES (1, 11, "2012-12-20", "I did it!");
INSERT INTO earns (playerId, achievementId, dateEarned, remark) VALUES (1, 12, "2012-12-20", "I did it!");
INSERT INTO earns (playerId, achievementId, dateEarned, remark) VALUES (1, 13, "2012-12-20", "I did it!");
INSERT INTO earns (playerId, achievementId, dateEarned, remark) VALUES (1, 14, "2012-12-20", "I did it!");
INSERT INTO earns (playerId, achievementId, dateEarned, remark) VALUES (1, 15, "2012-12-20", "I did it!");
INSERT INTO earns (playerId, achievementId, dateEarned, remark) VALUES (1, 16, "2012-12-20", "I did it!");
INSERT INTO earns (playerId, achievementId, dateEarned, remark) VALUES (1, 17, "2012-12-20", "I did it!");
INSERT INTO earns (playerId, achievementId, dateEarned, remark) VALUES (1, 18, "2012-12-20", "I did it!");
INSERT INTO earns (playerId, achievementId, dateEarned, remark) VALUES (1, 19, "2012-12-20", "Oops!");
INSERT INTO earns (playerId, achievementId, dateEarned, remark) VALUES (1, 20, "2012-12-20", "I did it!");



INSERT INTO earns (playerId, achievementId, dateEarned, remark) VALUES (,,"","");
INSERT INTO earns (playerId, achievementId, dateEarned, remark) VALUES (,,"","");
INSERT INTO earns (playerId, achievementId, dateEarned, remark) VALUES (,,"","");
INSERT INTO earns (playerId, achievementId, dateEarned, remark) VALUES (,,"","");