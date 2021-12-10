<?php
$totaalprijs =0;
include "header2.php";
include "cartfuncties.php";
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Winkelwagen</title>
</head>
<body >
<!-- Toont bericht als iemand ingelogd is. -->
<h6 id="CenteredContent">
</h6> <?php
// Als er op "empty cart" gedrukt wordt, word de cart geleegd.
if (isset($_POST["submit"])) {
    emptyCart();
}
// haalt cart op
$cart = getCart();
foreach ($cart as $productID => $amount)
{
    if (isset($_POST["delete$productID"]))
    {
        removeProductFromCart($productID);
    }
    $cart = getCart();
    if (isset($_POST["changecart"]) && $_POST["itemamount"] > 0)
        $cart[$productID] = $_POST["itemamount"];
}
if (empty($cart))
{;?>
<!--Tabel waarin de cart getoond wordt. -->
    <body>
    <div style="margin-top: 80px">
    <img src="Public\Img\gecko-eet.png" alt="Gecko eating" class="horizontalCenteredRelative">
    <h2 class="col-lg-6 col-lg-offset-6 horizontalCenteredRelative text-center">Hmmm, de winkelgekko kon geen producten vinden in de winkelwagen</h2>
    <form method="POST"  action="categories.php" class=" ">
        <button type="submit" class="btn btn-primary my-2 my-sm-0 horizontalCenteredRelative"> Begin met winkelen </button>
    </form>
    </div>
    </body>
<?php }
else{
// Dit blok code kan ook op een andere pagina geplaatst worden indien gewenst. Is nodig voor betaling, haalt items uit karretje en toont bericht
if (isset($_POST["betalen"]))
{
    if ($_SESSION["loggedin"] === true)
    {
    orderItems(getPersonIDNew($_SESSION['username'], $databaseConnection)[0]["USERID"],1,"SYSTEM",$databaseConnection, 1,$_POST["Voornaam"],$_POST["Achternaam"],$_POST["Straat"],$_POST["Plaats"],$_POST["Postcode"],$_POST["Huisnummer"],$_POST["email"]);
    }
    else
    {
        orderItemsNoAccount(1,"SYSTEM",$databaseConnection,1,$_POST["Voornaam"],$_POST["Achternaam"],$_POST["Straat"],$_POST["Plaats"],$_POST["Postcode"],$_POST["Huisnummer"],$_POST["email"]);
    }
    ?>
    <div class="alertpositive" >
        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
        Bestelling geplaatst!
    </div>
    <?php

    foreach ($cart as $item => $amount)
    {
        for ($i=0; $i < $amount; $i++)
        {
            lowerStock($item, $databaseConnection);
        }
        removeProductFromCart($item);
    }
    header("Location:betaald.php");
    exit();
}


// kopieren tot hier :)
?>

<h1 id="CenteredContent">Inhoud Winkelwagen</h1>
<!--Tabel waarin de cart getoond wordt. -->
    <table id="CenteredContent" class="table table-font-color">
        <thead>
        <tr>
            <th>Afbeelding</th>
            <th>Naam</th>
            <th>Aantal</th>
            <th>Prijs</th>
            <th>Subtotaal</th>
            <th>Verwijderen</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($cart as $productID => $aantal) {
            $stockitem = getStockItem($productID, $databaseConnection);
            $image = getStockItemImage($productID, $databaseConnection);
            if($aantal > explode(" ",$stockitem['QuantityOnHand'])[1])
                {
                    $aantal = explode(" ",$stockitem['QuantityOnHand'])[1];
                    ?> <div class="alert centeralert">
                    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                    Van item <?php print ($stockitem["StockItemName"] . " zijn er niet genoeg items beschikbaar. Het aantal is aangepast.") ?>
                    </div> <?php
                }
            if (isset($stockitem)) {
            ?>
        <tr>
            <td><img src="Public/StockItemIMG/<?php if (isset($image[0]['ImagePath'])) {
                    print $image[0]['ImagePath'];
                } else print$image ?>" width="200" height="200"></td>
            <td><a href="view.php?id=<?php print($productID) ?>"><?php print($stockitem["StockItemName"]); ?></a></td>
            <td class="padding0">
                <form action="cart.php" method="post"><input type="text" id="itemamount" name="itemamount" class="form-control col-sm-4"
                                                             class="winkelmandbutton" value=<?php print($aantal) ?>>
                    <button class="invisible" type="submit" name="changecart"></button>
                </form>
            </td>
            <td><?php
                $roundPrice = number_format(round($stockitem["SellPrice"], 2), 2);
                print("€" . $roundPrice);
                $totaalprijs += $roundPrice * $aantal; ?> </td>
            <td><?php print("€" . number_format($roundPrice * $aantal, 2)); ?> </td>
            <td>
                <form action="cart.php" method="post">
                    <button type="submit" name=<?php print("delete$productID") ?>>
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </form>
            </td>
        </tr>
        </tbody>
                <?php }
        } ?>
    </table>
<h5 id="CenteredContent">
<?php

print("<br> De totale prijs is €". (number_format(round(($totaalprijs), 2),2))." (inc. BTW)");?>
<?php $_SESSION["totprijs"]=$totaalprijs?>
</h5>
<br><br>
<?php if (!empty($cart) ) {?>
    <form method="post" action="iDeal.php" id="CenteredContent">
        <div class="winkelmandbutton"><input class="btn btn-primary" type="submit" name="Betalen" value="Betalen met iDeal"></div>
    </form>
    <form method="post" id="CenteredContent">
        <div class="smallbutton"><input type="submit" name="submit" value="Winkelwagen legen" class="btn btn-primary"></div>
    </form>
<?php
}
}
?>
</body>
</html>