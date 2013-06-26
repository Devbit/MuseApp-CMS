<?php header('content-type: application/json; charset=utf-8');

/*
 * Following code will get single places details
 * A places is identified by places id (mid)
 */

// array for JSON response
$response = array();

// include db connect class
require_once __DIR__ . '/db_connect.php';

// connecting to db
$db = new DB_CONNECT();

// check for post data
if (isset($_GET["mid"])) {
    $mid = $_GET['mid'];

    // get a places from placess table
    $result = mysql_query("SELECT *FROM monumenten WHERE ID = $mid");

    if (!empty($result)) {
        // check for empty result
        if (mysql_num_rows($result) > 0) {

            $result = mysql_fetch_array($result);

            $places = array();
			$places["ID"] = $result["ID"];
			$places["title"] = $result["title"];
			$places["address"] = $result["address"];
			$places["city"] = $result["city"];
			$places["otherinfo"] = $result["otherinfo"];
			$places["latitude"] = $result["latitude"];
			$places["longitude"] = $result["longitude"];
			$places["thumb"] = $result["thumb"];
			$places["category"] = $result["category"];
			$places["website"] = $result["website"];
			$places["phone"] = $result["phone"];
			$places["price"] = $result["price"];
            // success
            $response["success"] = 1;

            // user node
            $response["places"] = array();

            array_push($response["places"], $places);

            // echoing JSON response
            echo json_encode($response);
        } else {
            // no places found
            $response["success"] = 0;
            $response["message"] = "No places found";

            // echo no users JSON
            echo json_encode($response);
        }
    } else {
        // no places found
        $response["success"] = 0;
        $response["message"] = "No places found";

        // echo no users JSON
        echo json_encode($response);
    }
} else {
    // required field is missing
    $response["success"] = 0;
    $response["message"] = "Required field(s) is missing";

    // echoing JSON response
    echo json_encode($response);
}
?>