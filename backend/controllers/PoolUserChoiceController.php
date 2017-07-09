<?php

namespace backend\controllers;

use Yii;
use common\models\PoolUserChoice;
use backend\models\PoolUserChoiceSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PoolUserChoiceController implements the CRUD actions for PoolUserChoice model.
 */
class PoolUserChoiceController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all PoolUserChoice models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PoolUserChoiceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PoolUserChoice model.
     * @param integer $pool_id
     * @param integer $user_id
     * @param integer $choice_id
     * @return mixed
     */
    public function actionView($pool_id, $user_id, $choice_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($pool_id, $user_id, $choice_id),
        ]);
    }

    /**
     * Creates a new PoolUserChoice model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PoolUserChoice();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'pool_id' => $model->pool_id, 'user_id' => $model->user_id, 'choice_id' => $model->choice_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing PoolUserChoice model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $pool_id
     * @param integer $user_id
     * @param integer $choice_id
     * @return mixed
     */
    public function actionUpdate($pool_id, $user_id, $choice_id)
    {
        $model = $this->findModel($pool_id, $user_id, $choice_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'pool_id' => $model->pool_id, 'user_id' => $model->user_id, 'choice_id' => $model->choice_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing PoolUserChoice model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $pool_id
     * @param integer $user_id
     * @param integer $choice_id
     * @return mixed
     */
    public function actionDelete($pool_id, $user_id, $choice_id)
    {
        $this->findModel($pool_id, $user_id, $choice_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the PoolUserChoice model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $pool_id
     * @param integer $user_id
     * @param integer $choice_id
     * @return PoolUserChoice the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($pool_id, $user_id, $choice_id)
    {
        if (($model = PoolUserChoice::findOne(['pool_id' => $pool_id, 'user_id' => $user_id, 'choice_id' => $choice_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
