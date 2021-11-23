<?php
include "header.php";
?>


<img src="Public\Img\iDeal-logo.png" alt="Italian Trulli" width="180" height="100"><br>
<?php if ($_SESSION['loggedin']===True){
    print(nl2br("U bent ingelogd als " . $_SESSION["name"] . "\n"));}?>
<br>
Het totaalbedrag is: <?php if (isset ($_SESSION["totprijs"]))
{
    $_SESSION["totprijs"]=number_format($_SESSION["totprijs"], 2);
    print("€" . $_SESSION["totprijs"]);
}?>
<br>
<label for="betaal">Met welke bank wilt u betalen?</label>
<select name="betaal" id="betaal" class="winkelmandbutton">
    <option value="ING">ING</option>
    <option value="SNS">SNS</option>
    <option value="ABN AMRO">ABN AMRO</option>
    <option value="ASN">ASN</option>
    <option value="Rabobank">Rabobank</option>
</select>

<form method=post action="###">
    <label for="voornaam">Volledige naam:</label>
    <input type="text" id="voornaam" name="Volledige naam" value="<?php if (isset($_SESSION["name"])){print($_SESSION["name"]);} ?>"><br><br>
    <label for="straat">Straatnaam</label>
    <input type="text" id="straat" name="straat" value="<?php if (isset($_SESSION["Straat"])) { print($_SESSION["Straat"]); } else print("")?>"><br><br>
    <input type="submit" value="Betalen" class="winkelmandbutton">
</form>