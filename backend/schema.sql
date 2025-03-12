-- Create the database
CREATE DATABASE ecommerce;
USE ecommerce;

-- Create categories table
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE
);

select * from categories;

-- Create currencies table
CREATE TABLE currencies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    label VARCHAR(10) NOT NULL,
    symbol VARCHAR(10) NOT NULL
);

-- Create brands table
CREATE TABLE brands (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE
);

-- Create products table
CREATE TABLE products (
    id VARCHAR(100) PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    inStock BOOLEAN NOT NULL,
    description TEXT,
    category_id INT,
    brand_id INT,
    FOREIGN KEY (category_id) REFERENCES categories(id),
    FOREIGN KEY (brand_id) REFERENCES brands(id)
);

-- Create product_gallery table for product images
CREATE TABLE product_gallery (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id VARCHAR(100) NOT NULL,
    image_url TEXT NOT NULL,
    display_order INT NOT NULL,
    FOREIGN KEY (product_id) REFERENCES products(id)
);

-- Create product_attributes junction table

-- Create prices table
CREATE TABLE prices (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id VARCHAR(100) NOT NULL,
    amount DECIMAL(10, 2) NOT NULL,
    currency_id INT NOT NULL,
    FOREIGN KEY (product_id) REFERENCES products(id),
    FOREIGN KEY (currency_id) REFERENCES currencies(id)
);



-- Create orders table
-- Create orders table with price field
CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id VARCHAR(100) NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    price DECIMAL(10, 2) NOT NULL,  
    FOREIGN KEY (product_id) REFERENCES products(id)
);


-- Create order_items table to store individual products in an order
CREATE TABLE order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id VARCHAR(100) NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    FOREIGN KEY (order_id) REFERENCES orders(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);

-- Create order_attributes table to store selected attributes for each order
CREATE TABLE order_attributes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id VARCHAR(255) NOT NULL,
    attribute_set_id VARCHAR(255) NOT NULL,
    attribute_item_id VARCHAR(255) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) 
);



-- Create order_item_attributes table to link attributes to order items
CREATE TABLE order_item_attributes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_item_id INT NOT NULL,
    attribute_set_id VARCHAR(100) NOT NULL,
    attribute_item_id VARCHAR(100) NOT NULL,
    FOREIGN KEY (order_item_id) REFERENCES order_items(id) ON DELETE CASCADE,
    FOREIGN KEY (attribute_set_id) REFERENCES attribute_sets(id),
    FOREIGN KEY (attribute_item_id) REFERENCES attribute_items(id)
);

-- Insert data into categories
INSERT INTO categories (name) VALUES
('all'),
('clothes'),
('tech');

-- Insert data into currencies
INSERT INTO currencies (label, symbol) VALUES
('USD', '$');

-- Insert data into brands
INSERT INTO brands (name) VALUES
('Nike x Stussy'),
('Canada Goose'),
('Sony'),
('Microsoft'),
('Apple');

-- Insert data into products
INSERT INTO products (id, name, inStock, description, category_id, brand_id) 
VALUES 
('huarache-x-stussy-le', 'Nike Air Huarache Le', TRUE, '<p>Great sneakers for everyday use!</p>', 
    (SELECT id FROM categories WHERE name = 'clothes'),
    (SELECT id FROM brands WHERE name = 'Nike x Stussy')),
('jacket-canada-goosee', 'Jacket', TRUE, '<p>Awesome winter jacket</p>', 
    (SELECT id FROM categories WHERE name = 'clothes'),
    (SELECT id FROM brands WHERE name = 'Canada Goose')),
('ps-5', 'PlayStation 5', TRUE, '<p>A good gaming console. Plays games of PS4! Enjoy if you can buy it mwahahahaha</p>', 
    (SELECT id FROM categories WHERE name = 'tech'),
    (SELECT id FROM brands WHERE name = 'Sony')),
