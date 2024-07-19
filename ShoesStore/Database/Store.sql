/* ------------------------------------ Creation ------------------------------------ */

CREATE TABLE IF NOT EXISTS categories (
    category_id   INT PRIMARY KEY,
    category_name VARCHAR(255)
);

CREATE TABLE IF NOT EXISTS products (
    product_id                INT PRIMARY KEY,
    product_name              VARCHAR(255),
    product_seller            VARCHAR(255),
    product_description       TEXT,
    product_full_description  TEXT,
    product_price             DECIMAL(10, 2),
    product_discount          INT,
    product_available         INT,
    product_weight            INT DEFAULT '500',
    category_id               INT,
    image_url                 VARCHAR(255),
    FOREIGN KEY (category_id) REFERENCES categories (category_id)
);

CREATE TABLE IF NOT EXISTS users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255),
    password VARCHAR(255)
    );


CREATE TABLE IF NOT EXISTS cart
(
    cart_id    INT PRIMARY KEY AUTO_INCREMENT,
    product_id INT,
    user_id    INT,
    quantity INT,
    FOREIGN KEY (product_id) REFERENCES products (product_id),
    FOREIGN KEY (user_id) REFERENCES users (user_id)
);


/* ------------------------------------ Insertion ------------------------------------ */

INSERT INTO categories (category_id, category_name)
VALUES (1, 'Running Shoes'),
       (2, 'Casual Shoes'),
       (3, 'Formal Shoes'),
       (4, 'Sneakers'),
       (5, 'Sandals');

