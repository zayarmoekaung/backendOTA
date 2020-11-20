<<?php 
$banner_id = 0;
$url="";
$action="";
$bannerText="";
// general variables
$errors = [];
$d1=[];
//mycdn


// if user clicks the Delete admin button
if (isset($_GET['delete-banner'])) {
	$banner_id = $_GET['delete-banner'];
	delete_banner($banner_id);
}
if (isset($_POST['create_banner'])) { createBanner($_POST); }

function getBanners(){
	global $conn, $roles;
	$sql = "SELECT * FROM banner ";
	$result = mysqli_query($conn, $sql);
	$user = mysqli_fetch_all($result, MYSQLI_ASSOC);

	return $user;
}

function delete_banner($id){
global $conn;
	$sql = "DELETE FROM banner WHERE banner_id=$id";
	if (mysqli_query($conn, $sql)) {
		$_SESSION['message'] = "Banner successfully deleted";
		header("location: desk.php");
		exit(0);
}
}
function createBanner($request_values){
global $conn;
		$action = esc($request_values['action']);
		$bannerText =esc($request_values['bannerText']);
	
		
	
        // Set image placement folder
    $target_dir = '../static/banner/'; 
        // Get file path
        $target_file = $target_dir . basename($_FILES["url"]["name"]);
        // Get file extension
        $imageExt = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        // Allowed file types
        $allowd_file_ext = array("jpg", "jpeg", "png");
        

        if (!file_exists($_FILES["url"]["tmp_name"])) {
           $resMessage = array(
               "status" => "alert-danger",
               "message" => "Select image to upload."
           );
        } else if (!in_array($imageExt, $allowd_file_ext)) {
            $resMessage = array(
                "status" => "alert-danger",
                "message" => "Allowed file formats .jpg, .jpeg and .png."
            );            
        } else if ($_FILES["url"]["size"] > 2097152) {
            $resMessage = array(
                "status" => "alert-danger",
                "message" => "File is too large. File size should be less than 2 megabytes."
            );
        } else if (file_exists($target_file)) {
            $resMessage = array(
                "status" => "alert-danger",
                "message" => "File already exists."
            );
        } else {
            if (move_uploaded_file($_FILES["url"]["tmp_name"], $target_file)) {
            	$cdn_path = '/banner/ban-'.uniqid().$imageExt;
            	$storage_path = '/ota69'. $cdn_path;
            	$file_url = 'https://otaota.b-cdn.net'.$cdn_path;
            	$bunnyCDNStorage = new BunnyCDNStorage("ota69", "17d96ff2-5fc6-47e8-82807cc59e07-fc4b-4dbc", "sg");
				$bunnyCDNStorage->uploadFile($target_file, $storage_path);
				
				$sql = "INSERT INTO `banner` (`banner_id`, `url`, `action`, `bannerText`) VALUES (Null, '$file_url', '$action', '$bannerText')";
               
               if (mysqli_query($conn, $sql)) {
					unlink($target_file);
					header("location: desk.php");
					exit(0);

	
	}

        
                 }
                 
				

        }

   } 

function console_log($output, $with_script_tags = true) {
    $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) . 
');';
    if ($with_script_tags) {
        $js_code = '<script>' . $js_code . '</script>';
    }
    echo $js_code;
}
 ?>