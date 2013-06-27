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
$result = mysql_query("SELECT * FROM charities ORDER BY name ASC") or die(mysql_error());

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
        $places["info"] = $row["info"];
        $places["phone"] = $row["phone"];
        $places["website"] = $row["website"];
		$places["thumb"] = $row["thumb"];
		$places["image"] = $row["image"];


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
    $response["message"] = "No charities found";

    // echo no users JSON
    echo json_encode($response);
}
?>
