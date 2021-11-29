<?php
include "header.php";
?>

<form method="post" action="create.php" class="moveright">
    <label for="email">Emailadres</label><br>
    <input type="text" id="email" name="email" required><br>
    <label for="pass">Wachtwoord</label><br>
    <input type="text" id="pass" name="pass" required><br>
    <label for="voornaam">Voornaam</label><br>
    <input type="text" id="voornaam" name="voornaam" required><br>
    <label for="achternaam">Achternaam</label><br>
    <input type="text" id="achternaam" name="achternaam" required><br>
    <label for="straat">Straat</label><br>
    <input type="text" id="straat" name="straat" required><br>
    <label for="huisnummer">Huisnummer</label><br>
    <input type="text" id="huisnummer" name="huisnummer" required><br>
    <label for="postcode">Postcode</label><br>
    <input type="text" id="postcode" name="postcode" required><br>
    <label for="plaats">Plaats</label><br>
    <input type="text" id="plaats" name="plaats" required><br>
    <label for="land">Land (optioneel) </label><br>
    <input type="text" id="land" name="land"><br><br>
    <input type="submit" name="submit" value="Account aanmaken">
</form>

<?php if(isset($_POST["submit"]))
{
    $account = createAccount($_POST["email"],$_POST["pass"],$_POST["voornaam"],$_POST["achternaam"],$_POST["straat"],$_POST["huisnummer"],$_POST["postcode"],$_POST["plaats"],$_POST["land"],$databaseConnection);
    print_r($account);
}