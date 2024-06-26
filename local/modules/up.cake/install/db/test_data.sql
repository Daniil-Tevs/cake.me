INSERT IGNORE INTO up_cake_recipe(ID,NAME,DESCRIPTION,TIME,REACTION,USER_ID, CALORIES, PORTION_COUNT)
VALUES (1,'Брауни (brownie)','Один из самых популярных десертов в мире — брауни — был придуман в 1893 году на кухне легендарного отеля Palmer House в Чикаго. Этот пирог там пекут до сих пор по оригинальному рецепту, покрывая сверху абрикосовой глазурью. В домашней версии, впрочем, у брауни получается такая изумительная сахарная корочка, что глазировать ее было бы преступлением. У традиционных шоколадных брауни ванильный аромат, хрустящая корочка и влажная серединка. В торт также добавляют грецкие орехи или фисташки, а еще клюкву.', 40, 0, 1, 676, 4),
		(2,'Спагетти карбонара со сливками','Спагетти карбонара — хоть блюдо и итальянское, оно имеет хорошую популярность во всем мире, в том числе и у нас. Изобретенная когда-то простыми шахтерами, эта простая и сытная паста завоевала сердца и желудки многих. Для карбонары нужно выбирать такие ломтики бекона, где больше мяса и меньше жира. Если его будет много, то, вытапливаясь при готовке, он сделает пасту слишком тяжелой. Можно подавить чеснок и бросить в поджарку. Но, чтобы блюдо приобрело утонченный, еле уловимый аромат, достаточно потомить ломтики чеснока в масле и убрать из сковороды спустя пару минут. Не обязательно использовать в рецепте карбонары спагетти — выбирайте любимые макароны из 500 видов всевозможной пасты. Но только из твердых сортов пшеницы.',30,0,1, null, 5),
		(3,'Сырники из творога','Классические сырники - что может быть лучше на завтрак! Да еще со сметанкой или вареньем... Думаю, вам подойдет этот рецепт сырников.',40,0,1, null, 6),
       (4,'Имбирный лимонад','Прохладный летний напиток для утоления жажды.',15,0,1, 79, 4),
       (5,'Салат «Цезарь»','Классический салат "Цезарь" именно в таком виде узнал и полюбил весь мир. Позже салат начали дополнять куриным филе, помидорами или креветками, но и в самом простом виде салат цезарь очень хорош своим вкусом и хрустящими свойствами.',30,0,1, 245, 4),
       (6,'Итальянский суп с сосисками','Прекрасный, согревающий, густой итальянский суп с сосисками. Очень быстрый в приготовлении. Мясные составляющие можно брать какие угодно – от колбасных изделий до отварного мяса.', 60, 0, 1, 293, 8),
       (7,'Сэндвич с беконом, салатом и томатами','Один из самых популярных сэндвичей на северо-востоке США, Новой Англии. Простой рецепт, именно поэтому у каждого мало-мальски достойного шеф-повара есть свой «настоящий» вариант. Главное — это качество всех немногочисленных ингредиентов.', 20, 0, 1, 671, 1),
       (8,'Куриная печень в сметане','Простое и понятное блюдо, которое прочно обосновалось в русской кухне — куриная печень в сметане. Кто-то добавляет морковь, но мы обошлись без нее. Подавать с картофельным пюре, гречкой, рисом и вообще с каким-угодно гарниром.', 30, 0, 1, 511, 4),

       (9,'Чесночный соус','За основу взят говяжий бульон, сливочное масло придает телу соуса нежность, а чеснок отвечает за вкус. Уксус нужен в минимальных количествах, и, чтобы у соуса появилось новое измерение, лучше добавлять какие-нибудь благородные его сорта — можно яблочный, но лучше уксус из хереса или белого вина. Не возбраняется также внедрить в соус немного обжаренных грибов — тогда из куриных крылышек и ножек или бюджетного свиного шашлыка он сможет сотворить праздник.', 15, 0, 1, 36, 4),
       (10,'Картофельное пюре','Основа основ кулинарной повседневности — картофельное пюре. К чему оно только не идет в качестве гарнира. Главное, что нужно знать про пюре: картошка должна быть с высоким содержанием крахмала — это дает лучшую структуру, масло, молоко и сливки не должны быть обойдены вниманием, яйцо — штука факультативная, но оно дает гладкость и цвет, если использовать только желток, без белка. Собственно, с белком пюре надо готовить только в приступе непереносимой лени. Соблюдение всех технических предписаний способствует неминуемому присвоению таких эпитетов, как нежный, воздушный и вкусный.', 50, 0, 1, 463, 6);

