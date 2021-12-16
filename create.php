<?php
include "header2.php";
?>
<!-- form waarmee je NAW gegevens invult-->
<form method="post" action="create.php" class="moveright">
    <label for="email">Emailadres</label><br>
    <input type="text" id="email" name="email" required><br>
    <label for="pass">Wachtwoord</label><br>
    <input type="password" id="pass" name="pass" required><br>
    <label for="voornaam">Voornaam</label>
    <input type="text" id="voornaam" name="voornaam" required>
    <label for="achternaam">Achternaam</label>
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
        if (!empty (((checkexistence(($_POST["email"]), $databaseConnection))[0]["Emailadres"])))
        // zorgt dat de code hieronder geen foutmeldingen geeft:
    {
        // kijkt of het emailadres niet al bestaat in de database
        if((checkexistence(($_POST["email"]), $databaseConnection))[0]["Emailadres"] === $_POST["email"])
        { ?>
            <div class="alertcreation">
                <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                <?php print ("Een account met dit emailadres bestaat al, log in met uw email in de inlogpagina of maak hier een nieuw account aan."); ?>
            </div>
            <?php
        }
    }
    else
    {
        // geeft een groene waarschuwing als het account succesvol aangemaakt is
    createAccount($_POST["email"],$_POST["pass"],$_POST["voornaam"],$_POST["achternaam"],$_POST["straat"],$_POST["huisnummer"],$_POST["postcode"],$_POST["plaats"],$_POST["land"],$databaseConnection);
    ?> <div class="alertpositive" >
        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
        Account aangemaakt!
    </div> <?php
    }
}