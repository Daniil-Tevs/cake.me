INSERT IGNORE INTO up_cake_recipe(ID,NAME,DESCRIPTION,TIME,REACTION,USER_ID, CALORIES, PORTION_COUNT)
VALUES (1,'Брауни (brownie)','Один из самых популярных десертов в мире — брауни — был придуман в 1893 году на
кухне легендарного отеля Palmer House в Чикаго. Этот пирог там пекут до сих пор по оригинальному рецепту,
покрывая сверху абрикосовой глазурью. В домашней версии, впрочем, у брауни получается такая изумительная
сахарная корочка, что глазировать ее было бы преступлением. У традиционных шоколадных брауни ванильный аромат,
хрустящая корочка и влажная серединка. В торт также добавляют грецкие орехи или фисташки, а еще клюкву.',90,0,1, 435, 3),
       (2,'Спагетти карбонара со сливками','Спагетти карбонара — хоть блюдо и итальянское, оно имеет хорошую
популярность во всем мире, в том числе и у нас. Изобретенная когда-то простыми шахтерами, эта простая и сытная
паста завоевала сердца и желудки многих. Для карбонары нужно выбирать такие ломтики бекона, где больше мяса и меньше
жира. Если его будет много, то, вытапливаясь при готовке, он сделает пасту слишком тяжелой. Можно подавить чеснок
и бросить в поджарку. Но, чтобы блюдо приобрело утонченный, еле уловимый аромат, достаточно потомить ломтики чеснока
в масле и убрать из сковороды спустя пару минут. Не обязательно использовать в рецепте карбонары спагетти — выбирайте
любимые макароны из 500 видов всевозможной пасты. Но только из твердых сортов пшеницы.',120,0,1, 250, 2),
       (3,'Сырники из творога','Главный секрет идеальных сырников — а точнее творожников, —
творог нужно протереть через мелкое сито и отжать от влаги. Жирность предпочтительна не больше и не меньше
9%. Тесто должно получиться эластичным, чтобы при надавливании сырник не треснул на сковородке, а сохранил
форму. Если все сделать правильно, получатся нежные однородные кругляшки под плотной румяной корочкой.
Сырники можно запекать в духовке или готовить на пару. В рецепте не исключаются эксперименты с начинкой —
сухофрукты, орехи, свежие фрукты и даже картофель лишними не будут. Приятного аппетита!',30,0,1, 350, 4);

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
				тридцать минут до появления сахарной корочки.', 5, 1),
        (6, 'Нарезаем бекон кубиками. Два зубчика чеснока раздавливаем ножом.
				Разогреваем сковороду, растапливаем 1 ст. ложку сливочного масла и обжариваем бекон с чесноком.
				Жарим на слабом огне 10 минут, из бекона должен вытопиться жир, но бекон должен остаться мягким.
				После обжаривания чеснок удаляем.', 1, 2),
       (7, 'В кипящую воду (2,3 л) добавляем 1 ст. ложку соли, 1 ст. ложку оливкового масла и спагетти.
				Варим спагетти так, как указано на их упаковке, важно соблюдать указанное время варки,
				чтобы сварить спагетти правильно.', 2, 2),
       (8, 'Отделяем 3 желтка от белков. Кладем в миску желтки и одно яйцо, солим и перчим (по 1 щепотке),
			хорошо взбиваем.', 3, 2),
       (9, 'Выключаем огонь под сковородой с беконом, добавляем спагетти и 1 ст. ложку сливочного масла.
				Вливаем взбитые яйца с сыром, все тщательно перемешиваем.
				Постепенно добавляем 300 мл бульона (воды) от спагетти и постоянно перемешиваем, яйца не должны свернуться.', 4, 2),
       (10, 'Чтобы соус немного загустел, под сковородой включаем слабый огонь и постоянно перемешиваем примерно
				1 минуту, чтобы яйца не сварились. Если соус получится очень густой, можете добавить еще бульона.', 5, 2),
       (11, 'Соединим в миске творог, яйцо, сахар, ванильный сахар и соль.', 1, 3),
       (12, 'Затем добавим муку (2 столовые ложки с горкой) и также все тщательно перемешаем.', 2, 3),
       (13, 'Сформируем шарики из творожной массы.', 3, 3),
       (14, 'На разогретую сковороду нальем растительное масло. Обваляем сырники в муке и выложим на сковороду.
Будем жарить сырники на среднем огне с двух сторон до золотистой корочки.', 4, 3),
       (15, 'Приятного аппетита!', 5, 3);


INSERT IGNORE INTO up_cake_tag(ID, NAME)
VALUES (1, 'Выпечка'),
       (2, 'супы'),
       (3, 'салаты'),
       (4, 'горячее блюдо'),
       (5, 'холодное блюдо'),
       (6, 'диетическое'),
       (7, 'сытное'),
       (8, 'сладкое'),
       (9, 'веганское'),
       (10, 'мясное');

INSERT IGNORE INTO up_cake_recipe_tag(RECIPE_ID, TAG_ID)
VALUES (1, 1), (1, 7), (1, 8),
       (2, 4), (2, 7), (2, 10),
       (3, 1), (3, 4), (3, 8), (3, 7);

INSERT IGNORE INTO up_cake_ingredient(ID, NAME)
VALUES (1, 'Яйца'),
       (2, 'Сахар'),
       (3, 'Соль'),
       (4, 'Молоко'),
       (5, 'Курица'),
       (6, 'Сливки'),
       (7, 'Творог'),
       (8, 'Шоколад'),
       (9, 'Мука'),
       (10, 'Спагетти');

INSERT IGNORE INTO up_cake_type(ID)
VALUES ('грамм'),
       ('мл'),
       ('л'),
       ('кг'),
       ('ч. ложки'),
       ('ст. ложки'),
       ('штук');

INSERT IGNORE INTO up_cake_recipe_ingredient(RECIPE_ID, INGREDIENT_ID, COUNT, TYPE_ID)
VALUES (1, 1, 4, 'штук'), (1, 2, 2, 'ст. ложки'), (1, 9, 200, 'грамм'), (1, 8, 50, 'грамм'),
       (2, 10, 250, 'грамм'), (2, 5, 250, 'грамм'), (2, 9, 200, 'грамм'), (2, 6, 50, 'мл'),
       (3, 1, 2, 'штук'), (3, 2, 2, 'ч. ложки'), (3, 7, 200, 'грамм'), (3, 9, 100, 'грамм'), (3, 4, 200, 'мл');