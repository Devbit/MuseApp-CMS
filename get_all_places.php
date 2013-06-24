<?php header('content-type: application/json; charset=utf-8');

/*
 * Following code will list all the places
 */

// array for JSON response
$response = array();

// include db connect class
require_once __DIR__ . '/db_connect.php';

// connecting to db
$db = new DB_CONNECT();

// get all places from places table
$result = mysql_query("SELECT * FROM monumenten ORDER BY title ASC") or die(mysql_error());

// check for empty result
if (mysql_num_rows($result) > 0) {
    // looping through all results
    // places node
    $response["places"] = array();
    
    while ($row = mysql_fetch_array($result)) {
        // temp user array
        $places = array();
        $places["ID"] = $row["ID"];
        $places["title"] = $row["title"];
        $places["address"] = $row["address"];
        $places["city"] = $row["city"];
        $places["latitude"] = $row["latitude"];
		$places["longitude"] = $row["longitude"];
		$places["category"] = $row["category"];


        // push single places into final response array
        array_push($response["places"], $places);
    }
    // success
    $response["success"] = 1;

    // echoing JSON response
    echo json_encode($response);
} else {
    // no places found
    $response["success"] = 0;
    $response["message"] = "No places found";

    // echo no users JSON
    echo json_encode($response);
}
?>
