CREATE TABLE shoes (
    ShoeID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    ShoeName VARCHAR(255) NOT NULL,
    ShoeDescription TEXT NOT NULL,
    QuantityAvailable INT(11) NOT NULL,
    Price DECIMAL(10, 2) NOT NULL,
    ShoeType VARCHAR(255) NOT NULL;
    ShoeColor VARCHAR(255) NOT NULL;
);

INSERT INTO shoes (ShoeName, ShoeDescription, QuantityAvailable, Price, ShoeType, ShoeColor)
VALUES 
('PUMA', 'Rebound Sneakers, PUMA Black-PUMA White-PUMA Team Royal', 5, 95.00, 'Sneaker', 'Black & White'),
('New Balance', 'Womens 608 V5 Casual Comfort Cross Trainer', 10, 109.99, 'Casual Shoe', 'White'),
('Skechers', 'Skechers Youth Girls Microspec Max Brightastic Runner Shoe', 7, 59.99, 'Running Shoe', 'Blue'),
('Jordan 1', 'Jordan 1 Retro High OG Remastered PS White / Team Red', 12, 115.99, 'Casual Shoe', 'White & Red'),
('Nike', 'Nike Journey Run Mens Running Shoes', 25, 125.00, 'Running Shoe', 'Black'),
('Adidas', 'Adidas Mens Adidas Originals Samba - Mens Shoes White/Black', 15, 140.00, 'Casual Shoe', 'White'),
('Aldo', 'These almond toe Oxfords are perfect for work, weddings and...pretty much any occasion!', 3, 99.99, 'Formal Shoe', 'Black');
