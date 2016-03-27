<?php

namespace app\components;

class GDI_image{
	public $shahid;
	public $text;
	public $font_size;
	public $font_color;
	public $outline_color;
	public $file_name;
	public $image_directory;
	public $shadow_color;
	public $font_folder, $font_name;
	public $border_thickness;
	public $pad;
	public $wapal;
	public $border_options;
	public $shadow;
	public $shadow_offset;
	public $save_to_file;
	public $path;
	/**
	 *
	 * @param string $txt          The text to convert into image
	 *
	 */
	function  __construct($txt) {
		$this->text = $txt;
		$this->font_size ='12';
		$this->font_color ='#FFFFFF';
		$this->outline_color = '#FF0000';
		$this->file_name = 'untitiled';
		$this->image_directory= '';
		$this->font_folder = '';
		$this->font_name ='font/segoepr.ttf';
		$this->border_thickness =0;
		$this->pad= 5;
		$this->shadow_color = '$shadow_color';
		$this->border_options ='1';
		$this->shadow = false;
		$this->shadow_offset = 5;
		$this->save_to_file = false;
		// 1: thick and close,  2: thin and wide space ,  3: thick and close , 4: thick and white space
	}
	private function HexToRGB($hex){
		$hex = preg_replace("~#~", "", $hex);

		$color = array();

		if(strlen($hex) == 3) {
			$color['r'] = hexdec(substr($hex, 0, 1) . $r);
			$color['g'] = hexdec(substr($hex, 1, 1) . $g);
			$color['b'] = hexdec(substr($hex, 2, 1) . $b);
		}
		else if(strlen($hex) == 6) {
			$color['r'] = hexdec(substr($hex, 0, 2));
			$color['g'] = hexdec(substr($hex, 2, 2));
			$color['b'] = hexdec(substr($hex, 4, 2));
		}
		return $color;
	}
	/**
	 Saves the image with the given properties<br>
	 * Example:<br><br><b> $newImage = new DGI_Image('Salaaam');<br>
	 * $newImage->font_size =40;<br>
	 * $newImage->file_name='MyPng';<br>
	 * $newImage->save();<br>
	 * </b><br>
	 * This will save the the image with MyPng.png<br><br>
	 * Enjoy!!
	 */
	public function save(){
		$x=50;
		$y=50;

		//------new-----------
		$width_shk = 0;
		$height = 0;
		$offset_x = 0;
		$offset_y = 0;
		$rotation = 0;
		$bounds = array();

		//------end new--------

		$width= $this->border_thickness;
		/*image generation code*/
		$text = $this->text;
		$font = $this->font_name; //path to font you want to use
		$fontsize = $this->font_size; //size of font

		$_font_cl= $this->HexToRGB($this->font_color);
		$_outline_cl =$this->HexToRGB($this->outline_color);
		$text_box = imageftbbox($fontsize, 0, $font, $text);
		$_shadow_cl = $this->HexToRGB($this->shadow_color);
		//create Image of size 450px x 150px

		///distance formula to calculate length and width
		$box_height = $text_box['3'] - $text_box['5'];
		$box_width =  $text_box['2'] - $text_box['6'];

		$bounds = ImageTTFBBox($fontsize, 0, $font, "W");

		$font_height = abs($bounds[7]-$bounds[1]);
		// determine bounding box.
		$bounds = ImageTTFBBox($fontsize, $rotation, $font, $text);

		$width_shk = abs($bounds[4]-$bounds[6]);
		$height = abs($bounds[7]-$bounds[1]);
		$offset_y = $font_height;
		$offset_x = 0;

		$bg = imagecreatetruecolor($width_shk+($this->pad*2)+1,$height+($this->pad*2)+1);

		//This will make it transparent
		imagesavealpha($bg, true);
		$trans_colour = imagecolorallocatealpha($bg, 0, 0, 0, 127);
		imagefill($bg, 0, 0, $trans_colour);

		$outline_color = imagecolorallocate($bg, $_outline_cl['r'], $_outline_cl['g'], $_outline_cl['b']);
		$font_color = imagecolorallocate($bg, $_font_cl['r'], $_font_cl['g'], $_font_cl['b']);
		if($this->shadow){
			$shadow_clor_1 = imagecolorallocatealpha($bg, $_shadow_cl['r'], $_shadow_cl['g'], $_shadow_cl['b'],0);
			imagettftext($bg, $fontsize, 0, $offset_x+$this->pad+$this->shadow_offset, $offset_y+$this->pad+$this->shadow_offset, $shadow_clor_1, $font, $text);
		}
		////
		$x= $offset_x+$this->pad;
		$y= $offset_y+$this->pad;

		//---------for white area ---
		$white_color = imagecolorallocate($bg, 255, 0, 0);
		if($this->border_options =='1'){
			$newWidth =$width+ 2;
		}elseif($this->border_options =='2'){
			$newWidth =$width+ 3;
		}else if($this->border_options =='3'){
			$newWidth =$width+ 3;
		}else if($this->border_options =='4'){
			$newWidth =$width+ 4;
		}
		for ($xc=$x-abs($newWidth);$xc<=$x+abs($newWidth);$xc++) {
			// For every Y pixel to the top and the bottom
			for ($yc=$y-abs($newWidth);$yc<=$y+abs($newWidth);$yc++) {
				// Draw the text in the outline color
				$text1 = imagettftext($bg,$fontsize,0,$xc,$yc,$outline_color,$font,$text);
			}
		}
		//--------------

		if($this->border_options =='1')
		{
			$width = $width+1;
		}else if($this->border_options == '2'){
			$width = $width+2;
		}else if($this->border_options =='3'){
			$width = $width-1;
		}else if($this->border_options =='4'){
			$width = $width+2;
		}
		$white_space = imagecolorallocate($bg, 255, 255, 255);
		for ($xc=$x-abs($width);$xc<=$x+abs($width);$xc++) {
			// For every Y pixel to the top and the bottom
			for ($yc=$y-abs($width);$yc<=$y+abs($width);$yc++) {
				// Draw the text in the outline color
				$text1 = imagettftext($bg,$fontsize,0,$xc,$yc,$white_space,$font,$text);
			}
		}

		//Writes text to the image using fonts using FreeType
		imagettftext($bg, $fontsize,0, $offset_x+$this->pad,$offset_y+$this->pad, $font_color, $font, $text);
		$image_name = $this->file_name.'.png';

		if($this->save_to_file){
			imagepng($bg, $image_name);
			ImageDestroy($bg);
			return  $this->file_name .'.png?x='.uniqid((double)microtime()*1000000,1);
		}else{
			header('Content-type: image/png');
			imagepng($bg);
			ImageDestroy($bg);
		}
	}
}
