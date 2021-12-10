<?php
if (isset($_POST["logout"]))
{
    $_SESSION['loggedin']=False;
    $_SESSION['name']="";
    $_SESSION['wachtwoord']="";
}

if (isset($_POST["submitLogin"]))
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