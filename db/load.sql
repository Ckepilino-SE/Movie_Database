USE movie_db;

LOAD DATA LOCAL INFILE '/Users/scott/Developer/college/Movie_Database/data/directs.csv' INTO TABLE MOVIE FIELDS
TERMINATED BY ',' ENCLOSED BY '"' LINES TERMINATED BY '\r\n' IGNORE 1 ROWS;

LOAD DATA LOCAL INFILE '/Users/scott/Developer/college/Movie_Database/data/person.csv' INTO TABLE PERSON FIELDS
TERMINATED BY ',' ENCLOSED BY '"' LINES TERMINATED BY '\r\n' IGNORE 1 ROWS;

LOAD DATA LOCAL INFILE '/Users/scott/Developer/college/Movie_Database/data/directs.csv' INTO TABLE DIRECTS FIELDS
TERMINATED BY ',' ENCLOSED BY '"' LINES TERMINATED BY '\r\n' IGNORE 1 ROWS;

LOAD DATA LOCAL INFILE '/Users/scott/Developer/college/Movie_Database/data/writes.csv' INTO TABLE WRITES FIELDS
TERMINATED BY ',' ENCLOSED BY '"' LINES TERMINATED BY '\r\n' IGNORE 1 ROWS;

LOAD DATA LOCAL INFILE '/Users/scott/Developer/college/Movie_Database/data/stars_in.csv' INTO TABLE STARS_IN
FIELDS TERMINATED BY ',' ENCLOSED BY '"' LINES TERMINATED BY '\r\n' IGNORE 1 ROWS;

LOAD DATA LOCAL INFILE '/Users/scott/Developer/college/Movie_Database/data/user.csv' INTO TABLE USER FIELDS
TERMINATED BY ',' ENCLOSED BY '"' LINES TERMINATED BY '\r\n' IGNORE 1 ROWS;

LOAD DATA LOCAL INFILE '/Users/scott/Developer/college/Movie_Database/data/review.csv' INTO TABLE REVIEW FIELDS
TERMINATED BY ',' ENCLOSED BY '"' LINES TERMINATED BY '\r\n' IGNORE 1 ROWS;

LOAD DATA LOCAL INFILE '/Users/scott/Developer/college/Movie_Database/data/user_review.csv' INTO TABLE USER_REVIEW FIELDS 
TERMINATED BY ',' ENCLOSED BY '"' LINES TERMINATED BY '\r\n' IGNORE 1 ROWS;

LOAD DATA LOCAL INFILE '/Users/scott/Developer/college/Movie_Database/data/favorites.csv' INTO TABLE FAVORITES
FIELDS TERMINATED BY ',' ENCLOSED BY '"' LINES TERMINATED BY '\r\n' IGNORE 1 ROWS;