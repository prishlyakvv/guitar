/*
Тут в идеале сделать классы для миграции отдельных таблиц с интерфейсом через модели.
Для первого варианта тут будет sql который создаст и заполнит первичные данные.
 */


--
-- Структура таблицы `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `file` varchar(255) NOT NULL,
  `parent_category` int(11) NOT NULL,
  `number_sort` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `category`
--

INSERT INTO `category` (`name`, `file`, `parent_category`, `number_sort`) VALUES('Магнитофоны', '/img/uploaded/category/1.png', 0, 1);
INSERT INTO `category` (`name`, `file`, `parent_category`, `number_sort`) VALUES('Телевизоры', '/img/uploaded/category/2.png', 0, 2);
INSERT INTO `category` (`name`, `file`, `parent_category`, `number_sort`) VALUES('Кассеты', '/img/uploaded/category/3.png', 1, 4);
INSERT INTO `category` (`name`, `file`, `parent_category`, `number_sort`) VALUES('Диски', '/img/uploaded/category/4.png', 0, 3);
INSERT INTO `category` (`name`, `file`, `parent_category`, `number_sort`) VALUES('Sony', '/img/uploaded/category/5.png', 3, 5);
INSERT INTO `category` (`name`, `file`, `parent_category`, `number_sort`) VALUES('Philips', '/img/uploaded/category/6.png', 3, 6);
INSERT INTO `category` (`name`, `file`, `parent_category`, `number_sort`) VALUES('Ноутбуки', '/img/uploaded/category/7.png', 0, 7);
INSERT INTO `category` (`name`, `file`, `parent_category`, `number_sort`) VALUES('Планшеты', '/img/uploaded/category/8.png', 0, 8);
INSERT INTO `category` (`name`, `file`, `parent_category`, `number_sort`) VALUES('Наушники', '/img/uploaded/category/9.png', 0, 9);
INSERT INTO `category` (`name`, `file`, `parent_category`, `number_sort`) VALUES('Смартфоны', '/img/uploaded/category/1.png', 0, 10);
INSERT INTO `category` (`name`, `file`, `parent_category`, `number_sort`) VALUES('Стулья', '/img/uploaded/category/2.png', 0, 11);

--
-- Структура таблицы `product`
--

CREATE TABLE IF NOT EXISTS `product` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `date_create` datetime NOT NULL,
  `date_modifed` datetime NOT NULL,
  `file` varchar(255) NOT NULL,
  `visible` tinyint(1) NOT NULL,
  `isset` tinyint(1) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `product`
--

INSERT INTO `product` (`name`, `price`, `category_id`, `date_create`, `date_modifed`, `file`, `visible`, `isset`, `description`)
  VALUES('Магнитофон тест1', 100, 1, '2015-08-01 00:00:00', '2015-08-01 06:23:30', '/img/uploaded/product/1.png', 1, 1, 'Какой то текст описания ');
INSERT INTO `product` (`name`, `price`, `category_id`, `date_create`, `date_modifed`, `file`, `visible`, `isset`, `description`)
  VALUES('Магнитофон тест2', 11, 1, '2015-08-01 00:00:00', '2015-08-01 06:23:30', '/img/uploaded/product/2.png', 1, 1, 'Какой то текст описания 2 ');
INSERT INTO `product` (`name`, `price`, `category_id`, `date_create`, `date_modifed`, `file`, `visible`, `isset`, `description`)
  VALUES('Телевизор тест1', 123, 2, '2015-08-01 00:00:00', '2015-08-01 06:23:30', '/img/uploaded/product/3.png', 1, 1, 'Какой то текст описания ');
INSERT INTO `product` (`name`, `price`, `category_id`, `date_create`, `date_modifed`, `file`, `visible`, `isset`, `description`)
  VALUES('Кассета тест1', 3000, 3, '2015-08-01 00:00:00', '2015-08-01 06:23:30', '/img/uploaded/product/4.png', 1, 1, 'Какой то текст описания ');
INSERT INTO `product` (`name`, `price`, `category_id`, `date_create`, `date_modifed`, `file`, `visible`, `isset`, `description`)
  VALUES('Кассета тест2', 25, 3, '2015-08-01 00:00:00', '2015-08-01 06:23:30', '/img/uploaded/product/5.png', 1, 1, 'Какой то текст описания ');
INSERT INTO `product` (`name`, `price`, `category_id`, `date_create`, `date_modifed`, `file`, `visible`, `isset`, `description`)
  VALUES('Диск1', 55, 4, '2015-08-01 00:00:00', '2015-08-01 06:23:30', '/img/uploaded/product/6.png', 1, 1, 'Какой то текст описания ');
INSERT INTO `product` (`name`, `price`, `category_id`, `date_create`, `date_modifed`, `file`, `visible`, `isset`, `description`)
  VALUES('Кассета тест11', 77, 5, '2015-08-01 00:00:00', '2015-08-01 06:23:30', '/img/uploaded/product/7.png', 1, 1, 'Какой то текст описания ');
INSERT INTO `product` (`name`, `price`, `category_id`, `date_create`, `date_modifed`, `file`, `visible`, `isset`, `description`)
  VALUES('Кассета тест12', 78, 5, '2015-08-01 00:00:00', '2015-08-01 06:23:30', '/img/uploaded/product/8.png', 1, 1, 'Какой то текст описания ');
INSERT INTO `product` (`name`, `price`, `category_id`, `date_create`, `date_modifed`, `file`, `visible`, `isset`, `description`)
  VALUES('Кассета тест13', 99, 6, '2015-08-01 00:00:00', '2015-08-01 06:23:30', '/img/uploaded/product/9.png', 1, 1, 'Какой то текст описания ');
INSERT INTO `product` (`name`, `price`, `category_id`, `date_create`, `date_modifed`, `file`, `visible`, `isset`, `description`)
  VALUES('Кассета Скрытая', 99, 6, '2015-08-01 00:00:00', '2015-08-01 06:23:30', '/img/uploaded/product/9.png', 0, 1, 'Какой то текст описания ');

/*

DELIMITER //
CREATE TRIGGER `trigger_insert_product` BEFORE INSERT ON `product`
  FOR EACH ROW BEGIN
    SET NEW.date_create = now();
  END//
DELIMITER ;


DELIMITER //
CREATE TRIGGER `trigger_update_product` BEFORE UPDATE ON `product`
  FOR EACH ROW BEGIN
    SET NEW.date_modifed = now();
  END//
DELIMITER ;
*/


--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`name`, `password`) VALUES('admin1', MD5("123456"));
INSERT INTO `users` (`name`, `password`) VALUES('admin2', MD5("test"));