('xbox-series-s', 'Xbox Series S 512GB', FALSE, 
    '<div><ul><li><span>Hardware-beschleunigtes Raytracing macht dein Spiel noch realistischer</span></li><li><span>Spiele Games mit bis zu 120 Bilder pro Sekunde</span></li><li><span>Minimiere Ladezeiten mit einer speziell entwickelten 512GB NVMe SSD und wechsle mit Quick Resume nahtlos zwischen mehreren Spielen.</span></li><li><span>Xbox Smart Delivery stellt sicher, dass du die beste Version deines Spiels spielst, egal, auf welcher Konsole du spielst</span></li><li><span>Spiele deine Xbox One-Spiele auf deiner Xbox Series S weiter. Deine Fortschritte, Erfolge und Freundesliste werden automatisch auf das neue System übertragen.</span></li><li><span>Erwecke deine Spiele und Filme mit innovativem 3D Raumklang zum Leben</span></li><li><span>Der brandneue Xbox Wireless Controller zeichnet sich durch höchste Präzision, eine neue Share-Taste und verbesserte Ergonomie aus</span></li><li><span>Ultra-niedrige Latenz verbessert die Reaktionszeit von Controller zum Fernseher</span></li><li><span>Verwende dein Xbox One-Gaming-Zubehör -einschließlich Controller, Headsets und mehr</span></li><li><span>Erweitere deinen Speicher mit der Seagate 1 TB-Erweiterungskarte für Xbox Series X (separat erhältlich) und streame 4K-Videos von Disney+, Netflix, Amazon, Microsoft Movies &amp; TV und mehr</span></li></ul></div>', 
    (SELECT id FROM categories WHERE name = 'tech'),
    (SELECT id FROM brands WHERE name = 'Microsoft')),
('apple-imac-2021', 'iMac 2021', TRUE, 'The new iMac!', 
    (SELECT id FROM categories WHERE name = 'tech'),
    (SELECT id FROM brands WHERE name = 'Apple')),
('apple-iphone-12-pro', 'iPhone 12 Pro', TRUE, 'This is iPhone 12. Nothing else to say.', 
    (SELECT id FROM categories WHERE name = 'tech'),
    (SELECT id FROM brands WHERE name = 'Apple')),
('apple-airpods-pro', 'AirPods Pro', FALSE, 
    '<h3>Magic like you\'ve never heard</h3><p>AirPods Pro have been designed to deliver Active Noise Cancellation for immersive sound, Transparency mode so you can hear your surroundings, and a customizable fit for all-day comfort. Just like AirPods, AirPods Pro connect magically to your iPhone or Apple Watch. And they\'re ready to use right out of the case.<h3>Active Noise Cancellation</h3><p>Incredibly light noise-cancelling headphones, AirPods Pro block out your environment so you can focus on what you\'re listening to. AirPods Pro use two microphones, an outward-facing microphone and an inward-facing microphone, to create superior noise cancellation. By continuously adapting to the geometry of your ear and the fit of the ear tips, Active Noise Cancellation silences the world to keep you fully tuned in to your music, podcasts, and calls.<h3>Transparency mode</h3><p>Switch to Transparency mode and AirPods Pro let the outside sound in, allowing you to hear and connect to your surroundings. Outward- and inward-facing microphones enable AirPods Pro to undo the sound-isolating effect of the silicone tips so things sound and feel natural, like when you\'re talking to people around you.</p><h3>All-new design</h3><p>AirPods Pro offer a more customizable fit with three sizes of flexible silicone tips to choose from. With an internal taper, they conform to the shape of your ear, securing your AirPods Pro in place and creating an exceptional seal for superior noise cancellation.</p><h3>Amazing audio quality</h3><p>A custom-built high-excursion, low-distortion driver delivers powerful bass. A superefficient high dynamic range amplifier produces pure, incredibly clear sound while also extending battery life. And Adaptive EQ automatically tunes music to suit the shape of your ear for a rich, consistent listening experience.</p><h3>Even more magical</h3><p>The Apple-designed H1 chip delivers incredibly low audio latency. A force sensor on the stem makes it easy to control music and calls and switch between Active Noise Cancellation and Transparency mode. Announce Messages with Siri gives you the option to have Siri read your messages through your AirPods. And with Audio Sharing, you and a friend can share the same audio stream on two sets of AirPods — so you can play a game, watch a movie, or listen to a song together.</p>', 
    (SELECT id FROM categories WHERE name = 'tech'),
    (SELECT id FROM brands WHERE name = 'Apple')),
