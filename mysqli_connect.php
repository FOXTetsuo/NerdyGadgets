<?php
#connect to server
$host = "localhost";
$user = "root";
$pass = ""; //eigen password invullen
$databaseName = "cursus";
$port = 3306;
$connection = mysqli_connect($host, $user, $pass, $databaseName, $port);

#SQL query
$sql = "SELECT * FROM medewerker WHERE afd=?";
$statement = mysqli_prepare($connection, $sql);
$gebruikersinput = 30;
mysqli_stmt_bind_param($statement, 'i', $gebruikersinput);
mysqli_stmt_execute($statement);
$result = mysqli_stmt_get_result($statement);




#loop stuk voor stuk langs alle resultaten
while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
{
    $naam = $row["naam"];
    print($naam . "<br> \n");
}

#fetch alle gegevens in een associative array $medewerkers
$medewerkers = mysqli_fetch_all($result, MYSQLI_ASSOC);

mysqli_free_result($result);
mysqli_close($connection);