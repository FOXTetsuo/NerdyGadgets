<!-- dit is het bestand dat wordt geladen zodra je naar de website gaat -->
<?php
include __DIR__ . "/header2.php";
$topsolditems=topseller($databaseConnection);
?>

<div class="titlerecommendations"><h3 style="text-align: left">Bekijk ook eens onze meest verkochte items!</h3></div>
<?php foreach ($topsolditems as $item => $product){
    $FrontPageImage = getStockItemImage($product["StockItemID"], $databaseConnection);
    $FrontpageItem = getStockItem($product["StockItemID"],$databaseConnection);
    ?>
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
<?php } ?>
<?php
include __DIR__ . "/footer.php";
?>