INSERT IGNORE INTO up_cake_instructions(ID, DESCRIPTION, STEP, RECIPE_ID)
VALUES (1, 'Шоколад разломать на кусочки и вместе со сливочным маслом растопить на водяной бане, не переставая все время помешивать лопаткой или деревянной ложкой. Получившийся густой шоколадный соус снять с водяной бани и оставить остывать.', 1, 1),
		(2, 'Тем временем смешать яйца со ста граммами коричневого сахара: яйца разбить в отдельную миску и взбить, постепенно добавляя сахар. Взбивать можно при помощи миксера или вручную — как больше нравится, — но не меньше двух с половиной-трех минут.', 2, 1),
		(3, 'Острым ножом на разделочной доске порубить грецкие орехи. Предварительно их можно поджарить на сухой сковороде до появления аромата, но это необязательная опция.', 3, 1),
		(4, 'В остывший растопленный со сливочным маслом шоколад аккуратно добавить оставшийся сахар, затем муку и измельченные орехи и все хорошо перемешать венчиком.', 4, 1),
		(5, 'Затем влить сахарно-яичную смесь и тщательно смешать с шоколадной массой. Цвет у теста должен получиться равномерным, без разводов.', 5, 1),
       (6, 'Разогреть духовку до 200 градусов. Дно небольшой глубокой огнеупорной формы выстелить листом бумаги для выпечки или калькой. Перелить тесто в форму. Поставить в духовку и выпекать двадцать пять — тридцать минут до появления сахарной корочки.', 6, 1),
       (7, 'Готовый пирог вытащить из духовки, дать остыть и нарезать на квадратики острым ножом или ножом для пиццы — так кусочки получатся особенно ровными.', 7, 1),
       (8, 'Подавать брауни можно просто так, а можно посыпать сверху сахарной пудрой или разложить квадратики по тарелкам и украсить каждую порцию шариком ванильного мороженого.', 8, 1),


        (9, 'Нарезаем бекон кубиками. Два зубчика чеснока раздавливаем ножом. Разогреваем сковороду, растапливаем 1 ст. ложку сливочного масла и обжариваем бекон с чесноком. Жарим на слабом огне 10 минут, из бекона должен вытопиться жир, но бекон должен остаться мягким. После обжаривания чеснок удаляем.', 1, 2),
       (10, 'В кипящую воду (2,3 л) добавляем 1 ст. ложку соли, 1 ст. ложку оливкового масла и спагетти. Варим спагетти так, как указано на их упаковке, важно соблюдать указанное время варки, чтобы сварить спагетти правильно.', 2, 2),
       (11, 'Отделяем 3 желтка от белков. Кладем в миску желтки и одно яйцо, солим и перчим (по 1 щепотке), хорошо взбиваем. Добавляем 2 ст. ложки натертого сыра, перемешиваем.', 3, 2),
       (12, 'Готовые спагетти откидываем на дуршлаг, предварительно оставив 300 мл воды, в которой они варились.', 4, 2),
       (13, 'Выключаем огонь под сковородой с беконом, добавляем спагетти и 1 ст. ложку сливочного масла. Вливаем взбитые яйца с сыром, все тщательно перемешиваем.Постепенно добавляем 300 мл бульона (воды) от спагетти и постоянно перемешиваем, яйца не должны свернуться.', 5, 2),
       (14, 'Чтобы соус немного загустел, под сковородой включаем слабый огонь и постоянно перемешиваем примерно 1 минуту, чтобы яйца не сварились. Если соус получится очень густой, можете добавить еще бульона.', 6, 2),
       (15, 'Выкладываем спагетти на тарелку, сверху посыпаем черным молотым перцем и тертым сыром. Паста карбонара готова.Приятного аппетита!', 7, 2),


        (16, 'Творог хорошо растереть в миске.', 1, 3),
       (17, 'Добавить муку, яйцо, сахар, соль.', 2, 3),
       (18, 'Тщательно перемешать. Тесто должно быть очень мягким, но не должно липнуть к рукам. При необходимости (например, если творог жирный, влажный), можно добавить еще муки.', 3, 3),
       (19, 'Посыпать стол мукой. Массу скатать в форме колбаски диаметром около 5 см, нарезать поперек на равные куски толщиной 1 см. Куски обвалять в муке.', 4, 3),
       (20, 'В сковороде на среднем огне разогреть масло. Сырники обжарить с двух сторон на сковороде с топленым маслом. Сначала 4-5 минут с одной стороны. Затем 4-5 минут с другой стороны.', 5, 3),
		(21, 'К сырникам отдельно подать сметану или варенье!', 6, 3),


       (22, 'Натереть имбирь. На умеренном огне растворить в стакане воды сахар, смешать с тертым имбирем и довести смесь до кипения.', 1, 4),
       (23, 'Снять сковородку с огня и дать ей десять минут отдыха, чтобы сироп как следует настоялся на имбире.', 2, 4),
       (24, 'После чего добавить к сиропу сок четырех лимонов и оставшуюся воду, перемешать и подавать с большим количеством льда.', 3, 4),


       (25, 'Промыть, просушить и нарвать на небольшие кусочки листья салата, отложить в холодильник.', 1, 5),
       (26, 'В горячую сковородку положить 1 столовую ложку сливочного масла. После того, как оно полностью расплавится и начнет шипеть, кинуть нарезанный на пластины зубчик чеснока.', 2, 5),
       (27, 'Куриную грудку нарезать на кусочки приблизительно 1×3 см. Положить в сковороду к чесноку и маслу. Обжаривать на сильном огне приблизительно 10 минут до румяной корочки. Снять с огня.', 3, 5),
       (28, 'В ту же сковородку добавить еще одну столовую ложку сливочного масла и второй зубчик чеснока. В это время нарезать на небольшие кубики хлеб. Положить в сковороду и обжаривать до румяной корочки. Желательно непрерывно помешивать, чтобы не подгорело.', 4, 5),
       (29, 'Достать листья салата, туда же положить обжаренную куриную грудку, помидоры, нарезанные тонкой соломкой. Заправить соусом «Цезарь». Перемешать. Сверху положить получившиеся сухарики и натереть сыр.', 5, 5),

       (30, 'Обжариваем в кастрюле сосиски, пока они не зарумянятся. Перекладывем сосиски в миску.', 1, 6),
       (31, 'В той же кастрюле в масле нарезанный лук пассеруем, чтобы он стал золотистым. Добавляем очень мелко нарубленный чеснок, готовим еще 1 минуту, добавляем размятые ложкой помидоры.', 2, 6),
       (32, 'Добавляем куриный бульон, доводим до кипения, уменьшаем огонь и, закрыв крышкой, варим 25 минут.', 3, 6),
       (33, 'В суп добавляем консервированную белую фасоль, жареные сосиски и предварительно сваренные мелкие макароны. Подаем горячим, можно с пармезаном.', 4, 6),


       (34, 'Хлеб поджарить в тостере, ни в коем случае не доводя до состояния сухаря.', 1, 7),
       (35, 'В майонез (лучше всего сделать домашний), добавить немного оливкового масла, выдавить туда чеснока и капнуть Табаско или свежемолотого перца.', 2, 7),
       (36, 'Чтобы добиться красивых, хрустящих ломтиков, разложите бекон на холодном противне, поместите в холодную духовку и начните разогревать ее до 200''C. Через 15-20 минут бекон приобретет характерный хруст и цвет — главное не пересушить. Сразу выложить бекон на бумажное полотенце, чтобы впитался лишний жир.', 3, 7),
       (37, 'Помидоры порезать кружками по полсантиметра толщиной.', 4, 7),
       (38, 'Сложить листья салата под размер кусков хлеба.', 5, 7),
       (39, 'Сложите вместе ингредиенты, поместите на большую разогретую тарелку.', 6, 7),


       (40, 'Печень промыть. Если есть время вымочить в молоке минут 20, будет еще нежнее. Если времени нет, то можно и не вымачивать. Обрезать прожилки. Порезать на небольшие кусочки.', 1, 8),
       (41, 'Обжарить до золотистого цвета мелко порубленный репчатый лук на сливочном масле.', 2, 8),
       (42, 'Добавить печень. Обжаривать минут 5–7, пока не пропадет красный цвет. Посолить, поперчить.', 3, 8),
       (43, 'Залить сметаной. Тушить на среднем огне минут 10.', 4, 8),

       (44, 'Обжарьте в сковороде на среднем огне сливочное масло с мукой. Добавьте бульон. Посолите, введите уксус. Истолчите чеснок в ступке, введите в смесь.', 1, 9),
       (45, 'Варите, постоянно помешивая, соус в небольшой кастрюле на слабом огне в течение 10 минут. Соус универсален и очень хорош для отварного мяса, рыбы или птицы.', 2, 9),

       (46, 'Картофель — лучше крахмалистого сорта, Робюшон использует французский сорт ratte — помыть и очистить от остатков земли, не срезая кожицы. Положить его в кастрюлю, залить двумя литрами холодной воды, добавить столовую ложку крупной соли и довести все это до легкого кипения. Так варить 25 минут, чтобы в конце нож легко входил и выходил чистым из картошки.', 1, 10),
       (47, 'Вытащить картошку, очистить и пропустить через мельницу для овощей или картофельный пресс (более трудоемко, но для легкости текстуры даже лучше протереть через мелкое сито).', 2, 10),
       (48, 'Переложить результат в сковороду, разогреть и с силой перемешивать на огне пять минут, чтобы она подсушилась.', 3, 10),
       (49, 'Тем временем маленькую сковородку ополоснуть под водой, слить остатки воды и, не вытирая насухо, влить в нее молоко. Довести почти до кипения и держать горячим.', 4, 10),
       (50, 'Уменьшить огонь под картошкой. Нарезать масло — обязательно холодное — и по кусочку добавлять в картошку, энергично разминая и гомогенизируя смесь.', 5, 10),
       (51, 'Когда масло исчезнет, влить горячее молоко и, так же с силой разминая картошку, добиться однородности получающегося пюре. Попробовать пюре на вкус — и приправить солью и свежемолотым черным перцем.', 6, 10);

