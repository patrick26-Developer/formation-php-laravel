<?php

class Exemple
{
    private $valeurs = [1, 2, 3];

    public function total()
    {
        return array_sum($this->valeurs);
    }
}
