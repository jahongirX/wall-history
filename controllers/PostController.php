<?php


namespace app\controllers;


use app\models\Post;
use Yii;
use yii\filters\RateLimiter;
use yii\web\Controller;

class PostController extends Controller
{

    public function behaviors()
    {
        return [
            'rateLimiter' => [
                'class' => \andreyv\ratelimiter\IpRateLimiter::class,
                'rateLimit' => 1,
                'timePeriod' => 60,
                'actions' => ['post-save'],
            ],
        ];
    }

    public function actionIndex(){
        $model = new Post();
        $savedPosts = Post::find()->all();
        return $this->render('index',[
            'model' => $model,
            'savedPosts' => $savedPosts
        ]);
    }

    public function actionPostSave(){
        $model = new Post();
        if(Yii::$app->request->isPost && $model->load(Yii::$app->request->post()) && $model->save()){
            Yii::$app->session->setFlash('success', 'Ваши мысли успешно сохранены!');
            return $this->redirect('index');
        }
        return $this->redirect('index');
    }

    public function actionRules(){
        return $this->render('rules');
    }
}