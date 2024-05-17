<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database access configuration
$config["dbuser"] = "ora_yichen17";			// change "cwl" to your own CWL
$config["dbpassword"] = "a88262522";	// change to 'a' + your student number
$config["dbserver"] = "dbhost.students.cs.ubc.ca:1522/stu";
$db_conn = NULL;	// login credentials are used in connectToDB()

$success = true;	// keep track of errors so page redirects only if there are no errors

$show_debug_alert_messages = False; // show which methods are being triggered (see debugAlertMessage())

?>

<html>

<head>
	<title>Game Review Site Demo</title>

    <style>
            body {
                font-family: "Times New Roman", Times, serif;
                margin: 0;
                display: flex;
                justify-content: space-between;
                background-color: #a3c1ad;
            }
            .content-container {
                height: 100vh;
                overflow: auto;
                border: 1px solid #ccc;
                border-radius: 5px;
                box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.2);
                padding: 20px;
            }
            .left-content {
                flex: 50%; /* Set left content to 50% width */
                border-right: 1px solid #ddd;
                margin: 10px;
                padding-right: 20px;
				background-color: #ffffff;
            }
            .right-content {
                flex: 50%; /* Set right content to 50% width */
                background-color: #ffffff;
                border-radius: 5px;
                box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.2);
                margin: 10px;
                padding-left: 20px;
            }
            h2, h3 {
                margin-top: 0;
				color: #414d45;
            }
            form {
                margin-bottom: 20px;
            }
            input[type="text"], input[type="radio"], input[type="checkbox"] {
                margin: 5px 0;
                border: 1px solid #c7d9cd;
                padding: 5px;
                border-radius: 3px;
            }
			input[type="submit"]{
				font-family: "Times New Roman", Times, serif;
				font-size: 16px;
				margin: 5px 0;
                border: 1px solid #d1e0d6;
                padding: 5px;
                border-radius: 3px;
				background-color: #d1e0d6;
			}
            .radio-group {
                display: inline-block;
            }
            .radio-group input[type="radio"] {
                margin-right: 10px;
            }
            label {
                display: inline-block;
                width: 140px;
                font-weight: bold;
            }
            table {
                border-collapse: collapse;
                width: 100%;
                margin-top: 10px;
            }
            th, td {
                border: 1px solid #d1e0d6;
                padding: 8px;
                text-align: left;
            }
            th {
                background-color: #d1e0d6;
            }
			tr:hover {
				background-color: #e3ece6;
			}
            hr {
                margin-top: 20px;
            }
		
        </style>
</head>

<body>

