<?php
session_start();
include "init.php";
$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

			// Select All Data Depend On This ID

			$stmt = $con->prepare("SELECT
										items.*,
										categories.Name AS category_name,
										users.Username
									FROM
										items
									INNER JOIN
										categories
									ON
										categories.ID = items.Cat_ID
									INNER JOIN
										users
									ON
										users.UserID = items.Member_ID
                                  WHERE Item_ID = ? AND Approve = 1
									ORDER BY
										Item_ID DESC");

			// Execute Query

			$stmt->execute(array($itemid));

			// Fetch The Data

			$item = $stmt->fetch();

			// The Row Count

			$count = $stmt->rowCount();

if($count>0)
{



?>

<div class="container">
        <h3 class="text-center "> <?php echo $item['Name'] ;?> </h3>
        <div class="row">
        <div class="col-md-3">

            <img src="male.jpg" class="img-responsive">
            </div>
            <div class="info col-md-9 ">


                   <h4><?php echo $item['Name'] ?></h4>
                 <p><?php  echo $item['Description'] ?></p>
                   <ul  class ='list-unstyled'>
              <li> <i class='fa fa-money fa-fw'></i> <span>the Price: </span><?php  echo $item['Price']?></li>
                <li> <i class='fa fa-home fa-fw'></i><span> Date  :</span><?php echo $item['Add_Date']?></li>
                <li><i class='fa fa-building fa-fw'></i> <span>made in :</span><?php echo $item['Country_Made']?></li>
         <li><i class='fa fa-tag fa-fw'></i><span> category :</span>

              <a href=" categories.php?cat=<?php echo $item['Cat_ID'];?>" ><?php echo $item['category_name']; ?></a>
        </li>
                       <li><i class='fa fa-money fa-fw'></i><span> added by :</span> <?php echo $item['Username'];?></li>
                   </ul>




            </div>


        </div>
        <hr>

        <?php  if(isset($_SESSION['user'])) {?>
        <div class="row">

         <div class="col-md-offset-3">
            <div class="add-comment">
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']."?itemid=".$item['Item_ID'];?>">
            <h2>add comment</h2>
            <textarea name="comment"></textarea>
            <input class="btn btn-primary" type="submit" value ="add comment">
            </form>
						<?php

						if($_SERVER['REQUEST_METHOD'] == "POST")
	   	   	{
							$comment= filter_var($_POST['comment'],FILTER_SANITIZE_STRING);
							$userid =$_SESSION['ID'];
							$itemid = $item['Item_ID'];
							if(!empty($comment))
					{
							$sql = $con ->prepare("INSERT INTO Comments(comment,status,comment_date,item_id,user_id) values (?,0,now(),?,?)" );
							$sql ->execute(array($comment,$itemid,$userid));
							if($sql)
					   {
						   echo "<div class='alert alert-success'> comment success</div>";
					   }
					}


						}

						 ?>
            </div>
					</div>
        </div>

			<?php } // end if session user
    else {
            echo " <a href= 'login.php'>login</a> or <a href='login.php'>sign up</a> be able to comment";
         }
			?>
			      <hr>
						<?php
							$stmt = $con->prepare("SELECT comments.*,users.Username FROM comments INNER JOIN users ON users.UserID = comments.user_id

							WHERE status = 1 AND Item_ID = ?");
							// Execute The Statement
							$stmt->execute(array($itemid));
							// Assign To Variable
							$items = $stmt->fetchAll();
							foreach ($items as $row)
							{
								?>
							<div class="comment-box">
								<div class=row>
									<div class='col-md-2'>
											<img src="male.jpg" class="img-responsive img-thubnail img-circle center-block">

											 <?php echo "<p class='text-center'>" .   $row['Username'] . "</p>";  ?>

									</div>
											<div class='col-md-10'> <p class="lead"><?php echo          $row['comment']; ?></p>
											</div>
									</div>
	             </div>
<?php
        }
				?>
			</div>
			<?php
			}// count>0
        else
        {
             echo "<div class= 'alert alert-danger'> there is no such id or item waitng To be Approved</div>";
        }
 include $tpl. "footer.php"; ?>
