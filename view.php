<!-- dit bestand bevat alle code voor de pagina die één product laat zien -->
<?php
include "header2.php";
include "cartfuncties.php";
include "stockfuntions.php";
if (!empty($_GET['id']))
{
$StockItem = getStockItem($_GET['id'], $databaseConnection);
$StockItemImage = getStockItemImage($_GET['id'], $databaseConnection);

//?id=1 handmatig meegeven via de URL (gebeurt normaal gesproken als je via overzicht op artikelpagina terechtkomt)
if (isset($_GET["id"])) {
    $stockItemID = $_GET["id"];
} else {
    $stockItemID = 0;
}
?>
<!--Artikelnummer en artikelbeschrijving-->
<div class="CenteredContent">
<!--1 artikel toevoegen aan winkelwagen-->
            <?php
            if (isset($_POST["submit"]))    // zelfafhandelend formulier
            {
                {
                    if ($_POST["aantal"] <= explode(" ",$StockItem['QuantityOnHand'])[1])
                    {
                        $stockItemID = $_POST["stockItemID"];
                        $aantalInMand = $_POST["aantal"];
                        for ($i = 0; $i<$aantalInMand; $i++)
                        {
                            addProductToCart($stockItemID);     // maak gebruik van geïmporteerde functie uit cartfuncties.php
                        }?>
<!--melding: "toegevoegd aan winkelwagen"-->
                        <div
                            class="alertaddtocart" ><h3>
                            <span
                                class="closebtn" onclick="this.parentElement.style.display='none';">&times;
                            </span>
                            <?php print("Product toegevoegd aan <a href='cart.php'> winkelmandje!</a>"); ?>
                        </div>
                        <?php
                        $_SESSION["stockItemID"] = $_POST["stockItemID"];
                    }
//melding te weinig artikelen op voorraad
                    else
                    {
                        ?>
                        <div class="alert" >
                            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>

                            <?php
                            print("Er zijn niet genoeg artikelen beschikbaar. Verander het aantal gewenste artikelen.");
                            ?>
                        </div>
                        <?php
                    }
                }
            }
}
            ?>
    <?php if (!empty($StockItem))
    {?>
<!--artikelnummer en titel-->
    <div class="title">
        <h1 class="StockItemID">Artikelnummer: <?php print $StockItem["StockItemID"]; ?></h1>
        <h2 class="StockItemNameViewSize StockItemName">
            <?php print $StockItem['StockItemName']; ?>
    </div>
<!--video-->
        </h3>
        <div id="ArticleHeader">
            <div class="headerleft">
<!--afbeelding-->
            <?php
            if (isset($StockItemImage))
            {
// één plaatje laten zien
                if (count($StockItemImage) == 1) {
                    ?>
                    <div id="ImageFrame"
                         style="background-image: url('Public/StockItemIMG/<?php print $StockItemImage[0]['ImagePath']; ?>');
                             background-size: 400px;
                             background-repeat: no-repeat;
                             background-position: center;">
                    </div>
                    <?php
                } else if (count($StockItemImage) >= 2) { ?>
<!-- meerdere plaatjes laten zien -->
                    <div id="ImageFrame">
                        <div id="ImageCarousel" class="carousel slide" data-interval="false">
<!-- Indicators -->
                            <ul class="carousel-indicators">
                                <?php for ($i = 0; $i < count($StockItemImage); $i++) { ?>
                                    <li data-target="#ImageCarousel"
                                        data-slide-to="<?php print $i ?>"<?php print (($i == 0) ? 'class="active"' : ''); ?>>
                                    </li>
                                    <?php } ?>
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
<!--Backup afbeelding-->
                <div id="ImageFrame"
                     style="background-image: url('Public/StockGroupIMG/<?php print $StockItem['BackupImagePath']; ?>');
                         background-size: cover;">
                </div>
                <?php
            }

            ?>

    </h2>
</div>
<div class="headerright">
    <div class="recommendations">
<!--Artikelprijs-->
                <p class="StockItemPriceText"><b><?php print sprintf("€ %.2f", $StockItem['SellPrice']); ?></b></p>
                <?php if (!empty($_GET['id'])){ ?>      <!-- formulier via POST en niet GET om te zorgen dat refresh van pagina niet het artikel onbedoeld toevoegt-->
<!--aantal artikelen in winkelwagen toevoegen-->
                    <form method="post" class="form-inline">
                        <div class="form-group mx-sm-1">
                            <input type="number" id="aantal" name="aantal" value="1" class="aantalbutton">
                            <input type="number" name="stockItemID" value="<?php print($stockItemID) ?>" hidden>
                        </div>
<!--in inwinkelwagenknop-->
                        <button type="submit" name="submit" class="inwinkelwagen btn-alt btn-primary-orange"
                            <?php if (explode(" ",$StockItem['QuantityOnHand'])[1] < 1)
                            {
                                print "disabled";
                            } ?> >In winkelwagen</button>
                    </form>
<!--voorraadtekst-->
                    <div class="QuantityText">
                        <?php
                        $quantity = explode(" ",$StockItem['QuantityOnHand']);
                        if (($quantity[1]) < 11) {
                        ?>
                        <p style="color: red"><b><?php print "<br>".getVoorraadTekst($quantity[1]); ?></b></p>
                        <?php
                        } else {
                        ?>
                        <p style="color: #676EFF"><b><?php print "<br>".getVoorraadTekst($quantity[1]); ?></b></p>
                        <?php } ?>
                        <div>
                            <p style="color: white"><b>✔</b>
                                <?php print " Gratis verzending boven de €25<br>"; ?><b>✔</b>
                                <?php print "30 dagen bedenktijd<br>"; ?><b>✔</b>
                                <?php print "24/7 klantenservice<br>"; ?><b>✔</b>
                                <?php print "Prijs is incl. BTW"; ?></p>
                        </div>
                    </div>
                <?php } ?>
    </div>
</div>
</div>
<!--artikelbeschrijving-->
<div class="headerleft">
    <div id="StockItemDescription">
        <?php if ($StockItem["IsChillerStock"] === 1){?>
        <p style="color: #007bff">LIVE! Temperatuur product in opslag: <?php print temperature($databaseConnection)[0]["Temperature"];?> °C</p> <?php } ?>
        <h3>Artikel beschrijving</h3>
        <p><?php print $StockItem['SearchDetails']; ?></p>
    </div>
    </div>
<!--aanbevelingen-->
<div class="headerright">
<div class="recommendations">
<?php
$recommendations = getRecommendationValue($stockItemID, $databaseConnection);
$recommenditems = recommendations($recommendations[0]["ColorID"],$recommendations[0]["StockGroupID"], $databaseConnection);
shuffle($recommenditems);
foreach ($recommendations as $productID => $color) {
    $stockitem = getStockItem($productID, $databaseConnection);
    $image = getStockItemImage($productID, $databaseConnection);
    }
    ?>
<!--titel-->
    <div class="titlerecommendations"><h3 style="text-align: left">Bekijk deze ook eens:</h3></div>
    <div class="grid-container">

        <?php $i = 0; foreach ($recommenditems as $item => $arraynum){ ?>
        <div class="grid-item">
            <a class="ListItem" href='view.php?id=<?php print $arraynum['StockItemID']; ?>'>
            <div id="ImageFrameSmall"
                 style="background-image: url('Public/StockItemIMG/<?php print $arraynum['ImagePath']; ?>');
                         background-size: 100%;
                         background-repeat: no-repeat;
                         background-position: center;">
            </div>

            <div style="font-size: 20px;">
            <?php print getStockItem(($arraynum["StockItemID"]),$databaseConnection)['StockItemName']; ?>
                </div>
            </a>
        </div>
        <?php
            if (++$i == 6) break;
        } ?>
    </div>

</div>
</div>
<!--artikelspecificaties-->
<div class="headerleft">
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


        <!--review-->

        <div class="Review">
            <?php
            $Review = Reviews($stockItemID, $databaseConnection);
            ?>
            <div class="grid-container-review">
                <?php $i = 0; foreach ($Review as $item => $arraynum){ ?>
                <div class="grid-item-review">

                    <?php
                    print $arraynum['titel'] . "<br>";
                    print $arraynum['beoordeling'] . "<br>";
                    ?>
                    <div class="imageframeSter"
                    style="background-image: url('Public/StockItemIMG/<?php print $arraynum['aantalsterren'].".png";?>');
                        background-size: 100%;
                        background-repeat: no-repeat;
                        background-position: center;">
                    </div>
                    <?php
                    print $arraynum['naam'] . "<br>";
                    print $arraynum['datum'];
                    ?>
                </div>

                    <?php
                }
                ?>
            </div>
        </div>
<!--video-->
    <?php
    if (!empty($StockItem))
    {
    if (isset($StockItem['Video']))
    {
        ?>
        <div id="VideoFrame">
            <?php print $StockItem['Video']; ?>
        </div>
    <?php }
    } ?>
</div>
<!--onbekend product-->
<?php
} else {
?>

    </div>

<div class="centered" style="margin-top: 80px">
    <img src="Public\Img\gecko-eet.png" alt="Gecko eating" class="center">
    <h2 id="ProductNotFound">De winkelgekko kon helaas dit product niet vinden... Misschien heeft hij het opgegeten?</h2>
    <?php
    } ?>
</div>
