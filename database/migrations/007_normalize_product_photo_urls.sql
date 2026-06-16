UPDATE product_photos
SET photo_url = CONCAT('/uploads/', SUBSTRING_INDEX(photo_url, '/uploads/', -1))
WHERE photo_url LIKE 'http://%/uploads/%'
   OR photo_url LIKE 'https://%/uploads/%';
