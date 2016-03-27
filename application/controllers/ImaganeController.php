<?php
namespace app\controllers;
 
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\components\GDI_image;
use app\models\Imagine;
use yii\helpers\Html;
use yii\web\Session;
use Facebook\Facebook;
use app\models\Setting;

class ImaganeController extends Controller{

	public function actionIndex()
	{
		return $this->render('index');
	}
	
	public function actionCreate()
	{
		$model = new Imagine();
		if ($model->load(Yii::$app->request->post())) {
			$post = Yii::$app->request->post();
			$model->font_name = BASE_PATH.'/'.$post['Imagine']['font_name'];//.$model->font_name;
			$model->font_color = $post['Imagine']['font_color'];
			$model->outline_color = $post['Imagine']['outline_color'];
			$model->image_directory = BASE_PATH.'/images/';
			$model->file_name = 'post';
			$model->save_to_file = true;
			$model->create();
			
			$fb = new Facebook([
					'app_id' => Setting::getValue('FB_APP_ID'),
					'app_secret' => Setting::getValue('FB_APP_SECRET'),
					'default_graph_version' => 'v2.5',
			]);
			
			$linkData['message'] = '';
			$linkData['source'] =  $fb->fileToUpload($model->image_directory.$model->file_name.'.png');
			$helper = $fb->getCanvasHelper ();
			try {
				$accessToken = $helper->getAccessToken ();
				// Returns a `Facebook\FacebookResponse` object
				$response = $fb->post('/me/photos', $data, $accessToken);
			} catch(Facebook\Exceptions\FacebookResponseException $e) {
				echo 'Graph returned an error: ' . $e->getMessage();
				exit;
			} catch(Facebook\Exceptions\FacebookSDKException $e) {
				echo 'Facebook SDK returned an error: ' . $e->getMessage();
				exit;
			}
			
		}
		return $this->render('create', [
				'model' => $model,
		]);
	}
	
	public function actionSave()
	{
		if (Yii::$app->request->isAjax) {
			$post = Yii::$app->request->post();
			$session = new Session();
			$session['post_text'] = $post['Imagine']['text'];
			$session['font_size'] = $post['Imagine']['font_size'];
			$session['font_name'] = BASE_PATH.'/'.$post['Imagine']['font_name'];
			$session['font_color'] = $post['Imagine']['font_color'];
			$session['outline_color'] = $post['Imagine']['outline_color'];
			$session['image_directory'] = BASE_PATH.'/images/';
			$session['file_name'] = 'post';
			$session['save_to_file'] = true;
			echo 'sucess';
		}
	}
	public function actionShow()
	{
		$session = new Session();
		
		$image  = new GDI_image($session['post_text']);
		$image->font_size = '16';//$session['font_size'];
		$image->font_name = $session['font_name'];
		$image->font_color = $session['font_color'];
		$image->outline_color = $session['outline_color'];
		$image->image_directory = $session['image_directory'];
		$image->file_name = $session['file_name'];
		//$image->save_to_file = $session['save_to_file'];
		echo $image->save();
	}
	public function actionImage()
	{
		echo Html::img(['/images/post.png']);
	}
}