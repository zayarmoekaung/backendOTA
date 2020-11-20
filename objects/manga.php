<?php
class Manga{
  
    // database connection and table name
    private $conn;
    private $table_name = "manga";
    private $table_name2 = "manga_chapter";
    private $table_name3 = "manga_contents";
  
    // object properties
    public $manga_id;
    public $chpt_count;
    public $manga_title;
    public $manga_cover;
    public $manga_disp;
    public $manga_like_count;
    public $created;
    public $category_id;
    public $category_name;
    public $chpt_id;
    public $chpt_thumb;
    public $chpt_sum;
    public $chpt_num;
    public $c_id;
    public $url;
    public $c_num;
    public $key;
  
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
    // read products
function read(){
  
    // select all query
  
     $query = "SELECT
                c.category_name as category_name, p.manga_id, p.chpt_count, p.manga_title,p.manga_cover,p.manga_disp,p.manga_like_count,p.created,p.category_id
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


function readtip(){
  
    // select all query
  
     $query = "SELECT
                c.category_name as category_name, p.manga_id, p.chpt_count, p.manga_title,p.manga_cover,p.manga_disp,p.manga_like_count,p.created,p.category_id
            FROM
                " . $this->table_name . " p
                LEFT JOIN
                    category c
                        ON p.category_id = c.category_id
            ORDER BY
                p.created DESC

            LIMIT 6    
                ";            
  
    // prepare query statement
    $stmt = $this->conn->prepare($query);
  
    // execute query
    $stmt->execute();
  
    return $stmt;
}
//search manga
function search($keywords){
  
    // select all query
  
     $query = "SELECT
                c.category_name as category_name, p.manga_id, p.chpt_count, p.manga_title,p.manga_cover,p.manga_disp,p.manga_like_count,p.created,p.category_id
            FROM
                " . $this->table_name . " p
                LEFT JOIN
                    category c
                        ON p.category_id = c.category_id
            WHERE
                 p.manga_title LIKE ? OR p.manga_disp LIKE ? OR c.category_name LIKE ?           
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


// create product
function create(){
 
    // query to insert record
    $query = "INSERT INTO
                " . $this->table_name . "
            SET
                chpt_count=:chpt_count, manga_title=:manga_title, manga_cover=:manga_cover, manga_disp=:manga_disp,manga_like_count=:manga_like_count, created=:created, category_id=:category_id";
 
    // prepare query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->chpt_count=htmlspecialchars(strip_tags($this->chpt_count));
    $this->manga_title=htmlspecialchars(strip_tags($this->manga_title));
    $this->manga_cover=htmlspecialchars(strip_tags($this->manga_cover));
    $this->manga_disp=htmlspecialchars(strip_tags($this->manga_disp));
    $this->manga_like_count=htmlspecialchars(strip_tags($this->manga_like_count));
    $this->created=htmlspecialchars(strip_tags($this->created));
    $this->category_id=htmlspecialchars(strip_tags($this->category_id));
 
    // bind values
    $stmt->bindParam(":chpt_count", $this->chpt_count);
    $stmt->bindParam(":manga_title", $this->manga_title);
    $stmt->bindParam(":manga_cover", $this->manga_cover);
    $stmt->bindParam(":manga_disp", $this->manga_disp);
    $stmt->bindParam(":manga_like_count", $this->manga_like_count);
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
                 c.category_name as category_name, p.manga_id,  p.chpt_count, p.manga_title,p.manga_cover,p.manga_disp,p.manga_like_count,p.created,p.category_id
            FROM
                " . $this->table_name . " p
                LEFT JOIN
                    category c
                        ON p.category_id = c.category_id
            WHERE
                p.manga_id = ?
            LIMIT
                0,1";
 
    // prepare query statement
    $stmt = $this->conn->prepare( $query );
 
    // bind id of product to be updated
    $stmt->bindParam(1, $this->manga_id);
 
    // execute query
    $stmt->execute();
 
    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    // set values to object properties
   $this->chpt_count= $row['chpt_count'];
    $this->manga_title= $row['manga_title'];
    $this->manga_cover= $row['manga_cover'];
    $this->manga_disp= $row['manga_disp'];
    $this->manga_like_count= $row['manga_like_count'];
    $this->category_id = $row['category_id'];
    $this->category_name = $row['category_name'];
   
}

function readChpt(){
 
    // query to read single record
    $query = "SELECT
                 manga_id,  chpt_id, chpt_thumb,chpt_sum,chpt_num
            FROM
                " . $this->table_name2 . " 
                
            WHERE
                manga_id = ?
            
            ORDER BY
                chpt_num DESC";            
  
    $stmt = $this->conn->prepare( $query );
 
    // bind id of product to be updated
    $stmt->bindParam(1, $this->manga_id);
 
    // execute query
    $stmt->execute();
 
    // get retrieved row
    return $stmt;

}

function readcontent(){
 
    // query to read single record
    $query = "SELECT
                 c_id,chpt_id, url,c_num
            FROM
                " . $this->table_name3 . " 
                
            WHERE
                chpt_id = ?
            
            ORDER BY
                c_num ";            
  
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
                manga_title=:manga_title, manga_cover=:manga_cover, manga_disp=:manga_disp, category_id=:category_id
            WHERE
                manga_id = :manga_id";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->manga_title=htmlspecialchars(strip_tags($this->manga_title));
    $this->manga_cover=htmlspecialchars(strip_tags($this->manga_cover));
    $this->manga_disp=htmlspecialchars(strip_tags($this->manga_disp));
    $this->category_id=htmlspecialchars(strip_tags($this->category_id));
     $this->manga_id=htmlspecialchars(strip_tags($this->manga_id));
 
    // bind new values

    $stmt->bindParam(":manga_title", $this->manga_title);
    $stmt->bindParam(":manga_cover", $this->manga_cover);
    $stmt->bindParam(":manga_disp", $this->manga_disp);
    $stmt->bindParam(":category_id", $this->category_id);
    $stmt->bindParam(":manga_id", $this->manga_id);

 
    // execute the query
    if($stmt->execute()){
        return true;
    }
 
    return false;
}
// delete the product
function delete(){
 
    // delete query
    $query = "DELETE FROM " . $this->table_name . " WHERE manga_id = ?";
 
    // prepare query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->id=htmlspecialchars(strip_tags($this->manga_id));
 
    // bind id of record to delete
    $stmt->bindParam(1, $this->manga_id);
 
    // execute query
    if($stmt->execute()){
        return true;
    }
 
    return false;
}
}

?>