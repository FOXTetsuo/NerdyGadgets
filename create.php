<?php include "header2.php"; ?>
    <div class="aanmelden"
    <!-- form waarmee je NAW gegevens invult-->
        <form method=post action="create.php" class="tabel centered" style="top: 55%">
        <div class="row">
            <div class="col">
                <label for="email">Emailadres:</label>
                <input class="form-control" type="text" id="email" name="email" required><br>
            </div>
            <div class="col">
                <label for="pass">Wachtwoord:</label>
                <input class="form-control" type="password" id="pass" name="pass" required><br>
            </div>
        </div>
        <div class="row">
            <h6 class="horizontalCenteredRelative aligntxt">Vul hieronder uw factuurgegevens in. Als u een product bestelt, worden deze automatisch ingevuld bij de verzendgegevens.</h6><br>

            <div class="col">
                <label for="voornaam">Voornaam:</label>
                <input class="form-control" type="text" id="voornaam" name="voornaam" required maxlength="15"><br>
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
                <input class="form-control" type="text" style="text-align: center" id="postcode" name="postcode"
                       maxlength="6" required><br>
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
<?php if (isset($_POST["submit"])) {
        // kijkt of het emailadres correct is.
        if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) { ?>
            <div class="alertcreation">
                <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                Emailformaat is incorrect, vul een juist email-adres in.
            </div>
            <?php
        }
        // Checkt of het wachtwoord veilig is
        $uppercase = preg_match('@[A-Z]@', $_POST["pass"]);
        $lowercase = preg_match('@[a-z]@', $_POST["pass"]);
        $number    = preg_match('@[0-9]@', $_POST["pass"]);
        $specialChars = preg_match('@[^\w]@', $_POST["pass"]);
        $passsafe = 1;
        if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($_POST["pass"]) < 12) { ?>
            <div class="alertcreation">
                <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                Dit wachtwoord is onveilig. Vul a.u.b. een wachtwoord in met minimaal 12 karakters, 1 hoofdletter, 1 kleine letter, 1 nummer en een speciaal teken.
            </div> <?php $passsafe = 0;
        }
//    Regex zodata de postcode altijd klopt. Als deze dat niet doet, krijg je de onderstaande melding.
        if (!preg_match("([0-9][0-9][0-9][0-9][a-zA-Z][a-zA-Z])", $_POST["postcode"])) { ?>
            <div class="alertcreation">
                <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                Postcode is incorrect, vul een juiste postcode in.
            </div> <?php
        }
//        Kijkt of het emailadres niet al bestaat.
        if (!empty (((checkexistence(($_POST["email"]), $databaseConnection))[0]["Emailadres"]))) // zorgt dat de code hieronder geen foutmeldingen geeft:
        {
            if ((checkexistence(($_POST["email"]), $databaseConnection))[0]["Emailadres"] === $_POST["email"]) { ?>
                <div class="alertcreation">
                    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                    <?php print ("Een account met dit emailadres bestaat al, log in met uw email in de inlogpagina of maak hier een nieuw account aan."); ?>
                </div>
                <?php
            }
        }
//      Regex zodata de postcode altijd klopt.
        elseif (preg_match("([0-9][0-9][0-9][0-9][a-zA-Z][a-zA-Z])", $_POST["postcode"]) && $passsafe === 1 && (filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)))
            {
                createAccount($_POST["email"], $_POST["pass"], ucfirst($_POST["voornaam"]), $_POST["achternaam"], ucfirst($_POST["straat"]), $_POST["huisnummer"], $_POST["postcode"], ucfirst($_POST["plaats"]), ucfirst($_POST["land"]), $databaseConnection);
                ?>
                <div class="alertpositive">
                    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                    Account aangemaakt!
                </div>
                <?php
            }
}?>
