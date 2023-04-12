CREATE TABLE IF NOT EXISTS up_cake_tag
(
	ID INT NOT NULL AUTO_INCREMENT,
	NAME VARCHAR(255) NOT NULL,
	PRIMARY KEY(ID)
);

CREATE TABLE IF NOT EXISTS up_cake_ingredient
(
	ID INT NOT NULL AUTO_INCREMENT,
	NAME VARCHAR(255) NOT NULL,
	TYPE VARCHAR(100) NOT NULL,
	CALORIES INT,
	PRIMARY KEY(ID)
);

CREATE TABLE IF NOT EXISTS up_cake_recipe
(
	ID INT NOT NULL AUTO_INCREMENT,
	NAME VARCHAR(255) NOT NULL,
	DESCRIPTION VARCHAR(510),
	TIME INT,
	REACTION INT,
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

INSERT IGNORE INTO up_cake_instructions(ID, DESCRIPTION, STEP, RECIPE_ID)
		VALUES (1, 'Шоколад разломать на кусочки и вместе со сливочным маслом растопить на водяной бане, не переставая
				все время помешивать лопаткой или деревянной ложкой. Получившийся густой шоколадный соус снять с
				водяной бани и оставить остывать.', 1, 1),
		       (2, 'Тем временем смешать яйца со ста граммами коричневого сахара: яйца разбить в отдельную миску и
				взбить, постепенно добавляя сахар. Взбивать можно при помощи миксера или вручную — как больше нравится,
				— но не меньше двух с половиной-трех минут.', 2, 1),
		       (3, 'Острым ножом на разделочной доске порубить грецкие орехи. Предварительно их можно поджарить на сухой
				сковороде до появления аромата, но это необязательная опция.', 3, 1),
		       (4, 'Затем влить сахарно-яичную смесь и тщательно смешать с шоколадной массой.
				Цвет у теста должен получиться равномерным, без разводов.', 4, 1),
		       (5, 'Разогреть духовку до 200 градусов. Дно небольшой глубокой огнеупорной формы выстелить листом бумаги
				для выпечки или калькой. Перелить тесто в форму. Поставить в духовку и выпекать двадцать пять —
				тридцать минут до появления сахарной корочки.', 5, 1);