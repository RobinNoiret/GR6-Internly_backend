-- Insertion des entreprises
INSERT INTO entreprise (entreprise_nom, entreprise_description, entreprise_email, entreprise_telephone, entreprise_domaine, entreprise_visibilite) VALUES
("TechInnov", "Leader en solutions technologiques", "contact@techinnov.com", "0123456789", "Informatique", TRUE),
("MarketSphere", "Agence de marketing digital", "info@marketsphere.com", "0987654321", "Marketing", TRUE),
("HR Solutions", "Spécialiste en gestion des ressources humaines", "hr@hrsolutions.com", "0147852369", "RH", FALSE),
("FinancePro", "Experts en conseil financier", "support@financepro.com", "0123456788", "Finance", TRUE),
("SalesMaster", "Optimisation des ventes", "sales@salesmaster.com", "0987654322", "Vente", FALSE),
("LogisticsHub", "Solutions logistiques innovantes", "logistics@logisticshub.com", "0147852368", "Logistique", TRUE),
("HealthFirst", "Soins de santé de qualité", "health@healthfirst.com", "0123456787", "Santé", FALSE),
("EduSmart", "Éducation pour tous", "education@edusmart.com", "0987654323", "Éducation", TRUE),
("TechWave", "Innovations technologiques", "tech@techwave.com", "0147852367", "Technologie", FALSE),
("ArtCraft", "Créativité et design", "art@artcraft.com", "0123456786", "Art", TRUE),
("MediaVision", "Production média", "media@mediavision.com", "0987654324", "Média", FALSE),
("SportActive", "Promotion du sport", "sport@sportactive.com", "0147852366", "Sport", TRUE),
("TourGuide", "Voyages et aventures", "tour@tourguide.com", "0123456785", "Tourisme", FALSE),
("FashionTrend", "Mode et style", "fashion@fashiontrend.com", "0987654325", "Mode", TRUE),
("FoodDelight", "Saveurs culinaires", "food@fooddelight.com", "0147852365", "Alimentation", FALSE),
("BuildMasters", "Construction durable", "build@buildmasters.com", "0123456784", "Construction", TRUE),
("EnergyFlow", "Énergies renouvelables", "energy@energyflow.com", "0987654326", "Énergie", FALSE),
("GreenEarth", "Protection de l'environnement", "green@greenearth.com", "0147852364", "Environnement", TRUE),
("TransitPro", "Solutions de transport", "transit@transitpro.com", "0123456783", "Transport", FALSE),
("EntertainUs", "Divertissement et loisirs", "fun@entertainus.com", "0987654327", "Divertissement", TRUE),
("InnoTech", "Technologies de pointe", "innovation@innotech.com", "0147852363", "Technologie", FALSE),
("CreaDesign", "Design créatif", "design@creadesign.com", "0123456782", "Design", TRUE),
("EduFuture", "Éducation innovante", "future@edufuture.com", "0987654328", "Éducation", FALSE),
("HealthPlus", "Santé et bien-être", "wellness@healthplus.com", "0147852362", "Santé", TRUE),
("FinanceStar", "Conseils financiers", "finance@financestar.com", "0123456781", "Finance", FALSE),
("SalesBoost", "Stratégies de vente", "boost@salesboost.com", "0987654329", "Vente", TRUE),
("LogisticsPro", "Logistique avancée", "pro@logisticspro.com", "0147852361", "Logistique", FALSE),
("ArtInnovate", "Innovation artistique", "art@artinnovate.com", "0123456780", "Art", TRUE),
("MediaPulse", "Médias dynamiques", "pulse@mediapulse.com", "0987654330", "Média", FALSE),
("SportElite", "Excellence sportive", "elite@sportelite.com", "0147852360", "Sport", TRUE);

