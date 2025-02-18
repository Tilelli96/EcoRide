CREATE TABLE user (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(180) NOT NULL UNIQUE,
    roles JSON NOT NULL,
    password VARCHAR(255) NOT NULL,
    nom VARCHAR(50) NOT NULL,
    prenom VARCHAR(50) NOT NULL,
    telephone VARCHAR(50) NOT NULL,
    adresse VARCHAR(50) NOT NULL,
    date_naissance DATETIME NOT NULL,
    photo BLOB NULL,
    pseudo VARCHAR(50) NOT NULL,
    is_verified BOOLEAN NOT NULL DEFAULT FALSE,
    note FLOAT NOT NULL,
    credit INT NULL
);

CREATE TABLE covoiturage (
    id INT AUTO_INCREMENT PRIMARY KEY,
    date_depart DATE NOT NULL CHECK (date_depart >= CURDATE()),
    heure_depart TIME NOT NULL,
    lieu_depart VARCHAR(50) NOT NULL,
    date_arrivee DATE NOT NULL CHECK (date_arrivee >= CURDATE()),
    heure_arrivee TIME NOT NULL,
    lieu_arrivee VARCHAR(50) NOT NULL,
    statut VARCHAR(50) NOT NULL,
    nb_place INT NOT NULL CHECK (nb_place > 0 AND nb_place < 5),
    prix_personne FLOAT NOT NULL,
    voiture_id INT NULL,
    user_id INT NULL,
    CONSTRAINT fk_covoiturage_voiture FOREIGN KEY (voiture_id) REFERENCES voiture(id) ON DELETE SET NULL,
    CONSTRAINT fk_covoiturage_user FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE SET NULL
);

CREATE TABLE covoiturage_voyageurs (
    covoiturage_id INT NOT NULL,
    user_id INT NOT NULL,
    PRIMARY KEY (covoiturage_id, user_id),
    CONSTRAINT fk_covoiturage_voyageur_covoiturage FOREIGN KEY (covoiturage_id) REFERENCES covoiturage(id) ON DELETE CASCADE,
    CONSTRAINT fk_covoiturage_voyageur_user FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE CASCADE
);

CREATE TABLE marque (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL UNIQUE
);

CREATE TABLE voiture (
    id INT AUTO_INCREMENT PRIMARY KEY,
    modele VARCHAR(50) NOT NULL,
    immatriculation VARCHAR(50) NOT NULL UNIQUE,
    energie VARCHAR(50) NOT NULL,
    couleur VARCHAR(50) NOT NULL,
    date_premiere_immatriculation VARCHAR(50) NOT NULL,
    marque_id INT NOT NULL,
    user_id INT NULL,
    CONSTRAINT fk_voiture_marque FOREIGN KEY (marque_id) REFERENCES marque(id) ON DELETE CASCADE,
    CONSTRAINT fk_voiture_user FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE SET NULL
);
CREATE TABLE search (
    id INT AUTO_INCREMENT PRIMARY KEY,
    adresse_depart VARCHAR(50) NOT NULL,
    adresse_arrivee VARCHAR(50) NOT NULL,
    date DATE NOT NULL,
    nb_personnes INT NOT NULL CHECK (nb_personnes > 0)
);

CREATE TABLE a (
    id INT AUTO_INCREMENT PRIMARY KEY,
    commentaire VARCHAR(50) NOT NULL,
    note INT NOT NULL CHECK (note >= 0),
    statut VARCHAR(50) NOT NULL,
    user_id INT NOT NULL,
    created_by_id INT NULL,
    CONSTRAINT fk_a_user FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE CASCADE,
    CONSTRAINT fk_a_created_by FOREIGN KEY (created_by_id) REFERENCES user(id) ON DELETE SET NULL
);
CREATE TABLE role (
    id INT AUTO_INCREMENT PRIMARY KEY,
    libelle VARCHAR(50) NOT NULL,
    user_id INT UNIQUE,
    CONSTRAINT fk_role_user FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE SET NULL
);
CREATE TABLE litige (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    covoiturage_id INT NOT NULL,
    CONSTRAINT fk_litige_user FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE,
    CONSTRAINT fk_litige_covoiturage FOREIGN KEY (covoiturage_id) REFERENCES covoiturage (id) ON DELETE CASCADE
);
