<?php

$texte = "J'adore #PHP et #Laravel, c'est #Génial";

// The /u modifier enables Unicode mode, needed here because "Génial"
// contains an accented character (É) that \w wouldn't recognize without it.
preg_match_all('/#[\w]+/u', $texte, $correspondances);

print_r($correspondances[0]); // ["#PHP", "#Laravel", "#Génial"]
