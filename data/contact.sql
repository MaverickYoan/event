CREATE TABLE contact (
    id SERIAL PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE INDEX idx_contact_email ON contact(email);
CREATE INDEX idx_contact_created_at ON contact(created_at);
CREATE UNIQUE INDEX idx_contact_email_unique ON contact(email);
CREATE INDEX idx_contact_nom ON contact(nom);