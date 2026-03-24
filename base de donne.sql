CREATE DATABASE IF NOT EXISTS mwuna_vacances
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci; //pour prendre en compte les emoji html //


CREATE TABLE enfant (
  id_enfant       INT AUTO_INCREMENT PRIMARY KEY,
  nom             VARCHAR(50) NOT NULL,
  prenom          VARCHAR(50) NOT NULL,
  date_naissance  DATE        NOT NULL,
  id_tuteur       INT         NOT NULL,
  FOREIGN KEY (id_tuteur) REFERENCES tuteur(id_tuteur)
    ON DELETE CASCADE ON UPDATE CASCADE
);
CREATE TABLE tuteur (
  id_tuteur       INT AUTO_INCREMENT PRIMARY KEY,
  nom             VARCHAR(50)  NOT NULL,
  prenom          VARCHAR(50)  NOT NULL,
  email           VARCHAR(100) NOT NULL UNIQUE,
  telephone       VARCHAR(20),
  mot_de_passe    VARCHAR(255) NOT NULL,  -- hashé avec password_hash()
  date_inscription DATE DEFAULT (CURRENT_DATE)
);


CREATE TABLE reservation (
  id_reservation  INT AUTO_INCREMENT PRIMARY KEY,
  id_tuteur       INT          NOT NULL,
  id_sejour       INT          NOT NULL,
  date_reservation DATE        DEFAULT (CURRENT_DATE),
  nb_enfants      INT          NOT NULL DEFAULT 1,
  montant_total   DECIMAL(10,2),
  statut          ENUM('en_attente','confirmee','annulee') DEFAULT 'en_attente',
  FOREIGN KEY (id_tuteur) REFERENCES tuteur(id_tuteur) ON DELETE CASCADE,
  FOREIGN KEY (id_sejour) REFERENCES sejour(id_sejour)  ON DELETE RESTRICT
);
CREATE TABLE sejour (
  id_sejour       INT AUTO_INCREMENT PRIMARY KEY,
  destination     VARCHAR(50)    NOT NULL,  -- 'congo','senegal','angola','gabon'
  description     TEXT,
  prix            DECIMAL(8,2)   NOT NULL,
  duree_jours     INT            NOT NULL,
  places_dispo    INT            NOT NULL DEFAULT 20,
  photo           VARCHAR(255),
  date_depart     DATE           NOT NULL
);
INSERT INTO sejour (destination, description, prix, duree_jours, places_dispo, date_depart) VALUES
('congo',   'Découverte de Brazzaville et du Parc Odzala',  1200.00, 14, 20, '2026-07-01'),
('senegal', 'Safari au Sénégal et plages de Dakar',          980.00, 10, 20, '2026-07-15'),
('angola',  'Luanda et les chutes de Kalandula',            1350.00, 12, 20, '2026-08-01'),
('gabon',   'Libreville et le Parc National de Lopé',       1150.00, 11, 20, '2026-08-10');

