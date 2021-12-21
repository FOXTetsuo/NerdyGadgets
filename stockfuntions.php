<?php
function getVoorraadTekst($actueleVoorraad)
{
    if ($actueleVoorraad > 1000) {
        return "✔ Ruime voorraad beschikbaar<br>✔ Voor 23:59 uur besteld, morgen in huis";
    } elseif ($actueleVoorraad > 10) {
        return "✔ Voorraad: $actueleVoorraad<br>✔ Voor 23:59 uur besteld, morgen in huis";
    } elseif ($actueleVoorraad <11) {
        return "❗ Nog maar ". $actueleVoorraad. " op voorraad!"."<br>". "✔ Voor 23:59 uur besteld, morgen in huis";
} else {
        return "Product is helaas niet op voorraad";
    }
}