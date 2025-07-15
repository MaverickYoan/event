CREATE TABLE contact (
    id SERIAL PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO contact (nom, email, message) VALUES 
('John Doe', 'john.doe@example.com', 'Hello, message test000'),
('admin', 'admin@admin.com', 'Hello, message test001'),
('Maverick', 'yoanmaverick@gmail.com', 'Hello, message test002');