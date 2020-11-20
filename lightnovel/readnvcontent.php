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

$lightnovel->chpt_id = isset($_GET['chpt_id']) ? $_GET['chpt_id'] : die();
   
// read products will be here
// query products
$stmt = $lightnovel->readcontent();
$num = $stmt->rowCount();
  
// check if more than 0 record found
if($num>0){
  
    // products array
    $nvcon_arr=array();
    $nvcon_arr["cont"]=array();
  
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
  
        $nvcon_item =array(
            "nvcon_id" => $nvcon_id,
            "chpt_id" => $chpt_id,
            "nvcon_num" => $nvcon_num,
            "nvcon_type" => $nvcon_type,
            "nvcon_body"=>$nvcon_body

           
        );
  
        array_push($nvcon_arr["cont"],$nvcon_item);
    }
  
    // set response code - 200 OK
    http_response_code(200);
  
    // show products data in json format
    echo json_encode($nvcon_arr);
}
  
// no products found will be here
else{
  
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the user no products found
    echo json_encode(
        array("message" => "No Contentfound.")
    );
}


