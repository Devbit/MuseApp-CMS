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
if (isset($_GET["lat"]) && isset($_GET["lng"])) {
$lat = $_GET['lat'];
$lng = $_GET['lng'];
if(isset($_GET["lng"])) $dist = $_GET['dist']; else $dist = 20;
    // get a places from placess table
    $result = mysql_query("SELECT ID,title,address,city,latitude,longitude,category, ( 6371 * acos( cos( radians(".$lat.") ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(".$lng.") ) + sin( radians(".$lat.") ) * sin( radians( latitude ) ) ) ) AS distance FROM monumenten HAVING distance < ".$dist."
ORDER BY distance ASC");

// check for empty result
if (mysql_num_rows($result) > 0) {
    // looping through all results
    // places node
	    $response["success"] = 1;
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
?>


