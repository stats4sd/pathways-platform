SELECT
    r.id AS region_id,
    r.nom AS region_nom,
    fs.id AS federation_id,
    fs.nom AS federation_nom
FROM
    federation_scpcs fs
JOIN
    federation_scpc_region fsr ON fs.id = fsr.federation_scpc_id
JOIN
    regions r ON fsr.region_id = r.id;
