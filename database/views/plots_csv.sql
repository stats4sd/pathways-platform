SELECT
    p.id AS name,
    p.numero_parcelle AS label,
    p.field_id,
    fa.id AS farm_id,
    fa.code AS farm_code,
    p.trace_superficie_odk AS geometry
FROM
    plots p
JOIN
    fields f ON p.field_id = f.id
JOIN
    farms fa ON f.farm_id = fa.id;
