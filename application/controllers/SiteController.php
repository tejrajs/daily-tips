<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\SignupForm;
use app\components\GDI_image;
use app\models\Setting;
use yii\web\Session;
use Facebook\Facebook;

class SiteController extends Controller
{
	public $enableCsrfValidation = false;
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
    	$session = new Session();
    	$session->open();
    	
        return $this->render('index');
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    public function actionAbout()
    {
        return $this->render('about');
    }
    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
    	$model = new SignupForm();
    	if ($model->load(Yii::$app->request->post())) {
    		if ($user = $model->signup()) {
    			if (Yii::$app->getUser()->login($user)) {
    				return $this->goHome();
    			}
    		}
    	}
    
    	return $this->render('signup', [
    			'model' => $model,
    	]);
    }
    
    public function actionConnect()
    {
    	$session = new Session();
    	$session->open();
    	 
    	$fb = new Facebook([
    			'app_id' => Setting::getValue('FB_APP_ID'),
				'app_secret' => Setting::getValue('FB_APP_SECRET'),
    			'default_graph_version' => 'v2.5',
    			//'default_access_token' => '{access-token}', // optional
    	]);
    	 
    	$helper = $fb->getRedirectLoginHelper();
    	try {
    		$token = $helper->getAccessToken ();
    	} catch ( \Facebook\Exceptions\FacebookResponseException $e ) {
    		echo 'Graph returned an error: ' . $e->getMessage ();
    		exit ();
    	} catch ( \Facebook\Exceptions\FacebookSDKException $e ) {
    		echo 'Facebook SDK returned an error: ' . $e->getMessage();
    		exit;
    	}
    	 
    	$permissions = ['email', 'user_likes','user_posts','publish_actions']; // optional
    	$loginUrl = $helper->getLoginUrl(Setting::getValue('APP_CALLBACK_URL'), $permissions);
    	echo '<a href="' . $loginUrl . '">Log in with Facebook!</a>';
    }
    
    public function actionCallback()
    {
    	$session = new Session();
    	$session->open();
    	 
    	$fb = new Facebook([
    			'app_id' => Setting::getValue('FB_APP_ID'),
				'app_secret' => Setting::getValue('FB_APP_SECRET'),
    			'default_graph_version' => 'v2.5',
    			//'default_access_token' => '{access-token}', // optional
    	]);
    	$helper = $fb->getRedirectLoginHelper();
    	 
    	try {
    		$accessToken = $helper->getAccessToken();
    	} catch(\Facebook\Exceptions\FacebookResponseException $e) {
    		// When Graph returns an error
    		echo 'Graph returned an error: ' . $e->getMessage();
    		exit;
    	} catch(\Facebook\Exceptions\FacebookSDKException $e) {
    		// When validation fails or other local issues
    		echo 'Facebook SDK returned an error: ' . $e->getMessage();
    		exit;
    	}
    	 
    	if (isset($accessToken)) {
    		// Logged in!
    		$session['facebook_access_token'] = (string) $accessToken;
    		return $this->redirect(Setting::getValue('FB_APP_URL'));
    		// Now you can redirect to another page and use the
    		// Now you can redirect to another page and use the
    		// access token from $_SESSION['facebook_access_token']
    	}else{
    		return $this->redirect(['/site/connect']);
    	}
    }
}
