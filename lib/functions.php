<?php

function toStd($sekunden)
{
    $stunden = floor($sekunden / 3600);
    $minuten = floor(($sekunden - ($stunden * 3600)) / 60);
    $sekunden = round($sekunden - ($stunden * 3600) - ($minuten * 60), 0);

    if ($stunden <= 9) {
        $strStunden = "0" . $stunden;
    } else {
        $strStunden = $stunden;
    }

    if ($minuten <= 9) {
        $strMinuten = "0" . $minuten;
    } else {
        $strMinuten = $minuten;
    }

    if ($sekunden <= 9) {
        $strSekunden = "0" . $sekunden;
    } else {
        $strSekunden = $sekunden;
    }
    return "$strStunden:$strMinuten:$strSekunden";
}
