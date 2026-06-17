CREATE DATABASE IF NOT EXISTS music_store CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE music_store;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    photo VARCHAR(255) DEFAULT 'default.png',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(200) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    category VARCHAR(100),
    image VARCHAR(255) DEFAULT 'no-image.png',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO products (name, description, price, category, image) VALUES
('Fender Stratocaster', 'Легендарната електрическа китара с три звукоснимателя и плавен тремоло.', 2499.99, 'Китари', 'no-image.png'),
('Roland FP-30X', 'Дигитално пиано с 88 клавиша с тегло, идеално за начинаещи и напреднали.', 1299.99, 'Пиана', 'no-image.png'),
('Pearl Export Series', 'Пълен комплект барабани с 5 части, подходящ за всякакъв стил.', 1799.99, 'Барабани', 'no-image.png'),
('Yamaha YAS-280', 'Алт саксофон от студентски клас с отличен звук и лесно свирене.', 899.99, 'Духови', 'no-image.png'),
('Gibson Les Paul Standard', 'Иконичната електрическа китара с богат, топъл звук.', 3299.99, 'Китари', 'no-image.png'),
('Casio CT-S300', 'Клавишен инструмент с 61 клавиша, 400 тона и 77 ритъма.', 199.99, 'Клавишни', 'no-image.png');
