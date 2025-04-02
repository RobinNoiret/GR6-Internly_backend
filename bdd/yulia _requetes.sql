--------------------------------------------------- GESTION D'ACCES -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

---------- SFx 1 - Authentifier un utilisateur
SELECT utilisateur_id, utilisateur_nom, utilisateur_prenom, utilisateur_statut, utilisateur_email
FROM utilisateur
WHERE utilisateur_email = ? AND utilisateur_password = ?;



--------------------------------------------------- GESTION DES ENTREPRISES -----------------------------------------------------------------------------------------------------------------------------------------------------------------------

---------- SFx 2 ( Rechercher et afficher une entreprise)
SELECT e.entreprise_id, e.entreprise_nom, e.entreprise_description, e.entreprise_email, 
       e.entreprise_telephone, e.entreprise_domaine,
       (SELECT COUNT(DISTINCT c.utilisateur_id) 
        FROM candidature c 
        JOIN offre o ON c.offre_id = o.offre_id 
        WHERE o.entreprise_id = e.entreprise_id) AS nombre_stagiaires,
       (SELECT AVG(ev.evaluation_note) 
        FROM evaluations ev 
        WHERE ev.entreprise_id = e.entreprise_id) AS moyenne_evaluations,
       a.adresse_rue, a.adresse_num_rue, v.ville_nom, v.ville_code_postal
FROM entreprise e
LEFT JOIN adresse a ON e.entreprise_id = a.entreprise_id
LEFT JOIN ville v ON a.ville_id = v.ville_id
WHERE e.entreprise_nom LIKE ? OR e.entreprise_domaine LIKE ?
AND e.entreprise_visibilite = TRUE
ORDER BY e.entreprise_nom;



---------- SFx 3 - Créer une entreprise
INSERT INTO entreprise (entreprise_nom, entreprise_description, entreprise_email, entreprise_telephone, entreprise_domaine, entreprise_visibilite)
VALUES (?, ?, ?, ?, ?, TRUE);



---------- SFx 4 - Modifier une entreprise
UPDATE entreprise
SET entreprise_nom = ?, 
    entreprise_description = ?, 
    entreprise_email = ?, 
    entreprise_telephone = ?,
    entreprise_domaine = ?
WHERE entreprise_id = ?;



---------- SFx 5 - Évaluer une entreprise
INSERT INTO evaluations (entreprise_id, utilisateur_id, evaluation_note)
VALUES (?, ?, ?)
ON DUPLICATE KEY UPDATE evaluation_note = VALUES(evaluation_note);



---------- SFx 6 - Supprimer une entreprise
-- Option 1: Suppression logique (recommandée)
UPDATE entreprise
SET entreprise_visibilite = FALSE
WHERE entreprise_id = ?;



--------------------------------------------------- GESTION DES OFFRES DE STAGE -------------------------------------------------------------------------------------------------------------------------------------------------------


---------- SFx 7 - 




---------- SFx 8 - Rechercher et afficher une offre
SELECT o.offre_id, o.offre_titre, o.offre_description, o.offre_remuneration, 
       o.offre_date_debut, o.offre_date_fin, o.offre_places, o.offre_date_publication,
       e.entreprise_id, e.entreprise_nom, e.entreprise_email, e.entreprise_telephone,
       (SELECT COUNT(*) FROM candidature c WHERE c.offre_id = o.offre_id) AS nombre_candidats,
       GROUP_CONCAT(DISTINCT c.competence_nom SEPARATOR ', ') AS competences,
       a.adresse_rue, a.adresse_num_rue, v.ville_nom, v.ville_code_postal
FROM offre o
JOIN entreprise e ON o.entreprise_id = e.entreprise_id
LEFT JOIN competence_offre co ON o.offre_id = co.offre_id
LEFT JOIN competence c ON co.competence_id = c.competence_id
LEFT JOIN adresse a ON e.entreprise_id = a.entreprise_id
LEFT JOIN ville v ON a.ville_id = v.ville_id
WHERE (o.offre_titre LIKE ? OR o.offre_description LIKE ? OR e.entreprise_nom LIKE ?)
AND e.entreprise_visibilite = TRUE
GROUP BY o.offre_id
ORDER BY o.offre_date_publication DESC
LIMIT ?, ?;  -- Pour la pagination



