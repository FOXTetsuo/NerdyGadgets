<table>
    <tr>
        <th>naam</th>
        <th>maandsalaris</th>
    </tr>



    <?php
    $host = "localhost";
    $user = "root";
    $pass = ""; //eigen password invullen
    $databaseName = "cursus";
    $port = 3306;
    $connection = mysqli_connect($host, $user, $pass, $databaseName, $port);
    $sql = "SELECT naam, maandsal FROM Medewerker WHERE afd = 30";

    $result = mysqli_query($connection, $sql);
    // loop stuk voor stuk langs alle resultaten
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
    {

        ?>

        <tr>
            <td> <?php $naam = $row["naam"]; echo $naam ?> </td>
            <td> <?php $maandsal = $row["maandsal"]; echo $maandsal ?> </td>
        </tr>



        <?php



    }
    //fetch alle gegevens in een associative array $medewerkers
    $medewerkers = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_free_result($result);
    mysqli_close($connection);



    ?>
</table>