INSERT IGNORE INTO up_cake_category(ID, NAME)
VALUES (1, 'Кухня'),
       (2, 'Тип блюда'),
       (3, 'Особое');

INSERT IGNORE INTO up_cake_tag(ID, NAME, CATEGORY_ID)
VALUES (1, 'Русская',1),
       (2, 'Итальянская',1),
       (3, 'Английская',1),
       (4, 'Горячее блюдо',2),
       (5, 'Холодное блюдо',2),
       (6, 'Суп',2),
       (7, 'Салат',2),
       (8, 'Десерт',2),
       (9, 'Выпечка',2),
       (10, 'Напитки',2),
       (11, 'Закуска',2),
       (12, 'Соусы',2),
       (13, 'Веганское',3),
       (14, 'Диетическое',3),
       (15, 'Сытное',3),
       (16, 'Сладкое',3),
       (17, 'Мясное',3);


INSERT IGNORE INTO up_cake_recipe_tag(RECIPE_ID, TAG_ID)
VALUES (1, 3), (1, 8), (1, 16),
       (2, 2), (2, 4), (2, 15),(2, 17),
       (3, 1), (3, 4), (3, 9), (3, 15), (3, 16),
       (4, 1), (4, 10),(4, 14),(4, 13),
       (5, 2), (5, 5), (5, 7), (5, 11),(5, 13),(5, 14),
       (6, 2), (6, 6), (6, 15),(6, 17),
       (7, 3), (7, 5), (7, 11),(7, 13),(7, 14),
       (8, 2), (8, 5), (8, 11), (8, 14),(8, 17),
       (9, 1), (9, 12),(9, 13),(9, 14),
       (10, 1), (10, 5),(10, 13),(10, 15);

