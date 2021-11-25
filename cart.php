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
<?php if ($_SESSION["loggedin"] === True && isset($_SESSION["name"]))
{
    print("U bent ingelogd als " . $_SESSION["name"]);
} ?>

<h1>Inhoud Winkelwagen</h1>
<?php if (isset($_POST["submit"]))
{
    emptyCart();
}
$cart = getCart();
?>
    <table>
        <tr>
            <th>Afbeelding</th>
            <th>Naam</th>
            <th>Aantal</th>
            <th>Prijs</th>
            <th>Subtotaal</th>
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
            <td><?php print("€" . round($stockitem["SellPrice"], 2));
                $totaalprijs+= ($aantal*(round($stockitem["SellPrice"] , 2)));?> </td>
            <td><?php print("€" . round(($stockitem["SellPrice"]), 2)*$aantal); ?> </td>
        </tr>
                <?php }
        } ?>

    </table>

<?php
//gegevens per artikelen in $cart (naam, prijs, etc.) uit database halen
//totaal prijs berekenen
//mooi weergeven in html
//etc.

?>
<h5>
<?php

print nl2br( "\n De totale prijs is €$totaalprijs");?>
<?php $_SESSION["totprijs"]=$totaalprijs?>
</h5>
<br><br>
<form method="post">
    <input type="submit" name="submit" value="Winkelwagen legen" class="winkelmandbutton">
</form>
<form method="post" action="iDeal.php">
    <input type="submit" name="Betalen" value="Betalen met iDeal" class="winkelmandbutton">
</form>

</body>
</html>