<?php  include('../config.php'); ?>
<?php  include(ROOT_PATH . '/admin/includes/admin_function.php'); ?>
<?php  include(ROOT_PATH . '/admin/includes/bunnycdn-storage.php'); ?>
<?php include(ROOT_PATH . '/admin/includes/security.php'); ?>
<?php include(ROOT_PATH . '/admin/includes/head_section.php'); ?>
<?php include(ROOT_PATH . '/admin/includes/banner_function.php'); ?>
<link class="jsbin" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/base/jquery-ui.css" rel="stylesheet" type="text/css" />
<script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.0/jquery-ui.min.js"></script>

	<title>Creator Desk| Home</title>
</head>	
<style>
* {box-sizing: border-box;}
body {font-family: Verdana, sans-serif;}
.mySlides {display: none;}
img {vertical-align: middle;}

/* Slideshow container */
.slideshow-container {
  max-width: 1000px;
  position: relative;
  margin: auto;
}

/* Caption text */
.text {
  color: #f2f2f2;
  font-size: 25px;
  padding: 8px 12px;
  position: absolute;
  bottom: 8px;
  width: 100%;
  text-align: left;
}

/* Number text (1/3 etc) */
.numbertext {
  color: #f2f2f2;
  font-size: 12px;
  padding: 8px 12px;
  position: absolute;
  top: 0;
}

/* The dots/bullets/indicators */
.dot {
  height: 15px;
  width: 15px;
  margin: 0 2px;
  background-color: #bbb;
  border-radius: 50%;
  display: inline-block;
  transition: background-color 0.6s ease;
}

.active {
  background-color: #717171;
}

/* Fading animation */
.fade {
  -webkit-animation-name: fade;
  -webkit-animation-duration: 1.5s;
  animation-name: fade;
  animation-duration: 1.5s;
}

@-webkit-keyframes fade {
  from {opacity: .4} 
  to {opacity: 1}
}

@keyframes fade {
  from {opacity: .4} 
  to {opacity: 1}
}

/* On smaller screens, decrease text size */
@media only screen and (max-width: 300px) {
  .text {font-size: 11px}
}
.pic{
  width: 100%; 
  height: 400px; 
  object-fit: cover;
  align-self: center;

}
.bannerbox{
	
	
	width: 100%;
	display: block;
	position: relative;
	margin: 10px;
	
}
.bthumb{
	width: 100%;
	height: 80px;
	display: block;
	object-fit: cover;


}
.table{
	width: 80%;
	display: block;
	margin: auto;
}
.customize-banner{
	width: 100%;
	height: 250px;
	position: relative;
	overflow: scroll;
	display: flex;
}
.customize-btn{
	background-color: #8B008B;
	text-align: center;
	color: #ffffff;
	padding: 5px;
	width: 80%;
	height: 40px;
	margin: auto;
	cursor: pointer;
}
.newbannerbox{
	display: none;
	position: fixed;
	background-color: #8B008B;
	width: 80%;
	height: 300px;
	z-index: 99;
	margin-left: 10%;
	margin-right: 10%;

	bottom: 40vh;
	justify-content: center;
	padding: 10px;
	color: #ffffff;
	
}
.bannerimg{
	display: block;
	width: 100%;
	height: 100px;
	object-fit: scale-down;
	margin-bottom: 10px;
}
.file{
	content: 'Select some files';
	display:block;
	background: linear-gradient(top, #f9f9f9, #e3e3e3);
  border: 1px solid #999;
  border-radius: 3px;
  padding: 5px 8px;
  outline: none;
  white-space: nowrap;
  -webkit-user-select: none;
  cursor: pointer;
  text-shadow: 1px 1px #fff;
  font-weight: 700;
  font-size: 10pt;

}
.tbox{
	color: #8B008B;
	display:block;
	width: 80%;
	height: auto;
	margin: auto;
	margin-bottom: 5px;
	text-align: center;
	border: none;
}

</style>




<div id="slide" class="slideshow-container">






</div>
<br>

<div id="dott" style="text-align:center">
 

</div>

<script>

  // api url 
const api_url = 
  "http://localhost/api/banner/read.php"; 

// Defining async function 
async function getapi(url) { 
  
  // Storing response 
  const response = await fetch(url); 
  
  // Storing data in form of JSON 
  var data = await response.json(); 
  console.log(data); 
  if (response) { 
     
  } 
  show(data); 
} 
// Calling that async function 
getapi(api_url); 

// Function to hide the loader 
function hideloader() { 
  document.getElementById('loading').style.display = 'none'; 
} 
// Function to define innerHTML for HTML table 
function show(data) { 
  let dot=``;
  let sld = ``; 
  
  // Loop to access all rows 
  for (let r of data.records) { 
    sld += `
    <div class="mySlides fade"  onclick="location.href='${r.action}'">

  <img class="pic" src="${r.url}" style="width:100%">
  <div class="text">${r.bannerText}</div>
</div>
`; 
dot += `<span class="dot"></span>`
  } 

  // Setting innerHTML as tab variable 
  document.getElementById("slide").innerHTML = sld; 
  document.getElementById("dott").innerHTML = dot; 
  showSlides();

} 



var slideIndex = 0;


function showSlides() {
  var i;
  var slides = document.getElementsByClassName("mySlides");
  var dots = document.getElementsByClassName("dot");
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";  
  }
  slideIndex++;
  if (slideIndex > slides.length) {slideIndex = 1}    
  for (i = 0; i < dots.length; i++) {
    dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex-1].style.display = "block";  
  dots[slideIndex-1].className += " active";
  setTimeout(showSlides, 2000); // Change image every 2 seconds
}
</script>


