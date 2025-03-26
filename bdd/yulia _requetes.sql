// 
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
