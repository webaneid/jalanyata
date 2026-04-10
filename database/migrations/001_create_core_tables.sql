CREATE TABLE IF NOT EXISTS company_info (
  id INT(11) NOT NULL AUTO_INCREMENT,
  company_name VARCHAR(255) NOT NULL,
  company_address TEXT NOT NULL,
  company_phone VARCHAR(50) NOT NULL,
  company_whatsapp VARCHAR(50) NOT NULL,
  company_logo_url VARCHAR(255) DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS products (
  id INT(11) NOT NULL AUTO_INCREMENT,
  product_id_code VARCHAR(255) NOT NULL,
  product_weight VARCHAR(255) NOT NULL,
  product_date VARCHAR(255) NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY product_id_code (product_id_code)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS product_photos (
  id INT(11) NOT NULL AUTO_INCREMENT,
  kodeukuran VARCHAR(50) NOT NULL,
  product_weight VARCHAR(255) NOT NULL,
  photo_url VARCHAR(255) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY kodeukuran (kodeukuran),
  UNIQUE KEY product_weight (product_weight)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS users (
  id INT(11) NOT NULL AUTO_INCREMENT,
  username VARCHAR(50) NOT NULL,
  password VARCHAR(255) NOT NULL,
  role VARCHAR(50) NOT NULL DEFAULT 'admin',
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY username (username)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
