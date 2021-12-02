<?php
$totaalprijs =0;
include "header.php";
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
<?php if ($_SESSION["loggedin"] === True && isset($_SESSION["name"]))
{
    print("U bent ingelogd als " . $_SESSION["name"]);
}
?> </h6> <?php
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
}
if (empty($cart))
{;?>
<!--Tabel waarin de cart getoond wordt. -->
    <body>
    <div class="centered" style="margin-top: 80px">
    <img src="Public\Img\gecko-eet.png" alt="Gecko eating" class=" ">
    <h2 class="">Uw winkelwagen is leeg, wilt u verder winkelen?</h2>
    <form method="POST"  action="http://localhost/gitgadget/categories.php" class=" ">
        <button type="submit" class="btn-primary"> Begin met winkelen </button>
    </form>
    </div>
    </body>
<?php }
else{
// Dit blok code kan ook op een andere pagina geplaatst worden indien gewenst. Is nodig voor betaling, haalt items uit karretje en toont bericht
if (isset($_POST["betalen"]))
{
    orderItems(getPersonIDNew($_SESSION['username'], $databaseConnection)[0]["USERID"],1,"SYSTEM",$databaseConnection, 1);
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
    $cart = getCart();
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
            if (isset($stockitem)) {
            ?>
        <tr>
            <td><img src="Public/StockItemIMG/<?php if (isset($image[0]['ImagePath'])) {print $image[0]['ImagePath'];} else print$image ?>" width = "200" height="200"></td>
            <td><a href="view.php?id=<?php print($productID)?>"><?php print($stockitem["StockItemName"]);?></a></td>
            <td class="smallbutton"><input type="text" id="fname" name="fname" value=<?php print($aantal)?> ></td>
            <td><?php
                $roundPrice = number_format(round($stockitem["SellPrice"],2),2);
                print("€" . $roundPrice);
                $totaalprijs+= $roundPrice * $aantal; ?> </td>
            <td><?php print("€" . number_format($roundPrice * $aantal, 2)); ?> </td>
            <td>
                <form action="cart.php" method="post">
                    <button type="submit"  name=<?php print("delete$productID")?>>
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

print("<br> De totale prijs is €". (number_format(round(($totaalprijs), 2),2)));?>
<?php $_SESSION["totprijs"]=$totaalprijs?>
</h5>
<br><br>
<?php if (!empty($cart)) {?>
    <form method="post" action="iDeal.php" id="CenteredContent">
        <div class="winkelmandbutton"><input class="btn btn-primary" type="submit" name="Betalen" value="Betalen met iDeal"></div>
    </form>
    <form method="post" id="CenteredContent">
        <div class="smallbutton"><input type="submit" name="submit" value="Winkelwagen legen" class="btn btn-primary"></div>
    </form>
<?php }
}?>
</body>
</html>