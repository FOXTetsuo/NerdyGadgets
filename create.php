<?php
include "header2.php";

if(isset($_POST["submit"]))
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

<div class="aanmelden"
<!-- form waarmee je NAW gegevens invult-->
<form method="post" action="create.php" class="moveright">
    <label for="email">Emailadres</label>
    <input type="text" id="email" name="email" class="form-control" required>
    <label for="pass">Wachtwoord</label>
    <input type="password" id="pass" name="pass" class="form-control" required>
    <label for="voornaam">Voornaam</label>
    <input type="text" id="voornaam" name="voornaam" class="form-control" required>
    <label for="achternaam">Achternaam</label>
    <input type="text" id="achternaam" name="achternaam" class="form-control" required>
    <label for="straat">Straat</label>
    <input type="text" id="straat" name="straat" class="form-control" required>
    <label for="huisnummer">Huisnummer</label>
    <input type="text" id="huisnummer" name="huisnummer" class="form-control" required>
    <label for="postcode">Postcode</label>
    <input type="text" id="postcode" name="postcode" class="form-control" required>
    <label for="plaats">Plaats</label>
    <input type="text" id="plaats" name="plaats" class="form-control" required>
    <label for="land">Land (optioneel) </label>
    <input type="text" id="land" name="land" class="form-control"> <br>
    <input type="submit" name="submit" class="btn btn-primary"value="Account aanmaken">
</form>

<?php
    }
}