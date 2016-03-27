<?php
namespace app\models;

use Yii;
use yii\base\Model;
use app\components\GDI_image;

/**
 * Login form
 */
class Imagine extends Model
{
	public $shahid;
	public $text = 'Hello World';
	public $font_size = '12';
	public $font_color ='#FFFFFF';
	public $outline_color;
	public $file_name;
	public $image_directory;
	public $shadow_color;
	public $font_name;
	public $border_thickness;
	public $pad;
	public $wapal;
	public $border_options;
	public $shadow;
	public $shadow_offset;
	public $save_to_file = false;
	
	//public $image;
	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
				// username and password are both required
				[['text', 'font_size'], 'required'],
		];
	}
	
	public function fonts(){
		$fonts = [];
		$files = \yii\helpers\FileHelper::findFiles('font/');
		if(!empty($files)){
			foreach ($files as $file){
				$fonts[$file] = $file;
			}
		}
		return $fonts;
	}
	
	public function create(){
		
		if (!$this->validate()) {
			return null;
		}
		
		$image = new GDI_image($this->text);
		//$image->shahid = $this->shahid;
		$image->font_size = $this->font_size;
		$image->font_color = strtoupper($this->font_color);
		$image->outline_color = $this->outline_color;
		$image->file_name = $this->image_directory.$this->file_name;
		$image->font_name = $this->font_name; //Url::base(['/font/'.$this->font_name]);
		//$image->border_thickness = $this->border_thickness;
		//$image->pad = $this->pad;
		//$image->shadow_color = '$shadow_color';
		//$image->border_options = $this->border_options;
		//$image->shadow = $this->shadow;
		//$image->shadow_offset =  $this->shadow_offset;
		$image->save_to_file = $this->save_to_file;
		
		return $image->save();
	}
}