---------- SFx 9 - Créer une offre
-- Étape 1: Insérer l'offre
INSERT INTO offre (offre_titre, offre_description, offre_remuneration, offre_date_debut, offre_date_fin, offre_places, entreprise_id)
VALUES (?, ?, ?, ?, ?, ?, ?);

-- Étape 2: Récupérer l'ID de l'offre créée
SET @last_offre_id = LAST_INSERT_ID();

-- Étape 3: Ajouter les compétences à l'offre (à répéter pour chaque compétence)
INSERT INTO competence_offre (offre_id, competence_id)
VALUES (@last_offre_id, ?);



----------- SFx 10 - Modifier une offre
-- Étape 1: Mettre à jour les informations de l'offre
UPDATE offre
SET offre_titre = ?, 
    offre_description = ?, 
    offre_remuneration = ?, 
    offre_date_debut = ?,
    offre_date_fin = ?,
    offre_places = ?,
    entreprise_id = ?
WHERE offre_id = ?;
-- Étape 2: Supprimer les anciennes compétences
DELETE FROM competence_offre
WHERE offre_id = ?;
-- Étape 3: Ajouter les nouvelles compétences (à répéter pour chaque compétence)
INSERT INTO competence_offre (offre_id, competence_id)
VALUES (?, ?);



---------- SFx 11 - Supprimer une offre 
DELETE FROM offre
WHERE offre_id = ?;



---------- SFx 12 - Consulter les statistiques des offres
-- Répartition par compétence
SELECT c.competence_nom, COUNT(co.offre_id) AS nombre_offres
FROM competence c
JOIN competence_offre co ON c.competence_id = co.competence_id
GROUP BY c.competence_id
ORDER BY nombre_offres DESC;
-- Répartition par durée de stage (en mois)
SELECT 
    TIMESTAMPDIFF(MONTH, offre_date_debut, offre_date_fin) AS duree_mois,
    COUNT(*) AS nombre_offres
FROM offre
GROUP BY duree_mois
ORDER BY duree_mois;
-- Top des offres en wishlist
SELECT o.offre_id, o.offre_titre, e.entreprise_nom, COUNT(w.utilisateur_id) AS nombre_wishlist
FROM offre o
JOIN entreprise e ON o.entreprise_id = e.entreprise_id
JOIN wishlist w ON o.offre_id = w.offre_id
GROUP BY o.offre_id
ORDER BY nombre_wishlist DESC
LIMIT 10;



--------------------------------------------------- GESTION DES PILOTES DES PROMOTIONS -------------------------------------------------------------------------------------------------------------------------------------------------------


---------- SFx 13 - Rechercher et afficher un compte Pilote
SELECT u.utilisateur_id, u.utilisateur_nom, u.utilisateur_prenom, u.utilisateur_email,
       v.ville_nom, v.ville_code_postal,
       GROUP_CONCAT(DISTINCT p.class_name SEPARATOR ', ') AS promotions
FROM utilisateur u
LEFT JOIN ville v ON u.ville_id = v.ville_id
LEFT JOIN appartenir a ON u.utilisateur_id = a.utilisateur_id
LEFT JOIN promotion p ON a.promotion_id = p.promotion_id
WHERE u.utilisateur_statut = 'pilote'
AND (u.utilisateur_nom LIKE ? OR u.utilisateur_prenom LIKE ?)
GROUP BY u.utilisateur_id
ORDER BY u.utilisateur_nom, u.utilisateur_prenom
LIMIT ?, ?;  -- Pour la pagination



---------- SFx 14 - Créer un compte Pilote
INSERT INTO utilisateur (utilisateur_nom, utilisateur_prenom, utilisateur_statut, utilisateur_email, utilisateur_password, ville_id)
VALUES (?, ?, 'pilote', ?, ?, ?);



---------- SFx 15 - Modifier un compte Pilote
UPDATE utilisateur
SET utilisateur_nom = ?, 
    utilisateur_prenom = ?, 
    utilisateur_email = ?,
    ville_id = ?
WHERE utilisateur_id = ? AND utilisateur_statut = 'pilote';



---------- SFx 16 - Supprimer un compte Pilote
DELETE FROM utilisateur
WHERE utilisateur_id = ? AND utilisateur_statut = 'pilote';



--------------------------------------------------- GESTION DES ETUDIANTS --------------------------------------------------------------------------------------------------------------------------------------------------------------------------

