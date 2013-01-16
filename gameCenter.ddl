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
	picture VARCHAR (50),
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
	username VARCHAR (50) NOT NULL,
	password VARCHAR (10),
	PRIMARY KEY (id),
	UNIQUE (username)
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

INSERT INTO player (firstName, lastName, sex, username, password) VALUES ("Ramon", "Lawrence", "Male", "rlawrence", "123456");
INSERT INTO player (firstName, lastName, sex, username, password) VALUES ("Patricia", "Lasserre", "Female", "plasserre", "123456");
INSERT INTO player (firstName, lastName, sex, username, password) VALUES ("Yves", "Lucet", "Male", "ylucet", "123456");
INSERT INTO player (firstName, lastName, sex, username, password) VALUES ("Yong", "Gao", "Male", "ygao", "123456");
INSERT INTO player (firstName, lastName, sex, username, password) VALUES ("Bowen", "Hui", "Female", "bhui", "123456");
INSERT INTO player (firstName, lastName, sex, username, password) VALUES ("Alan", "Paeth", "Male", "apaeth", "123456");
INSERT INTO player (firstName, lastName, sex, username, password) VALUES ("Jodie", "Foster", "Female", "jfoster", "123456");

UPDATE player SET picture = "1.jpg" WHERE id = 1;
UPDATE player SET picture = "2.jpg" WHERE id = 2;
UPDATE player SET picture = "3.jpg" WHERE id = 3;
UPDATE player SET picture = "4.jpg" WHERE id = 4;
UPDATE player SET picture = "5.jpg" WHERE id = 5;
UPDATE player SET picture = "7.jpg" WHERE id = 7;

INSERT INTO game (name, publisher, releaseDate, rating) VALUES ("Pacifist Pigs", "Back Bacon, Inc", "2010-04-01", "EC");
INSERT INTO game (name, publisher, releaseDate, rating) VALUES ("Nuke Dukem", "NorKor Industries", "1000-01-01", "M");
INSERT INTO game (name, publisher, releaseDate, rating) VALUES ("Civilization MMXIII", "MayanIncAl Software", "2012-12-20", "T");
INSERT INTO game (name, publisher, releaseDate, rating) VALUES ("Numbers with Enemies", "VengeanceIsBestServed Productions", "2012-01-02", "T");
INSERT INTO game (name, publisher, releaseDate, rating) VALUES ("Draw Nothing", "Blank Page Entertainment", "2012-06-30", "E");

UPDATE game SET picture = "1.jpg" WHERE id = 1;

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

INSERT INTO scores (playerId, gameId, score) VALUES (1, 1, (select SUM(points) from achievement where id in (select achievementId from earns where playerId = 1 and gameId = 1)));
INSERT INTO scores (playerId, gameId, score) VALUES (1, 2, (select SUM(points) from achievement where id in (select achievementId from earns where playerId = 1 and gameId = 2)));
INSERT INTO scores (playerId, gameId, score) VALUES (1, 3, (select SUM(points) from achievement where id in (select achievementId from earns where playerId = 1 and gameId = 3)));
INSERT INTO scores (playerId, gameId, score) VALUES (1, 4, (select SUM(points) from achievement where id in (select achievementId from earns where playerId = 1 and gameId = 4)));
INSERT INTO scores (playerId, gameId, score) VALUES (1, 5, (select SUM(points) from achievement where id in (select achievementId from earns where playerId = 1 and gameId = 5)));

INSERT INTO earns (playerId, achievementId, dateEarned, remark) VALUES (7,1,"2013-01-15","Yay, I got an achievement!");
INSERT INTO earns (playerId, achievementId, dateEarned, remark) VALUES (7,11,"2013-01-15","Anger management classes really came in handy!");
INSERT INTO earns (playerId, achievementId, dateEarned, remark) VALUES (7,12,"2013-01-15","This is going on my wall!");
INSERT INTO earns (playerId, achievementId, dateEarned, remark) VALUES (7,13,"2013-01-15","World Peace!");

INSERT INTO scores (playerId, gameId, score) VALUES (7, 1, (select SUM(points) from achievement where id in (select achievementId from earns where playerId = 7 and gameId = 1)));