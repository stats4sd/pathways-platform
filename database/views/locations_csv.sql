SELECT 
    r.id AS region_id,
    r.nom AS region_nom,
    c.id AS cercle_id,
    c.nom AS cercle_nom,
    co.id AS commune_id,
    co.nom AS commune_nom,
    v.id AS village_id,
    v.nom AS village_nom
FROM 
    regions r
JOIN 
    cercles c ON r.id = c.region_id
JOIN 
    communes co ON c.id = co.cercle_id
JOIN 
    villages v ON co.id = v.commune_id;