</html> 


<?php 
	// Get all admin users from DB
	$banners = getBanners();
	
			
?>

<div onclick="showcban();" class="customize-btn" >Customize Banner</div>

<!-- Display records Banners from DB-->
<div id="customize-banner" style="display: none;">
		<div  class="customize-banner">
			<!-- Display notification message -->
			<?php include(ROOT_PATH . '/includes/message.php') ?>

			<?php if (empty($banners)): ?>
				<h1>No Banners in the database.</h1>
			<?php else: ?>
			
					<?php foreach ($banners as $key => $banner): ?>
						
						<div class="bannerbox" onclick="location.href='<?php echo $banner['action']; ?>'">
							<img class="bthumb" src="<?php echo $banner['url']; ?>">
							<p style="font-size: 15px; font-style: bold; background-color:#A9A9A9; color: #ffffff; padding: 3px; ">
							<?php echo $banner['bannerText']; ?>
							</p>
						
								<a 
								    href="desk.php?delete-banner=<?php echo $banner['banner_id'] ?>">
								    <div style="width: 100%; height: 30px; color: #ffffff; background-color:#800080; margin-bottom: 10px; text-align: center; padding: 3px; ">Delete</div>
								</a>
							
						</div>
						
							
									
							
						
					
					<?php endforeach ?>
					
			<?php endif ?>
			
				
			</div>
			<div id="newbannerbox" class="newbannerbox">
				
				<form method="post" enctype="multipart/form-data" action="<?php echo BASE_URL . 'admin/desk.php'; ?>" >
				<!-- validation errors for the form -->
				<?php include(ROOT_PATH . '/includes/error.php') ?>

				<!-- if editing post, the id is required to identify that post -->
				<label style="float: left; margin: 5px auto 5px;">Banner Image</label>
				<img id="blah" class="bannerimg" src="<?php echo BASE_URL . 'static/upload.png'; ?>" alt="your image" />
				<input class="file" type="file" name="url" onchange="readURL(this);" >
				<input class="tbox" type="text" name="action" value="" placeholder="Action">
				<input class="tbox" type="text" name="bannerText" value="" placeholder="Banner Text">
				<button class="tbox" type="submit" class="btn" name="create_banner">Save Banner</button>
			</form>
			</div>
				
			<div style="display: flex; width: 100%; position: relative;">
				<div style="display: inline-block; width: 50%; height: 40px; color: #ffffff; background-color:#00FF00;text-align: center; cursor: pointer; padding: 5px;" onclick="newbannerbox();"> Add New Banner</div>
					<div style="display: inline-block; width: 50%; height: 40px; color: #ffffff; background-color:#D3D3D3;text-align: center; cursor: pointer; padding: 5px;" onclick="hidecban()"> Done </div>
		</div>

	</div>	
		<!-- // Display records from DB -->
	
<script type="text/javascript">
	function showcban(){

		document.getElementById('customize-banner').style.display='block';
	}
	function hidecban(){

		document.getElementById('customize-banner').style.display='none';
	}
	function newbannerbox(){
		document.getElementById('newbannerbox').style.display='block';
	}
	function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#blah')
                        .attr('src', e.target.result);
                       
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
</script>

 