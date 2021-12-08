<?php
function getVoorraadTekst($actueleVoorraad) {
    if ($actueleVoorraad > 1000) {
        return "✔ Ruime voorraad beschikbaar<br>✔ Voor 23:59 uur besteld, morgen in huis";
    } elseif ($actueleVoorraad > 0) {
        return "✔ Voorraad: $actueleVoorraad<br>✔ Voor 23:59 uur besteld, morgen in huis";
    } else {
        return "Product is helaas niet op voorraad";
    }
}