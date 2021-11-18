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
<?php

print nl2br( "\n De totale prijs = €$totaalprijs");?>

<form method="post">
    <input type="submit" name="submit" value="Winkelwagen legen" class="winkelmandbutton">
</form>

</body>
</html>