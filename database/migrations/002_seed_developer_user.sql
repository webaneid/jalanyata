INSERT INTO users (username, password, role)
SELECT 'admin@webane.com', '$2y$12$6Ya1jFSDUaf980GC2dirme2WlxladqW8Pd/bQNkrGpDi3heMI.Zc6', 'developer'
WHERE NOT EXISTS (
  SELECT 1 FROM users WHERE username = 'admin@webane.com'
);
