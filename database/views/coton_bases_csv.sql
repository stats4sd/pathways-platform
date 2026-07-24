SELECT
    v.id AS village_id,
    v.nom AS village_nom,
    bs.id AS base_scpc_id,
    bs.nom AS base_scpc_nom
FROM
    base_scpcs bs
JOIN
    base_scpc_village bsv ON bs.id = bsv.base_scpc_id
JOIN
    villages v ON bsv.village_id = v.id;
