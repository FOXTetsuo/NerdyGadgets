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
<body>
<!-- Toont bericht als iemand ingelogd is. -->
<?php if ($_SESSION["loggedin"] === True && isset($_SESSION["name"]))
{
    print("U bent ingelogd als " . $_SESSION["name"]);
}
$cart = getCart();
// Dit blok code kan ook op een andere pagina geplaatst worden indien gewenst. Is nodig voor betaling, haalt items uit karretje en toont bericht
if (isset($_POST["betalen"]))
{
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

<h1>Inhoud Winkelwagen</h1>
<!-- Als er op "empty cart" gedrukt wordt, word de cart geleegd. -->
<?php if (isset($_POST["submit"]))
{
    emptyCart();
}
// haalt cart op

?>
<!--Tabel waarin de cart getoond wordt. -->
    <table>
        <tr>
            <th>Afbeelding</th>
            <th>Naam</th>
            <th>Aantal</th>
            <th>Prijs</th>
            <th>Subtotaal</th>
            <th>Verwijderen</th>
        </tr>
        <?php foreach($cart as $productID => $aantal) {
            $stockitem = getStockItem($productID, $databaseConnection);
            $image = getStockItemImage($productID, $databaseConnection);
            if (isset($stockitem)) {
            ?>
        <tr>
            <td><img src="Public/StockItemIMG/<?php print $image[0]['ImagePath']; ?>" width = "200" height="200"></td>
            <td><a href="view.php?id=<?php print($productID)?>"><?php print($stockitem["StockItemName"]);?></a></td>
            <td><?php print($aantal); ?> </td>
            <td><?php print("€" . number_format(round($stockitem["SellPrice"], 2),2));
                $totaalprijs+= (number_format(round($aantal*($stockitem["SellPrice"]), 2),2));?> </td>
            <td><?php print("€" . number_format(round((($stockitem["SellPrice"])*$aantal), 2),2)); ?> </td>
            <td><form action="cart.php" method="post"><input type="submit" value="delete" name="delete"></form></td>

        </tr>
                <?php }
        } ?>
    </table>
<h5>
<?php

print("<br> De totale prijs is €". (number_format(round(($totaalprijs), 2),2)));?>
<?php $_SESSION["totprijs"]=$totaalprijs?>
</h5>
<br><br>
<?php if (!empty($cart)) {?>
<form method="post">
    <input type="submit" name="submit" value="Winkelwagen legen" class="winkelmandbutton">
</form>

<form method="post" action="iDeal.php">
    <input type="submit" name="Betalen" value="Betalen met iDeal" class="winkelmandbutton">
</form>
<?php } ?>
</body>
</html>