---------- SFx 17 - Rechercher et afficher un compte Etudiant
SELECT u.utilisateur_id, u.utilisateur_nom, u.utilisateur_prenom, u.utilisateur_email,
       v.ville_nom, v.ville_code_postal,
       GROUP_CONCAT(DISTINCT p.class_name SEPARATOR ', ') AS promotions,
       (SELECT COUNT(*) FROM candidature c WHERE c.utilisateur_id = u.utilisateur_id) AS nombre_candidatures,
       (SELECT COUNT(*) FROM candidature c WHERE c.utilisateur_id = u.utilisateur_id AND c.candidature_status = 'acceptée') AS candidatures_acceptees,
       (SELECT COUNT(*) FROM wishlist w WHERE w.utilisateur_id = u.utilisateur_id) AS nombre_wishlist
FROM utilisateur u
LEFT JOIN ville v ON u.ville_id = v.ville_id
LEFT JOIN appartenir a ON u.utilisateur_id = a.utilisateur_id
LEFT JOIN promotion p ON a.promotion_id = p.promotion_id
WHERE u.utilisateur_statut = 'etudiant'
AND (u.utilisateur_nom LIKE ? OR u.utilisateur_prenom LIKE ? OR u.utilisateur_email LIKE ?)
GROUP BY u.utilisateur_id
ORDER BY u.utilisateur_nom, u.utilisateur_prenom
LIMIT ?, ?;  -- Pour la pagination



---------- SFx 18 - Créer un compte Etudiant
-- Étape 1: Insérer l'utilisateur
INSERT INTO utilisateur (utilisateur_nom, utilisateur_prenom, utilisateur_statut, utilisateur_email, utilisateur_password, ville_id)
VALUES (?, ?, 'etudiant', ?, ?, ?);
-- Étape 2: Récupérer l'ID de l'utilisateur créé
SET @last_user_id = LAST_INSERT_ID();
-- Étape 3: Ajouter l'étudiant à une promotion (si nécessaire)
INSERT INTO appartenir (utilisateur_id, promotion_id)
VALUES (@last_user_id, ?);



---------- SFx 19 - Modifier un compte Etudiant
UPDATE utilisateur
SET utilisateur_nom = ?, 
    utilisateur_prenom = ?, 
    utilisateur_email = ?,
    ville_id = ?
WHERE utilisateur_id = ? AND utilisateur_statut = 'etudiant';



---------- SFx 20 - Supprimer un compte Etudiant
DELETE FROM utilisateur
WHERE utilisateur_id = ? AND utilisateur_statut = 'etudiant';



---------- SFx 21 - Consulter les statistiques d un compte Etudiant
SELECT 
    u.utilisateur_id, u.utilisateur_nom, u.utilisateur_prenom, u.utilisateur_email,
    COUNT(DISTINCT c.offre_id) AS total_candidatures,
    SUM(CASE WHEN c.candidature_status = 'en_attente' THEN 1 ELSE 0 END) AS candidatures_en_attente,
    SUM(CASE WHEN c.candidature_status = 'acceptée' THEN 1 ELSE 0 END) AS candidatures_acceptees,
    SUM(CASE WHEN c.candidature_status = 'refusée' THEN 1 ELSE 0 END) AS candidatures_refusees,
    COUNT(DISTINCT w.offre_id) AS total_wishlist
FROM utilisateur u
LEFT JOIN candidature c ON u.utilisateur_id = c.utilisateur_id
LEFT JOIN wishlist w ON u.utilisateur_id = w.utilisateur_id
WHERE u.utilisateur_id = ? AND u.utilisateur_statut = 'etudiant'
GROUP BY u.utilisateur_id;



--------------------------------------------------- GESTION DES CANDIDATURES -------------------------------------------------------------------------------------------------------------------------------------------------------


---------- SFx 22 - Ajouter une offre à la wish-list
INSERT INTO wishlist (offre_id, utilisateur_id)
VALUES (?, ?);



---------- SFx 23 - Retirer une offre de la wish-list
DELETE FROM wishlist
WHERE offre_id = ? AND utilisateur_id = ?;



---------- SFx 24 - Afficher les offres ajoutées à la wish-list
SELECT w.offre_id, o.offre_titre, o.offre_description, o.offre_remuneration,
       o.offre_date_debut, o.offre_date_fin, o.offre_places,
       e.entreprise_nom, e.entreprise_email, e.entreprise_telephone,
       GROUP_CONCAT(DISTINCT c.competence_nom SEPARATOR ', ') AS competences