('apple-airtag', 'AirTag', TRUE, 
    '<h1>Lose your knack for losing things.</h1><p>AirTag is an easy way to keep track of your stuff. Attach one to your keys, slip another one in your backpack. And just like that, they\'re on your radar in the Find My app. AirTag has your back.</p>', 
    (SELECT id FROM categories WHERE name = 'tech'),
    (SELECT id FROM brands WHERE name = 'Apple'));

-- Insert data into product gallery for Nike Air Huarache
INSERT INTO product_gallery (product_id, image_url, display_order) VALUES
('huarache-x-stussy-le', 'https://cdn.shopify.com/s/files/1/0087/6193/3920/products/DD1381200_DEOA_2_720x.jpg?v=1612816087', 1),
('huarache-x-stussy-le', 'https://cdn.shopify.com/s/files/1/0087/6193/3920/products/DD1381200_DEOA_1_720x.jpg?v=1612816087', 2),
('huarache-x-stussy-le', 'https://cdn.shopify.com/s/files/1/0087/6193/3920/products/DD1381200_DEOA_3_720x.jpg?v=1612816087', 3),
('huarache-x-stussy-le', 'https://cdn.shopify.com/s/files/1/0087/6193/3920/products/DD1381200_DEOA_5_720x.jpg?v=1612816087', 4),
('huarache-x-stussy-le', 'https://cdn.shopify.com/s/files/1/0087/6193/3920/products/DD1381200_DEOA_4_720x.jpg?v=1612816087', 5);

-- Insert data into product gallery for Jacket
INSERT INTO product_gallery (product_id, image_url, display_order) VALUES
('jacket-canada-goosee', 'https://images.canadagoose.com/image/upload/w_480,c_scale,f_auto,q_auto:best/v1576016105/product-image/2409L_61.jpg', 1),
('jacket-canada-goosee', 'https://images.canadagoose.com/image/upload/w_480,c_scale,f_auto,q_auto:best/v1576016107/product-image/2409L_61_a.jpg', 2),
('jacket-canada-goosee', 'https://images.canadagoose.com/image/upload/w_480,c_scale,f_auto,q_auto:best/v1576016108/product-image/2409L_61_b.jpg', 3),
('jacket-canada-goosee', 'https://images.canadagoose.com/image/upload/w_480,c_scale,f_auto,q_auto:best/v1576016109/product-image/2409L_61_c.jpg', 4),
('jacket-canada-goosee', 'https://images.canadagoose.com/image/upload/w_480,c_scale,f_auto,q_auto:best/v1576016110/product-image/2409L_61_d.jpg', 5),
('jacket-canada-goosee', 'https://images.canadagoose.com/image/upload/w_1333,c_scale,f_auto,q_auto:best/v1634058169/product-image/2409L_61_o.png', 6),
('jacket-canada-goosee', 'https://images.canadagoose.com/image/upload/w_1333,c_scale,f_auto,q_auto:best/v1634058159/product-image/2409L_61_p.png', 7);

