CREATE TABLE entreprise (
   entreprise_id INT PRIMARY KEY AUTO_INCREMENT,
   entreprise_nom VARCHAR(100) UNIQUE NOT NULL,
   entreprise_description TEXT,
   entreprise_email VARCHAR(255) UNIQUE NOT NULL,
   entreprise_telephone VARCHAR(15),
   entreprise_domaine VARCHAR(100) NOT NULL,
   entreprise_visibilite BOOLEAN NOT NULL
);

CREATE TABLE offres (
   offre_id INT PRIMARY KEY AUTO_INCREMENT,
   offre_titre VARCHAR(250) NOT NULL,  
   offre_description TEXT,
   offre_remuneration DECIMAL(10,2),
   offre_dates_debut DATE NOT NULL,
   offre_dates_fin DATE NOT NULL,
   offre_places INT NOT NULL,
   offre_date_publication TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
   entreprise_id INT NOT NULL,
   FOREIGN KEY (entreprise_id) REFERENCES entreprise(entreprise_id)
);

CREATE TABLE promotion (
   promo_id INT PRIMARY KEY AUTO_INCREMENT,
   class_name VARCHAR(100) NOT NULL
);

CREATE TABLE competence (
   competence_id INT PRIMARY KEY AUTO_INCREMENT,
   competence_nom VARCHAR(100) NOT NULL
);

CREATE TABLE ville (
   ville_id INT PRIMARY KEY AUTO_INCREMENT,
   ville_nom VARCHAR(100) NOT NULL,
   ville_code_postal VARCHAR(5) NOT NULL
);

CREATE TABLE adresse (
   adresse_id INT PRIMARY KEY AUTO_INCREMENT,
   adresse_rue VARCHAR(255) NOT NULL,
   adresse_num_rue VARCHAR(10) NOT NULL,
   entreprise_id INT,
   ville_id INT NOT NULL,
   FOREIGN KEY (entreprise_id) REFERENCES entreprise(entreprise_id),
   FOREIGN KEY (ville_id) REFERENCES ville(ville_id)
);

CREATE TABLE utilisateur (
   user_id INT PRIMARY KEY AUTO_INCREMENT,
   user_nom VARCHAR(100) NOT NULL,
   user_prenom VARCHAR(100) NOT NULL,
   user_statut ENUM('etudiant', 'piolte', 'admin') NOT NULL,
   user_email VARCHAR(255) UNIQUE NOT NULL,
   user_password VARCHAR(255) NOT NULL,
   ville_id INT,
   UNIQUE (user_email),
   FOREIGN KEY (ville_id) REFERENCES ville(ville_id)
);

CREATE TABLE candidatures (
   offre_id INT,
   user_id INT,
   candidature_lm TEXT,
   candidature_status ENUM('en_attente', 'acceptée', 'refusée') NOT NULL DEFAULT 'en_attente',
   candidature_cv VARCHAR(255),
   candidature_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
   PRIMARY KEY (offre_id, user_id),
   FOREIGN KEY (offre_id) REFERENCES offres(offre_id),
   FOREIGN KEY (user_id) REFERENCES utilisateur(user_id)
);

CREATE TABLE appartenir (
   user_id INT,
   promo_id INT,
   PRIMARY KEY (user_id, promo_id),
   FOREIGN KEY (user_id) REFERENCES utilisateur(user_id),
   FOREIGN KEY (promo_id) REFERENCES promotion(promo_id)
);

CREATE TABLE wishlist (
   offre_id INT,
   user_id INT,
   PRIMARY KEY (offre_id, user_id),
   FOREIGN KEY (offre_id) REFERENCES offres(offre_id),
   FOREIGN KEY (user_id) REFERENCES utilisateur(user_id)
);

CREATE TABLE evaluations (
   entreprise_id INT,
   user_id INT,
   evaluation_note DECIMAL(1,0) NOT NULL,
   PRIMARY KEY (entreprise_id, user_id),
   FOREIGN KEY (entreprise_id) REFERENCES entreprise(entreprise_id),
   FOREIGN KEY (user_id) REFERENCES utilisateur(user_id)
);

CREATE TABLE competence_offre (
   offre_id INT,
   competence_id INT,
   PRIMARY KEY (offre_id, competence_id),
   FOREIGN KEY (offre_id) REFERENCES offres(offre_id),
   FOREIGN KEY (competence_id) REFERENCES competence(competence_id)
);