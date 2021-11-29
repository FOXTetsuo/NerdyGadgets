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
// Als Loggedin = true, wordt een bericht getoond
if($_SESSION["loggedin"]===True){
if(!empty((getPersonIDNew($_SESSION['username'], $databaseConnection))[0]["Wachtwoord"]))
{
    $_SESSION["name"]=((getPersonIDNew($_SESSION['username'], $databaseConnection))[0]["Voornaam"] . " " . (getPersonIDNew($_SESSION['username'], $databaseConnection))[0]["Achternaam"]);
    print("Je bent ingelogd als " . $_SESSION['name']);
}
}

?>
<!--Toont login scherm als gebruiker niet al ingelogd is-->
<?php if ($_SESSION['loggedin']===False || !array_key_exists("loggedin", $_SESSION)){?>
    <form method="post" action="index_login.php" class="centered">
        <label for="uname">Gebruikersnaam</label><br>
        <input type="text" id="uname" name="uname"><br>
        <label for="pass">Wachtwoord</label><br>
        <input type="text" id="pass" name="pass"><br><br>
        <input type="submit" name="submit" value="Inloggen" class="horizontalcentered">
    </form>
    <form method="post" action="create.php" class="accountbutton">
        <input type="submit" name="createaccount" value="Nog geen account? Klik hier!">
    </form>
<?php } else {?>
    <form method="post" action="index_login.php" class="centered">
        <input type="submit" name="logout" value="Uitloggen">
    </form>
<?php } ?>

