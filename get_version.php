<?php header('content-type: application/json; charset=utf-8');

// array for JSON response
$response = array();


// include db connect class
include('db_connect.php');

// connecting to db
$db = new DB_CONNECT();

    // get a product from products table
    $result = mysql_query("SELECT * FROM version WHERE id = 1");

    if (!empty($result)) {
        // check for empty result
        if (mysql_num_rows($result) > 0) {

            $result = mysql_fetch_array($result);
            $version = array();
			$version["id"] = $result["id"];
			$version["version"] = $result["version"];
            // success
            $response["success"] = 1;

            // user node
            $response["version"] = array();

            array_push($response["version"], $version);

            // echoing JSON response
            echo json_encode($response);
        } else {
            // no product found
            $response["success"] = 0;
            $response["message"] = "No version found";

            // echo no users JSON
            echo json_encode($response);
        }
    } else {
        // no product found
        $response["success"] = 0;
        $response["message"] = "No version found.";

        // echo no users JSON
        echo json_encode($response);
    }
?>