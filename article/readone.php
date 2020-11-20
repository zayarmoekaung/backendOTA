<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
// include database and object files
include_once '../config/database.php';
include_once '../objects/article.php';
  
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
  
// initialize object
$article = new article($db);

$article->art_id = isset($_GET['art_id']) ? $_GET['art_id'] : die();
   
// read products will be here
// query products
$stmt = $article->readcontent();
$num = $stmt->rowCount();
  
// check if more than 0 record found
if($num>0){
  
    // products array
    $arcon_arr=array();
    $arcon_arr["cont"]=array();
  
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
  
        $arcon_item =array(
            "arcon_id" => $arcon_id,
            "art_id" => $art_id,
            "arcon_num" => $arcon_num,
            "arcon_type" => $arcon_type,
            "arcon_body"=>$arcon_body

           
        );
  
        array_push($arcon_arr["cont"],$arcon_item);
    }
  
    // set response code - 200 OK
    http_response_code(200);
  
    // show products data in json format
    echo json_encode($arcon_arr);
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


