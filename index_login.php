<?php
include "header.php";
?>
<form method="post" action="index_login.php">
    <label for="uname">Username</label><br>
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
    if ($_SESSION['username'] == "inkoper" &&
        $_SESSION['wachtwoord'] == "spekkoper")
    {
        ($_SESSION["loggedin"]=True);
    }
    else
    {
        $_SESSION["loggedin"]=False;
    }
}
if ($_SESSION['loggedin']==True)
{
    print("Je bent ingelogd als " . $_SESSION['username']);
}
?>
