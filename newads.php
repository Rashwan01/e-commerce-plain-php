<?php
session_start();
include "init.php";



if(isset($_SESSION['user']))
{
    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
        $Title = filter_var($_POST['name'],FILTER_SANITIZE_STRING);
        $Desc = filter_var($_POST['description'],FILTER_SANITIZE_STRING);
        $price =filter_var( $_POST['price'],FILTER_SANITIZE_NUMBER_INT);
        $Country =filter_var( $_POST['country'],FILTER_SANITIZE_STRING);
        $Status =filter_var( $_POST['status'],FILTER_SANITIZE_NUMBER_INT);
        $Cat =filter_var( $_POST['category'],FILTER_SANITIZE_NUMBER_INT);
        $FormError = array();
        if(strlen($Title)<3)
        {
            $FormError [] = " Title can Not Be Less than 3 char";
        }
                if(strlen($Desc)<10)
        {
            $FormError [] = " description can Not Be Less than 10 char";
        }
                if(strlen($Country)<3)
        {
            $FormError [] = " There is no country Be Less than 3 char";
        }
        if(empty($price))
        {
            $FormError [] = " Put You Price";
        }

          // Check If There's No Error Proceed The Update Operation

				if (empty($FormError)) {

					// Insert Userinfo In Database

					$stmt = $con->prepare("INSERT INTO

						items(Name, Description, Price, Country_Made, Status, Add_Date, Cat_ID, Member_ID)

						VALUES(:zname, :zdesc, :zprice, :zcountry, :zstatus, now(), :zcat, :zmember)");

					$stmt->execute(array(

						'zname' 	=> $Title,
						'zdesc' 	=> $Desc,
						'zprice' 	=> $price,
						'zcountry' 	=> $Country,
						'zstatus' 	=> $Status,
						'zcat'		=> $Cat,
						'zmember'	=> $_SESSION['ID']

					));

					// Echo Success Message

					$theMsg = "success";


				}



    }

?>
    <div class="container">
        <h3 class="text-center "> My Ads </h3>
        <!-- start panel scope -->
        <div class="ads ">
            <div class="panel panel-primary">

                <div class="panel panel-heading"> my ads</div>
                <div class="panel panel-body">
                    <div class="row">
                        <div class="col-md-8">
                            <form class="form-horizontal" method="POST">
                                <!-- Start Name Field -->
                                <div class="form-group form-group-lg">
                                    <label class="col-sm-2 control-label">Name</label>
                                    <div class="col-sm-10 col-md-8">
                                        <input type="text" name="name" class="form-control Live" placeholder="Name of The Item" data-class="LiveName" />
                                    </div>
                                </div>
                                <!-- End Name Field -->
                                <!-- Start Description Field -->
                                <div class="form-group form-group-lg">
                                    <label class="col-sm-2 control-label">Description</label>
                                    <div class="col-sm-10 col-md-8 ">
                                        <input type="text" name="description" class="form-control Live" r placeholder="Description of The Item" data-class="LiveDes" />
                                    </div>
                                </div>
                                <!-- End Description Field -->
                                <!-- Start Price Field -->
                                <div class="form-group form-group-lg">
                                    <label class="col-sm-2 control-label">Price</label>
                                    <div class="col-sm-10 col-md-8">
                                        <input type="text" name="price" class="form-control Live" placeholder="Price of The Item" data-class="LivePrice" />
                                    </div>
                                </div>
                                <!-- End Price Field -->
                                <!-- Start Country Field -->
                                <div class="form-group form-group-lg">
                                    <label class="col-sm-2 control-label">Country</label>
                                    <div class="col-sm-10 col-md-8">
                                        <input type="text" name="country" class="form-control" placeholder="Country of Made" />
                                    </div>
                                </div>
                                <!-- End Country Field -->
                                <!-- Start Status Field -->
                                <div class="form-group form-group-lg">
                                    <label class="col-sm-2 control-label">Status</label>
                                    <div class="col-sm-10 col-md-8">
                                        <select name="status">
                                                    <option value="0">...</option>
                                                    <option value="1">New</option>
                                                    <option value="2">Like New</option>
                                                    <option value="3">Used</option>
                                                    <option value="4">Very Old</option>
                                                </select>
                                    </div>
                                </div>
                                <!-- End Status Field -->

                                <!-- Start Categories Field -->
                                <div class="form-group form-group-lg">
                                    <label class="col-sm-2 control-label">Category</label>
                                    <div class="col-sm-10 col-md-8">
                                        <select name="category">
                                                    <option value="0">...</option>

                                                    <?php

                                                        $allCats = getAllFrom("*", "categories",'','', "ID");
                                                        foreach ($allCats as $cat) {
                                                            echo "<option value='" . $cat['ID'] . "'>" . $cat['Name'] . "</option>";

                                                        }

                                                    ?>
                                                </select>
                                    </div>
                                </div>
                                <!-- End Categories Field -->

                                <!-- Start Submit Field -->
                                <div class="form-group form-group-lg">
                                    <div class="col-sm-offset-2 ">
                                        <input type="submit" value="Add Item" class="btn btn-primary btn-sm" />
                                    </div>
                                </div>
                                <!-- End Submit Field -->
                            </form>


                        </div>
                        <div class="col-md-4">


                            <div class='thumbnail LivePreview'>
                                <span class=' price'><span class="LivePrice">0</span>$</span>
                                <img src='male.jpg' alt='' class='img-responsive' />
                                <div class='caption'>
                                    <h3 class="LiveName">Title</h3>
                                    <p class="LiveDes">description</p>
                                </div>
                            </div>
                        </div>
                        <!-- show error form -->
                        <div class="col-lg-6 offset-3">

                    <?php        if(!empty($FormError))
                                  {
                                   foreach($FormError as $error)
                         {
                            echo "<div class='alert alert-danger'>".$error." </div> ";
                            }
                                                    }
    if(isset($theMsg))
    {
        echo "<div class='alert alert-success'> success</div>";
    }
                        ?>

                        </div>
                        <!-- show error form -->

                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- end panel scope -->
    <!-- start panel scope -->

    <?php
}
else{
    header("location:login.php");
}

include $tpl. "footer.php";

?>
