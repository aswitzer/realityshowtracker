<?php
class ThumbnailImage
{
    // Private member data
	private $image;

	private $quality = 100;
	private $mimetype;
	private $imageproperties;
	private $initialfilesize;
	
    // Constructor
	public function __construct($file, $thumbnailsize = 100) {
		// Validate provided path
		is_file($file) or die ("File: $file doesn't exist.");
		
		$this->initialfilesize = filesize($file);
		$this->imageproperties = getimagesize($file) or die ("Incorrect file type.");
		
		// Determine mime type of image
		$this->mimetype = image_type_to_mime_type($this->imageproperties[2]);	
		
		// Create image
		switch($this->imageproperties[2]) {
			case IMAGETYPE_JPEG:
				$this->image = imagecreatefromjpeg($file);	
				break;
			case IMAGETYPE_GIF:	
				$this->image = imagecreatefromgif($file);
				break;
			case IMAGETYPE_PNG:
				$this->image = imagecreatefrompng($file);
				break;
			default:
				die("Couldn't create image.");
		}
		$this->createThumb($thumbnailsize);
	}
	
    // Destructor
	public function __destruct() {
		if (isset($this->image)) {
			imagedestroy($this->image);			
		}
	}

    // Public methods
	public function getImage() {
		header("Content-type: $this->mimetype");
		switch ($this->imageproperties[2]) {
			case IMAGETYPE_JPEG:
				imagejpeg($this->image,"",$this->quality);
				break;
			case IMAGETYPE_GIF:
				imagegif($this->image);
				break;
			case IMAGETYPE_PNG:
				imagepng($this->image);
				break;
			default:
				die("Couldn't create image.");
		}
	}

	public function getMimeType() {
		return $this->mimetype;
	}

	public function getQuality() {
		$quality = null;
		
		if ($this->imageproperties[2] == IMAGETYPE_JPEG) {
			$quality = $this->quality;
		}
		
		return $quality;
	}

	public function setQuality($quality) {
		if ($quality > 100 || $quality  <  1) {
			$quality = 75;
        }
		if ($this->imageproperties[2] == IMAGETYPE_JPEG) {
			$this->quality = $quality;
		}
	}

	public function getInitialFileSize() {	
		return $this->initialfilesize;
	}
	
    // Private methods
	private function createThumb($thumbnailSize) {
		$srcW = $this->imageproperties[0];
		$srcH = $this->imageproperties[1];
		
		if ($srcW >$thumbnailSize || $srcH > $thumbnailSize) {
			$reduction = $this->calculateReduction($thumbnailSize);
			
			// Calculate new proportions
  		    $desW = $srcW/$reduction;
  		    $desH = $srcH/$reduction;	
			
			//echo 'width = ' . $desW . ' height = ' . $desH;
										
			$copy = imagecreatetruecolor($desW, $desH);			
			imagecopyresampled($copy,$this->image, 0, 0, 0, 0, $desW, $desH, $srcW, $srcH)
				 or die ("Image copy failed.");			
			
			// Destroy original
			imagedestroy($this->image);
			$this->image = $copy;			
		}
	}

	private function calculateReduction($thumbnailSize) {
		// Adjust size
		$srcW = $this->imageproperties[0];
		$srcH = $this->imageproperties[1];
     	if ($srcW < $srcH) {
  		  $reduction = round($srcH/$thumbnailSize);
  	    }
		else {  			
  		  $reduction = round($srcW/$thumbnailSize);
  	    }
		
		return $reduction;
	}
}
?>