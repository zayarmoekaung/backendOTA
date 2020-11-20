<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
// include database and object files
include_once '../config/database.php';
include_once '../objects/lightnovel.php';
  
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
  
// initialize object
$lightnovel = new lightnovel($db);
  
// read products will be here
// query products
$stmt = $lightnovel->readtip();
$num = $stmt->rowCount();
  
// check if more than 0 record found
if($num>0){
  
    // products array
    $lightnovel_arr=array();
    $lightnovel_arr["records"]=array();
  
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
  
        $lightnovel_item=array(
            "lightnovel_id" => $lightnovel_id,
            "chpt_count" => $chpt_count,
            "lightnovel_title" => $lightnovel_title,
            "lightnovel_cover" => $lightnovel_cover,
            "lightnovel_disp" => html_entity_decode($lightnovel_disp),
            "lightnovel_like_count" => $lightnovel_like_count,
            "created" => $created,
            "category_id"=> $category_id,
            "category_name" => $category_name

           
        );
  
        array_push($lightnovel_arr["records"], $lightnovel_item);
    }
  
    // set response code - 200 OK
    http_response_code(200);
  
    // show products data in json format
    echo json_encode($lightnovel_arr);
}
  
// no products found will be here
else{
  
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the user no products found
    echo json_encode(
        array("message" => "No lightnovel found.")
    );
}


