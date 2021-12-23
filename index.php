<!-- dit is het bestand dat wordt geladen zodra je naar de website gaat -->
<?php
include __DIR__ . "/header2.php";
$topsolditems=topseller($databaseConnection);
shuffle($topsolditems);
$FrontPageImage = getStockItemImage($topsolditems[0]["StockItemID"], $databaseConnection);
$FrontpageItem = getStockItem($topsolditems[0]["StockItemID"],$databaseConnection);
?>
<div class="verticalcentered" style="margin-top: 5%; margin-right: 5%">
    <div class="col-11">
        <div class="TextPrice">
            <a href="view.php?id=<?php print $topsolditems[0]["StockItemID"]?>">
                <div class="TextMain">
                    <?php print($FrontpageItem["StockItemName"]); ?>
                </div>
                <ul id="ul-class-price">
                    <li class="HomePagePrice">€30.95</li>
                </ul>
        </div>
        </a>
        <div class="HomePageStockItemPicture"></div> <img class="HomePageStockItemPicture" src="Public/StockItemIMG/<?php print $FrontPageImage[0]['ImagePath'] ?>"></div>
    </div>
</div>
<?php
include __DIR__ . "/footer.php";
?>

