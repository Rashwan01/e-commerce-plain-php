<?php
session_start();
include "init.php";

if(isset($_SESSION['user']))
{
    $sql = $con->prepare("SELECT * from users where username = ?");
    $sql->execute(array($_SESSION['user']));
    $rowUSer = $sql-> fetch();
    $userid =$rowUSer['UserID']

?>
    <div class="container">
        <h3 class="text-center "> my profile </h3>
        <!-- start panel scope -->
        <div class="information ">
            <div class="panel panel-primary">

                <div class="panel panel-heading"> information</div>
                <div class="panel panel-body">
                    <ul class="list-unstyled">
<li><i class="fa fa-users fa-fw"></i><span>name :</span> <?php echo $rowUSer["Username"] ?></li>
<li><i class="fa fa-envelope fa-fw"></i> <span>email :</span>  <?php echo $rowUSer["Email"] ?> </li>
<li><i class="fa fa-beer fa-fw"></i><span>  fullName :</span>  <?php echo $rowUSer["FullName"] ?>   </li>
<li><i class="fa fa-home fa-fw"></i><span>  data : </span><?php echo $rowUSer["Date"] ?>  </li>



                  </ul>
                  <a href= "" class="btn btn-default">edit profile</a>

                </div>
            </div>
        </div>
        <!-- end panel scope -->
        <!-- start panel scope -->

        <div class="ads">
            <div class="panel panel-primary">

                <div class="panel panel-heading"> ads</div>
                <div class="panel panel-body">
               <?php
               $item = getAllFrom('*','items'," WHERE  Member_ID = $userid ",'','Member_ID');
        if(!empty($item))
        {
        foreach($item as $cat)
    {
        echo "<div class='col-sm-6 col-md-3'>";
         echo "<div class='thumbnail'>";
         if($cat['Approve'] == 0)
         {
           echo "<span  class='napproved'>not Approved</span>";
         }
        echo "<span class='price'>".$cat['Price']." </span>";
        echo "<img src='male.jpg' alt ='' class='img-responsive' />";
            echo "<div class='caption' >";

             echo"<h3><a href='items.php?itemid=".$cat['Item_ID']."'> ".$cat['Name'] . "</a></h3>";
             echo"<p>".$cat['Description'] . "</p>";


             echo "</div>";
           echo"</div>";
         echo "</div>";
    }
        }
    else{
        echo "there is no ads to show <a href='newads.php'>new ads</a>";
    }
    ?>


                </div>
            </div>
        </div>
                <!-- end panel scope -->
                <!-- start panel scope -->

        <div class="information">
            <div class="panel panel-primary">

                <div class="panel panel-heading"> latest comment</div>
                <div class="panel panel-body">
                      <?php

                             $allComments = getAllFrom("comment","comments","WHERE user_id =$userid","","c_id");
                            if(!empty($allComments) ){
                            foreach( $allComments as $comment)
                            {
                                echo $comment['comment']."<br>";
                            }
                        ?>

                </div>
            </div>
        </div>
                <!-- end panel scope -->

    </div>

    <?php  }
    else{
        echo "There is Not Comment Yet !";
    }
}
else{
    header("location:login.php");
}

include $tpl. "footer.php";

?>