<div class="content-container left-content">
 
	<h2>CPSC304 Project - Group 47 - Theme: Game Review Site</h2>

	<hr/>

	<h2>Show the tuples in a table</h2>
	<form method="GET" action="demo.php">
		<input type="hidden" id="showTupleRequest" name="showTupleRequest">
        Choose the table you want to view:
		<select name="tableName">
                <option value="Users">Users</option>
                <option value="Game_Genre">Game_Genre</option>
                <option value="Game">Game</option>
                <option value="MakeM_MComment">MakeM_MComment</option>
                <option value="Trailer_mid_link">Trailer_mid_link</option>
                <option value="Tralier_link_ID">Tralier_link_ID</option>
                <option value="AveragePerson">AveragePerson</option>
                <option value="Press">Press</option>
                <option value="create_GameWishlist">create_GameWishlist</option>
                <option value="contains">contains</option>
                <option value="writeN_News">writeN_News</option>
                <option value="make_Ncomment_about">make_Ncomment_about</option>
                <option value="writeR_ReviewArticle_for">writeR_ReviewArticle_for</option>
            </select>
            <br/><br/>
            <input type="submit" name="showSubmit" value="Show Table">
	</form>

	<hr />

	<?php
          session_start();
          if (isset($_GET['Login'])) {; # Log-in is successful
    ?>
                <h1> Log in successful! </h1>
                <h3> Account logged in: <?= $_GET['Email'] ?> </h3>
                <form method="GET" action="demo.php">
                        <input type="hidden" id="logOutRequest" name="logOutRequest">
                        <input type="submit" value="Logout" name="Logout"></p>
                </form>

    <?php } else { ?>

		<h2>Login</h2>
		<p> Login your account to view account information</p>
		<form method="GET" action="demo.php">
			<input type="hidden" id="displayRequest" name="displayRequest">
			Email: <input type="text" name="Email"> <br /><br />
			Password: <input type="text" name="Password"> <br /><br />

			<input type="submit" value="Login" name="Login"></p>
		</form>

	<?php }  ?>

	<hr />

	<h2>Create Account</h2> 
	<form method="POST" action="demo.php">
		<input type="hidden" id="insertQueryRequest" name="insertQueryRequest">
		Select "Press" if registering as a press account:
		<select name="userType">
                <option value="normal">Normal User</option>
                <option value="press">Press</option>
            </select><br /><br />
		Username: <input type="text" name="insUsername"> <br /><br />
		Email: <input type="text" name="insEmail"> <br /><br />
		Password: <input type="text" name="insPassword"> <br /><br />
		Age: <input type="text" name="insAge"> <br /><br />
		<input type="submit" value="Create Account" name="insertSubmit"></p>
	</form>

	<hr />

	<h2>Delete Comment</h2> 
	<p> Enter the ncid of the comment you want to delete</p>
	<form method="POST" action="demo.php">
		<input type="hidden" id="deleteQueryRequest" name="deleteQueryRequest">
		ncid: <input type="text" name="insNcid"> <br /><br />
		<input type="submit" value="Delete Comment" name="Delete Comment"></p>
	</form>

	<hr />

	<h2>Update Account Information</h2> 
	<p> Enter your original email and new information</p>
	<p> (Leave blank for field not to be updated)</p>
	<form method="POST" action="demo.php">
		<input type="hidden" id="updateQueryRequest" name="updateQueryRequest">
		Old Email: <input type="text" name="insOldemail"> <br /><br />
		New Email: <input type="text" name="insNewemail"> <br /><br />
		New User Name: <input type="text" name="insNewusername"> <br /><br />
		New Password: <input type="text" name="insNewpassword"> <br /><br />
		New Age: <input type="text" name="insNewage"> <br /><br />
		<input type="submit" value="Update Submit" name="updateSubmit"></p>
	</form>

	<hr />

	<h2>Select Game of each Genre</h2> 
	<p> Select the genre below </p>
	<form method="GET" action="demo.php">
		<input type="hidden" id="selectQueryRequest" name="selectQueryRequest">
            <input type="checkbox" id="action" name="action">
            <lable for="action"> Action</label><br>
            <input type="checkbox" id="platformGame" name="platformGame">
            <lable for="platformGame">Platform Game</label><br>
            <input type="checkbox" id="socialSimulation" name="socialSimulation">
            <lable for="socialSimulation">Social Simulation</label><br>
            <input type="checkbox" id="puzzle" name="puzzle">
            <lable for="puzzle">Puzzle</label><br>
			<input type="checkbox" id="fighting" name="fighting">
            <lable for="fighting">Fighting</label><br><br>

			<p> Select the published year below </p>
			<input type="checkbox" id="2017" name="2017">
            <lable for="2017"> 2017 </label><br>
            <input type="checkbox" id="2018" name="2018">
            <lable for="2018"> 2018 </label><br>
            <input type="checkbox" id="2019" name="2019">
            <lable for="2019">2019 </label><br>
            <input type="checkbox" id="2020" name="2020">
            <lable for="2020">2020 </label><br>
			<input type="checkbox" id="2021" name="2021">
            <lable for="2021">2021</label><br>
			<input type="checkbox" id="2022" name="2022">
            <lable for="2022">2022</label><br>
			<input type="checkbox" id="2023" name="2023">
            <lable for="2023">2023</label><br><br>

			<p> Select the price range below </p>
			<input type="checkbox" id="60" name="60">
            <lable for="60"> below $70 </label><br>
			<input type="checkbox" id="70" name="70">
            <lable for="70"> $70 ~ $80 </label><br>
            <input type="checkbox" id="80" name="80">
            <lable for="80"> $80 ~ 90$ </label><br>
            <input type="checkbox" id="90" name="90">
            <lable for="90">$90 ~ $100 </label><br>
            <input type="checkbox" id="100" name="100">
            <lable for="100">above $100 </label><br><br>
		
		<input type="submit" value="Submit" name="SelectSubmit"></p>
	</form>

	<hr />

	<h2>Projection: Show game information</h2> 
	<p> Select the columns you want to view</p>
	<form method="GET" action="demo.php">
	<input type="hidden" id="projectQueryRequest" name="projectQueryRequest">
	<input type="checkbox" id="id" name="id">
            <lable for="id"> Game ID</label><br>
            <input type="checkbox" id="name" name="name">
            <lable for="name">Game Name</label><br>
            <input type="checkbox" id="description" name="description">
            <lable for="description">Game Description</label><br>
			<input type="checkbox" id="price" name="price">
            <lable for="price">Game Price</label><br>
			<input type="checkbox" id="release_year" name="release_year">
            <lable for="release_year">Game Released Year</label><br><br>
			
		<input type="submit" value="Submit" name="projectSubmit"></p>
	</form>

	<hr />

	<h2>Join: Show comment on game with comment's owner</h2> 
	<form method="GET" action="demo.php">
		<input type="hidden" id="joinQueryRequest" name="joinQueryRequest">
		Choose one of Game ID from below:
		<select name="gameid">
                <option value="1001">1001: The Legend of Zelda: Breath of the Wild</option>
                <option value="1002">1002: Super Mario Odyssey</option>
                <option value="1003">1003: Super Mario Bros. Wonder</option>
                <option value="1004">1004: Animal Crossing: New Horizons</option>
                <option value="1005">1005: INSIDE</option>
            </select>
            <br/><br/>
		<input type="submit" value="Click to show the comments" name="join"></p>
	</form>

	<hr />

	<h2>Show number of news written by each press</h2> 
	<form method="GET" action="demo.php">
		<input type="hidden" id="countQueryRequest" name="countQueryRequest">
		<input type="submit" value="Click to show the count of news by each press" name="count"></p>
	</form>
	
	<hr />

	<h2>Show highest rating for each game (only for those games having more than one comment)</h2> 
	<form method="GET" action="demo.php">
		<input type="hidden" id="highQueryRequest" name="highQueryRequest">
		<input type="submit" value="Click to show the highest rating" name="high"></p>
	</form>

	<hr />

	<h2>Show the game with highest average rating</h2> 
	<form method="GET" action="demo.php">
		<input type="hidden" id="avgQueryRequest" name="avgQueryRequest">
		<input type="submit" value="Click to show the highest average rating" name="avg"></p>
	</form>
	
	<hr />


	<h2>Show users that have commented on all games</h2> 
	<form method="GET" action="demo.php">
		<input type="hidden" id="divQueryRequest" name="divQueryRequest">
		<input type="submit" value="Click to show the results" name="div"></p>
	</form>
	
	</div>
	

	<?php
	// The following code will be parsed as PHP

	function debugAlertMessage($message)
	{
		global $show_debug_alert_messages;

		if ($show_debug_alert_messages) {
			echo "<script type='text/javascript'>alert('" . $message . "');</script>";
		}
	}

	function executePlainSQL($cmdstr)
	{ //takes a plain (no bound variables) SQL command and executes it
		// echo "<br>running ".$cmdstr."<br>";
		global $db_conn, $success;

		$statement = oci_parse($db_conn, $cmdstr);
		//There are a set of comments at the end of the file that describe some of the OCI specific functions and how they work

		if (!$statement) {
			echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
			$e = OCI_Error($db_conn); // For oci_parse errors pass the connection handle
			echo htmlentities($e['message']);
			$success = False;
		}

		$r = oci_execute($statement, OCI_DEFAULT);
		if (!$r) {
			echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
			$e = oci_error($statement); // For oci_execute errors pass the statementhandle
			echo htmlentities($e['message']);
			$success = False;
		}

		return $statement;
	}

	function executeBoundSQL($cmdstr, $list)
	{
		/* Sometimes the same statement will be executed several times with different values for the variables involved in the query.
		In this case you don't need to create the statement several times. Bound variables cause a statement to only be
		parsed once and you can reuse the statement. This is also very useful in protecting against SQL injection.
		See the sample code below for how this function is used */

		global $db_conn, $success;
		$statement = oci_parse($db_conn, $cmdstr);

		if (!$statement) {
			echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
			$e = OCI_Error($db_conn);
			echo htmlentities($e['message']);
			$success = False;
		}

		foreach ($list as $tuple) {
			foreach ($tuple as $bind => $val) {
				//echo $val;
				//echo "<br>".$bind."<br>";
				oci_bind_by_name($statement, $bind, $val);
				unset($val); //make sure you do not remove this. Otherwise $val will remain in an array object wrapper which will not be recognized by Oracle as a proper datatype
			}

			$r = oci_execute($statement, OCI_DEFAULT);
			if (!$r) {
				echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
				$e = OCI_Error($statement); // For oci_execute errors, pass the statementhandle
				echo htmlentities($e['message']);
				echo "<br>";
				$success = False;
			}
		}
	}


    function printResult($result) { //prints results from a select statement
        echo "<div class=\"content-container right-content\">";
        echo "<br>Retrieved data:<br>";
        echo "<table>";
        echo "<tr>";

        // Get column names from the OCI result
        $columnNames = array();
        $ncols = oci_num_fields($result);
        for ($i = 1; $i <= $ncols; ++$i) {
            $columnNames[] = oci_field_name($result, $i);
            echo "<th>" . oci_field_name($result, $i) . "</th>";
        }

        echo "</tr>";

        while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
            echo "<tr>";
            foreach ($columnNames as $columnName) {
                echo "<td>" . $row[$columnName] . "</td>";
            }
            echo "</tr>";
        }

        echo "</table>";
        echo "</div>";
    }


	function connectToDB()
	{
		global $db_conn;
		global $config;

		// Your username is ora_(CWL_ID) and the password is a(student number). For example,
		// ora_platypus is the username and a12345678 is the password.
		// $db_conn = oci_connect("ora_cwl", "a12345678", "dbhost.students.cs.ubc.ca:1522/stu");
		$db_conn = oci_connect("ora_yichen17" ,"a88262522", "dbhost.students.cs.ubc.ca:1522/stu");

		if ($db_conn) {
			debugAlertMessage("Database is Connected");
			return true;
		} else {
			debugAlertMessage("Cannot connect to Database");
			$e = OCI_Error(); // For oci_connect errors pass no handle
			echo htmlentities($e['message']);
			return false;
		}
	}

	function disconnectFromDB()
	{
		global $db_conn;

		debugAlertMessage("Disconnect from Database");
		oci_close($db_conn);
	}


    function handleShowRequest() {
        $tableName = $_GET['tableName'];

        // Form the SQL query
        echo "<script type='text/javascript'>console.log('hitted');</script>";
        echo "<script type='text/javascript'>console.log('" . $tableName . "');</script>";
        $result = executePlainSQL("SELECT * FROM $tableName");
        printResult($result);
    }

	function handleDisplayRequest() {
		global $db_conn;
		
		$email = $_GET['Email'];
		$password = $_GET['Password'];

        $result = executePlainSQL("SELECT * FROM Users WHERE email = '". $email ."' AND pass_word = '". $password ."' ");
        
		printResult($result);

    }

	function handleInsertRequest() 
	{
		global $db_conn;
		global $success;

		$tuple = array (
			":bind1" => null,
			":bind2" => $_POST['insUsername'],
			":bind3" => $_POST['insEmail'],
			":bind4" => $_POST['insPassword'],
			":bind5" => $_POST['insAge']
		);

		$email = $_POST['insEmail'];
		$userType = $_POST['userType'];

		$alltuples = array (
			$tuple
		);

		executeBoundSQL("INSERT INTO Users VALUES (:bind1, :bind2, :bind3, :bind4, :bind5)", $alltuples);
		$result = executePlainSQL("SELECT userid FROM Users WHERE email = '". $email ."'");
		$row = OCI_Fetch_Array($result, OCI_BOTH);
		$columnName = oci_field_name($result, 1);
		if (!strcmp($userType, "normal")) {
			executePlainSQL("INSERT INTO AveragePerson VALUES (" . $row[$columnName] . ")");
		} else if (!strcmp($userType, "press")) {
			executePlainSQL("INSERT INTO Press VALUES (" . $row[$columnName] . ")");
		}
		if ($success == True) {
			oci_commit($db_conn);
		} else {
			echo '<script>alert("Failed to Create New Account")</script>';
		}
	}

	function handleDeleteRequest() {
		global $db_conn;
		global $success;

		$ncid = $_POST['insNcid'];

		executePlainSQL("DELETE FROM make_Ncomment_about WHERE ncid = ". $ncid);
		if ($success == True) {
			oci_commit($db_conn);
		} else {
			echo '<script>alert("Failed to delete the comment")</script>';
		}
	}

	function handleUpdateRequest() {
		global $db_conn;
		global $success;

		$oldEmail = $_POST['insOldemail'];
		$newEmail = $_POST['insNewemail'];
		$newName = $_POST['insNewusername'];
		$newPassword = $_POST['insNewpassword'];
		$newAge = $_POST['insNewage'];


		if(strcmp($newName , "")) {
			executePlainSQL("UPDATE Users Set username = '". $newName ."' WHERE email = '" . $oldEmail . "'");
		}
		if(strcmp($newPassword , "")) {
			executePlainSQL("UPDATE Users Set pass_word = '". $newPassword ."' WHERE email = '" . $oldEmail . "'");
		}
		if(strcmp($newAge , "")) {
			executePlainSQL("UPDATE Users Set age = '". $newAge ."' WHERE email = '" . $oldEmail . "'");
		}
		if(strcmp($newEmail , "")) {
			executePlainSQL("UPDATE Users Set email = '". $newEmail ."' WHERE email = '" . $oldEmail . "'");
		}

		if ($success == True) {
			oci_commit($db_conn);
		} else {
			echo '<script>alert("Failed to Update User information")</script>';
		}
	}

	function handleSelectRequest() {
		global $db_conn;
		
		$genre = [];

        if (array_key_exists('action', $_GET)) {
            $genre[] = "gg.genre = 'action' ";
        }
        if (array_key_exists('platformGame', $_GET)) {
            $genre[] = "gg.genre = 'platform game'";
        }
        if (array_key_exists('socialSimulation', $_GET)) {
            $genre[] = "gg.genre ='social simulation'";
        }
        if (array_key_exists('puzzle', $_GET)) {
            $genre[] = "gg.genre = 'puzzle'";
        }
		if (array_key_exists('fighting', $_GET)) {
            $genre[] ="gg.genre = 'fighting'";
        }

		$year = [];

        if (array_key_exists('2017', $_GET)) {
            $year[] = "g.release_year = 2017";
        }
        if (array_key_exists('2018', $_GET)) {
            $year[] = "g.release_year = 2018";
        }
        if (array_key_exists('2019', $_GET)) {
            $year[] = "g.release_year = 2019";
        }
        if (array_key_exists('2020', $_GET)) {
            $year[] = "g.release_year = 2020";
        }
		if (array_key_exists('2021', $_GET)) {
            $year[] = "g.release_year = 2021";
        }
		if (array_key_exists('2022', $_GET)) {
            $year[] = "g.release_year = 2022";
        }
		if (array_key_exists('2023', $_GET)) {
            $year[] = "g.release_year = 2023";
        }

		$price = [];

		if (array_key_exists('60', $_GET)) {
            $price[] = "(g.price < 70.00)";
        }
		if (array_key_exists('70', $_GET)) {
			$price[] = "(g.price >= 70.00 and g.price < 80.00)";
        }
		if (array_key_exists('80', $_GET)) {
            $price[] = "(g.price >= 80.00 and g.price < 90.00)";
        }
		if (array_key_exists('90', $_GET)) {
            $price[] = "(g.price >= 90.00 and g.price < 100.00)";
        }
		if (array_key_exists('100', $_GET)) {
            $price[] = "(g.price >= 100.00)";
        }

		// Combine all conditions
        $genreFilter = implode(' OR ', $genre);
		$yearFilter = implode(' OR ', $year);
		$priceFilter = implode(' OR ', $price);

		$condition = [];

		if (!empty($genreFilter)) {
			$condition[] = "($genreFilter)";			
		}
		if (!empty($yearFilter)) {
			$condition[] = "($yearFilter)";
		}
		if (!empty($priceFilter)) {
			$condition[] = "($priceFilter)";
		}

		$conditions = implode(' AND ', $condition);
         
		if (!empty($conditions)) {

            $result = executePlainSQL("SELECT g.g_name AS Game, gg.genre 
									   FROM Game g, Game_Genre gg 
									   WHERE g.genreID = gg.genreID 
									   AND ($conditions) ");

            printResult($result);

        } else {
            echo "Please select at least one filter option.";
        }
    }

	function handleProjectRequest() {
		global $db_conn;
		
		$projection = '';
        if (array_key_exists('id', $_GET)) {
            $projection .= 'mid, ';
        }
        if (array_key_exists('name', $_GET)) {
            $projection .= 'g_name, ';
        }
        if (array_key_exists('description', $_GET)) {
            $projection .= 'g_description, ';
        }
		if (array_key_exists('price', $_GET)) {
            $projection .= 'price, ';
        }
		if (array_key_exists('release_year', $_GET)) {
            $projection .= 'release_year, ';
        }
    
        $projection = substr($projection, 0 , -1);
		$projection = substr($projection, 0 , -1);
        $result = executePlainSQL("SELECT ". $projection ." FROM Game");
        
		printResult($result);
    }

	function handleJoinRequest() {
		global $db_conn;

		$gameid = $_GET['gameid'];
		
        $result = executePlainSQL("SELECT g.g_name AS Game, m.rating, m.content, u.username 
	    						   FROM Game g, MakeM_MComment m, Users u 
								   WHERE g.mid = m.mid 
								   AND m.userid = u.userid
								   AND g.mid = ". $gameid ."");
        
		printResult($result);
    }

	function handleCountRequest() {
		global $db_conn;
		
        $result = executePlainSQL("SELECT u.username AS Press, u.userid AS UserID, COUNT(*) AS Number_of_News
								   FROM Users u, Press p,  writeN_News n 
								   WHERE u.userid = p.userid 
								   AND p.userid = n.userid 
								   GROUP BY u.username, u.userid");
        
		printResult($result);
    }

	function handleAvgRequest() {
		global $db_conn;

		executePlainSQL("CREATE OR REPLACE view Temp(game, avg_rating) AS 
						 SELECT g.g_name, AVG(m.rating) 
						 FROM Game g, MakeM_MComment m 
						 WHERe g.mid = m.mid 
						 GROUP BY g.g_name" );
			 
        $result = executePlainSQL( "SELECT game, avg_rating 
								   FROM Temp 
								   WHERE avg_rating = (SELECT MAX(avg_rating) FROM Temp)");

		printResult($result);
    }

	function handleMaxRequest() {
		global $db_conn;
		
        $result = executePlainSQL("SELECT g.g_name AS Game, MAX(m.rating) AS Max_Rating
								   FROM Game g, MakeM_MComment m 
								   WHERE g.mid = m.mid 
								   GROUP BY g.g_name
								   HAVING COUNT(*) > 1");
        
		printResult($result);
    }

	function handleDivRequest() {
		global $db_conn;
		
        $result = executePlainSQL("SELECT u.username 
								   FROM Users u 
								   WHERE NOT EXISTS (
									(SELECT g.mid FROM Game g) 
									minus 
									(SELECT m.mid FROM MakeM_MComment m WHERE m.userid = u.userid))");
        
		printResult($result);
    }

	// HANDLE ALL POST ROUTES
	// A better coding practice is to have one method that reroutes your requests accordingly. It will make it easier to add/remove functionality.
	
    function handlePOSTRequest()
	{	
		if (connectToDB()) {
			if (array_key_exists('deleteQueryRequest', $_POST)) {
				handleDeleteRequest();
			} else if (array_key_exists('updateQueryRequest', $_POST)) {
				handleUpdateRequest();
			} else if (array_key_exists('insertQueryRequest', $_POST)) {
				handleInsertRequest();
			}

			disconnectFromDB();
		}
	}

	

	// HANDLE ALL GET ROUTES
	// A better coding practice is to have one method that reroutes your requests accordingly. It will make it easier to add/remove functionality.
	function handleGETRequest()
	{
		if (connectToDB()) {
            if (array_key_exists('showSubmit', $_GET)) {
                handleShowRequest();
            } elseif (array_key_exists('Login', $_GET)) {
                handleDisplayRequest();
            } elseif (array_key_exists('SelectSubmit', $_GET) || array_key_exists('Action', $_GET) || array_key_exists('Platform Game', $_GET) || array_key_exists('Social Simulation', $_GET) || array_key_exists('Puzzle', $_GET) || array_key_exists('Fighting', $_GET)) {
                handleSelectRequest();
            } elseif (array_key_exists('projectSubmit', $_GET) || array_key_exists('id', $_GET) || array_key_exists('name', $_GET) || array_key_exists('description', $_GET)) {
                handleProjectRequest();
            } elseif (array_key_exists('join', $_GET)) {
                handleJoinRequest();
			} elseif (array_key_exists('avg', $_GET)) {
                handleAvgRequest();
			} elseif (array_key_exists('high', $_GET)) {
                handleMaxRequest();
			} elseif (array_key_exists('div', $_GET)) {
                handleDivRequest();
			} elseif (array_key_exists('count', $_GET)) {
                handleCountRequest();
			}
			disconnectFromDB();
		}
	}

	if (isset($_POST['Delete_Comment']) || isset($_POST['updateSubmit']) || isset($_POST['insertSubmit'])) {
		handlePOSTRequest();
	} else if (isset($_GET['showTupleRequest']) || isset($_GET['displayRequest']) || isset($_GET['selectQueryRequest']) || isset($_GET['joinQueryRequest']) || isset($_GET['avgQueryRequest']) || isset($_GET['highQueryRequest']) || isset($_GET['projectQueryRequest']) || isset($_GET['divQueryRequest']) || isset($_GET['countQueryRequest']) || isset($_GET['logOutRequest'])) {
		handleGETRequest();
	}

	// End PHP parsing and send the rest of the HTML content
	?>
</body>

</html>