-- Insert data into product gallery for PS5
INSERT INTO product_gallery (product_id, image_url, display_order) VALUES
('ps-5', 'https://images-na.ssl-images-amazon.com/images/I/510VSJ9mWDL._SL1262_.jpg', 1),
('ps-5', 'https://images-na.ssl-images-amazon.com/images/I/610%2B69ZsKCL._SL1500_.jpg', 2),
('ps-5', 'https://images-na.ssl-images-amazon.com/images/I/51iPoFwQT3L._SL1230_.jpg', 3),
('ps-5', 'https://images-na.ssl-images-amazon.com/images/I/61qbqFcvoNL._SL1500_.jpg', 4),
('ps-5', 'https://images-na.ssl-images-amazon.com/images/I/51HCjA3rqYL._SL1230_.jpg', 5);

-- Insert data into product gallery for Xbox Series S
INSERT INTO product_gallery (product_id, image_url, display_order) VALUES
('xbox-series-s', 'https://images-na.ssl-images-amazon.com/images/I/71vPCX0bS-L._SL1500_.jpg', 1),
('xbox-series-s', 'https://images-na.ssl-images-amazon.com/images/I/71q7JTbRTpL._SL1500_.jpg', 2),
('xbox-series-s', 'https://images-na.ssl-images-amazon.com/images/I/71iQ4HGHtsL._SL1500_.jpg', 3),
('xbox-series-s', 'https://images-na.ssl-images-amazon.com/images/I/61IYrCrBzxL._SL1500_.jpg', 4),
('xbox-series-s', 'https://images-na.ssl-images-amazon.com/images/I/61RnXmpAmIL._SL1500_.jpg', 5);

-- Insert data into product gallery for iMac 2021
INSERT INTO product_gallery (product_id, image_url, display_order) VALUES
('apple-imac-2021', 'https://store.storeimages.cdn-apple.com/4982/as-images.apple.com/is/imac-24-blue-selection-hero-202104?wid=904&hei=840&fmt=jpeg&qlt=80&.v=1617492405000', 1);

-- Insert data into product gallery for iPhone 12 Pro
INSERT INTO product_gallery (product_id, image_url, display_order) VALUES
('apple-iphone-12-pro', 'https://store.storeimages.cdn-apple.com/4982/as-images.apple.com/is/iphone-12-pro-family-hero?wid=940&amp;hei=1112&amp;fmt=jpeg&amp;qlt=80&amp;.v=1604021663000', 1);

-- Insert data into product gallery for AirPods Pro
INSERT INTO product_gallery (product_id, image_url, display_order) VALUES
('apple-airpods-pro', 'https://store.storeimages.cdn-apple.com/4982/as-images.apple.com/is/MWP22?wid=572&hei=572&fmt=jpeg&qlt=95&.v=1591634795000', 1);

-- Insert data into product gallery for AirTag
INSERT INTO product_gallery (product_id, image_url, display_order) VALUES
('apple-airtag', 'https://store.storeimages.cdn-apple.com/4982/as-images.apple.com/is/airtag-double-select-202104?wid=445&hei=370&fmt=jpeg&qlt=95&.v=1617761672000', 1);

-- Insert attribute sets
INSERT INTO attribute_sets (id, name, type) VALUES
('Size', 'Size', 'text'),
('Color', 'Color', 'swatch'),
('Capacity', 'Capacity', 'text'),
('With USB 3 ports', 'With USB 3 ports', 'text'),
('Touch ID in keyboard', 'Touch ID in keyboard', 'text');

-- Insert attribute items for Size
INSERT INTO attribute_items (id, attribute_set_id, display_value, value) VALUES
('40', 'Size', '40', '40'),
('41', 'Size', '41', '41'),
('42', 'Size', '42', '42'),
('43', 'Size', '43', '43'),
('Small', 'Size', 'Small', 'S'),
('Medium', 'Size', 'Medium', 'M'),
('Large', 'Size', 'Large', 'L'),
('Extra Large', 'Size', 'Extra Large', 'XL');

