<?php
include "header.php";
?>
<body>
<!-- Checkt of de "uitloggen" knop is ingedrukt. Zo ja, haalt het wachtwoord en naam van de user weg (niet de user/inlognaam) -->
<?php
if (isset($_POST["logout"]))
{
    $_SESSION['loggedin']=False;
    $_SESSION['name']="";
    $_SESSION['wachtwoord']="";
}
// Checkt of de "inloggen" knop ingedrukt is & slaat username en wachtwoord op in de session.
// Als de username niet leeg is en het wachtwoord het wachtwoord uit de database matcht ("HashedPassword"), word loggedin True
if (isset($_POST["submit"]))
{
    $_SESSION['username'] = $_POST["uname"];
    $_SESSION['wachtwoord'] = $_POST["pass"];
    if((!empty((getPersonIDNew($_SESSION['username'], $databaseConnection))[0]["Wachtwoord"])) &&
        $_SESSION['wachtwoord'] === (getPersonIDNew($_SESSION['username'], $databaseConnection))[0]["Wachtwoord"])
        {
            ($_SESSION["loggedin"] = True);
        }
    else
        {
            $_SESSION['loggedin']=False;
            $_SESSION['name']="";
            $_SESSION['wachtwoord']="";
            ?>
            <div class="alert" >
                <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                Vul een juiste combinatie van gebruikersnaam en wachtwoord in.
            </div> <?php
        }
}

if (isset($_POST["edit"]))
{
    setPersonID($_POST["Voornaam"],$_POST["Achternaam"],$_POST["Straat"],$_POST["Huisnummer"],$_POST["Postcode"],$_POST["Plaats"],$_POST["Land"],$_SESSION['username'],$databaseConnection);
    ?> <div class="alertaddtocart" >
    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
    <?php print("Accountgegevens aangepast!"); ?> </div><?php
}

// Als Loggedin = true, wordt een bericht getoond
if($_SESSION["loggedin"]===True){
if(!empty((getPersonIDNew($_SESSION['username'], $databaseConnection))[0]["Wachtwoord"]))
{
    $_SESSION["name"]=((getPersonIDNew($_SESSION['username'], $databaseConnection))[0]["Voornaam"] . " " . (getPersonIDNew($_SESSION['username'], $databaseConnection))[0]["Achternaam"]);
    ?> <h2 class="tabel"> <?php print("Je bent ingelogd als " . $_SESSION['name']);?> </h2>

    <form method=post action="index_login.php" class="tabel">
    <label for="voornaam">Voornaam:</label>
    <input type="text" id="voornaam" name="Voornaam" required value="<?php if ($_SESSION['loggedin']===True){print(getPersonIDNew($_SESSION['username'], $databaseConnection))[0]["Voornaam"];} ?>"><br><br>
    <label for="straat">Achternaam:</label>
    <input type="text" id="Achternaam" name="Achternaam" required value="<?php if ($_SESSION['loggedin']===True){print(getPersonIDNew($_SESSION['username'], $databaseConnection))[0]["Achternaam"];} ?>"><br><br>
    <label for="straat">Straat:</label>
    <input type="text" id="Straat" name="Straat" required value="<?php if ($_SESSION['loggedin']===True){print(getPersonIDNew($_SESSION['username'], $databaseConnection))[0]["Straat"];} ?>"><br><br>
    <label for="straat">Huisnummer:</label>
    <input type="text" id="Huisnummer" name="Huisnummer" required value="<?php if ($_SESSION['loggedin']===True){print(getPersonIDNew($_SESSION['username'], $databaseConnection))[0]["Huisnummer"];} ?>"><br><br>
    <label for="straat">Postcode:</label>
    <input type="text" id="Postcode" name="Postcode" required value="<?php if ($_SESSION['loggedin']===True){print(getPersonIDNew($_SESSION['username'], $databaseConnection))[0]["Postcode"];} ?>"><br><br>
    <label for="straat">Plaats:</label>
    <input type="text" id="Plaats" name="Plaats" required value="<?php if ($_SESSION['loggedin']===True){print(getPersonIDNew($_SESSION['username'], $databaseConnection))[0]["Plaats"];} ?>"><br><br>
    <label for="straat">Land (optioneel):</label>
    <input type="text" id="Land" name="Land" value="<?php if ($_SESSION['loggedin']===True){print(getPersonIDNew($_SESSION['username'], $databaseConnection))[0]["Land"];} ?>"><br><br>
    <input type="submit" value="Gegevens aanpassen" name="edit" class="winkelmandbutton">
    <input type="submit" name="logout" value="Uitloggen" class = "winkelmandbutton">

</form>
    <?php
    }
}
?>
<!--Toont login scherm als gebruiker niet al ingelogd is-->
<?php if ($_SESSION['loggedin']===False || !array_key_exists("loggedin", $_SESSION)){?>
    <form method="post" action="index_login.php" class="centered">
        <label for="uname">Gebruikersnaam</label><br>
        <input type="text" id="uname" name="uname"><br>
        <label for="pass">Wachtwoord</label><br>
        <input type="password" id="pass" name="pass"><br><br>
        <input type="submit" name="submit" value="Inloggen" class="horizontalcentered">
    </form>
    <form method="post" action="create.php" class="accountbutton">
        <input type="submit" name="createaccount" value="Nog geen account? Klik hier!">
    </form>
<?php } ?>
</body>
