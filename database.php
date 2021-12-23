<!-- dit bestand bevat alle code die verbinding maakt met de database -->
<?php

function connectToDatabase()
{
    $Connection = null;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Set MySQLi to throw exceptions
    try {
        $Connection = mysqli_connect("localhost", "root", "", "nerdygadgets");
        mysqli_set_charset($Connection, 'latin1');
        $DatabaseAvailable = true;
    } catch (mysqli_sql_exception $e) {
        $DatabaseAvailable = false;
    }
    if (!$DatabaseAvailable) {
        ?><h2>Website wordt op dit moment onderhouden.</h2><?php
        die();
    }

    return $Connection;
}

function recommendations($Color, $databaseConnection)
{
    $Query = "
                SELECT items.StockItemID, images.ImagePath
                FROM stockitems AS items
                JOIN stockitemimages AS images ON items.StockItemID = images.StockItemID
                WHERE (ColorID = ?)
    ";
    $Statement = mysqli_prepare($databaseConnection, $Query);
    mysqli_stmt_bind_param($Statement, "i", $Color);
    mysqli_stmt_execute($Statement);
    $Result = mysqli_stmt_get_result($Statement);
    $Result = mysqli_fetch_all($Result, MYSQLI_ASSOC);
    return $Result;
}

function topseller($databaseConnection)
{
    $Query = "
        SELECT StockItemID, SUM(amount) AS Aantalverkocht
        FROM webshoporderlines
        GROUP BY StockItemID
        ORDER BY Aantalverkocht DESC;
    ";
    $Statement = mysqli_prepare($databaseConnection, $Query);
        mysqli_stmt_execute($Statement);
    $Result = mysqli_stmt_get_result($Statement);
    $Result = mysqli_fetch_all($Result, MYSQLI_ASSOC);
    return $Result;
}

function getHeaderStockGroups($databaseConnection)
{
    $Query = "
                SELECT StockGroupID, StockGroupName, ImagePath
                FROM stockgroups 
                WHERE StockGroupID IN (
                                        SELECT StockGroupID 
                                        FROM stockitemstockgroups
                                        ) AND ImagePath IS NOT NULL
                ORDER BY StockGroupID ASC";
    $Statement = mysqli_prepare($databaseConnection, $Query);
    mysqli_stmt_execute($Statement);
    $HeaderStockGroups = mysqli_stmt_get_result($Statement);
    return $HeaderStockGroups;
}

function getStockGroups($databaseConnection)
{
    $Query = "
            SELECT StockGroupID, StockGroupName, ImagePath
            FROM stockgroups 
            WHERE StockGroupID IN (
                                    SELECT StockGroupID 
                                    FROM stockitemstockgroups
                                    ) AND ImagePath IS NOT NULL
            ORDER BY StockGroupID";
    $Statement = mysqli_prepare($databaseConnection, $Query);
    mysqli_stmt_execute($Statement);
    $Result = mysqli_stmt_get_result($Statement);
    $StockGroups = mysqli_fetch_all($Result, MYSQLI_ASSOC);
    return $StockGroups;
}

function getStockItem($id, $databaseConnection)
{
    $Result = null;

    $Query = " 
           SELECT SI.StockItemID, 
            (RecommendedRetailPrice*(1+(TaxRate/100))) AS SellPrice, 
            StockItemName,
            CONCAT('Voorraad: ',QuantityOnHand)AS QuantityOnHand,
            SearchDetails, 
            (CASE WHEN (RecommendedRetailPrice*(1+(TaxRate/100))) > 50 THEN 0 ELSE 6.95 END) AS SendCosts, MarketingComments, CustomFields, SI.Video,
            (SELECT ImagePath FROM stockgroups JOIN stockitemstockgroups USING(StockGroupID) WHERE StockItemID = SI.StockItemID LIMIT 1) as BackupImagePath   
            FROM stockitems SI 
            JOIN stockitemholdings SIH USING(stockitemid)
            JOIN stockitemstockgroups ON SI.StockItemID = stockitemstockgroups.StockItemID
            JOIN stockgroups USING(StockGroupID)
            WHERE SI.stockitemid = ?
            GROUP BY StockItemID";

    $Statement = mysqli_prepare($databaseConnection, $Query);
    mysqli_stmt_bind_param($Statement, "i", $id);
    mysqli_stmt_execute($Statement);
    $ReturnableResult = mysqli_stmt_get_result($Statement);
    if ($ReturnableResult && mysqli_num_rows($ReturnableResult) == 1) {
        $Result = mysqli_fetch_all($ReturnableResult, MYSQLI_ASSOC)[0];
    }

    return $Result;
}

