<?php
include "header2.php";
?>
<body>
<!-- Checkt of de "uitloggen" knop is ingedrukt. Zo ja, haalt het wachtwoord en naam van de user weg (niet de user/inlognaam) -->
<?php
// Checkt of de "inloggen" knop ingedrukt is & slaat username en wachtwoord op in de session.
// Als de username niet leeg is en het wachtwoord het wachtwoord uit de database matcht ("HashedPassword"), word loggedin True

if (isset($_POST["edit"])) {
    setPersonID($_POST["Voornaam"], $_POST["Achternaam"], $_POST["Straat"], $_POST["Huisnummer"], $_POST["Postcode"], $_POST["Plaats"], $_POST["Land"], $_SESSION['username'], $databaseConnection);
    ?>
    <div class="alertaddtocart">
    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
    <?php print("Accountgegevens aangepast!"); ?> </div><?php
}

// Als Loggedin = true, wordt een bericht getoond
if ($_SESSION["loggedin"] === True) {
    if (!empty((getPersonIDNew($_SESSION['username'], $databaseConnection))[0]["Wachtwoord"])) {
        $_SESSION["name"] = ((getPersonIDNew($_SESSION['username'], $databaseConnection))[0]["Voornaam"] . " " . (getPersonIDNew($_SESSION['username'], $databaseConnection))[0]["Achternaam"]);
        ?>
        <br>
        <h6 class="horizontalCenteredRelative aligntxt">Welkom in het klantenscherm, hier kunt u uw factuuradres en persoonlijke gegevens aanpassen </h6>
        <form method=post action="index_login.php" class="tabel centered" style="top: 400px">
            <div class="row">
                <div class="col">

                    <label for="voornaam">Voornaam:</label>
                        <input class="form-control" type="text" id="voornaam" name="Voornaam" maxlength="15" required
                           value="<?php if ($_SESSION['loggedin'] === True) {
                               print(getPersonIDNew($_SESSION['username'], $databaseConnection))[0]["Voornaam"];
                           } ?>"><br>
                </div>
                <div class="col">
                    <label for="Achternaam">Achternaam:</label>
                    <input class="form-control" type="text" id="Achternaam" name="Achternaam" required
                           value="<?php if ($_SESSION['loggedin'] === True) {
                               print(getPersonIDNew($_SESSION['username'], $databaseConnection))[0]["Achternaam"];
                           } ?>"><br>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label for="Straat">Straat:</label>
                    <input class="form-control" type="text" id="Straat" name="Straat" required
                           value="<?php if ($_SESSION['loggedin'] === True) {
                               print(getPersonIDNew($_SESSION['username'], $databaseConnection))[0]["Straat"];
                           } ?>"><br>
                </div>
                <div class="col-md-3">
                    <label for="Huisnummer">Huisnummer:</label>
                    <input class="form-control center-block" style="text-align:center" maxlength="10"
                           type="text"
                           id="Huisnummer" name="Huisnummer" required value="<?php if ($_SESSION['loggedin'] === True) {
                        print(getPersonIDNew($_SESSION['username'], $databaseConnection))[0]["Huisnummer"];
                    } ?>"><br>
                </div>
                <div class="col-md-3">
                    <label for="Postcode">Postcode:</label>
                    <input class="form-control" type="text" style="text-align: center" id="Postcode" name="Postcode" maxlength="6" required
                           value="<?php if ($_SESSION['loggedin'] === True) {
                               print(getPersonIDNew($_SESSION['username'], $databaseConnection))[0]["Postcode"];
                           } ?>"><br>
                </div>
            </div>
            <label for="Plaats">Plaats:</label>
            <input class="form-control" type="text" id="Plaats" name="Plaats" required
                   value="<?php if ($_SESSION['loggedin'] === True) {
                       print(getPersonIDNew($_SESSION['username'], $databaseConnection))[0]["Plaats"];
                   } ?>"><br>
            <label for="Land">Land (optioneel):</label>
            <input class="form-control" type="text" id="Land" name="Land"
                   value="<?php if ($_SESSION['loggedin'] === True) {
                       print(getPersonIDNew($_SESSION['username'], $databaseConnection))[0]["Land"];
                   } ?>"><br>
            <div class="horizontalCentered">
                <input type="submit" name="logout" value="Uitloggen" class="winkelmandbutton btn btn-primary" style="margin-right: 230px">
                <input type="submit" value="Gegevens aanpassen" name="edit" class="winkelmandbutton btn btn-danger">
            </div>
        </form>
        <?php
    }
}
?>
<!--Toont login scherm als gebruiker niet al ingelogd is-->
<?php if ($_SESSION['loggedin'] === False || !array_key_exists("loggedin", $_SESSION)) { ?>
    <form method="post" action="index_login.php" class="centered">
        <label for="uname">Gebruikersnaam</label><br>
        <input class="form-control" type="text" id="uname" name="uname"><br>
        <label for="pass">Wachtwoord</label><br>
        <input class="form-control" type="password" id="pass" name="pass"><br>
        <input type="submit" name="submitLogin" value="Inloggen" class="horizontalcentered btn btn-primary">
    </form>
    <form method="post" action="create.php" class="accountbutton">
        <button type="submit" name="createaccount" class="btn btn-primary btn-lg" style="border-radius 0.3rem"> Nog geen
            account? Klik hier!
        </button>
    </form>
<?php } ?>
</body>
<?php if ($_SESSION['loginattempts'] >= 20)
{ ?>
    <div class="alertbadrelative horizontalCenteredRelative">
        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
        Teveel inlogpogingen. Neem contact op met de websitebeheerder om uw wachtwoord te resetten.
    </div> <?php
}