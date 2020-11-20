<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/manga.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare product object
$manga = new manga($db);
 
// set ID property of record to read
$manga->manga_id = isset($_GET['manga_id']) ? $_GET['manga_id'] : die();
 
// read the details of product to be edited
$manga->readOne();
 
if($manga->manga_title!=null){
    // create array
    $manga_arr = array(
        "manga_id" => $manga ->manga_id,
        "chpt_count" => $manga ->chpt_count,
        "manga_title" => $manga ->manga_title,
        "manga_cover" => $manga ->manga_cover,
        "manga_disp" => $manga ->manga_disp,
        "manga_like_count" => $manga ->manga_like_count,
        "created" => $manga ->created,
        "category_id"=> $manga ->category_id,
        "category_name" => $manga ->category_name
 
    );
 
    // set response code - 200 OK
    http_response_code(200);
 
    // make it json format
    echo json_encode($manga_arr);
}
 
else{
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user product does not exist
    echo json_encode(array("message" => "Manga does not exist."));
}
?>