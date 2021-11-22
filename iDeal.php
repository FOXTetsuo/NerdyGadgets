<?php
include "header.php";
?>


<img src="Public\Img\iDeal-logo.png" alt="Italian Trulli">

Totaalbedrag: <?php if (isset ($_SESSION["totprijs"]))
{
    $_SESSION["totprijs"]=number_format($_SESSION["totprijs"], 2);
    print("€" . $_SESSION["totprijs"]);
}?>