<?php
include "header.php";
?>
<?php
if (isset($_POST["logout"]))
{
    session_destroy();
}
if (isset($_POST["submit"]))
{
    $_SESSION['username'] = $_POST["uname"];
    $_SESSION['wachtwoord'] = $_POST["pass"];
    if((!empty((getPersonID($_SESSION['username'], $databaseConnection))[0]["HashedPassword"])))
        {
            if ($_SESSION['wachtwoord'] === (getPersonID($_SESSION['username'], $databaseConnection))[0]["HashedPassword"])
                {
                    ($_SESSION["loggedin"] = True);
                }
            else
                {
                    $_SESSION['loggedin']= False;
                    $_SESSION["name"]="";
                    $_SESSION['wachtwoord']="";
                    print("Vul een juiste gebruikersnaam en wachtwoord in");
                }
        }
    else
    {
        $_SESSION['loggedin']=False;
        $_SESSION['name']="";
        $_SESSION['wachtwoord']="";
        print("Vul een juiste gebruikersnaam en wachtwoord in");
    }
}
if($_SESSION["loggedin"]===True){
if(!empty((getPersonID($_SESSION['username'], $databaseConnection))[0]["HashedPassword"]))
{
    $_SESSION["name"]=(getPersonID($_SESSION['username'], $databaseConnection))[0]["FullName"];
    print("Je bent ingelogd als " . $_SESSION['name']);
}
}

?>
<!--Toont login scherm als gebruiker niet al ingelogd is-->
<?php if ($_SESSION['loggedin']===False){?>
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

