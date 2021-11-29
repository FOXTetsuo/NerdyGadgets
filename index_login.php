<?php
include "header.php";
?>
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
    if((!empty((getPersonID($_SESSION['username'], $databaseConnection))[0]["HashedPassword"])) &&
        $_SESSION['wachtwoord'] === (getPersonID($_SESSION['username'], $databaseConnection))[0]["HashedPassword"])
        {
            ($_SESSION["loggedin"] = True);
        }
    else
        {
            $_SESSION['loggedin']=False;
            $_SESSION['name']="";
            $_SESSION['wachtwoord']="";
            print("Vul een juiste gebruikersnaam en wachtwoord in");
        }
}
// Als Loggedin = true, wordt een bericht getoond
if($_SESSION["loggedin"]===True){
if(!empty((getPersonID($_SESSION['username'], $databaseConnection))[0]["HashedPassword"]))
{
    $_SESSION["name"]=(getPersonID($_SESSION['username'], $databaseConnection))[0]["FullName"];
    print("Je bent ingelogd als " . $_SESSION['name']);
}
}

?>
<!--Toont login scherm als gebruiker niet al ingelogd is-->
<?php if ($_SESSION['loggedin']===False || !array_key_exists("loggedin", $_SESSION)){?>
    <form method="post" action="index_login.php">
        <label for="uname">Gebruikersnaam</label><br>
        <input type="text" id="uname" name="uname" class="winkelmandbutton"><br>
        <label for="pass">Wachtwoord</label><br>
        <input type="text" id="pass" name="pass" class="winkelmandbutton"><br>
        <input type="submit" name="submit" value="Inloggen" class="winkelmandbutton">
    </form>
<?php } else {?>
    <form method="post" action="index_login.php">
        <input type="submit" name="logout" value="Uitloggen" class="winkelmandbutton">
    </form>
<?php } ?>

