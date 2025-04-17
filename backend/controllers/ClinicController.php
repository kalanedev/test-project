<?php

namespace backend\controllers;

use Yii;
use common\models\Clinic;
use common\models\Professional;
use common\models\ProfessionalClinic;
use backend\models\ClinicSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ClinicController implements the CRUD actions for Clinic model.
 */
class ClinicController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return[
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                        'update' => ['GET', 'POST'],
                    ],
                ],
            ];
    }

    /**
     * Lists all Clinic models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ClinicSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Clinic model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Clinic model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Clinic();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Clinic model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if(Yii::$app->request->isAjax){

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                $professionalClinic = ProfessionalClinic::findOne(['clinic_id' => $id]);
                $professionalId = $professionalClinic ?$professionalClinic->professional_id : null;

                if ($professionalId) {
                    $professional = Professional::findOne($professionalId);
                    $searchModel = new ClinicSearch();
                    $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $professionalId);
                    
                return $this->renderAjax('/professional/_clinics', [
                    'professional' => $professional,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                ]);
            }

            return '<div class="alert alert-success">Clinic updated successfully!</div>';
        }

        return $this->renderAjax('_form', [
            'model' => $model,
            'isModal' => true,
        ]);
    }
    if ($model->load(Yii::$app->request->post()) && $model->save()) {
        return $this->redirect(['view', 'id' => $model->id]);
    }

    return $this->render('update', [
        'model' => $model,
    ]);
}


    /**
     * Deletes an existing Clinic model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Clinic model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Clinic the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Clinic::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
