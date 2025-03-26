//////////////////////////////////////////////////// Rechercher et afficher une entreprise
sql
Copier
Modifier
 
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

//////////////////////////////////////////////////// modifier une entreprise
UPDATE entreprise
SET 
    entreprise_nom = 'Nouveau Nom',
    entreprise_description = 'Nouvelle description',
    entreprise_email = 'nouveau@email.com',
    entreprise_telephone = '0987654321'
WHERE entreprise_id = 1;

//////////////////////////////////////////////////// Rechercher et afficher une offre
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


////////////////////////////////////////////////// créer une offre 
INSERT INTO offre (
    offre_titre,
    offre_description,
    offre_remuneration,
    offre_date_debut,
    offre_date_fin,
    offre_places,
    entreprise_id
) VALUES (
    'Titre de l\'offre',
    'Description de l\'offre...',
    800.00,
    '2025-04-01',
    '2025-06-30',
    3,
    1
);

-- Associer les compétences
INSERT INTO competence_offre (offre_id, competence_id)
VALUES (1, 2), (1, 3);  -- Ex : associer les compétences 2 et 3 à l’offre 1