-- Insert attribute items for Color
INSERT INTO attribute_items (id, attribute_set_id, display_value, value) VALUES
('Green', 'Color', 'Green', '#44FF03'),
('Cyan', 'Color', 'Cyan', '#03FFF7'),
('Blue', 'Color', 'Blue', '#030BFF'),
('Black', 'Color', 'Black', '#000000'),
('White', 'Color', 'White', '#FFFFFF');

-- Insert attribute items for Capacity
INSERT INTO attribute_items (id, attribute_set_id, display_value, value) VALUES
('512G', 'Capacity', '512G', '512G'),
('1T', 'Capacity', '1T', '1T'),
('256GB', 'Capacity', '256GB', '256GB'),
('512GB', 'Capacity', '512GB', '512GB');

-- Insert attribute items for With USB 3 ports
INSERT INTO attribute_items (id, attribute_set_id, display_value, value) VALUES
('Yes', 'With USB 3 ports', 'Yes', 'Yes'),
('No', 'With USB 3 ports', 'No', 'No');

-- Insert attribute items for Touch ID in keyboard
INSERT INTO attribute_items (id, attribute_set_id, display_value, value) VALUES
('Yes_Touch', 'Touch ID in keyboard', 'Yes', 'Yes'),
('No_Touch', 'Touch ID in keyboard', 'No', 'No');

-- Associate products with attributes
INSERT INTO product_attributes (product_id, attribute_set_id) VALUES
('huarache-x-stussy-le', 'Size'),
('jacket-canada-goosee', 'Size'),
('ps-5', 'Color'),
('ps-5', 'Capacity'),
('xbox-series-s', 'Color'),
('xbox-series-s', 'Capacity'),
('apple-imac-2021', 'Capacity'),
('apple-imac-2021', 'With USB 3 ports'),
('apple-imac-2021', 'Touch ID in keyboard'),
('apple-iphone-12-pro', 'Capacity'),
('apple-iphone-12-pro', 'Color');

-- Insert prices
INSERT INTO prices (product_id, amount, currency_id) VALUES
('huarache-x-stussy-le', 144.69, (SELECT id FROM currencies WHERE label = 'USD')),
('jacket-canada-goosee', 518.47, (SELECT id FROM currencies WHERE label = 'USD')),
('ps-5', 844.02, (SELECT id FROM currencies WHERE label = 'USD')),
('xbox-series-s', 333.99, (SELECT id FROM currencies WHERE label = 'USD')),
('apple-imac-2021', 1688.03, (SELECT id FROM currencies WHERE label = 'USD')),
('apple-iphone-12-pro', 1000.76, (SELECT id FROM currencies WHERE label = 'USD')),
('apple-airpods-pro', 300.23, (SELECT id FROM currencies WHERE label = 'USD')),
('apple-airtag', 120.57, (SELECT id FROM currencies WHERE label = 'USD'));

-- Create attribute_sets table
CREATE TABLE attribute_sets (
    id VARCHAR(100) PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    type VARCHAR(50) NOT NULL,
    `__typename` VARCHAR(50) DEFAULT 'AttributeSet'
);

-- Create attribute_items table
CREATE TABLE attribute_items (
    id VARCHAR(100) PRIMARY KEY,
    attribute_set_id VARCHAR(100) NOT NULL,
    display_value VARCHAR(100) NOT NULL,
    value VARCHAR(100) NOT NULL,
    `__typename` VARCHAR(50) DEFAULT 'AttributeItem',
    FOREIGN KEY (attribute_set_id) REFERENCES attribute_sets(id)
);

-- Create product_attributes junction table
CREATE TABLE product_attributes (
    product_id VARCHAR(100) NOT NULL,
    attribute_set_id VARCHAR(100) NOT NULL,
    attribute_item_id VARCHAR(100) NOT NULL,
    PRIMARY KEY (product_id, attribute_set_id, attribute_item_id),
    FOREIGN KEY (product_id) REFERENCES products(id),
    FOREIGN KEY (attribute_set_id) REFERENCES attribute_sets(id),
    FOREIGN KEY (attribute_item_id) REFERENCES attribute_items(id)
);

