<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/lightnovel.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare product object
$lightnovel = new lightnovel($db);
 
// set ID property of record to read
$lightnovel->lightnovel_id = isset($_GET['lightnovel_id']) ? $_GET['lightnovel_id'] : die();
 
// read the details of product to be edited
$lightnovel->readOne();
 
if($lightnovel->lightnovel_title!=null){
    // create array
    $lightnovel_arr = array(
        "lightnovel_id" => $lightnovel ->lightnovel_id,
        "chpt_count" => $lightnovel ->chpt_count,
        "lightnovel_title" => $lightnovel ->lightnovel_title,
        "lightnovel_cover" => $lightnovel ->lightnovel_cover,
        "lightnovel_disp" => $lightnovel ->lightnovel_disp,
        "lightnovel_like_count" => $lightnovel ->lightnovel_like_count,
        "created" => $lightnovel ->created,
        "category_id"=> $lightnovel ->category_id,
        "category_name" => $lightnovel ->category_name
 
    );
 
    // set response code - 200 OK
    http_response_code(200);
 
    // make it json format
    echo json_encode($lightnovel_arr);
}
 
else{
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user product does not exist
    echo json_encode(array("message" => "lightnovel does not exist."));
}
?>