-- Insertion des offres
INSERT INTO offre (offre_titre, offre_description, offre_remuneration, offre_date_debut, offre_date_fin, offre_places, entreprise_id) VALUES
("Développeur Web", "Développement de sites web", 1500.00, "2024-01-01", "2024-06-30", 5, 1),
("Spécialiste Marketing", "Stratégies de marketing digital", 1800.00, "2024-02-01", "2024-07-31", 3, 2),
("Assistant RH", "Support aux ressources humaines", 1600.00, "2024-03-01", "2024-08-31", 2, 3),
("Analyste Financier", "Analyse des données financières", 2000.00, "2024-04-01", "2024-09-30", 4, 4),
("Responsable des Ventes", "Gestion des ventes", 1900.00, "2024-05-01", "2024-10-31", 3, 5),
("Coordinateur Logistique", "Gestion de la chaîne logistique", 1700.00, "2024-06-01", "2024-11-30", 2, 6),
("Assistant Médical", "Support aux soins de santé", 1500.00, "2024-07-01", "2024-12-31", 5, 7),
("Éducateur", "Programmes éducatifs", 1600.00, "2024-08-01", "2025-01-31", 3, 8),
("Ingénieur Réseau", "Gestion des réseaux informatiques", 2100.00, "2024-09-01", "2025-02-28", 4, 9),
("Designer Graphique", "Création de designs", 1800.00, "2024-10-01", "2025-03-31", 2, 10),
("Producteur Vidéo", "Production de contenu vidéo", 1900.00, "2024-11-01", "2025-04-30", 3, 11),
("Entraîneur Sportif", "Coaching sportif", 1700.00, "2024-12-01", "2025-05-31", 2, 12),
("Guide Touristique", "Organisation de visites", 1600.00, "2025-01-01", "2025-06-30", 5, 13),
("Styliste", "Création de collections de mode", 1800.00, "2025-02-01", "2025-07-31", 3, 14),
("Chef Cuisinier", "Préparation de repas", 2000.00, "2025-03-01", "2025-08-31", 4, 15),
("Ingénieur Civil", "Projets de construction", 2100.00, "2025-04-01", "2025-09-30", 3, 16),
("Consultant Énergie", "Optimisation énergétique", 1900.00, "2025-05-01", "2025-10-31", 2, 17),
("Écologiste", "Protection de l'environnement", 1700.00, "2025-06-01", "2025-11-30", 5, 18),
("Logisticien", "Gestion des transports", 1600.00, "2025-07-01", "2025-12-31", 3, 19),
("Animateur", "Organisation d'événements", 1800.00, "2025-08-01", "2026-01-31", 4, 20),
("Développeur Mobile", "Applications mobiles", 2000.00, "2025-09-01", "2026-02-28", 2, 21),
("Formateur", "Formation professionnelle", 1900.00, "2025-10-01", "2026-03-31", 3, 22),
("Thérapeute", "Soins de bien-être", 1700.00, "2025-11-01", "2026-04-30", 5, 23),
("Conseiller Financier", "Conseils en investissement", 2100.00, "2025-12-01", "2026-05-31", 3, 24),
("Commercial", "Développement commercial", 1800.00, "2026-01-01", "2026-06-30", 4, 25),
("Responsable Logistique", "Optimisation logistique", 1900.00, "2026-02-01", "2026-07-31", 2, 26),
("Artiste", "Création artistique", 1600.00, "2026-03-01", "2026-08-31", 5, 27),
("Journaliste", "Rédaction d'articles", 1800.00, "2026-04-01", "2026-09-30", 3, 28),
("Entraîneur", "Coaching sportif", 2000.00, "2026-05-01", "2026-10-31", 4, 29),
("Coordinateur Événementiel", "Organisation d'événements", 1900.00, "2026-06-01", "2026-11-30", 2, 30);

-- Insertion des promotions
INSERT INTO promotion (class_name) VALUES
("Promo 2024-A"), ("Promo 2024-B"), ("Promo 2024-C"), ("Promo 2025-A"), ("Promo 2025-B"),
("Promo 2025-C"), ("Promo 2026-A"), ("Promo 2026-B"), ("Promo 2026-C"), ("Promo 2027-A"),
("Promo 2027-B"), ("Promo 2027-C"), ("Promo 2028-A"), ("Promo 2028-B"), ("Promo 2028-C"),
("Promo 2029-A"), ("Promo 2029-B"), ("Promo 2029-C"), ("Promo 2030-A"), ("Promo 2030-B"),
("Promo 2030-C"), ("Promo 2031-A"), ("Promo 2031-B"), ("Promo 2031-C"), ("Promo 2032-A"),
("Promo 2032-B"), ("Promo 2032-C"), ("Promo 2033-A"), ("Promo 2033-B"), ("Promo 2033-C");

