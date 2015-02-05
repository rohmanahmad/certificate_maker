<?php

// link to the font file no the server
$fontname = 'font/arial.ttf';
// controls the spacing between text
$i=40;
//JPG image quality 0-100
$quality = 90;

function create_image($user){

		global $fontname;	
		global $quality;
		$file = "covers/".md5($user[0]['name'].$user[1]['name']).".jpg";	
	
	// if the file already exists dont create it again just serve up the original	
	//if (!file_exists($file)) {	
			

			// define the base image that we lay our text on
			$im = imagecreatefromjpeg("bg.jpg");
			
			// setup the text colours
			$color['red'] = imagecolorallocate($im, 166, 22, 39);
			$color['black'] = imagecolorallocate($im, 54, 56, 60);
			
			$height= 340;
			// this defines the starting height for the text block
			$y = imagesy($im) - $height - 890;// pengaturan tinggi posisi
			 
		// loop through the array and write the text
		$i=200;	
		foreach ($user as $value){
			// center the text in our image - returns the x value
			$x = center_text($value['name'], $value['font-size']);
			imagettftext($im, $value['font-size'], 0, $x, $y + $i, $color[$value['color']], $fontname,$value['name']);
			// add 32px to the line height for the next text block
			$i = $i + 27;	
			
		}
			// create the image
			imagejpeg($im, $file, $quality);
			
	//}
						
		return $file;	
}

function center_text($string, $font_size){

			global $fontname;

			$image_width = 1000;
			$dimensions = imagettfbbox($font_size, 0, $fontname, $string);
			
			return ceil(($image_width - $dimensions[4]) / 2);				
}



	$user = array(
	
		array(
			'name'=> 'Zumrotun Naruto', 
			'font-size'=>'42',
			'color'=>'red'),
			
		array(
			'name'=> 'www.Scripper.com',
			'font-size'=>'16',
			'color'=>'black')
			
	);
	
	
	if(isset($_POST['submit'])){
	
	$error = array();
	
		if(strlen($_POST['name'])==0){
			$error[] = 'Please enter a name';
		}
		
		if(strlen($_POST['email'])==0){
			$error[] = 'Please enter a job title';
		}		
		
	if(count($error)==0){
		
	$user = array(
	
		array(
			'name'=> $_POST['name'], 
			'font-size'=>'30',
			'font-weight'=>'bold',
			'color'=>'red'),
			
		array(
			'name'=> $_POST['email'],
			'font-size'=>'16',
			'color'=>'black'),
			
	);		
		
	}
		
	}

// run the script to create the image
echo '<br /><br /><br /><br />';
$filename = create_image($user);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Rohman-PC</title>
<link href="../style.css" rel="stylesheet" type="text/css" />

<style>
.form{
	position:absolute;
	top:1px;
	right:1px;
}
input{
	border:1px solid #ccc;
	padding:8px;
	font-size:14px;
	width:300px;
	}
	
.submit{
	width:110px;
	background-color:#FF6;
	padding:3px;
	border:1px solid #FC0;
	margin-top:20px;}	

</style>

</head>

<body>
<img src="<?=$filename;?>?id=<?=rand(0,1292938);?>"/><br/><br/>

<ul>
<?php if(isset($error)){
	
	foreach($error as $errors){
		
		echo '<li>'.$errors.'</li>';
			
	}
	
	
}?>
</ul>

<div class="form">
<form action="" method="post">
<table>
 <tr>
  <td>Name</td>
  <td><input type="text" value="<?php if(isset($_POST['name'])){echo $_POST['name'];}?>" name="name"  placeholder="Name"></td>
 </tr>
 <tr>
  <td>Email</td>
  <td><input type="text" value="<?php if(isset($_POST['email'])){echo $_POST['email'];}?>" name="email" placeholder="Job Title"></td>
 </tr>
 <tr>
  <td></td>
  <td><input name="submit" type="submit" class="btn btn-primary" value="Update Image" /></td>
 </tr>

</form>
</div>

</body>
</html>