FROM wishlist w
JOIN offre o ON w.offre_id = o.offre_id
JOIN entreprise e ON o.entreprise_id = e.entreprise_id
LEFT JOIN competence_offre co ON o.offre_id = co.offre_id
LEFT JOIN competence c ON co.competence_id = c.competence_id
WHERE w.utilisateur_id = ?
GROUP BY w.offre_id
ORDER BY o.offre_date_publication DESC;



---------- SFx 25 - Postuler à une offre
INSERT INTO candidature (offre_id, utilisateur_id, candidature_lm, candidature_status, candidature_cv)
VALUES (?, ?, ?, 'en_attente', ?);



---------- SFx 26 - Afficher les offres en cours de candidature
SELECT c.offre_id, o.offre_titre, o.offre_description, 
       e.entreprise_nom, e.entreprise_email,
       c.candidature_date, c.candidature_status, c.candidature_lm, c.candidature_cv
FROM candidature c
JOIN offre o ON c.offre_id = o.offre_id
JOIN entreprise e ON o.entreprise_id = e.entreprise_id
WHERE c.utilisateur_id = ?
ORDER BY c.candidature_date DESC;



--------------------------------------------------- AUTRE ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------


---------- Recherche d offres par compétence
SELECT o.offre_id, o.offre_titre, o.offre_description, o.offre_remuneration,
       o.offre_date_debut, o.offre_date_fin, o.offre_places,
       e.entreprise_nom, e.entreprise_email
FROM offre o
JOIN entreprise e ON o.entreprise_id = e.entreprise_id
JOIN competence_offre co ON o.offre_id = co.offre_id
JOIN competence c ON co.competence_id = c.competence_id
WHERE c.competence_id = ? AND e.entreprise_visibilite = TRUE
ORDER BY o.offre_date_publication DESC
LIMIT ?, ?;  -- Pour la pagination



---------- Liste des compétences disponibles
SELECT competence_id, competence_nom
FROM competence
ORDER BY competence_nom;



---------- Liste des promotions disponibles
SELECT promotion_id, class_name
FROM promotion
ORDER BY class_name;



---------- Liste des villes disponibles
SELECT ville_id, ville_nom, ville_code_postal
FROM ville
ORDER BY ville_nom;


















 -------------------------- NO NEED


---------------------------------------- Rechercher et afficher une entreprise
SELECT 
    e.entreprise_nom,
    e.entreprise_description,
    e.entreprise_email,
    e.entreprise_telephone,
    COUNT(DISTINCT c.utilisateur_id) AS nb_stagiaires,
    ROUND(AVG(ev.evaluation_note), 1) AS moyenne_evaluation
FROM entreprise e
LEFT JOIN offre o ON o.entreprise_id = e.entreprise_id
LEFT JOIN candidature c ON c.offre_id = o.offre_id
LEFT JOIN evaluations ev ON ev.entreprise_id = e.entreprise_id
WHERE e.entreprise_nom LIKE '%nom_recherche%'
GROUP BY e.entreprise_id;

------------------------------------------ modifier une entreprise
UPDATE entreprise
SET 
    entreprise_nom = 'Nouveau Nom',
    entreprise_description = 'Nouvelle description',
    entreprise_email = 'nouveau@email.com',
    entreprise_telephone = '0987654321'
WHERE entreprise_id = 1;

--------------------------------------------- Rechercher et afficher une offre
SELECT 
    o.offre_titre,
    o.offre_description,
    e.entreprise_nom,
    o.offre_remuneration,
    o.offre_date_debut,
    o.offre_date_fin,
    COUNT(DISTINCT c.utilisateur_id) AS nb_postulants,
    GROUP_CONCAT(DISTINCT comp.competence_nom SEPARATOR ', ') AS competences
FROM offre o
JOIN entreprise e ON e.entreprise_id = o.entreprise_id
LEFT JOIN candidature c ON c.offre_id = o.offre_id
LEFT JOIN competence_offre co ON co.offre_id = o.offre_id
LEFT JOIN competence comp ON comp.competence_id = co.competence_id
WHERE o.offre_titre LIKE '%titre_recherche%'
GROUP BY o.offre_id;




