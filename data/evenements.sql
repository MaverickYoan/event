CREATE TABLE evenements (
    id SERIAL PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    date DATE NOT NULL,
    lieu VARCHAR(255) NOT NULL,
    description TEXT,
    image VARCHAR(255),
    places_disponibles INT,
    -- lien VARCHAR(255)
);
