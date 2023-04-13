CREATE TABLE IF NOT EXISTS up_cake_tag
(
	ID INT NOT NULL AUTO_INCREMENT,
	NAME VARCHAR(255) NOT NULL,
	PRIMARY KEY(ID)
);

CREATE TABLE IF NOT EXISTS up_cake_type
(
	ID INT NOT NULL AUTO_INCREMENT,
	NAME VARCHAR(255) NOT NULL,
	PRIMARY KEY(ID)
);

CREATE TABLE IF NOT EXISTS up_cake_ingredient
(
	ID INT NOT NULL AUTO_INCREMENT,
	NAME VARCHAR(255) NOT NULL,
	PRIMARY KEY(ID)
);

CREATE TABLE IF NOT EXISTS up_cake_recipe
(
	ID INT NOT NULL AUTO_INCREMENT,
	NAME VARCHAR(255) NOT NULL,
	DESCRIPTION VARCHAR(510),
	TIME INT,
	REACTION INT,
	CALORIES INT,
	USER_ID INT NOT NULL ,
	DATE_ADDED DATETIME NOT NULL,
	DATE_UPDATED DATETIME,
	PRIMARY KEY(ID),
	FOREIGN KEY FK_CAKE_USER(USER_ID)
		REFERENCES b_user(ID)
		ON UPDATE RESTRICT
		ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS up_cake_instructions
(
	ID INT NOT NULL AUTO_INCREMENT,
	DESCRIPTION VARCHAR(510) NOT NULL,
	STEP INT NOT NULL,
	RECIPE_ID INT,
	PRIMARY KEY(ID),
	FOREIGN KEY FK_CAKE_RECIPE(RECIPE_ID)
		REFERENCES up_cake_recipe(ID)
		ON UPDATE RESTRICT
		ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS up_cake_recipe_tag
(
	RECIPE_ID INT,
	TAG_ID INT,
	FOREIGN KEY FK_CAKE_RECIPE(RECIPE_ID)
		REFERENCES up_cake_recipe(ID)
		ON UPDATE RESTRICT
		ON DELETE CASCADE,
	FOREIGN KEY FK_CAKE_TAG(TAG_ID)
		REFERENCES up_cake_tag(ID)
		ON UPDATE RESTRICT
		ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS up_cake_recipe_ingredient
(
	RECIPE_ID INT,
	INGREDIENT_ID INT,
	COUNT FLOAT,
	TYPE_ID INT,
	FOREIGN KEY FK_CAKE_TYPE(TYPE_ID)
		REFERENCES up_cake_type(ID)
		ON UPDATE RESTRICT
		ON DELETE CASCADE,
	FOREIGN KEY FK_CAKE_RECIPE(RECIPE_ID)
		REFERENCES up_cake_recipe(ID)
		ON UPDATE RESTRICT
		ON DELETE CASCADE,
	FOREIGN KEY FK_CAKE_INGREDIENT(INGREDIENT_ID)
		REFERENCES up_cake_ingredient(ID)
		ON UPDATE RESTRICT
		ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS up_cake_recipe_image
(
	RECIPE_ID INT,
	IMAGE_ID INT,
	FOREIGN KEY FK_CAKE_RECIPE(RECIPE_ID)
		REFERENCES up_cake_recipe(ID)
		ON UPDATE RESTRICT
		ON DELETE CASCADE,
	FOREIGN KEY FK_CAKE_IMAGE(IMAGE_ID)
		REFERENCES b_file(ID)
		ON UPDATE RESTRICT
		ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS up_cake_recipe_comment
(
	RECIPE_ID INT,
	USER_ID INT,
	COMMENT VARCHAR(510),
	FOREIGN KEY FK_CAKE_RECIPE(RECIPE_ID)
		REFERENCES up_cake_recipe(ID)
		ON UPDATE RESTRICT
		ON DELETE CASCADE,
	FOREIGN KEY FK_CAKE_USER(USER_ID)
		REFERENCES b_user(ID)
		ON UPDATE RESTRICT
		ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS up_cake_user_subs
(
	USER_ID INT,
	SUB_ID INT,
	FOREIGN KEY FK_CAKE_USER(USER_ID)
		REFERENCES b_user(ID)
		ON UPDATE RESTRICT
		ON DELETE CASCADE,
	FOREIGN KEY FK_CAKE_SUB(SUB_ID)
		REFERENCES b_user(ID)
		ON UPDATE RESTRICT
		ON DELETE CASCADE
);