-- Insert attribute sets
INSERT INTO attribute_sets (id, name, type) VALUES 
('Size', 'Size', 'text'),
('Color', 'Color', 'swatch'),
('Capacity', 'Capacity', 'text'),
('With USB 3 ports', 'With USB 3 ports', 'text'),
('Touch ID in keyboard', 'Touch ID in keyboard', 'text');

-- Insert attribute items for Nike Air Huarache Le
INSERT INTO attribute_items (id, attribute_set_id, display_value, value) VALUES 
('40', 'Size', '40', '40'),
('41', 'Size', '41', '41'),
('42', 'Size', '42', '42'),
('43', 'Size', '43', '43');

-- Insert product attributes for Nike Air Huarache Le
INSERT INTO product_attributes (product_id, attribute_set_id, attribute_item_id) VALUES 
('huarache-x-stussy-le', 'Size', '40'),
('huarache-x-stussy-le', 'Size', '41'),
('huarache-x-stussy-le', 'Size', '42'),
('huarache-x-stussy-le', 'Size', '43');

-- Insert attribute items for Jacket
INSERT INTO attribute_items (id, attribute_set_id, display_value, value) VALUES 
('Small', 'Size', 'Small', 'S'),
('Medium', 'Size', 'Medium', 'M'),
('Large', 'Size', 'Large', 'L'),
('Extra Large', 'Size', 'Extra Large', 'XL');

-- Insert product attributes for Jacket
INSERT INTO product_attributes (product_id, attribute_set_id, attribute_item_id) VALUES 
('jacket-canada-goosee', 'Size', 'Small'),
('jacket-canada-goosee', 'Size', 'Medium'),
('jacket-canada-goosee', 'Size', 'Large'),
('jacket-canada-goosee', 'Size', 'Extra Large');

-- Insert attribute items for PlayStation 5
INSERT INTO attribute_items (id, attribute_set_id, display_value, value) VALUES 
('Green', 'Color', 'Green', '#44FF03'),
('Cyan', 'Color', 'Cyan', '#03FFF7'),
('Blue', 'Color', 'Blue', '#030BFF'),
('Black', 'Color', 'Black', '#000000'),
('White', 'Color', 'White', '#FFFFFF'),
('512G', 'Capacity', '512G', '512G'),
('1T', 'Capacity', '1T', '1T');

-- Insert product attributes for PlayStation 5
INSERT INTO product_attributes (product_id, attribute_set_id, attribute_item_id) VALUES 
('ps-5', 'Color', 'Green'),
('ps-5', 'Color', 'Cyan'),
('ps-5', 'Color', 'Blue'),
('ps-5', 'Color', 'Black'),
('ps-5', 'Color', 'White'),
('ps-5', 'Capacity', '512G'),
('ps-5', 'Capacity', '1T');

-- Insert attribute items and product attributes for Xbox Series S
INSERT INTO attribute_items (id, attribute_set_id, display_value, value) VALUES 
('Green-Xbox', 'Color', 'Green', '#44FF03'),
('Cyan-Xbox', 'Color', 'Cyan', '#03FFF7'),
('Blue-Xbox', 'Color', 'Blue', '#030BFF'),
('Black-Xbox', 'Color', 'Black', '#000000'),
('White-Xbox', 'Color', 'White', '#FFFFFF'),
('512G-Xbox', 'Capacity', '512G', '512G'),
('1T-Xbox', 'Capacity', '1T', '1T');

INSERT INTO product_attributes (product_id, attribute_set_id, attribute_item_id) VALUES 
('xbox-series-s', 'Color', 'Green-Xbox'),
('xbox-series-s', 'Color', 'Cyan-Xbox'),
('xbox-series-s', 'Color', 'Blue-Xbox'),
('xbox-series-s', 'Color', 'Black-Xbox'),
('xbox-series-s', 'Color', 'White-Xbox'),
('xbox-series-s', 'Capacity', '512G-Xbox'),
('xbox-series-s', 'Capacity', '1T-Xbox');