INSERT IGNORE INTO up_cake_ingredient(ID, NAME)
VALUES (1, 'яйца куриные'), (2, 'сахар'), (3, 'соль'),
       (4, 'молоко'), (6, 'сливки'), (7, 'творог'),
       (8, 'тёмный шоколад'), (9, 'пшеничная мука'), (10, 'спагетти'),
       (11, 'сливочное масло'), (12, 'грецкие орехи'), (13, 'бекон'),
       (14, 'сыр пармезан'), (15, 'масло оливковое'), (16, 'чеснок'),
       (17, 'вода'), (18, 'перец чёрный молотый'), (19, 'лимон'),
       (20, 'имбирь'), (21, 'зелёный салат'), (22, 'помидоры'),
       (23, 'куриное филе'), (24, 'хлеб'), (25, 'соус цезарь'),
       (26, 'сосиски'), (27, 'репчатый лук'), (28, 'куриный бульон'),
       (29, 'макароны'), (30, 'консервированная фасоль'), (31, 'бекон'),
       (32, 'майонез'), (33, 'куриная печень'), (34, 'сметана'),
       (5, 'уксус'), (35, 'мясной бульон') , (36, 'картофель');

INSERT IGNORE INTO up_cake_type(ID)
 VALUES ('грамм'), ('мл'), ('л'),
       ('кг'), ('ч. ложки'), ('ст. ложки'),
       ('штук'), ('стакан'),
        ('зубчика'), ('куска');

