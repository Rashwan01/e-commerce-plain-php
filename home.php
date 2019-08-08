<?php
session_start();
include "init.php";


foreach(getAllFrom("*","items","WHERE Approve = 1",'',"Item_ID","DESC") as $cat)
{
    echo "<div class='col-sm-6 col-md-3'>";
     echo "<div class='thumbnail'>";
    echo "<span class='price'>".$cat['Price']." </span>";
    echo "<img src='male.jpg' alt ='' class='img-responsive' />";
        echo "<div class='caption' >";

         echo"<h3><a href='items.php?itemid=".$cat['Item_ID']."'>".$cat['Name'] . "</a></h3>";
         echo"<p>".$cat['Description'] . "</p>";
         echo"<p class='DateOfItem'>".$cat['Add_Date'] . "</p>";


         echo "</div>";
       echo"</div>";
     echo "</div>";
}

?>

<?php include $tpl. "footer.php"; ?>
