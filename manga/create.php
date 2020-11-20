<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once '../config/database.php';
 
// instantiate product object
include_once '../objects/manga.php';
 
$database = new Database();
$db = $database->getConnection();
 
$manga = new manga($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));
 
// make sure data is not empty
if( 
    !empty($data->count) &&
    !empty($data->title) &&
    !empty($data->cover) &&
    !empty($data->disp)  &&
    !empty($data->like)  &&
    !empty($data->cat) 
    
){
 
    // set product property values
    $manga->chpt_count = $data->count;
    $manga->manga_title = $data->title;
    $manga->manga_cover = $data->cover;
    $manga->manga_disp = $data->disp;
    $manga->manga_like_count = $data->like;
    $manga->created = date('Y-m-d H:i:s');
    $manga->category_id = $data->cat;

 
    // create the product
    if($manga->create()){
 
        // set response code - 201 created
        http_response_code(201);
 
        // tell the user
        echo json_encode(array("message" => "manga was created."));
    }
 
    // if unable to create the product, tell the user
    else{
 
        // set response code - 503 service unavailable
        http_response_code(503);
 
        // tell the user
        echo json_encode(array("message" => "Unable to create manga."));
    }
}
 
// tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
    echo json_encode(array("message" => "Unable to create manga. Data is incomplete."));
}
?>