INSERT IGNORE INTO up_cake_recipe_ingredient(RECIPE_ID, INGREDIENT_ID, COUNT, TYPE_ID)
VALUES (1, 1, 3, 'штук'), (1, 2, 6.5, 'ст. ложки'), (1, 9, 100, 'грамм'), (1, 8, 2, 'ст. ложки'), (1, 11, 120, 'грамм'), (1, 12, 4, 'штук'),
       (2, 10, 400, 'грамм'), (2, 13, 200, 'грамм'), (2, 1, 4, 'шт'), (2, 14, 50, 'грамм'), (2, 11, 2, 'ст. ложки'),
                (2, 14, 1, 'ст. ложки'), (2, 15, 1, 'ст. ложки'), (2, 16, 2, 'шт'), (2, 17, 2.3, 'л'), (2, 3, 1, 'ч. ложки'), (2, 18, 1, 'ч. ложки'),
       (3, 1, 1, 'штук'), (3, 2, 2, 'ст. ложки'), (3, 7, 500, 'грамм'), (3, 9, 1, 'стакан'), (3, 11, 30, 'грамм'), (3, 3, 1, 'ч. ложки'),
       (4, 2, 50, 'грамм'), (4, 19, 4, 'штук'), (4, 20, 50, 'грамм'), (4, 17, 2, 'л'),
       (5, 21, 50, 'грамм'), (5, 22, 1, 'штук'), (5, 23, 300, 'грамм'), (5, 24, 100, 'грамм'), (5, 25, 1, 'ч. ложки'),
                (5, 11, 2.5, 'ст. ложки'), (5, 16, 2.5, 'зубчика'), (5, 11, 20, 'грамм'), (5, 14, 1, 'ч. ложки'),
       (6, 15, 1.5, 'ст. ложки'), (6, 26, 450, 'грамм'), (6, 27, 2, 'шт'), (6, 16, 2, 'зубчика'), (6, 28, 1, 'л'),
                (6, 22, 800, 'грамм'), (6, 29, 150, 'грамм'), (6, 30, 225, 'грамм'),
       (7, 24, 2, 'куска'), (7, 31, 50, 'грамм'), (7, 32, 3, 'ст. ложки'), (7, 22, 3, 'штук'), (7, 21, 2, 'штук'),
       (8, 33, 600, 'грамм'), (8, 34, 500, 'грамм'), (8, 27, 1, 'штук'), (8, 11, 20, 'грамм'), (8, 3, 1, 'ч. ложки'), (8, 18, 1, 'ч. ложки'),
       (9, 11, 10, 'грамм'), (9, 9, 1, 'ст. ложки'), (9, 35, 1, 'стакан'), (9, 5, 1, 'ст. ложки'), (9, 16, 1, 'штук'), (9, 3, 1, 'ч. ложки'),
       (10, 36, 1, 'кг'), (10, 11, 250, 'грамм'), (10, 4, 150, 'мл'), (10, 3, 1, 'ч. ложки'), (10, 18, 1, 'ч. ложки');