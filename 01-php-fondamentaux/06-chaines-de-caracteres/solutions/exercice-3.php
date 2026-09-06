<?php

$texte = "J'adore #PHP et #Laravel, c'est #Génial";

// Le modificateur /u active le mode Unicode, nécessaire ici car "Génial"
// contient un caractère accentué (É) qui ne serait pas reconnu par \w sans lui.
preg_match_all('/#[\w]+/u', $texte, $correspondances);

print_r($correspondances[0]); // ["#PHP", "#Laravel", "#Génial"]
