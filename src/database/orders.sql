CREATE TABLE orders (
    user_id INT NOT NULL,
    order_items LONGTEXT NOT NULL,
    order_total DECIMAL(10,2) NOT NULL,
    payment_type VARCHAR(20) NOT NULL,
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) references users(id)
);
