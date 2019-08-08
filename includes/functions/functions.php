<?php

function getAllFrom($field, $table,$where = null, $AND = null, $orderfield, $ordering = "DESC" ) {

  global $con;


  $getAll = $con->prepare("SELECT $field FROM $table $where  $AND ORDER BY $orderfield $ordering");

  $getAll->execute();

  $all = $getAll->fetchAll();

  return $all;

}


/*
** GetCat function ver 1.0

*/
function GetCat ()
{
    global $con;

    $sql  = $con->prepare("select * from categories");

    $sql->execute();

    $rows = $sql->fetchAll();

    return $rows;
}
function GetItem ($where,$value,$approve ="null")
{
    global $con;
   if($approve == "null")
   {
    $sql = null;
   }
  else {

      $sql= "AND Approve = 1";
  }
    $sql  = $con->prepare("select * from items where $where = ? $sql");

    $sql->execute(array($value));

    $rows = $sql->fetchAll();

    return $rows;
}




/* get user status v1.0
** accept one argument [user name]
**if return result 0 mean user is actived if 1 there is there is one user need to be actived
*/
function UserStatus($user)
{
    global $con;
    $sql= $con -> prepare("SELECT Username ,RegStatus FROM users WHERE Username = ? AND RegStatus = 0");
    $sql ->execute(array($user));
    $count = $sql->rowCount();
    return $count;
}




	/*
	** Get All Function v2.0
	** Function To Get All Records From Any Database Table
	*/


	/*
	** Title Function v1.0
	** Title Function That Echo The Page Title In Case The Page
	** Has The Variable $pageTitle And Echo Defult Title For Other Pages
	*/

	function getTitle() {

		global $pageTitle;

		if (isset($pageTitle)) {

			echo $pageTitle;

		} else {

			echo 'Default';

		}
	}

	/*
	** Home Redirect Function v2.0
	** This Function Accept Parameters
	** $theMsg = Echo The Message [ Error | Success | Warning ]
	** $url = The Link You Want To Redirect To
	** $seconds = Seconds Before Redirecting
	*/

	function redirectHome($theMsg, $url = null, $seconds = 3) {

		if ($url === null) {

			$url = 'index.php';

			$link = 'Homepage';

		} else {

			if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== '') {

				$url = $_SERVER['HTTP_REFERER'];

				$link = 'Previous Page';

			} else {

				$url = 'index.php';

				$link = 'Homepage';

			}

		}

		echo $theMsg;

		echo "<div class='alert alert-info'>You Will Be Redirected to $link After $seconds Seconds.</div>";

		header("refresh:$seconds;url=$url");

		exit();

	}

	/*
	** Check Items Function v1.0
	** Function to Check Item In Database [ Function Accept Parameters ]
	** $select = The Item To Select [ Example: user, item, category ]
	** $from = The Table To Select From [ Example: users, items, categories ]
	** $value = The Value Of Select [ Example: Osama, Box, Electronics ]
	*/

	function checkItem($select, $from, $value) {

		global $con;

		$statement = $con->prepare("SELECT $select FROM $from WHERE $select = ?");

		$statement->execute(array($value));

		$count = $statement->rowCount();

		return $count;

	}

	/*
	** Count Number Of Items Function v1.0
	** Function To Count Number Of Items Rows
	** $item = The Item To Count
	** $table = The Table To Choose From
	*/

	function countItems($item, $table) {

		global $con;

		$stmt2 = $con->prepare("SELECT COUNT($item) FROM $table");

		$stmt2->execute();

		return $stmt2->fetchColumn();

	}

	/*
	** Get Latest Records Function v1.0
	** Function To Get Latest Items From Database [ Users, Items, Comments ]
	** $select = Field To Select
	** $table = The Table To Choose From
	** $order = The Desc Ordering
	** $limit = Number Of Records To Get
	*/

	function getLatest($select, $table, $order, $limit = 5) {

		global $con;

		$getStmt = $con->prepare("SELECT $select FROM $table ORDER BY $order DESC LIMIT $limit");

		$getStmt->execute();

		$rows = $getStmt->fetchAll();

		return $rows;

	}
