<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8" />
		<title><?php getTitle() ?></title>
		<link rel="stylesheet" href="<?php echo $css ?>bootstrap.min.css" />
		<link rel="stylesheet" href="<?php echo $css ?>font-awesome.min.css" />
		<link rel="stylesheet" href="<?php echo $css ?>jquery-ui.css" />
		<link rel="stylesheet" href="<?php echo $css ?>jquery.selectBoxIt.css" />
		<link rel="stylesheet" href="<?php echo $css ?>frontend.css" />
	</head>
	<body>
        <div class="upper_nav">
        <div class="container">
            <?php

            if(isset($_SESSION["user"]))
            {
               $userStat = UserStatus($_SESSION["user"]);

                   if($userStat == 1) // not activation
                   {
                          echo "<p class='pull-right text-bold  btn btn-primary'> welcome ".$_SESSION['user']." NOT ACTIVATION RIGHT NOW  <a href='logout.php'> logout</a></p>";
                   }
                else
                {
                     echo "<p class='pull-right text-bold text-info '><span class='Name'> welcome ".$_SESSION['user'] ." </span><a class='btn btn-primary' href='profile.php'> profile</a> <a class='btn btn-success' href='newads.php'> new ads</a> <a class='btn btn-danger' href='logout.php'> logout</a></p>";
                }

            }
            else
            {
                  echo "<p class='pull-right text-bold text-info'><a href='login.php' class='btn btn-primary'> signin</a>OR<a href='login.php' class='btn btn-success'> SignUp</a> </p>";
            }

    ?>

            </div>

        </div>
        <nav class="navbar navbar-inverse">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-nav" aria-expanded="false">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="home.php"><?php echo lang('HOME_ADMIN') ?></a>
    </div>
    <div class="collapse navbar-collapse" id="app-nav">
      <ul class="nav navbar-nav ml-auto">
  <?php

$allCat = getAllFrom('*','categories','WHERE parent = 0','',"ID","ASC");
    foreach ($allCat as $row)
    {
        echo "<li
                class='nav-item' >
                <a class='nav-link' href ='categories.php?cat=".$row['ID']."' >
                ".$row['Name'].
            "</a>
        </li>";
    }
    ?>











      </ul>
    </div>
  </div>
</nav>
