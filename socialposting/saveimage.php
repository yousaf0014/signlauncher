<?php

/**
* 
*/
class SaveImage
{
	
	function save_image($image_link)
	{
		//$image_link = "https://vignette.wikia.nocookie.net/fantendo/images/6/6e/Small-mario.png/revision/latest/scale-to-width-down/381?cb=20120718024112";//https://www.wallpaperup.com/uploads/wallpapers/2016/06/24/991808/9ab236cccae5470451c20329ca43ec6b-700.jpg";//Direct link to image
		$split_image = pathinfo($image_link);
		//if ($split_image["extension"] == NULL) {
			$image_info = getImageSize($image_link);
			switch ($image_info['mime']) {
				case 'image/gif':
				    $extension = 'gif';
				    break;
				case 'image/jpeg':
				    $extension = 'jpg';
				    break;
				case 'image/png':        
				    $extension = 'png';
				    break;
				default:
				    // handle errors
				    break;
			}

			$split_image["extension"] = $extension;
		//}
		$file_name = "uploads/".$split_image['filename'].".".$split_image['extension'];
		if (!file_exists($file_name)){
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL , $image_link);
			curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US) AppleWebKit/525.13 (KHTML, like Gecko) Chrome/0.A.B.C Safari/525.13");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
			$response= curl_exec ($ch);
			curl_close($ch);
			
			$file = fopen($file_name , 'w') or die("X_x");
			fwrite($file, $response);
			fclose($file);
		}
		
		if ($split_image['extension'] == 'png') {
			$file_name_jpg = "uploads/".$split_image['filename'].".jpg";
			if (!file_exists($file_name_jpg)){
				$this->png2jpg($file_name, $file_name_jpg, 100);
			}
			return $file_name_jpg;
		}
		else {
			return $file_name;
		}
	}

	// Quality is a number between 0 (best compression) and 100 (best quality)
	function png2jpg($originalFile, $outputFile, $quality) {
	    $image = imagecreatefrompng($originalFile);
	    imagejpeg($image, $outputFile, $quality);
	    imagedestroy($image);
	}
}

?>


