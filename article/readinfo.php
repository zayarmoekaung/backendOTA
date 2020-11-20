<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/article.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare product object
$article = new article($db);
 
// set ID property of record to read
$article->art_id = isset($_GET['art_id']) ? $_GET['art_id'] : die();
 
// read the details of product to be edited
$article->readOne();
 
if($article->art_title!=null){
    // create array
    $art_arr = array(
        "art_id" => $article->art_id,
        "art_title" => $article ->art_title,
        "art_thumb" => $article ->art_thumb,
        "art_sum" => $article ->art_sum,
        "created" => $article ->created,
        "category_id"=> $article ->category_id,
        "category_name" => $article ->category_name
 
    );
 
    // set response code - 200 OK
    http_response_code(200);
 
    // make it json format
    echo json_encode($art_arr);
}
 
else{
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user product does not exist
    echo json_encode(array("message" => "art does not exist."));
}
?>