function getStockItemImage($id, $databaseConnection)
{

    $Query = "
                SELECT ImagePath
                FROM stockitemimages 
                WHERE StockItemID = ?";

    $Statement = mysqli_prepare($databaseConnection, $Query);
    mysqli_stmt_bind_param($Statement, "i", $id);
    mysqli_stmt_execute($Statement);
    $R = mysqli_stmt_get_result($Statement);
    $R = mysqli_fetch_all($R, MYSQLI_ASSOC);

    return $R;

}

// Deze functie haalt een persoon zijn gegevens op, die je kan gebruiken om te zien of het inloggen werkt.
function getRecommendationValue($id, $databaseConnection)
{
    $Query = "
                SELECT ColorID
                FROM stockitems
                WHERE StockItemID = ?";

    $Statement = mysqli_prepare($databaseConnection, $Query);
    mysqli_stmt_bind_param($Statement, "s", $id);
    mysqli_stmt_execute($Statement);
    $Result = mysqli_stmt_get_result($Statement);
    $Result = mysqli_fetch_all($Result, MYSQLI_ASSOC);

    return $Result;
}
function getPersonIDNew($id, $databaseConnection)
{
    $Query = "
                SELECT *
                FROM webshopgebruikers
                WHERE Emailadres = ?";

    $Statement = mysqli_prepare($databaseConnection, $Query);
    mysqli_stmt_bind_param($Statement, "s", $id);
    mysqli_stmt_execute($Statement);
    $Result = mysqli_stmt_get_result($Statement);
    $Result = mysqli_fetch_all($Result, MYSQLI_ASSOC);

    return $Result;
}

// Verandert gegevens die al bestaan
function setPersonID($voornaam, $achternaam, $straat, $huisnummer, $postcode, $plaats, $land, $email, $databaseConnection)
{
    $Query = "
                UPDATE webshopgebruikers
                SET Voornaam=?, Achternaam=?, Straat=?, Huisnummer=?, Postcode=?, Plaats=?, Land=?
                WHERE Emailadres = ?";

    $Statement = mysqli_prepare($databaseConnection, $Query);
    mysqli_stmt_bind_param($Statement, "ssssssss", $voornaam, $achternaam, $straat, $huisnummer, $postcode, $plaats, $land, $email);
    mysqli_stmt_execute($Statement);
}

// Deze functie haalt een persoon zijn ID en wachtwoord op, die je kan gebruiken om te zien of het inloggen werkt.
function createAccount($email, $pass, $voornaam, $achternaam, $straat, $huisnummer, $postcode, $plaats, $land, $databaseConnection)
{
    $Query = "
                INSERT INTO webshopgebruikers (Emailadres, Wachtwoord, Voornaam, Achternaam, Straat, Huisnummer, Postcode, Plaats, Land) 
                VALUES (?, MD5(?), ?, ?, ?, ?, ?, ?, ?)";

    $Statement = mysqli_prepare($databaseConnection, $Query);
    mysqli_stmt_bind_param($Statement, "sssssssss", $email, $pass, $voornaam, $achternaam, $straat, $huisnummer, $postcode, $plaats, $land);
    try {
        mysqli_stmt_execute($Statement);
    } catch (mysqli_sql_exception $exception) {
        print $exception;
        print ($exception->getMessage());
        return false;
    }
    return true;
}

function checkexistence($email, $databaseConnection)
{
    $Query = "
                SELECT Emailadres FROM nerdygadgets.webshopgebruikers
                WHERE Emailadres = ?";

    $Statement = mysqli_prepare($databaseConnection, $Query);
    mysqli_stmt_bind_param($Statement, "s", $email);
    mysqli_stmt_execute($Statement);
    $Result = mysqli_stmt_get_result($Statement);
    $Result = mysqli_fetch_all($Result, MYSQLI_ASSOC);
    return $Result;
}

function lowerStock($item, $databaseConnection)
{
    $Query = "
                UPDATE nerdygadgets.stockitemholdings
                SET QuantityOnHand=(QuantityOnHand-1)
                WHERE StockItemID = ?";
    $Statement = mysqli_prepare($databaseConnection, $Query);
    mysqli_stmt_bind_param($Statement, "i", $item);
    mysqli_stmt_execute($Statement);
}

