CREATE TABLE administrateurs (
    id SERIAL PRIMARY KEY,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE
);

INSERT INTO administrateurs (first_name, last_name, email) VALUES
('Yoan', 'De_Menezes', 'yoan.demenezes@gmail.com'),
('test', 'test', 'test@gmail.com'),
('admin', 'user', 'admin@admin.com');

