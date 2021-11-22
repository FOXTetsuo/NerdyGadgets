<?php
include "header.php";
?>
<form method="post" action="index_login.php">
    <label for="uname">Gebruikersnaam</label><br>
    <input type="text" id="uname" name="uname"><br>
    <label for="pass">Wachtwoord</label><br>
    <input type="text" id="pass" name="pass">
    <input type="submit" name="submit" value="Inloggen">
</form>

<?php
if (isset($_POST["submit"]))
{
    $_SESSION['username'] = $_POST["uname"];
    $_SESSION['wachtwoord'] = $_POST["pass"];
    if((!empty((getPersonID($_SESSION['username'], $databaseConnection))[0]["HashedPassword"])))
        {
        if ($_SESSION['wachtwoord'] == (getPersonID($_SESSION['username'], $databaseConnection))[0]["HashedPassword"])
        {
            ($_SESSION["loggedin"] = True);
        }
        else {
        $_SESSION['loggedin']=False;
        $_SESSION['username']="";
        $_SESSION['wachtwoord']="";
        print("Vul een juiste gebruikersnaam en wachtwoord in");
        }
        }
    else
    {
        $_SESSION['loggedin']=False;
        $_SESSION['username']="";
        $_SESSION['wachtwoord']="";
        print("Vul een juiste gebruikersnaam en wachtwoord in");
    }
}


if(!empty((getPersonID($_SESSION['username'], $databaseConnection))[0]["HashedPassword"]) && $_SESSION["loggedin"]==True)
{
    $_SESSION["name"]=(getPersonID($_SESSION['username'], $databaseConnection))[0]["FullName"];
    print("Je bent ingelogd als " . $_SESSION['name']);
}
?>

