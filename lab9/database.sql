-- 1. Создаем саму базу данных, если её ещё нет
--    Кодировка utf8mb4 нужна для полной поддержки русского языка и эмодзи
CREATE DATABASE IF NOT EXISTS `friends_book`
    CHARACTER SET utf8mb4 
    COLLATE utf8mb4_general_ci;

-- 2. Говорим серверу использовать именно эту базу для следующих команд
USE `friends_book`;

-- 3. Создаем таблицу для контактов
CREATE TABLE IF NOT EXISTS `friends` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `surname` VARCHAR(50) NOT NULL,
    `name` VARCHAR(50) NOT NULL,
    `patronymic` VARCHAR(50) NULL DEFAULT NULL,
    `gender` ENUM('М','Ж') NOT NULL,
    `birth_date` DATE NULL DEFAULT NULL,
    `phone` VARCHAR(20) NULL DEFAULT NULL,
    `address` TEXT NULL DEFAULT NULL,
    `email` VARCHAR(100) NULL DEFAULT NULL,
    `comment` TEXT NULL DEFAULT NULL,
    
    PRIMARY KEY (`id`)
) 
ENGINE = InnoDB          -- Тип таблицы (поддерживает связи и безопасные транзакции)
DEFAULT CHARACTER SET = utf8mb4 
COLLATE = utf8mb4_general_ci;

-- (Необязательно) Сразу добавим несколько тестовых записей для проверки
INSERT INTO `friends` (`surname`, `name`, `patronymic`, `gender`, `birth_date`, `phone`, `email`, `comment`) VALUES
('Иванов', 'Иван', 'Иванович', 'М', '1990-05-15', '+7 900 123 45 67', 'ivanov@mail.ru', 'Коллега по работе'),
('Петрова', 'Анна', 'Сергеевна', 'Ж', '1985-12-03', '+7 916 777 88 99', 'anna.p@yandex.ru', 'Подруга детства');