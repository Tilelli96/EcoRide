-- Insertion d'un utilisateur vide
INSERT INTO user (email, roles, password, nom, prenom, telephone, adresse, date_naissance, photo, pseudo, is_verified, note, credit) 
VALUES ('', '["ROLE_USER"]', '', '', '', '', '', NULL, NULL, '', FALSE, 0, 0);

-- Insertion d'un covoiturage vide
INSERT INTO covoiturage (date_depart, heure_depart, lieu_depart, date_arrivee, heure_arrivee, lieu_arrivee, statut, nb_place, prix_personne, voiture_id, user_id) 
VALUES (NULL, NULL, '', NULL, NULL, '', '', 1, 0, NULL, NULL);

-- Insertion d'un litige vide
INSERT INTO litige (user_id, covoiturage_id) 
VALUES (NULL, NULL);

-- Insertion d'une voiture vide
INSERT INTO voiture (modele, annee, couleur, immatriculation, marque_id, user_id) 
VALUES ('', NULL, '', '', NULL, NULL);

-- Insertion d'une marque vide
INSERT INTO marque (nom) 
VALUES ('');

-- Insertion d'une recherche vide (Search)
INSERT INTO search (destination, date_depart, nb_places) 
VALUES ('', NULL, NULL);

-- Insertion d'un élément A vide (ajuste selon la structure de ta classe)
INSERT INTO a (champ1, champ2, champ3) 
VALUES ('', '', '');
