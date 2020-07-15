<?php

namespace app\controllers;

use app\models\Tree;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
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

    /**
     * {@inheritdoc}
     */
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

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $array = Tree::find()->orderBy('level')->all();
        $level = 1;

        foreach ($array as $item)
        {
            if($item->level != $level)
            {
                $level = $item->level;
                echo '<br>';
            }

            echo $item->path;
            echo '|';
        }
    }

    public function actionSeeder()
    {
        if(Tree::seeder(1))
        {
            return $this->redirect('index');
        }

        echo 'error';
    }

    public function actionGetDownItems($id)
    {
        $array = Tree::getDownItems($id);
        $level = 1;

        foreach ($array as $item)
        {
            if($item->level != $level)
            {
                $level = $item->level;
                echo '<br>';
            }

            echo $item->path;
            echo '|';
        }
    }

    public function actionGetUpItems($id)
    {
        $array = Tree::getUpItems($id);
        $level = 1;

        foreach ($array as $item)
        {
            if($item->level != $level)
            {
                $level = $item->level;
                echo '<br>';
            }

            echo $item->path;
            echo '|';
        }
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
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

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
