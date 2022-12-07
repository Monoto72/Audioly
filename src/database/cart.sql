CREATE TABLE cart (
    user_id INT NOT NULL,
    item_id INT NOT NULL,
    amount INT NOT NULL,
    
    PRIMARY KEY (user_id, item_id),
    FOREIGN KEY (user_id) references users(id),
    FOREIGN KEY (item_id) references store_items(id)
);


/****************************************************************
    * 
    *  INSERT INTO store_items
    * 
****************************************************************/

SELECT * FROM cart 
INNER JOIN store_items ON store_items.id = cart.item_id WHERE user_id=5