function orderItems($USERID, $deliverymethodID, $Lasteditedby, $databaseConnection, $packageTypeID, $voornaam, $achternaam, $street, $city, $zip, $housenumber, $email)
{
    $orderdate = date('Y-m-d H:i:s');
    $IsOrderFinalized = False;
    $LasteditedWhen = date('Y-m-d H:i:s');
    $Query = "
                INSERT INTO webshoporders (USERID, DeliveryMethodID, OrderDate, IsOrderFinalized, LastEditedBy, LastEditedWhen, VzAdresStraatnaam, VzAdresPlaats, VzAdresPostcode, VzAdresHuisnummer, VzAdresEmail, VzAdresVoornaam, VzAdresAchternaam) 
                VALUES (?, ?, ?, ?, ?, ?, ? , ? , ? , ?, ?,?,?)";
    $Statement = mysqli_prepare($databaseConnection, $Query);
    mysqli_stmt_bind_param($Statement, "sssssssssssss", $USERID, $deliverymethodID, $orderdate, $IsOrderFinalized, $Lasteditedby, $LasteditedWhen, $street, $city, $zip, $housenumber, $email, $voornaam, $achternaam);
    mysqli_stmt_execute($Statement);

    // Tweede deel van de functie, nu de orderlines aanmaken voor elk product.
    // haalt cart op om per item een orderline te maken
    $cart = getCart();
    // zorgt ervoor dat de PRIMARY KEY van het vorige veld wordt ingevuld in het ORDERID veld van de volgende functie
    // mysqli_insert_id is afhankelijk van connectie, dus dit zou nooit fout moeten kunnen gaan.
    $ORDERID = mysqli_insert_id($databaseConnection);
    foreach ($cart as $item => $amount) {
        $Query = "
                            INSERT INTO webshoporderlines (ORDERID, packageTypeID, stockitemID, amount, IsOrderLineFinalized, LastEditedBy, LastEditedWhen) 
                            VALUES (?, ?, ?, ?, ?, ?, ?)";
        $Statement = mysqli_prepare($databaseConnection, $Query);
        mysqli_stmt_bind_param($Statement, "sssssss", $ORDERID, $packageTypeID, $item, $amount, $IsOrderFinalized, $Lasteditedby, $LasteditedWhen);
        mysqli_stmt_execute($Statement);
    }
}

function orderItemsNoAccount($deliverymethodID, $Lasteditedby, $databaseConnection, $packageTypeID, $voornaam, $achternaam, $street, $city, $zip, $housenumber, $email)
{
    $orderdate = date('Y-m-d H:i:s');
    $IsOrderFinalized = False;
    $LasteditedWhen = date('Y-m-d H:i:s');
    $Query = "
                INSERT INTO webshoporders (USERID, DeliveryMethodID, OrderDate, IsOrderFinalized, LastEditedBy, LastEditedWhen, VzAdresStraatnaam, VzAdresPlaats, VzAdresPostcode, VzAdresHuisnummer, VzAdresEmail, VzAdresVoornaam, VzAdresAchternaam) 
                VALUES (NULL, ?, ?, ?, ?, ?, ? , ? , ? , ?, ?,?,?)";
    $Statement = mysqli_prepare($databaseConnection, $Query);
    mysqli_stmt_bind_param($Statement, "ssssssssssss", $deliverymethodID, $orderdate, $IsOrderFinalized, $Lasteditedby, $LasteditedWhen, $street, $city, $zip, $housenumber, $email, $voornaam, $achternaam);
    mysqli_stmt_execute($Statement);
    // Tweede deel van de functie, nu de orderlines aanmaken voor elk product.
    // haalt cart op om per item een orderline te maken
    $cart = getCart();
    // zorgt ervoor dat de PRIMARY KEY van het vorige veld wordt ingevuld in het ORDERID veld van de volgende functie
    // mysqli_insert_id is afhankelijk van connectie, dus dit zou nooit fout moeten kunnen gaan.
    $ORDERID = mysqli_insert_id($databaseConnection);
    foreach ($cart as $item => $amount) {
        $Query = "
                            INSERT INTO webshoporderlines (ORDERID, packageTypeID, stockitemID, amount, IsOrderLineFinalized, LastEditedBy, LastEditedWhen) 
                            VALUES (?, ?, ?, ?, ?, ?, ?)";
        $Statement = mysqli_prepare($databaseConnection, $Query);
        mysqli_stmt_bind_param($Statement, "sssssss", $ORDERID, $packageTypeID, $item, $amount, $IsOrderFinalized, $Lasteditedby, $LasteditedWhen);
        mysqli_stmt_execute($Statement);
    }
}