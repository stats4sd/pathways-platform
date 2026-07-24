SELECT
    ce.id AS cercle_id,
    ce.nom AS cercle_nom,
    uc.id AS union_id,
    uc.nom AS union_nom,
    cc.id AS cooperative_id,
    cc.nom AS cooperative_nom
FROM
    cooperative_cereales cc
JOIN
    union_cereales uc ON cc.union_cereale_id = uc.id
JOIN
    cercles ce ON uc.cercle_id = ce.id;
