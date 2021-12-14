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
    <h1 class="StockItemID">Artikelnummer: <?php print $StockItem["StockItemID"]; ?></h1>
    <h2 class="StockItemNameViewSize StockItemName">
        <?php print $StockItem['StockItemName']; ?>
    <h3>
    <?php
    if (isset($_POST["submit"])){              // zelfafhandelend formulier
            {
                if ($_POST["aantal"] < explode(" ",$StockItem['QuantityOnHand'])[1]){
                $stockItemID = $_POST["stockItemID"];
                $aantalInMand = $_POST["aantal"];
                for ($i = 0; $i<$aantalInMand; $i++)
                    {
                        addProductToCart($stockItemID);         // maak gebruik van geïmporteerde functie uit cartfuncties.php
                    }?>
                <div class="alertaddtocart" >
                <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                <?php print("Product toegevoegd aan <a href='cart.php'> winkelmandje!</a>"); ?> </div>
                <?php
                $_SESSION["stockItemID"] = $_POST["stockItemID"];}
                else
                {   ?>
                    <div class="alert" >
                <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                <?php print("Er zijn niet genoeg artikelen beschikbaar. Verander het aantal gewenste artikelen."); ?> </div> <?php

                }
            }
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
                         style="background-image: url('Public/StockItemIMG/<?php print $StockItemImage[0]['ImagePath']; ?>'); background-size: 400px; background-repeat: no-repeat; background-position: center;"></div>
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
                                        <img class="horizontalCenteredRelative" src="Public/StockItemIMG/<?php print $StockItemImage[$i]['ImagePath'] ?>">
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

            </h2>
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
                        <div>
                        <?php if (!empty($_GET['id'])){ ?>
                            <!-- formulier via POST en niet GET om te zorgen dat refresh van pagina niet het artikel onbedoeld toevoegt-->
                            <form method="post" class="inwinkelwagenbtn">
                                <?php print "<br><br><br>"; ?>
                                <input type="number" id="aantal" name="aantal" value="1" class="aantalbutton">
                                <input type="number" name="stockItemID" value="<?php print($stockItemID) ?>" hidden>
                                <button type="submit" name="submit" class="inwinkelwagen btn btn-primary"
                                <?php if (explode(" ",$StockItem['QuantityOnHand'])[1] < 1)
                                    {
                                        print "disabled";
                                    } ?> >In winkelwagen</button>
                            </form>
                            <div class="QuantityText">
                                <?php
                                $quantity = explode(" ",$StockItem['QuantityOnHand']); ?>
                                <p style="color: #676EFF"><b><?php print "<br>".getVoorraadTekst($quantity[1]); ?></b></p>
                                <div>
                                    <p style="color: white"><strong>✔</strong>
                                    <?php print " Gratis verzending boven de €25<br>"; ?><strong>✔</strong>
                                    <?php print "30 dagen bedenktijd<br>"; ?><strong>✔</strong>
                                    <?php print "24/7 klantenservice<br>"; ?><strong>✔</strong>
                                    <?php print "Prijs is incl. BTW"; ?></p>
                                </div>
                        </div>
                        <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="StockItemDescription" style="float: left">

        </div>
        <div id="StockItemSpecifications">
            <h3>Artikel beschrijving</h3>
            <p><?php print $StockItem['SearchDetails']; ?></p>
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
        ?>
        <div class="centered" style="margin-top: 80px">
            <img src="Public\Img\gecko-eet.png" alt="Gecko eating" class="center">
            <h2 id="ProductNotFound">De winkelgekko kon helaas dit product niet vinden... Misschien heeft hij het opgegeten?</h2>
        <?php
    } ?>


</div>