-- Insertion des compétences
INSERT INTO competence (competence_nom) VALUES
("Java"), ("Python"), ("SQL"), ("HTML"), ("CSS"), ("JavaScript"), ("C#"), ("PHP"), ("Ruby"), ("Swift"),
("Kotlin"), ("Go"), ("R"), ("TypeScript"), ("Dart"), ("Perl"), ("Scala"), ("Shell"), ("MATLAB"), ("Rust"),
("Objective-C"), ("Groovy"), ("Haskell"), ("Lua"), ("Julia"), ("Elixir"), ("Clojure"), ("F#"), ("Erlang"), ("COBOL");

-- Insertion des villes
INSERT INTO ville (ville_nom, ville_code_postal) VALUES
("Paris", "75000"), ("Lyon", "69000"), ("Marseille", "13000"), ("Toulouse", "31000"), ("Nice", "06000"),
("Nantes", "44000"), ("Strasbourg", "67000"), ("Montpellier", "34000"), ("Bordeaux", "33000"), ("Lille", "59000"),
("Rennes", "35000"), ("Reims", "51000"), ("Le Havre", "76000"), ("Saint-Étienne", "42000"), ("Toulon", "83000"),
("Grenoble", "38000"), ("Dijon", "21000"), ("Angers", "49000"), ("Nîmes", "30000"), ("Villeurbanne", "69100"),
("Le Mans", "72000"), ("Aix-en-Provence", "13090"), ("Clermont-Ferrand", "63000"), ("Brest", "29200"), ("Tours", "37000"),
("Amiens", "80000"), ("Limoges", "87000"), ("Annecy", "74000"), ("Boulogne-Billancourt", "92100"), ("Perpignan", "66000");

-- Insertion des adresses
INSERT INTO adresse (adresse_rue, adresse_num_rue, entreprise_id, ville_id) VALUES
("Rue de la Paix", "1", 1, 1), ("Avenue des Champs-Élysées", "2", 2, 2), ("Boulevard de la Liberté", "3", 3, 3),
("Rue de la République", "4", 4, 4), ("Avenue Jean Jaurès", "5", 5, 5), ("Boulevard de la Victoire", "6", 6, 6),
("Rue des Écoles", "7", 7, 7), ("Avenue de la Gare", "8", 8, 8), ("Boulevard du Maréchal Leclerc", "9", 9, 9),
("Rue Victor Hugo", "10", 10, 10), ("Avenue du Général de Gaulle", "11", 11, 11), ("Boulevard de la Mer", "12", 12, 12),
("Rue du Commerce", "13", 13, 13), ("Avenue de la Libération", "14", 14, 14), ("Boulevard des Nations", "15", 15, 15),
("Rue de la Mairie", "16", 16, 16), ("Avenue de l'Europe", "17", 17, 17), ("Boulevard de la Paix", "18", 18, 18),
("Rue des Arts", "19", 19, 19), ("Avenue de la Culture", "20", 20, 20), ("Boulevard de la Science", "21", 21, 21),
("Rue de l'Innovation", "22", 22, 22), ("Avenue de la Santé", "23", 23, 23), ("Boulevard de la Finance", "24", 24, 24),
("Rue des Affaires", "25", 25, 25), ("Avenue de la Logistique", "26", 26, 26), ("Boulevard de l'Art", "27", 27, 27),
("Rue des Médias", "28", 28, 28), ("Avenue du Sport", "29", 29, 29), ("Boulevard de la Technologie", "30", 30, 30);

