select
    id,
    label_fr,
    label_bm,
    nom_fichier_image,
    type,
    `order`
from crops
where type!='autre'
order by `order`;