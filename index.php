<!-- dit is het bestand dat wordt geladen zodra je naar de website gaat -->
<?php
include __DIR__ . "/header2.php";
$topsolditems=topseller($databaseConnection);
foreach ($topsolditems as $item)
{
    $FrontPageImage = getStockItemImage((topseller($databaseConnection)[0]["StockItemID"]), $databaseConnection);
}
?>
<div class="IndexStyle">
    <div class="col-11">
        <div class="TextPrice">
            <a href="view.php?id=93">
                <div class="TextMain">
                    <?php print(topseller($databaseConnection)[0]["StockItemID"]); ?>
                </div>
                <ul id="ul-class-price">
                    <li class="HomePagePrice">€30.95</li>
                </ul>
        </div>
        </a>
        <div class="HomePageStockItemPicture"></div>
    </div>
</div>
<?php
include __DIR__ . "/footer.php";
?>