-- Insert attribute items and product attributes for iMac 2021
INSERT INTO attribute_items (id, attribute_set_id, display_value, value) VALUES 
('256GB', 'Capacity', '256GB', '256GB'),
('512GB', 'Capacity', '512GB', '512GB'),
('USB-Yes', 'With USB 3 ports', 'Yes', 'Yes'),
('USB-No', 'With USB 3 ports', 'No', 'No'),
('TouchID-Yes', 'Touch ID in keyboard', 'Yes', 'Yes'),
('TouchID-No', 'Touch ID in keyboard', 'No', 'No');

INSERT INTO product_attributes (product_id, attribute_set_id, attribute_item_id) VALUES 
('apple-imac-2021', 'Capacity', '256GB'),
('apple-imac-2021', 'Capacity', '512GB'),
('apple-imac-2021', 'With USB 3 ports', 'USB-Yes'),
('apple-imac-2021', 'With USB 3 ports', 'USB-No'),
('apple-imac-2021', 'Touch ID in keyboard', 'TouchID-Yes'),
('apple-imac-2021', 'Touch ID in keyboard', 'TouchID-No');

-- Insert attribute items and product attributes for iPhone 12 Pro
INSERT INTO attribute_items (id, attribute_set_id, display_value, value) VALUES 
('512G', 'Capacity', '512G', '512G'),
('1T', 'Capacity', '1T', '1T'),
('Green-iPhone', 'Color', 'Green', '#44FF03'),
('Cyan-iPhone', 'Color', 'Cyan', '#03FFF7'),
('Blue-iPhone', 'Color', 'Blue', '#030BFF'),
('Black-iPhone', 'Color', 'Black', '#000000'),
('White-iPhone', 'Color', 'White', '#FFFFFF');

INSERT INTO product_attributes (product_id, attribute_set_id, attribute_item_id) VALUES 
('apple-iphone-12-pro', 'Capacity', '512G'),
('apple-iphone-12-pro', 'Capacity', '1T'),
('apple-iphone-12-pro', 'Color', 'Green-iPhone'),
('apple-iphone-12-pro', 'Color', 'Cyan-iPhone'),
('apple-iphone-12-pro', 'Color', 'Blue-iPhone'),
('apple-iphone-12-pro', 'Color', 'Black-iPhone'),
('apple-iphone-12-pro', 'Color', 'White-iPhone');

-- Use INSERT IGNORE to skip duplicate entries
INSERT IGNORE INTO attribute_items (id, attribute_set_id, display_value, value) VALUES 
('512G-iPhone', 'Capacity', '512G', '512G'),
('1T-iPhone', 'Capacity', '1T', '1T'),
('Green-iPhone', 'Color', 'Green', '#44FF03'),
('Cyan-iPhone', 'Color', 'Cyan', '#03FFF7'),
('Blue-iPhone', 'Color', 'Blue', '#030BFF'),
('Black-iPhone', 'Color', 'Black', '#000000'),
('White-iPhone', 'Color', 'White', '#FFFFFF');

-- Then update the product_attributes to use the new unique IDs
INSERT IGNORE INTO product_attributes (product_id, attribute_set_id, attribute_item_id) VALUES 
('apple-iphone-12-pro', 'Capacity', '512G-iPhone'),
('apple-iphone-12-pro', 'Capacity', '1T-iPhone'),
('apple-iphone-12-pro', 'Color', 'Green-iPhone'),
('apple-iphone-12-pro', 'Color', 'Cyan-iPhone'),
('apple-iphone-12-pro', 'Color', 'Blue-iPhone'),
('apple-iphone-12-pro', 'Color', 'Black-iPhone'),
('apple-iphone-12-pro', 'Color', 'White-iPhone');