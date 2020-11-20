<?php
class Banner{
  
    // database connection and table name
    private $conn;
    private $table_name = "banner";
  
    // object properties
    public $banner_id;
    public $url;
    public $action;
    public $bannerText;
   
  
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
    // read products
function read(){
  
    // select all query
  
     $query = "SELECT
                 banner_id,url,action,bannerText
            FROM
                " . $this->table_name . " 
               ";            
  
    // prepare query statement
    $stmt = $this->conn->prepare($query);
  
    // execute query
    $stmt->execute();
  
    return $stmt;
}
// create product
function create(){
 
    // query to insert record
    $query = "INSERT INTO
                " . $this->table_name . "
            SET
                url=:url, action=:action, bannerText=:bannerText";
 
    // prepare query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->url=htmlspecialchars(strip_tags($this->url));
    $this->action=htmlspecialchars(strip_tags($this->action));
    $this->bannerText=htmlspecialchars(strip_tags($this->bannerText));
   
 
    // bind values
    $stmt->bindParam(":url", $this->url);
    $stmt->bindParam(":action", $this->action);
    $stmt->bindParam(":bannerText", $this->bannerText);
    
    // execute query
    if($stmt->execute()){
        return true;
    }
 
    return false;
     
}

// update the product
function update(){
 
    // update query
    $query = "UPDATE
                " . $this->table_name . "
            SET
                rl=:url, action=:action, bannerText=:bannerText
            WHERE
                banner_id = :banner_id";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->url=htmlspecialchars(strip_tags($this->url));
    $this->action=htmlspecialchars(strip_tags($this->action));
    $this->bannerText=htmlspecialchars(strip_tags($this->bannerText));

   
 
    // bind values
    $stmt->bindParam(":url", $this->url);
    $stmt->bindParam(":action", $this->action);
    $stmt->bindParam(":bannerText", $this->bannerText);
 
    // execute the query
    if($stmt->execute()){
        return true;
    }
 
    return false;
}
// delete the product
function delete(){
 
    // delete query
    $query = "DELETE FROM " . $this->table_name . " WHERE banner_id = ?";
 
    // prepare query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->id=htmlspecialchars(strip_tags($this->banner_id));
 
    // bind id of record to delete
    $stmt->bindParam(1, $this->banner_id);
 
    // execute query
    if($stmt->execute()){
        return true;
    }
 
    return false;
}
}

?>