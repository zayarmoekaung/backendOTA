<?php
class lightnovel{
  
    // database connection and table name
    private $conn;
    private $table_name = "lightnovel";
    private $table_name2 = "lightnovel_chapter";
    private $table_name3 = "lightnovel_contents";
  
    // object properties
    public $lightnovel_id;
    public $chpt_count;
    public $lightnovel_title;
    public $lightnovel_cover;
    public $lightnovel_disp;
    public $lightnovel_like_count;
    public $created;
    public $category_id;
    public $category_name;
    public $chpt_id;
    public $chpt_thumb;
    public $chpt_sum;
    public $chpt_num;
    public $nvcon_id;
    public $nvcon_num;
    public $nvcon_type;
    public $nvcon_body;
  
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
    // read products
function read(){
  
    // select all query
  
     $query = "SELECT
                c.category_name as category_name, p.lightnovel_id, p.chpt_count, p.lightnovel_title,p.lightnovel_cover,p.lightnovel_disp,p.lightnovel_like_count,p.created,p.category_id
            FROM
                " . $this->table_name . " p
                LEFT JOIN
                    category c
                        ON p.category_id = c.category_id
            ORDER BY
                p.created DESC";            
  
    // prepare query statement
    $stmt = $this->conn->prepare($query);
  
    // execute query
    $stmt->execute();
  
    return $stmt;
}

//search LN
function search($keywords){
  
    // select all query
  
     $query = "SELECT
                c.category_name as category_name, p.lightnovel_id, p.chpt_count, p.lightnovel_title,p.lightnovel_cover,p.lightnovel_disp,p.lightnovel_like_count,p.created,p.category_id
            FROM
                " . $this->table_name . " p
                LEFT JOIN
                    category c
                        ON p.category_id = c.category_id
             WHERE
                p.lightnovel_title LIKE ? OR p.lightnovel_disp LIKE ? OR c.category_name LIKE ?           
            ORDER BY
                p.created DESC";            
  
    // prepare query statement
    $stmt = $this->conn->prepare($query);
    // sanitize
    $keywords=htmlspecialchars(strip_tags($keywords));
    $keywords = "%{$keywords}%";
 
    // bind
    $stmt->bindParam(1, $keywords);
    $stmt->bindParam(2, $keywords);
    $stmt->bindParam(3, $keywords);
    // execute query
    $stmt->execute();
  
    return $stmt;
}

function readtip(){
  
    // select all query
  
     $query = "SELECT
                c.category_name as category_name, p.lightnovel_id, p.chpt_count, p.lightnovel_title,p.lightnovel_cover,p.lightnovel_disp,p.lightnovel_like_count,p.created,p.category_id
            FROM
                " . $this->table_name . " p
                LEFT JOIN
                    category c
                        ON p.category_id = c.category_id
            ORDER BY
                p.created DESC

            LIMIT 4    
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
                chpt_count=:chpt_count, lightnovel
           _title=:lightnovel
           _title, lightnovel
           _cover=:lightnovel
           _cover, lightnovel
           _disp=:lightnovel
           _disp,lightnovel
           _like_count=:lightnovel
           _like_count, created=:created, category_id=:category_id";
 
    // prepare query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->chpt_count=htmlspecialchars(strip_tags($this->chpt_count));
    $this->lightnovel_title=htmlspecialchars(strip_tags($this->lightnovel_title));
    $this->lightnovel_cover=htmlspecialchars(strip_tags($this->lightnovel_cover));
    $this->lightnovel_disp=htmlspecialchars(strip_tags($this->lightnovel_disp));
    $this->lightnovel_like_count=htmlspecialchars(strip_tags($this->lightnovel_like_count));
    $this->created=htmlspecialchars(strip_tags($this->created));
    $this->category_id=htmlspecialchars(strip_tags($this->category_id));
 
    // bind values
    $stmt->bindParam(":chpt_count", $this->chpt_count);
    $stmt->bindParam(":lightnovel
   _title", $this->lightnovel_title);
    $stmt->bindParam(":lightnovel
   _cover", $this->lightnovel_cover);
    $stmt->bindParam(":lightnovel
   _disp", $this->lightnovel_disp);
    $stmt->bindParam(":lightnovel
   _like_count", $this->lightnovel_like_count);
    $stmt->bindParam(":created", $this->created);
    $stmt->bindParam(":category_id", $this->category_id);
 
    // execute query
    if($stmt->execute()){
        return true;
    }
 
    return false;
     
}
// used when filling up the update product form
function readOne(){
 
    // query to read single record
    $query = "SELECT
                 c.category_name as category_name, p.lightnovel_id,  p.chpt_count, p.lightnovel_title,p.lightnovel_cover,p.lightnovel_disp,p.lightnovel_like_count,p.created,p.category_id
            FROM
                " . $this->table_name . " p
                LEFT JOIN
                    category c
                        ON p.category_id = c.category_id
            WHERE
                p.lightnovel_id = ?
            LIMIT
                0,1";
 
    // prepare query statement
    $stmt = $this->conn->prepare( $query );
 
    // bind id of product to be updated
    $stmt->bindParam(1, $this->lightnovel_id);
 
    // execute query
    $stmt->execute();
 
    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    // set values to object properties
   $this->chpt_count= $row['chpt_count'];
    $this->lightnovel_title= $row['lightnovel_title'];
    $this->lightnovel_cover= $row['lightnovel_cover'];
    $this->lightnovel_disp= $row['lightnovel_disp'];
    $this->lightnovel_like_count= $row['lightnovel_like_count'];
    $this->category_id = $row['category_id'];
    $this->category_name = $row['category_name'];
   
}

function readChpt(){
 
    // query to read single record
    $query = "SELECT
                 lightnovel_id,  chpt_id, chpt_thumb,chpt_sum,chpt_num
            FROM
                " . $this->table_name2 . " 
                
            WHERE
                lightnovel_id = ?
            
            ORDER BY
                chpt_num DESC";            
  
    $stmt = $this->conn->prepare( $query );
 
    // bind id of product to be updated
    $stmt->bindParam(1, $this->lightnovel_id);
 
    // execute query
    $stmt->execute();
 
    // get retrieved row
    return $stmt;

}

function readcontent(){
 
    // query to read single record
    $query = "SELECT
                 nvcon_id,chpt_id, nvcon_num,nvcon_type,nvcon_body
            FROM
                " . $this->table_name3 . " 
                
            WHERE
                chpt_id = ?
            
            ORDER BY
                nvcon_num ";            
  
    $stmt = $this->conn->prepare( $query );
 
    // bind id of product to be updated
    $stmt->bindParam(1, $this->chpt_id);
 
    // execute query
    $stmt->execute();
 
    // get retrieved row
    return $stmt;

}



// update the product
function update(){
 
    // update query
    $query = "UPDATE
                " . $this->table_name . "
            SET
                lightnovel_title=:lightnovel_title, 
                lightnovel_cover=:lightnovel_cover, 
                lightnovel_disp=:lightnovel_disp, 
                category_id=:category_id
            WHERE
                lightnovel_id = :lightnovel_id";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->lightnovel_title=htmlspecialchars(strip_tags($this->lightnovel_title));
    $this->lightnovel_cover=htmlspecialchars(strip_tags($this->lightnovel_cover));
    $this->lightnovel_disp=htmlspecialchars(strip_tags($this->lightnovel_disp));
    $this->category_id=htmlspecialchars(strip_tags($this->category_id));
     $this->lightnovel_id=htmlspecialchars(strip_tags($this->lightnovel_id));
 
    // bind new values

    $stmt->bindParam(":lightnovel_title", $this->lightnovel_title);
    $stmt->bindParam(":lightnovel_cover", $this->lightnovel_cover);
    $stmt->bindParam(":lightnovel_disp", $this->lightnovel_disp);
    $stmt->bindParam(":category_id", $this->category_id);
    $stmt->bindParam(":lightnovel_id", $this->lightnovel_id);

 
    // execute the query
    if($stmt->execute()){
        return true;
    }
 
    return false;
}
// delete the product
function delete(){
 
    // delete query
    $query = "DELETE FROM " . $this->table_name . " WHERE lightnovel_id = ?";
 
    // prepare query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->id=htmlspecialchars(strip_tags($this->lightnovel_id));
 
    // bind id of record to delete
    $stmt->bindParam(1, $this->lightnovel_id);
 
    // execute query
    if($stmt->execute()){
        return true;
    }
 
    return false;
}
}

?>