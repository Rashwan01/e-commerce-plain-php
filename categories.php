<?php
session_start();
include "init.php";

?>
<div class="container">
<h1 class="text-center">
   <?php
      if(isset($_GET['catName'])) { echo $_GET['catName'];}
    ?>
</h1>
     <div class ="row">

    <?php

     $item  = getAllFrom('*',"Items","where Cat_ID = {$_GET['cat']} ","AND Approve = 1","Cat_ID");
    foreach($item as $cat)
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


    </div>
</div>
<?php
include $tpl."footer.php";

?>