INSERT INTO products (product_id, product_name, product_seller, product_description, product_full_description, product_price, product_discount, product_available, product_weight, category_id, image_url)
VALUES
    (1, 'Nike Air Zoom Pegasus', 'Nike', 'Versatile running shoes for all distances.', 'Elevate your running experience with the Nike Air Zoom Pegasus, versatile shoes designed for all distances. Featuring advanced Zoom technology, these running shoes offer optimal cushioning and support. A perfect blend of style and functionality, these Nike shoes are a must-have for runners of all levels.', 120.00, 10, 100, 500, 1, 'NikeAirZoomPegasus.jpg'),
    (2, 'Adidas Ultraboost', 'Adidas', 'Comfortable and stylish running shoes.', 'Experience unparalleled comfort and style with Adidas Ultraboost, premium running shoes with Ultraboost technology. Crafted for a plush and responsive ride, these shoes are perfect for both casual and seasoned runners. Make a statement with Adidas Ultraboost, combining comfort, style, and cutting-edge technology.', 150.00, 15, 80, 500, 1, 'AdidasUltraboost.jpg'),
    (3, 'Converse Chuck Taylor', 'Converse', 'Classic casual sneakers for everyday wear.', 'Step into timeless style with Converse Chuck Taylor, classic casual sneakers perfect for everyday wear. Featuring the iconic Chuck Taylor design, these sneakers bring a touch of nostalgia to your wardrobe. Timeless and comfortable, Converse Chuck Taylor is the go-to choice for casual and laid-back vibes.', 50.00, 2, 150, 500, 2, 'ConverseChuckTaylor.jpg'),
    (4, 'Formal Oxford Shoes', 'Unknown', 'Elegant formal shoes for special occasions.', 'Make a lasting impression with Formal Oxford Shoes, offering elegance and sophistication for special occasions. Classic Oxford design meets modern comfort, providing a timeless and refined look. Elevate your formal attire with these elegant shoes, perfect for those special moments.', 80.00, 12, 50, 500, 3, 'FormalOxfordShoes.jpg'),
    (5, 'Vans Old Skool', 'Vans', 'Iconic skate shoes with a timeless design.', 'Embrace skate culture with Vans Old Skool, iconic skate shoes boasting a timeless design. Known for durability and the signature side stripe, these Vans sneakers are a symbol of authenticity. Join the skateboarders community with Vans Old Skool, combining comfort and style effortlessly.', 65.00, 5, 120, 500, 2, 'VansOldSkool.jpg'),
    (6, 'Puma RS-X', 'Puma', 'Fashionable and futuristic sneakers.', 'Step into the future of fashion with Puma RS-X, fashionable and futuristic sneakers featuring RS-X technology. Modern design meets advanced technology, making these sneakers a statement piece in your wardrobe. Stay ahead of the trend with Puma RS-X, where style and innovation converge.', 110.00, 12, 90, 500, 4, 'PumaRS-X.jpg'),
    (7, 'Birkenstock Arizona', 'Birkenstock', 'Comfortable sandals with adjustable straps.', 'Experience maximum comfort with Birkenstock Arizona, comfortable sandals designed with adjustable straps. These orthopedic sandals prioritize comfort, making them perfect for all-day wear. Embrace a casual yet supportive style with Birkenstock Arizona, ideal for those who prioritize foot wellness.', 90.00, 8, 110, 500, 5, 'BirkenstockArizona.jpg'),
    (8, 'New Balance 990v5', 'New Balance', 'Stability and comfort for running enthusiasts.', 'Find stability and comfort with New Balance 990v5, premium running shoes equipped with advanced cushioning. Designed for running enthusiasts, these shoes provide a superior blend of support and style. Step confidently into your runs with New Balance 990v5, where performance meets exceptional design.', 175.00, 20, 70, 500, 1, 'NewBalance990v5.jpg'),
    (9, 'Loafer Shoes', 'Unknown', 'Stylish and comfortable loafers for a relaxed look.', 'Embrace a relaxed yet stylish look with Loafer Shoes, offering comfort and style for casual occasions. Classic loafers that add a touch of sophistication to your appearance, perfect for various settings. Elevate your casual style with these timeless loafers, designed for comfort and versatility.', 70.00, 5, 100, 500, 2, 'LoaferShoes.jpg'),
    (10, 'Nike React Element', 'Nike', 'Modern and innovative sneakers with React technology.', 'Step into the future with Nike React Element, modern and innovative sneakers featuring React technology. Experience enhanced comfort and style with these cutting-edge sneakers designed for the fashion-forward. Make a bold statement with Nike React Element, where innovation and aesthetics converge.', 130.00, 15, 60, 500, 4, 'NikeReactElement.jpg'),
    (11, 'Casual Slip-on Shoes', 'Unknown', 'Easy-to-wear slip-on shoes for casual occasions.', 'Enjoy convenience and style with Casual Slip-on Shoes, easy-to-wear footwear perfect for casual occasions. These slip-on shoes offer a laid-back style without compromising on comfort. Effortlessly elevate your casual look with these comfortable and convenient slip-on shoes.', 45.00, 5, 120, 500, 2, 'CasualSlip-onShoes.jpg'),
    (12, 'ASICS Gel-Kayano', 'ASICS', 'Premium long-distance running shoes with gel cushioning.', 'Experience premium long-distance running with ASICS Gel-Kayano, high-performance shoes with gel cushioning. Designed for runners seeking stability and comfort, these shoes provide a smooth and supportive ride. Conquer your runs with confidence in ASICS Gel-Kayano, where advanced technology meets exceptional performance.', 160.00, 18, 85, 500, 1, 'ASICSGel-Kayano.jpg'),
    (13, 'Espadrille Sandals', 'Unknown', 'Light and breathable sandals with a summer vibe.', 'Embrace the summer vibe with Espadrille Sandals, light and breathable sandals perfect for warm days. These casual sandals add a touch of laid-back style to your summer wardrobe. Enjoy comfort and simplicity with Espadrille Sandals, your go-to choice for easygoing summer days.', 55.00, 10, 130, 500, 5, 'EspadrilleSandals.jpg'),
    (14, 'Brooks Ghost 13', 'Brooks', 'Neutral running shoes for a smooth ride.', 'Achieve a smooth ride with Brooks Ghost 13, neutral running shoes designed for comfort. These running shoes are ideal for neutral runners seeking a balance of cushioning and responsiveness. Elevate your running experience with Brooks Ghost 13, where comfort and performance seamlessly come together.', 120.00, 10, 75, 500, 1, 'BrooksGhost13.jpg'),
    (15, 'Hiking Boots', 'Unknown', 'Durable and supportive boots for outdoor adventures.', 'Gear up for outdoor adventures with Hiking Boots, durable and supportive boots designed for rugged trails. These sturdy hiking boots provide the reliability you need for outdoor exploration. Venture confidently into nature with Hiking Boots, your trusted companion for challenging terrains.', 90.00, 23, 95, 500, 2, 'HikingBoots.jpg'),
    (16, 'Reebok Classic Leather', 'Reebok', 'Timeless and versatile sneakers for everyday wear.', 'Step into classic style with Reebok Classic Leather, timeless sneakers featuring a versatile design. These classic leather sneakers bring an iconic and timeless look to your everyday wardrobe. Elevate your style with Reebok Classic Leather, a perfect choice for those who appreciate timeless fashion.', 75.00, 8, 110, 500, 2, 'ReebokClassicLeather.jpg'),
    (17, 'Merrell Moab 2', 'Merrell', 'Trail-ready hiking shoes with Vibram traction.', 'Conquer rugged trails with Merrell Moab 2, trail-ready hiking shoes equipped with Vibram traction. Designed for outdoor enthusiasts, these hiking shoes provide the grip and durability needed for challenging terrains. Gear up for adventure with Merrell Moab 2, your reliable choice for trail exploration.', 110.00, 15, 80, 500, 1, 'MerrellMoab2.jpg'),
    (18, 'Platform Sneakers', 'Unknown', 'Bold and stylish sneakers with a platform sole.', 'Make a bold fashion statement with Platform Sneakers, bold and stylish sneakers featuring a trendy platform design. These fashionable sneakers elevate your look with a touch of boldness and style. Step into the latest trends with Platform Sneakers, perfect for those who want to stand out from the crowd.', 55.00, 23, 100, 500, 4, 'PlatformSneakers.jpg'),
    (19, 'Flip-Flop Sandals', 'Unknown', 'Casual and easygoing sandals for beach days.', 'Embrace casual vibes with Flip-Flop Sandals, simple and comfortable sandals perfect for beach days. These easygoing flip-flop sandals are ideal for laid-back outings and relaxed beach adventures. Enjoy the simplicity of beach life with Flip-Flop Sandals, your essential footwear for sunny days.', 25.00, 25, 120, 500, 5, 'Flip-FlopSandals.jpg'),
    (20, 'High-Top Basketball Shoes', 'Unknown', 'Performance-oriented shoes for basketball enthusiasts.', 'Elevate your basketball game with High-Top Basketball Shoes, performance-oriented shoes designed for enhanced on-court performance. These high-top basketball shoes offer the support and style needed for serious basketball enthusiasts. Make a slam dunk in style with High-Top Basketball Shoes, your go-to choice for dominating the court.', 120.00, 0, 90, 500, 4, 'High-TopBasketballShoes.jpg');


INSERT INTO users (username, password)
VALUES ('admin', 'admin'),
       ('john_doe', '1234'),
       ('jane_smith', '12345678');