-- Insertion des utilisateurs
INSERT INTO utilisateur (utilisateur_nom, utilisateur_prenom, utilisateur_statut, utilisateur_email, utilisateur_password, ville_id) VALUES
("Dupont", "Jean", "etudiant", "jean.dupont@viacesi.fr", "password1", 1),
("Martin", "Marie", "piolte", "mmartin@cesi.fr", "password2", 2),
("Durand", "Paul", "admin", "paul.durand@internly.fr", "password3", 3),
("Lefevre", "Alice", "etudiant", "alice.lefevre@viacesi.fr", "password4", 4),
("Rousseau", "Luc", "piolte", "lrousseau@cesi.fr", "password5", 5),
("Moreau", "Sophie", "admin", "sophie.moreau@internly.fr", "password6", 6),
("Garnier", "Marc", "etudiant", "marc.garnier@viacesi.fr", "password7", 7),
("Leroy", "Julie", "piolte", "jleroy@cesi.fr", "password8", 8),
("Dubois", "Thomas", "admin", "thomas.dubois@internly.fr", "password9", 9),
("Lemaire", "Claire", "etudiant", "claire.lemaire@viacesi.fr", "password10", 10),
("Chevalier", "Antoine", "piolte", "achevalier@cesi.fr", "password11", 11),
("Francois", "Laura", "admin", "laura.francois@internly.fr", "password12", 12),
("Morin", "Nicolas", "etudiant", "nicolas.morin@viacesi.fr", "password13", 13),
("Gauthier", "Emma", "piolte", "egauthier@cesi.fr", "password14", 14),
("Henry", "Louis", "admin", "louis.henry@internly.fr", "password15", 15),
("Roche", "Camille", "etudiant", "camille.roche@viacesi.fr", "password16", 16),
("Simon", "Alexandre", "piolte", "asimon@cesi.fr", "password17", 17),
("Laurent", "Chloe", "admin", "chloe.laurent@internly.fr", "password18", 18),
("Bertrand", "Victor", "etudiant", "victor.bertrand@viacesi.fr", "password19", 19),
("Renard", "Manon", "piolte", "mrenard@cesi.fr", "password20", 20),
("Blanc", "Hugo", "admin", "hugo.blanc@internly.fr", "password21", 21),
("Fournier", "Lea", "etudiant", "lea.fournier@viacesi.fr", "password22", 22),
("Girard", "Jules", "piolte", "jgirard@cesi.fr", "password23", 23),
("Boyer", "Anais", "admin", "anais.boyer@internly.fr", "password24", 24),
("Julien", "Mathieu", "etudiant", "mathieu.julien@viacesi.fr", "password25", 25),
("Muller", "Eva", "piolte", "emuller@cesi.fr", "password26", 26),
("Perrin", "Maxime", "admin", "maxime.perrin@internly.fr", "password27", 27),
("Morel", "Lola", "etudiant", "lola.morel@viacesi.fr", "password28", 28),
("Guerin", "Baptiste", "piolte", "bguerin@cesi.fr", "password29", 29),
("Colin", "Zoe", "admin", "zoe.colin@internly.fr", "password30", 30);

