/*
Тут в идеале сделать классы для миграции отдельных таблиц с интерфейсом через модели.
Для первого варианта тут будет sql который создаст и заполнит первичные данные.
 */


SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

--
-- База данных: `test_prishlyak`
--
CREATE DATABASE IF NOT EXISTS `test_prishlyak` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE test_prishlyak;

-- --------------------------------------------------------

--
-- Структура таблицы `category`
--

CREATE TABLE IF NOT EXISTS `category` (
`id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `file` varchar(255) NOT NULL,
  `parent_category` int(11) NOT NULL,
  `number_sort` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Дамп данных таблицы `category`
--

INSERT INTO `category` (`id`, `name`, `file`, `parent_category`, `number_sort`) VALUES(1, 'Магнитофоны', '/img/uploaded/category/1.png', 0, 1);
INSERT INTO `category` (`id`, `name`, `file`, `parent_category`, `number_sort`) VALUES(2, 'Телевизоры', '/img/uploaded/category/2.png', 0, 2);
INSERT INTO `category` (`id`, `name`, `file`, `parent_category`, `number_sort`) VALUES(3, 'Кассеты', '/img/uploaded/category/3.png', 1, 4);
INSERT INTO `category` (`id`, `name`, `file`, `parent_category`, `number_sort`) VALUES(4, 'Диски', '/img/uploaded/category/4.png', 0, 3);
INSERT INTO `category` (`id`, `name`, `file`, `parent_category`, `number_sort`) VALUES(5, 'Sony', '/img/uploaded/category/5.png', 3, 5);
INSERT INTO `category` (`id`, `name`, `file`, `parent_category`, `number_sort`) VALUES(6, 'Philips', '/img/uploaded/category/6.png', 3, 6);
INSERT INTO `category` (`id`, `name`, `file`, `parent_category`, `number_sort`) VALUES(7, 'Ноутбуки', '/img/uploaded/category/7.png', 0, 7);
INSERT INTO `category` (`id`, `name`, `file`, `parent_category`, `number_sort`) VALUES(8, 'Планшеты', '/img/uploaded/category/8.png', 0, 8);
INSERT INTO `category` (`id`, `name`, `file`, `parent_category`, `number_sort`) VALUES(9, 'Наушники', '/img/uploaded/category/9.png', 0, 9);
INSERT INTO `category` (`id`, `name`, `file`, `parent_category`, `number_sort`) VALUES(10, 'Смартфоны', '/img/uploaded/category/1.png', 0, 10);
INSERT INTO `category` (`id`, `name`, `file`, `parent_category`, `number_sort`) VALUES(11, 'Стулья', '/img/uploaded/category/2.png', 0, 11);

INSERT INTO `category` (`id`, `name`, `file`, `parent_category`, `number_sort`) VALUES(12, 'Магнитофоны', '/img/uploaded/category/1.png', 0, 12);
INSERT INTO `category` (`id`, `name`, `file`, `parent_category`, `number_sort`) VALUES(13, 'Телевизоры', '/img/uploaded/category/2.png', 0, 13);
INSERT INTO `category` (`id`, `name`, `file`, `parent_category`, `number_sort`) VALUES(14, 'Кассеты', '/img/uploaded/category/3.png', 1, 14);
INSERT INTO `category` (`id`, `name`, `file`, `parent_category`, `number_sort`) VALUES(15, 'Диски', '/img/uploaded/category/4.png', 0, 15);
INSERT INTO `category` (`id`, `name`, `file`, `parent_category`, `number_sort`) VALUES(16, 'Sony', '/img/uploaded/category/5.png', 3, 16);
INSERT INTO `category` (`id`, `name`, `file`, `parent_category`, `number_sort`) VALUES(17, 'Philips', '/img/uploaded/category/6.png', 3, 17);
INSERT INTO `category` (`id`, `name`, `file`, `parent_category`, `number_sort`) VALUES(18, 'Ноутбуки', '/img/uploaded/category/7.png', 0, 18);
INSERT INTO `category` (`id`, `name`, `file`, `parent_category`, `number_sort`) VALUES(19, 'Планшеты', '/img/uploaded/category/8.png', 0, 19);
INSERT INTO `category` (`id`, `name`, `file`, `parent_category`, `number_sort`) VALUES(20, 'Наушники', '/img/uploaded/category/9.png', 0, 20);
INSERT INTO `category` (`id`, `name`, `file`, `parent_category`, `number_sort`) VALUES(21, 'Смартфоны', '/img/uploaded/category/1.png', 0, 21);
INSERT INTO `category` (`id`, `name`, `file`, `parent_category`, `number_sort`) VALUES(22, 'Стулья', '/img/uploaded/category/2.png', 0, 22);

INSERT INTO `category` (`id`, `name`, `file`, `parent_category`, `number_sort`) VALUES(23, 'Магнитофоны', '/img/uploaded/category/1.png', 0, 23);
INSERT INTO `category` (`id`, `name`, `file`, `parent_category`, `number_sort`) VALUES(24, 'Телевизоры', '/img/uploaded/category/2.png', 0, 24);
INSERT INTO `category` (`id`, `name`, `file`, `parent_category`, `number_sort`) VALUES(25, 'Кассеты', '/img/uploaded/category/3.png', 1, 25);
INSERT INTO `category` (`id`, `name`, `file`, `parent_category`, `number_sort`) VALUES(26, 'Диски', '/img/uploaded/category/4.png', 0, 26);
INSERT INTO `category` (`id`, `name`, `file`, `parent_category`, `number_sort`) VALUES(27, 'Sony', '/img/uploaded/category/5.png', 3, 27);
INSERT INTO `category` (`id`, `name`, `file`, `parent_category`, `number_sort`) VALUES(28, 'Philips', '/img/uploaded/category/6.png', 3, 28);
INSERT INTO `category` (`id`, `name`, `file`, `parent_category`, `number_sort`) VALUES(29, 'Ноутбуки', '/img/uploaded/category/7.png', 0, 29);
INSERT INTO `category` (`id`, `name`, `file`, `parent_category`, `number_sort`) VALUES(30, 'Планшеты', '/img/uploaded/category/8.png', 0, 30);
INSERT INTO `category` (`id`, `name`, `file`, `parent_category`, `number_sort`) VALUES(31, 'Наушники', '/img/uploaded/category/9.png', 0, 31);
INSERT INTO `category` (`id`, `name`, `file`, `parent_category`, `number_sort`) VALUES(32, 'Смартфоны', '/img/uploaded/category/1.png', 0, 32);
INSERT INTO `category` (`id`, `name`, `file`, `parent_category`, `number_sort`) VALUES(33, 'Стулья', '/img/uploaded/category/2.png', 0, 33);

INSERT INTO `category` (`id`, `name`, `file`, `parent_category`, `number_sort`) VALUES(34, 'Магнитофоны', '/img/uploaded/category/1.png', 0, 34);
INSERT INTO `category` (`id`, `name`, `file`, `parent_category`, `number_sort`) VALUES(35, 'Телевизоры', '/img/uploaded/category/2.png', 0, 35);
INSERT INTO `category` (`id`, `name`, `file`, `parent_category`, `number_sort`) VALUES(36, 'Кассеты', '/img/uploaded/category/3.png', 1, 36);
INSERT INTO `category` (`id`, `name`, `file`, `parent_category`, `number_sort`) VALUES(37, 'Диски', '/img/uploaded/category/4.png', 0, 37);
INSERT INTO `category` (`id`, `name`, `file`, `parent_category`, `number_sort`) VALUES(38, 'Sony', '/img/uploaded/category/5.png', 3, 38);
INSERT INTO `category` (`id`, `name`, `file`, `parent_category`, `number_sort`) VALUES(39, 'Philips', '/img/uploaded/category/6.png', 3, 39);
INSERT INTO `category` (`id`, `name`, `file`, `parent_category`, `number_sort`) VALUES(40, 'Ноутбуки', '/img/uploaded/category/7.png', 0, 40);
INSERT INTO `category` (`id`, `name`, `file`, `parent_category`, `number_sort`) VALUES(41, 'Планшеты', '/img/uploaded/category/8.png', 0, 41);
INSERT INTO `category` (`id`, `name`, `file`, `parent_category`, `number_sort`) VALUES(42, 'Наушники', '/img/uploaded/category/9.png', 0, 42);
INSERT INTO `category` (`id`, `name`, `file`, `parent_category`, `number_sort`) VALUES(43, 'Смартфоны', '/img/uploaded/category/1.png', 0, 43);
INSERT INTO `category` (`id`, `name`, `file`, `parent_category`, `number_sort`) VALUES(44, 'Стулья', '/img/uploaded/category/2.png', 0, 44);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
 ADD PRIMARY KEY (`id`);


--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=57;
--

DELIMITER //
CREATE TRIGGER `trigger_delete_category` BEFORE DELETE ON `category`
 FOR EACH ROW BEGIN
   DELETE FROM product WHERE category_id = OLD.id;
END//
DELIMITER ;

-- --------------------------------------------------------

--
-- Структура таблицы `product`
--

CREATE TABLE IF NOT EXISTS `product` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `date_create` datetime NOT NULL,
  `date_modifed` datetime NOT NULL,
  `file` varchar(255) NOT NULL,
  `visible` tinyint(1) NOT NULL,
  `isset` tinyint(1) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Дамп данных таблицы `product`
--

INSERT INTO `product` (`id`, `name`, `price`, `category_id`, `date_create`, `date_modifed`, `file`, `visible`, `isset`, `description`)
  VALUES(1, 'Магнитофон тест1', 100, 1, '2015-08-01 00:00:00', '2015-08-01 06:23:30', '/img/uploaded/product/1.png', 1, 1, 'Какой то текст описания ');
INSERT INTO `product` (`id`, `name`, `price`, `category_id`, `date_create`, `date_modifed`, `file`, `visible`, `isset`, `description`)
  VALUES(2, 'Магнитофон тест2', 11, 1, '2015-08-01 00:00:00', '2015-08-01 06:23:30', '/img/uploaded/product/2.png', 1, 1, 'Какой то текст описания 2 ');
INSERT INTO `product` (`id`, `name`, `price`, `category_id`, `date_create`, `date_modifed`, `file`, `visible`, `isset`, `description`)
  VALUES(3, 'Телевизор тест1', 123, 2, '2015-08-01 00:00:00', '2015-08-01 06:23:30', '/img/uploaded/product/3.png', 1, 1, 'Какой то текст описания ');
INSERT INTO `product` (`id`, `name`, `price`, `category_id`, `date_create`, `date_modifed`, `file`, `visible`, `isset`, `description`)
  VALUES(4, 'Кассета тест1', 3000, 3, '2015-08-01 00:00:00', '2015-08-01 06:23:30', '/img/uploaded/product/4.png', 1, 1, 'Какой то текст описания ');
INSERT INTO `product` (`id`, `name`, `price`, `category_id`, `date_create`, `date_modifed`, `file`, `visible`, `isset`, `description`)
  VALUES(5, 'Кассета тест2', 25, 3, '2015-08-01 00:00:00', '2015-08-01 06:23:30', '/img/uploaded/product/5.png', 1, 1, 'Какой то текст описания ');
INSERT INTO `product` (`id`, `name`, `price`, `category_id`, `date_create`, `date_modifed`, `file`, `visible`, `isset`, `description`)
  VALUES(6, 'Диск1', 55, 4, '2015-08-01 00:00:00', '2015-08-01 06:23:30', '/img/uploaded/product/6.png', 1, 1, 'Какой то текст описания ');
INSERT INTO `product` (`id`, `name`, `price`, `category_id`, `date_create`, `date_modifed`, `file`, `visible`, `isset`, `description`)
  VALUES(7, 'Кассета тест11', 77, 5, '2015-08-01 00:00:00', '2015-08-01 06:23:30', '/img/uploaded/product/7.png', 1, 1, 'Какой то текст описания ');
INSERT INTO `product` (`id`, `name`, `price`, `category_id`, `date_create`, `date_modifed`, `file`, `visible`, `isset`, `description`)
  VALUES(8, 'Кассета тест12', 78, 5, '2015-08-01 00:00:00', '2015-08-01 06:23:30', '/img/uploaded/product/8.png', 1, 1, 'Какой то текст описания ');
INSERT INTO `product` (`id`, `name`, `price`, `category_id`, `date_create`, `date_modifed`, `file`, `visible`, `isset`, `description`)
  VALUES(9, 'Кассета тест13', 99, 6, '2015-08-01 00:00:00', '2015-08-01 06:23:30', '/img/uploaded/product/9.png', 1, 1, 'Какой то текст описания ');
INSERT INTO `product` (`id`, `name`, `price`, `category_id`, `date_create`, `date_modifed`, `file`, `visible`, `isset`, `description`)
  VALUES(10, 'Кассета Скрытая', 99, 6, '2015-08-01 00:00:00', '2015-08-01 06:23:30', '/img/uploaded/product/9.png', 0, 1, 'Какой то текст описания ');


--
-- Indexes for table `product`
--
ALTER TABLE `product`
 ADD PRIMARY KEY (`id`);


-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;


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


COMMIT;
