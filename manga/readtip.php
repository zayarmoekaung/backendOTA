<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
// include database and object files
include_once '../config/database.php';
include_once '../objects/manga.php';
  
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
  
// initialize object
$manga = new manga($db);
  
// read products will be here
// query products
$stmt = $manga->readtip();
$num = $stmt->rowCount();
  
// check if more than 0 record found
if($num>0){
  
    // products array
    $manga_arr=array();
    $manga_arr["records"]=array();
  
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
  
        $manga_item=array(
            "manga_id" => $manga_id,
            "chpt_count" => $chpt_count,
            "manga_title" => $manga_title,
            "manga_cover" => $manga_cover,
            "manga_disp" => html_entity_decode($manga_disp),
            "manga_like_count" => $manga_like_count,
            "created" => $created,
            "category_id"=> $category_id,
            "category_name" => $category_name

           
        );
  
        array_push($manga_arr["records"], $manga_item);
    }
  
    // set response code - 200 OK
    http_response_code(200);
  
    // show products data in json format
    echo json_encode($manga_arr);
}
  
// no products found will be here
else{
  
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the user no products found
    echo json_encode(
        array("message" => "No manga found.")
    );
}


