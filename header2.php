<!-- de inhoud van dit bestand wordt bovenaan elke pagina geplaatst -->
<?php
session_start();
// als de sessionwaarde "loggedin" nog niet bestaat, laad deze in als "false"
if (!isset($_SESSION["loggedin"]))
{
    $_SESSION["loggedin"]=False;
}

include "database.php";
$databaseConnection = connectToDatabase();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>NerdyGadgets</title>

    <!-- Javascript -->
    <script src="Public/JS/fontawesome.js"></script>
    <script src="Public/JS/jquery.min.js"></script>
    <script src="Public/JS/popper.min.js"></script>
    <script src="Public/JS/bootstrap.min.js"></script>
    <script src="Public/JS/resizer.js"></script>

    <!-- Style sheets-->
    <link rel="stylesheet" href="Public/CSS/style.css" type="text/css">
    <link rel="stylesheet" href="Public/CSS/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="Public/CSS/typekit.css">
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-light bg-gecko">
    <a class="navbar-brand" href="#">
        <img src="Public/ProductIMGHighRes/NerdyGadgetsLogo.png" alt="Gecko">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="categories.php">Alle categorieën</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Speelgoed & Cadeau's
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="browse.php?category_id=6">Computing Novelties</a>
                    <a class="dropdown-item" href="browse.php?category_id=7">USB's</a>
                    <a class="dropdown-item" href="browse.php?category_id=9">Toys</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="browse.php?category_id=2">Alle speelgoed & cadeau's</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Kleding
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="browse.php?category_id=4">T-shirts</a>
                    <a class="dropdown-item" href="browse.php?category_id=9">Dierensokken</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="browse.php?category_id=2">Alle kleding</a>
                </div>
            </li>
        </ul>
        <form class="form-inline my-2 my-lg-0" method="get" action="browse.php ">
            <input class="form-control mr-sm-2" type="text" placeholder="Zoeken" aria-label="Search" id="search_string" name="search_string">
            <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Zoeken</button>
        </form>
    </div>
</nav>

</body>