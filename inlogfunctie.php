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
        md5($_SESSION['wachtwoord']) === (getPersonIDNew($_SESSION['username'], $databaseConnection))[0]["Wachtwoord"])
    {
        $_SESSION['loginattempts']=0;
        ($_SESSION["loggedin"] = True);
    }
    else
    {
        $_SESSION['loggedin']=False;
        $_SESSION['name']="";
        $_SESSION['wachtwoord']="";
        $_SESSION['loginattempts']+=1;
        ?>
        <div class="alertbadrelative horizontalCenteredRelative">
            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
            Vul een juiste combinatie van gebruikersnaam en wachtwoord in.
        </div> <?php
    }
    if (!empty($_SESSION['loginattempts'])) {
        if ($_SESSION['loginattempts'] > 3) {
            ?>
            <div class="alertbadrelative horizontalCenteredRelative">
                <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                Teveel inlogpogingen. U wordt over een paar seconden doorgeleid om de veiligheid van de website te
                bewaren.
            </div> <?php
            if ($_SESSION['loginattempts'] > 4) {
                sleep(10);
            }
        }
    }
}