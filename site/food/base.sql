CREATE DATABASE foodmart;
USE foodmart;

CREATE TABLE categories (
    category_id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) 
);

CREATE TABLE products (
    product_id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) ,
    price DECIMAL(10,2) ,
    stock_quantity INT DEFAULT 0,
    unit VARCHAR(50),
    rating DECIMAL(3,2),
    category_id INT,
    image_url VARCHAR(255),
    FOREIGN KEY (category_id) REFERENCES categories(category_id)
);

CREATE TABLE users (
    user_id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50),
    email VARCHAR(100)
    
);



CREATE TABLE orders (
    order_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    status ENUM('pending', 'processing', 'shipped', 'delivered', 'cancelled') DEFAULT 'pending',
    total_amount DECIMAL(10,2),
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

CREATE TABLE articles_commandes(
    order_item_id INT PRIMARY KEY AUTO_INCREMENT,
    order_id INT,
    product_id INT,
    quantity INT,
    unit_price DECIMAL(10,2),
    subtotal DECIMAL(10,2),
    FOREIGN KEY (order_id) REFERENCES orders(order_id),
    FOREIGN KEY (product_id) REFERENCES products(product_id)
);

CREATE TABLE avis_clients (
    review_id INT PRIMARY KEY AUTO_INCREMENT,
    product_id INT,
    user_id INT,
    rating INT CHECK (rating BETWEEN 1 AND 5),
    FOREIGN KEY (product_id) REFERENCES products(product_id),
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

CREATE TABLE niveau_ventes(
    niveau_ventes_id INT PRIMARY KEY AUTO_INCREMENT,
    product_id INT,
    FOREIGN KEY (product_id) REFERENCES products(product_id)

);






INSERT INTO categories (name) VALUES
('Groceries'),
('Drinks'),
('Chocolates'),
('Fresh Fruits'),
('Vegetables'),
('Dairy & Eggs'),
('Bakery'),
('Organic Foods');



INSERT INTO products (name, price, stock_quantity, unit, rating, category_id, image_url) VALUES
('Sunstar Fresh Melon Juice', 18.99, 100, '1L', 4.5, 2, 'thumb-bananas.png'),
('Fresh Smoothie Mix', 12.99, 75, '500ml', 4.3, 2, 'product-thumb-1.png'),
('Organic Green Tea', 9.99, 150, '100g', 4.7, 2, 'product-thumb-12.jpg'),
('Natural Orange Juice', 8.99, 80, '1L', 4.6, 2, 'thumb-orange-juice.png'),
('Coconut Water', 5.99, 120, '500ml', 4.4, 2, 'slide-1.jpg'),

('Dark Chocolate Bar', 4.99, 200, '100g', 4.8, 3, 'close.png'),
('Milk Chocolate Truffles', 12.99, 150, '200g', 4.6, 3, 'fullscreen.png'),
('White Chocolate Bar', 3.99, 180, '100g', 4.2, 3, 'fullscreen-black.png'),
('Chocolate Covered Almonds', 8.99, 120, '150g', 4.7, 3, 'left.png'),
('Organic Cacao Powder', 15.99, 90, '250g', 4.5, 3, 'right.png'),

('Organic Bananas', 3.99, 150, '1kg', 4.5, 4, 'thumb-bananas.png'),
('Fresh Strawberries', 6.99, 100, '250g', 4.7, 4, 'thumb-raspberries.png'),
('Green Apples', 4.99, 200, '1kg', 4.4, 4, 'thumb-avocado.png'),
('Fresh Oranges', 5.99, 180, '1kg', 4.6, 4, 'thumb-orange-juice.png'),
('Organic Blueberries', 8.99, 80, '125g', 4.8, 4, 'thumb-raspberries.png'),

('Fresh concombre', 4.99, 100, '200g', 4.6, 5, 'thumb-cucumber.png'),
('Cherry Tomatoes', 3.99, 150, '250g', 4.5, 5, 'thumb-tomatoes.png'),
('Organic Carrots', 2.99, 200, '500g', 4.4, 5, 'banner-image-1.jpg'),
('Bell Peppers Mix', 5.99, 120, '500g', 4.7, 5, 'product-thumb-14.jpg'),
('Fresh Broccoli', 3.99, 100, '400g', 4.3, 5, 'post-thumb-3.jpg');

('Chocolate Covered Almonds', 8.99, 120, '150g', 4.7, 1, 'left.png'),
('Organic Cacao Powder', 15.99, 90, '250g', 4.5, 1, 'right.png'),
('Organic Carrots', 2.99, 200, '500g', 4.4, 1, 'banner-image-1.jpg'),
('Bell Peppers Mix', 5.99, 120, '500g', 4.7, 1, 'product-thumb-14.jpg'),
('White Chocolate Bar', 3.99, 180, '100g', 4.2, 1, 'fullscreen-black.png'),
('Chocolate Covered Almonds', 8.99, 120, '150g', 4.7, 1, 'left.png');


INSERT INTO users (name, email) VALUES
('John','john.doe@email.com'),
('Jane', 'jane.smith@email.com'),
('Mike',  'mike.johnson@email.com'),
('Sarah', 'sarah.williams@email.com'),
('David','david.brown@email.com');

INSERT INTO orders (user_id, status, total_amount) VALUES
(1, 'delivered', 156.94),
(2, 'processing', 89.95),
(3, 'shipped', 234.85);

INSERT INTO articles_commandes(order_id, product_id, quantity, unit_price, subtotal) VALUES
(1, 1, 2, 18.99, 37.98),
(1, 6, 3, 4.99, 14.97),
(2, 11, 4, 3.99, 15.96),
(2, 16, 3, 4.99, 14.97),
(3, 3, 5, 9.99, 49.95),
(3, 8, 2, 3.99, 7.98);


INSERT INTO avis_clients (product_id, user_id, rating) VALUES
(1, 1, 5),
(1, 2, 4),
(6, 3, 5),
(11, 4, 4),
(16, 5, 5);











