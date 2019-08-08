<?php  include "init.php"; ?>
<?php

	session_start();
	$pageTitle = 'Login';

	if (isset($_SESSION['user'])) {
		header('Location: home.php'); // Redirect To Dashboard Page
	}


	// Check If User Coming From HTTP Post Request

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
// in condition login
        if(isset($_POST['SignIn']))
        {
		$username = $_POST['user'];
		$password = $_POST['pass'];
		$hashedPass = sha1($password);

		// Check If The User Exist In Database

		$stmt = $con->prepare("SELECT
									 Username, Password ,UserID
								FROM
									users
								WHERE
									Username = ?
								AND
									Password = ?
								");

		$stmt->execute(array($username, $hashedPass));
            $get = $stmt->fetch();
		$count = $stmt->rowCount();
echo $count;
		// If Count > 0 This Mean The Database Contain Record About This Username
		if ($count > 0) {
			$_SESSION['user'] = $username;
            $_SESSION['ID'] = $get['UserID'];
            // Register Session Name
			header('Location:home.php'); // Redirect To Dashboard Page
			exit();
		}



        }
        // sign Up
        else
        {
            //decalre array of error
            $ErrorMsg = array();

            $User = $_POST['User'];
            $pass = $_POST['Pass'];
            $pass1 = $_POST['Pass1'];
            $Email = $_POST['Email'];
            $Name = $_POST['FullName'];

            // if request method post called User filter it and check if val less than 4 char
        if( isset($User) )
           {     $UserFiltered = filter_var($User,FILTER_SANITIZE_STRING);

              if(strlen($UserFiltered)<4)
                {

               $ErrorMsg[] = "username can not be less than 4 character";
                }
           }


                     // if request method post called pass1 and pass  check of Two input cal are equal after encrypted it
        if(isset($pass ) && isset($pass1) )
        {
                   $passE = sha1($pass);
                    $pass1E = sha1($pass1);

            //check if passowrd not empty
            if(empty($pass ))
            {
                 $ErrorMsg[] = "password can not be empty";
            }



            if($passE !== $pass1E)
             {

               $ErrorMsg[] = "passwords not matched";
             }
        }


                        // if request method post called User filter it and check if val less than 4 char
        if(isset($Email))
           {
            $EmailFiltered = filter_var($Email,FILTER_SANITIZE_EMAIL);

              if(filter_var($EmailFiltered,FILTER_VALIDATE_EMAIL) != true )
                {

               $ErrorMsg[] = "invalid email";
                }
           }

               // check if user is exist in databases or not if exist show msg that is exist
       	if (empty($ErrorMsg)) {


					$check = checkItem("Username", "users", $User);

					if ($check == 1) {

						$ErrorMsg [] = "<div class='error'> user is already Exist </div> ";


                          }
            else {

						// Insert Userinfo In Database

						$stmt = $con->prepare("INSERT INTO
													users(Username, Password, Email, FullName, RegStatus, Date )
												VALUES(?,?,?,?, 0, now()) ");
						$stmt->execute(array($User,sha1($pass),$Email,$Name));
$done = "<div class='success' >successed </div>";
						// Echo Success Message


					}

				}



        }
    }
?>
<div class="container page-login">
<h1 class="text-center"> <span class="active" data-class="login" >SignIn</span> |<span data-class='SignUp'>  SignUP </span></h1>


<form class="login main-form " action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
		<input class="form-control" type="text" name="user" placeholder="Username" autocomplete="off" />
		<input class="form-control" type="password" name="pass" placeholder="Password" autocomplete="new-password" />
		<input class="btn btn-primary btn-block" name ="SignIn" type="submit" value="SignIn" />
	</form>

    <form class="SignUp ds-none  main-form" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
		<input class="form-control" type="text" name="User" placeholder="Username" autocomplete="off" />
       <input class="form-control" type="password" name="Pass" placeholder="Password" autocomplete="new-password" />
  <input class="form-control" type="password" name="Pass1" placeholder="Password" autocomplete="new-password" />

		<input class="form-control" type="email" name="Email" placeholder="Type invalid Email" autocomplete="off" />
		<input class="form-control" type="text" name="FullName" placeholder="Full Name" autocomplete="off" />
		<input class="btn btn-success btn-block" name = "SignUp" type="submit" value="SignUp" />
	</form>
    <div class="error">

   <?php  if(!empty($ErrorMsg))
{
    foreach($ErrorMsg as $error)
    {
        echo "<div class ='ErrorMsg' >". $error ."</div>";
    }
}
        ?>
    </div>
</div>
<?php include $tpl . "footer.php"
    ?>
