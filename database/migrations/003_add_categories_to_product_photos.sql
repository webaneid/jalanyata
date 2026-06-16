CREATE TABLE IF NOT EXISTS categories (
  id INT(11) NOT NULL AUTO_INCREMENT,
  name VARCHAR(50) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY name (name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO categories (name) VALUES ('Gold')
ON DUPLICATE KEY UPDATE name = name;

INSERT INTO categories (name) VALUES ('Silver')
ON DUPLICATE KEY UPDATE name = name;

ALTER TABLE product_photos
  ADD COLUMN category_id INT(11) NULL AFTER id;

ALTER TABLE product_photos
  DROP INDEX product_weight;

ALTER TABLE product_photos
  ADD KEY idx_product_photos_product_weight (product_weight),
  ADD KEY idx_product_photos_category_id (category_id);

UPDATE product_photos pp
INNER JOIN categories c ON c.name = 'Silver'
SET pp.category_id = c.id
WHERE pp.category_id IS NULL;

ALTER TABLE product_photos
  MODIFY category_id INT(11) NOT NULL;

ALTER TABLE product_photos
  ADD CONSTRAINT fk_product_photos_category
    FOREIGN KEY (category_id) REFERENCES categories(id)
    ON UPDATE CASCADE;
