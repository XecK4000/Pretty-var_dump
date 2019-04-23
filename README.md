# Pretty-var_dump
This is a simple implementation of the PHP var_dump printing an HTML version

functions.php -> All the functions needed

index.php -> A small example

/**
 * TODOs
 *      Aligner les flèches pour un même objet
 * OK?  S'étendre à droite quand on a plus assez de place / bien gérer l'écrasement des données -> nope, les attributs sont pas bien
 *
 * Possibilité :
 *      Créer de nouvelles classes au risque de rendre la structure moins lisible, pour rendre le js/css plus lisible (éviter les énumérations de 5 fois la même classe)
 *      Ajouter des retours à la ligne avant chaque donnée pour rendre le tout lisible dans de l'ajax
 *      Cacher le null si pas de paramètres donnés à la fonciton. Par exemple en lui mettant un paramètre par défaut "data_dump_empty" (car si mon met null ça marche po)
 */