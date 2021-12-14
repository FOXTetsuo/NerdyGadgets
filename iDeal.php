<?php
include "header2.php";
?>
<head>

</head>
<body>

<!--iDeal logo wordt getoond -->
<img src="Public\Img\iDeal-logo.png" alt="Ideal Logo" width="180" height="100" ><br>
<div class="tabel">
<?php if ($_SESSION['loggedin']===True){
    print(nl2br("U bent ingelogd als " . $_SESSION["name"] . "\n"));}?>
</div><br>
<h5 {absolute} class="tabel">
Het totaalbedrag is: <?php if (isset ($_SESSION["totprijs"]))
{
    //verandert totale prijs in juiste formaat met 2 decimalen
    $_SESSION["totprijs"]=number_format($_SESSION["totprijs"], 2);
    print("€" . $_SESSION["totprijs"]);
}?>
</h5>
<br>

<!-- tabel met opties van bank -->
<label for="betaal" class="tabel button20">Met welke bank wilt u betalen?</label>
<select name="betaal" id="betaal" class="smallbutton" required >
    <option value="ING">ING</option>
    <option value="SNS">SNS</option>
    <option value="ABN AMRO">ABN AMRO</option>
    <option value="ASN">ASN</option>
    <option value="Rabobank">Rabobank</option>
</select>

<form method=post action="cart.php" class="tabel">
    Vul hier uw verzendgegevens in. Als U ingelogd bent, worden uw accountgegevens gebruikt voor het factuuradres. Als u niet ingelogd bent zijn het verzendadres en factuuradres identiek. <br>
    <label for="email">Emailadres:</label>
    <input type="text" class="form-control" id="email" name="email" required value="<?php if ($_SESSION['loggedin']===True){print(getPersonIDNew($_SESSION['username'], $databaseConnection))[0]["Emailadres"];} ?>"> <br>
    <label for="voornaam">Voornaam:</label>
    <input type="text" class="form-control" id="voornaam" name="Voornaam" required value="<?php if ($_SESSION['loggedin']===True){print(getPersonIDNew($_SESSION['username'], $databaseConnection))[0]["Voornaam"];} ?>"><br>
    <label for="straat">Achternaam:</label>
    <input type="text" class="form-control" id="Achternaam" name="Achternaam" required value="<?php if ($_SESSION['loggedin']===True){print(getPersonIDNew($_SESSION['username'], $databaseConnection))[0]["Achternaam"];} ?>"><br>
    <label for="straat">Straat:</label>
    <input type="text" class="form-control" id="Straat" name="Straat" required value="<?php if ($_SESSION['loggedin']===True){print(getPersonIDNew($_SESSION['username'], $databaseConnection))[0]["Straat"];} ?>"><br>
    <label for="straat">Huisnummer:</label>
    <input type="text" class="form-control" id="Huisnummer" name="Huisnummer" required value="<?php if ($_SESSION['loggedin']===True){print(getPersonIDNew($_SESSION['username'], $databaseConnection))[0]["Huisnummer"];} ?>"><br>
    <label for="straat">Postcode:</label>
    <input type="text" class="form-control" id="Postcode" name="Postcode" required value="<?php if ($_SESSION['loggedin']===True){print(getPersonIDNew($_SESSION['username'], $databaseConnection))[0]["Postcode"];} ?>"><br>
    <label for="straat">Plaats:</label>
    <input type="text" class="form-control" id="Plaats" name="Plaats" required value="<?php if ($_SESSION['loggedin']===True){print(getPersonIDNew($_SESSION['username'], $databaseConnection))[0]["Plaats"];} ?>"><br>
    <label for="straat">Land (optioneel):</label>
    <input type="text" class="form-control" id="Land" name="Land" value="<?php if ($_SESSION['loggedin']===True){print(getPersonIDNew($_SESSION['username'], $databaseConnection))[0]["Land"];} ?>"><br>
    <input type="submit" value="Betalen" name="betalen" class="winkelmandbutton">
</form>
</body>
