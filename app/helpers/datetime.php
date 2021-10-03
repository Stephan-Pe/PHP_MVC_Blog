<?php
function createDay()
{
    $tage = array("Sonntag", "Montag", "Dienstag", "Mittwoch", "Donnerstag", "Freitag", "Samstag");
    $monate = array(
        1 => "Januar",
        2 => "Februar",
        3 => "M&auml;rz",
        4 => "April",
        5 => "Mai",
        6 => "Juni",
        7 => "Juli",
        8 => "August",
        9 => "September",
        10 => "Oktober",
        11 => "November",
        12 => "Dezember"
    );
    date_default_timezone_set("Europe/Berlin");
    $tag = date("w");
    $monat = date("n");
    echo $tage[$tag] . ' der ' . date("n") . '. ' . $monate[$monat];
}
