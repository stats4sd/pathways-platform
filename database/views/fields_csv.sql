SELECT
    f.id AS value,
    f.nom AS label,
    f.year,
    f.farm_id,
    fa.code AS farm_code
FROM
    fields f
JOIN
    farms fa ON f.farm_id = fa.id;
