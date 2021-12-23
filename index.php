<!-- dit is het bestand dat wordt geladen zodra je naar de website gaat -->
<?php
include __DIR__ . "/header2.php";
$topsolditems=topseller($databaseConnection);
shuffle($topsolditems);
$FrontPageImage = getStockItemImage($topsolditems[0]["StockItemID"], $databaseConnection);
$FrontpageItem = getStockItem($topsolditems[0]["StockItemID"],$databaseConnection);
?>
<div class="CenteredContent">
<div id="indextop">
    <div class="indexheaderleft">
        <div class="TextPrice">
            <a href="view.php?id=<?php print $topsolditems[0]["StockItemID"]?>">
                <div class="TextMain">
                    <?php print($FrontpageItem["StockItemName"]); ?>
                </div>
                <ul id="ul-class-price">
                    <li class="HomePagePrice"><?php print("€");
                    print(number_format(round($FrontpageItem["SellPrice"], 2), 2)) ?></li>
                </ul>
        </div>

    </div>
    <div class="indexheaderright">
        <img class="HomePageStockItemPicture" src="Public/StockItemIMG/<?php print $FrontPageImage[0]['ImagePath'] ?>">
        </a>
    </div>
</div>
    <div style="color: #FFA500" class="titlerecommendations"><h3><b>Populair op dit moment:</b></h3></div>
<?php foreach ($topsolditems as $item => $product){
    $FrontPageImage = getStockItemImage($product["StockItemID"], $databaseConnection);
    $FrontpageItem = getStockItem($product["StockItemID"],$databaseConnection);
    ?>

    <div id="indexbottom">
    <div class="grid-container-large">
        <div class="grid-item-large">
            <a class="ListItem" href='view.php?id=<?php print $product["StockItemID"]?>'>
                <div id="ImageFrameHome"
                     style="background-image: url('Public/StockItemIMG/<?php print $FrontPageImage[0]['ImagePath'] ?>');
                             background-size: 100%;
                             background-repeat: no-repeat;
                             background-position: center;">
                </div>
                <div style="font-size: 20px;">
                    <?php print($FrontpageItem["StockItemName"]); ?>
                </div>
            </a>
        </div>
    </div>
    </div>
<?php } ?>

</div>
<?php
include __DIR__ . "/footer.php";
?>

