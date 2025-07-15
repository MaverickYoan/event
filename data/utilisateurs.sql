CREATE TABLE utilisateurs (
    id SERIAL PRIMARY KEY,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE
);

INSERT INTO utilisateurs (first_name, last_name, email) VALUES
('Maverick', 'Yoan', 'yoan.dalkia@gmail.com'),
('Bob', 'Sponge', 'bob.sponge@gmail.com'),
('Patrick', 'Seastar', 'patrick.seastar@gmail.com'),
('Anne', 'Franck', 'anne.franck@gmail.com'),
('Steeve', 'McQueen', 'steeve.mcqueen@gmail.com'),
('Yo', 'Yoan', 'yo.yoan@gmail.com'),
('Alice', 'Wonderland', 'Alice.Wonderland@gmail.com'),
('John', 'Doe', 'john.doe@gmail.com'),
('Jane', 'Smith', 'jane.smith@gmail.com'),
('Max', 'Power', 'max.power@gmail.com'),
('Lisa', 'Simpson', 'lisa.simpson@gmail.com'),
('Bart', 'Simpson', 'bart.simpson@gmail.com'),
('Homer', 'Simpson', 'homer.simpson@gmail.com'),
('Marge', 'Simpson', 'marge.simpson@gmail.com'),
('Nelson', 'Muntz', 'nelson.muntz@gmail.com'),
('Milhouse', 'Van_Houten', 'milhouse.vanhouten@gmail.com'),
('Ralph', 'Wiggum', 'ralph.wiggum@gmail.com'),
('Seymour', 'Skinner', 'seymour.skinner@gmail.com'),
('Edna', 'Krabappel', 'edna.krabappel@gmail.com'),
('Apu', 'Nahasapeemapetilon', 'apu.nahasapeemapetilon@gmail.com');
