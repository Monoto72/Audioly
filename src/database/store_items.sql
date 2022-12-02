CREATE TABLE store_items (
    id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    image_url VARCHAR(250) NOT NULL,
    slug VARCHAR(100) NOT NULL,
    description VARCHAR(255) NOT NULL,
    type VARCHAR(50) NOT NULL,

    PRIMARY KEY (id)
)

/****************************************************************
    * 
    *  INSERT INTO store_items
    * 
****************************************************************/

INSERT INTO store_items (name, price, image_url, slug, description, type) 
VALUES("PRS SE P20 Parlour VM", 50.79, "../media/categories/guitar/guitar-1.jpg", "prs-p20-guitar", "I am a dummy description change me soon", "guitar");

INSERT INTO store_items (name, price, image_url, slug, description, type) 
VALUES("Marin Smith Acoustic Guitar Kit", 80.00, "../media/categories/guitar/guitar-2.jpg", "martin-smith-guitar", "I am a dummy description change me soon", "guitar");

INSERT INTO store_items (name, price, image_url, slug, description, type) 
VALUES("Music Alley MA-51 Classical Acoustic Guitar", 26.99, "../media/categories/guitar/guitar-3.jpg", "ma-51-guitar", "I am a dummy description change me soon", "guitar");

INSERT INTO store_items (name, price, image_url, slug, description, type) 
VALUES("RockJam Full Size Electric Guitar Kit", 129.99, "../media/categories/guitar/guitar-4.jpg", "rock-jam-guitar", "I am a dummy description change me soon", "guitar");

INSERT INTO store_items (name, price, image_url, slug, description, type) 
VALUES("Donner Acoustic Guitar 4/4 Dreadnought", 119.98, "../media/categories/guitar/guitar-5.jpg", "donner-dreadnought-guitar", "I am a dummy description change me soon", "guitar");

INSERT INTO store_items (name, price, image_url, slug, description, type) 
VALUES("Yamaha F370 Full Size Steel Stringg Acoustic Guitar", 159.00, "../media/categories/guitar/guitar-6.jpg", "yamaha-f370-guitar", "I am a dummy description change me soon", "guitar");