-- Insertion des candidatures
INSERT INTO candidatures (offre_id, user_id, candidature_lm, candidature_status, candidature_cv) VALUES
(1, 1, "Lettre de motivation 1", "en_attente", "CV1.pdf"),
(2, 2, "Lettre de motivation 2", "acceptée", "CV2.pdf"),
(3, 3, "Lettre de motivation 3", "refusée", "CV3.pdf"),
(4, 4, "Lettre de motivation 4", "en_attente", "CV4.pdf"),
(5, 5, "Lettre de motivation 5", "acceptée", "CV5.pdf"),
(6, 6, "Lettre de motivation 6", "refusée", "CV6.pdf"),
(7, 7, "Lettre de motivation 7", "en_attente", "CV7.pdf"),
(8, 8, "Lettre de motivation 8", "acceptée", "CV8.pdf"),
(9, 9, "Lettre de motivation 9", "refusée", "CV9.pdf"),
(10, 10, "Lettre de motivation 10", "en_attente", "CV10.pdf"),
(11, 11, "Lettre de motivation 11", "acceptée", "CV11.pdf"),
(12, 12, "Lettre de motivation 12", "refusée", "CV12.pdf"),
(13, 13, "Lettre de motivation 13", "en_attente", "CV13.pdf"),
(14, 14, "Lettre de motivation 14", "acceptée", "CV14.pdf"),
(15, 15, "Lettre de motivation 15", "refusée", "CV15.pdf"),
(16, 16, "Lettre de motivation 16", "en_attente", "CV16.pdf"),
(17, 17, "Lettre de motivation 17", "acceptée", "CV17.pdf"),
(18, 18, "Lettre de motivation 18", "refusée", "CV18.pdf"),
(19, 19, "Lettre de motivation 19", "en_attente", "CV19.pdf"),
(20, 20, "Lettre de motivation 20", "acceptée", "CV20.pdf"),
(21, 21, "Lettre de motivation 21", "refusée", "CV21.pdf"),
(22, 22, "Lettre de motivation 22", "en_attente", "CV22.pdf"),
(23, 23, "Lettre de motivation 23", "acceptée", "CV23.pdf"),
(24, 24, "Lettre de motivation 24", "refusée", "CV24.pdf"),
(25, 25, "Lettre de motivation 25", "en_attente", "CV25.pdf"),
(26, 26, "Lettre de motivation 26", "acceptée", "CV26.pdf"),
(27, 27, "Lettre de motivation 27", "refusée", "CV27.pdf"),
(28, 28, "Lettre de motivation 28", "en_attente", "CV28.pdf"),
(29, 29, "Lettre de motivation 29", "acceptée", "CV29.pdf"),
(30, 30, "Lettre de motivation 30", "refusée", "CV30.pdf");

-- Insertion des appartenances
INSERT INTO appartenir (utilisateur_id, promotion_id) VALUES
(1, 1), (2, 2), (4, 3), (5, 4), (7, 5), (8, 6), (10, 7), (11, 8), (13, 9), (14, 10),
(16, 11), (17, 12), (19, 13), (20, 14), (22, 15), (23, 16), (25, 17), (26, 18), (28, 19), (29, 20),
(30, 21), (1, 22), (2, 23), (4, 24), (5, 25), (7, 26), (8, 27), (10, 28), (11, 29), (13, 30);

-- Insertion des wishlists
INSERT INTO wishlist (offre_id, utilisateur_id) VALUES
(1, 1), (2, 1), (3, 1), (4, 1), (5, 1), (6, 1), (7, 1), (8, 1), (9, 1), (10, 1),
(11, 1), (12, 1), (13, 1), (14, 1), (15, 1), (16, 1), (17, 1), (18, 1), (19, 1), (20, 1),
(21, 1), (22, 1), (23, 1), (24, 1), (25, 1), (26, 1), (27, 1), (28, 1), (29, 1), (30, 1);

-- Insertion des évaluations
INSERT INTO evaluations (entreprise_id, utilisateur_id, evaluation_note) VALUES
(1, 1, 4), (2, 1, 5), (3, 1, 3), (4, 1, 4), (5, 1, 5), (6, 1, 3), (7, 1, 4), (8, 1, 5), (9, 1, 3), (10, 1, 4),
(11, 1, 5), (12, 1, 3), (13, 1, 4), (14, 1, 5), (15, 1, 3), (16, 1, 4), (17, 1, 5), (18, 1, 3), (19, 1, 4), (20, 1, 5),
(21, 1, 3), (22, 1, 4), (23, 1, 5), (24, 1, 3), (25, 1, 4), (26, 1, 5), (27, 1, 3), (28, 1, 4), (29, 1, 5), (30, 1, 3);

-- Insertion des compétences des offres
INSERT INTO competence_offre (offre_id, competence_id) VALUES
(1, 1), (2, 2), (3, 3), (4, 4), (5, 5), (6, 6), (7, 7), (8, 8), (9, 9), (10, 10),
(11, 11), (12, 12), (13, 13), (14, 14), (15, 15), (16, 16), (17, 17), (18, 18), (19, 19), (20, 20),
(21, 21), (22, 22), (23, 23), (24, 24), (25, 25), (26, 26), (27, 27), (28, 28), (29, 29), (30, 30);
