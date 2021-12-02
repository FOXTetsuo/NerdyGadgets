<!-- dit bestand bevat alle code voor de pagina die één product laat zien -->
<?php
include "header.php";
include "cartfuncties.php";
include "stockfuntions.php";
if (!empty($_GET['id']))
{
    $StockItem = getStockItem($_GET['id'], $databaseConnection);
    $StockItemImage = getStockItemImage($_GET['id'], $databaseConnection);
}
?>

<div id="CenteredContent">
    <h3>
    <?php
    if (isset($_POST["submit"])) {              // zelfafhandelend formulier
        $stockItemID = $_POST["stockItemID"];
        $aantalInMand = $_POST["aantal"];
        for ($i = 0; $i<$aantalInMand; $i++)
        {
            addProductToCart($stockItemID);         // maak gebruik van geïmporteerde functie uit cartfuncties.php
        }
        ?>
        <div class="alertaddtocart" >
            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
            <?php print("Product toegevoegd aan <a href='cart.php'> winkelmandje!</a>"); ?> </div>
        <?php
        $_SESSION["stockItemID"] = $_POST["stockItemID"];
    }
    ?>
    </h3>
    <?php
    if (!empty($StockItem)) {
        ?>
        <?php
        if (isset($StockItem['Video'])) {
            ?>
            <div id="VideoFrame">
                <?php print $StockItem['Video']; ?>
            </div>
        <?php }
        ?>


        <div id="ArticleHeader">
            <?php
            if (isset($StockItemImage)) {
                // één plaatje laten zien
                if (count($StockItemImage) == 1) {
                    ?>
                    <div id="ImageFrame"
                         style="background-image: url('Public/StockItemIMG/<?php print $StockItemImage[0]['ImagePath']; ?>'); background-size: 300px; background-repeat: no-repeat; background-position: center;"></div>
                    <?php
                } else if (count($StockItemImage) >= 2) { ?>
                    <!-- meerdere plaatjes laten zien -->
                    <div id="ImageFrame">
                        <div id="ImageCarousel" class="carousel slide" data-interval="false">
                            <!-- Indicators -->
                            <ul class="carousel-indicators">
                                <?php for ($i = 0; $i < count($StockItemImage); $i++) {
                                    ?>
                                    <li data-target="#ImageCarousel"
                                        data-slide-to="<?php print $i ?>" <?php print (($i == 0) ? 'class="active"' : ''); ?>></li>
                                    <?php
                                } ?>
                            </ul>

                            <!-- slideshow -->
                            <div class="carousel-inner">
                                <?php for ($i = 0; $i < count($StockItemImage); $i++) {
                                    ?>
                                    <div class="carousel-item <?php print ($i == 0) ? 'active' : ''; ?>">
                                        <img src="Public/StockItemIMG/<?php print $StockItemImage[$i]['ImagePath'] ?>">
                                    </div>
                                <?php } ?>
                            </div>

                            <!-- knoppen 'vorige' en 'volgende' -->
                            <a class="carousel-control-prev" href="#ImageCarousel" data-slide="prev">
                                <span class="carousel-control-prev-icon"></span>
                            </a>
                            <a class="carousel-control-next" href="#ImageCarousel" data-slide="next">
                                <span class="carousel-control-next-icon"></span>
                            </a>
                        </div>
                    </div>
                    <?php
                }
            } else {
                ?>
                <div id="ImageFrame"
                     style="background-image: url('Public/StockGroupIMG/<?php print $StockItem['BackupImagePath']; ?>'); background-size: cover;"></div>
                <?php
            }
            ?>


            <h1 class="StockItemID">Artikelnummer: <?php print $StockItem["StockItemID"]; ?></h1>
            <h2 class="StockItemNameViewSize StockItemName">
                <?php print $StockItem['StockItemName']; ?>
            </h2>
            <div class="QuantityText"><?php
                $quantity = explode(" ",$StockItem['QuantityOnHand']);
                print getVoorraadTekst($quantity[1]); ?></div>
            <!-- Nog plakken bovenaan-->
            <?php
            //?id=1 handmatig meegeven via de URL (gebeurt normaal gesproken als je via overzicht op artikelpagina terechtkomt)
            if (isset($_GET["id"])) {
                $stockItemID = $_GET["id"];
            } else {
                $stockItemID = 0;
            }
            ?>

            <div id="StockItemHeaderLeft">
                <div class="CenterPriceLeft">
                    <div class="CenterPriceLeftChild">

                        <p class="StockItemPriceText"><b><?php print sprintf("€ %.2f", $StockItem['SellPrice']); ?></b></p>
                        <h6> Inclusief BTW </h6>
                        <?php if (!empty($_GET['id'])){ ?>
                            <!-- formulier via POST en niet GET om te zorgen dat refresh van pagina niet het artikel onbedoeld toevoegt-->
                            <form method="post">
                                <label for="aantal">Aantal:</label>
                                <input type="number" id="aantal" name="aantal" value="1" class="winkelmandbutton">
                                <input type="number" name="stockItemID" value="<?php print($stockItemID) ?>" hidden>
                                <button class="btn-primary" type="submit" name="submit" > <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-cart-check" viewBox="0 0 16 16">
                                        <path d="M11.354 6.354a.5.5 0 0 0-.708-.708L8 8.293 6.854 7.146a.5.5 0 1 0-.708.708l1.5 1.5a.5.5 0 0 0 .708 0l3-3z"/>
                                        <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                                    </svg></button>
                            </form>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>

        <div id="StockItemDescription">
            <h3>Artikel beschrijving</h3>
            <p><?php print $StockItem['SearchDetails']; ?></p>
        </div>
        <div id="StockItemSpecifications">
            <h3>Artikel specificaties</h3>
            <?php
            $CustomFields = json_decode($StockItem['CustomFields'], true);
            if (is_array($CustomFields)) { ?>
                <table>
                <thead>
                <th>Naam</th>
                <th>Data</th>
                </thead>
                <?php
                foreach ($CustomFields as $SpecName => $SpecText) { ?>
                    <tr>
                        <td>
                            <?php print $SpecName; ?>
                        </td>
                        <td>
                            <?php
                            if (is_array($SpecText)) {
                                foreach ($SpecText as $SubText) {
                                    print $SubText . " ";
                                }
                            } else {
                                print $SpecText;
                            }
                            ?>
                        </td>
                    </tr>
                <?php } ?>
                </table><?php
            } else { ?>

                <p><?php print $StockItem['CustomFields']; ?>.</p>
                <?php
            }
            ?>
        </div>
        <?php
    } else {
        ?><h2 id="ProductNotFound">De winkelgekko kon helaas dit product niet vinden... misschien heeft hij het opgegeten?</h2>
        <img src="Public\Img\gecko-eet.png" alt="Gecko eating" class="center"> <?php
    } ?>


</div>
