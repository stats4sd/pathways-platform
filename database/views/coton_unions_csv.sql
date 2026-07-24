SELECT
    co.id AS commune_id,
    co.nom AS commune_nom,
    us.id AS union_id,
    us.nom AS union_nom
FROM
    union_scpcs us
JOIN
    communes co ON us.commune_id = co.id;
