<?php
include "header2.php";
?>
<div class="aanmelden"
<!-- form waarmee je NAW gegevens invult-->

    <form method=post action="create.php" class="tabel centered" style="top: 400px">
        <div class="row">
            <div class="col">
                <label for="email">Emailadres:</label>
                <input class="form-control" type="text" id="email" name="email" maxlength="15" required ><br>
            </div>
            <div class="col">
                <label for="pass">Wachtwoord:</label>
                <input class="form-control" type="password" id="pass" name="pass" maxlength="15" required><br>
            </div>
        </div>
        <div class="row">

            <div class="col">
                <label for="voornaam">Voornaam:</label>
                <input class="form-control" type="text" id="voornaam" name="voornaam" maxlength="15" required><br>
            </div>
            <div class="col">
                <label for="Achternaam">Achternaam:</label>
                <input class="form-control" type="text" id="achternaam" name="achternaam" required><br>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <label for="straat">Straat:</label>
                <input class="form-control" type="text" id="straat" name="straat" required><br>
            </div>
            <div class="col-md-3">
                <label for="huisnummer">Huisnummer:</label>
                <input class="form-control center-block" style="text-align:center" maxlength="10"
                       type="text"
                       id="huisnummer" name="huisnummer" required><br>
            </div>
            <div class="col-md-3">
                <label for="postcode">Postcode:</label>
                <input class="form-control" type="text" style="text-align: center" id="postcode" name="postcode" maxlength="6" required><br>
            </div>
        </div>
        <label for="Plaats">Plaats:</label>
        <input class="form-control" type="text" id="plaats" name="plaats" required><br>
        <label for="Land">Land (optioneel):</label>
        <input class="form-control" type="text" id="land" name="land"><br>
        <div class="horizontalCenteredRelative">
            <input type="submit" name="submit" class="btn btn-primary" value="Account aanmaken">
        </div>
    </form>



    <!-- Document Header Starts
<form method="post" action="create.php" class="tabel centered">
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
    <input type="text" id="postcode" name="postcode" class="form-control" maxlength="6" required>
    <label for="plaats">Plaats</label>
    <input type="text" id="plaats" name="plaats" class="form-control" required>
    <label for="land">Land (optioneel) </label>

</form>
-->
<?php if(isset($_POST["submit"]))
{
    $email = $_POST["email"];
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
    createAccount($_POST["email"],$_POST["pass"],$_POST["voornaam"],$_POST["achternaam"],$_POST["straat"],$_POST["huisnummer"],$_POST["postcode"],$_POST["plaats"],$_POST["land"],$databaseConnection);
    }
    if (checkexistence(($_POST["email"]),$databaseConnection)[0]["Emailadres"] === $_POST["email"])
    { ?>
    <div class="alertpositive" >
        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
        Account aangemaakt!
    </div>
        <?php
    }
    else if ?>
        <div class="alert" >
        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
        Incorrecte adresgegevens. Kijk de postcode na.
    </div>

    <?php }