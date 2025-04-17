<?php

namespace backend\controllers;

use Yii;
use common\models\Professional;
use common\models\Clinic;
use common\models\ProfessionalClinic;
use backend\models\ProfessionalSearch;
use backend\models\ClinicSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;


/**
 * ProfessionalController implements the CRUD actions for Professional model.
 */
class ProfessionalController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                        'delete-relation' => ['POST'],
                        'add-clinic' => ['GET', 'POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Professional models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ProfessionalSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Professional model.
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
     * Creates a new Professional model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Professional();

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
     * Updates an existing Professional model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Professional model.
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

    public function actionClinics($id){
        $professional = $this->findModel($id);
        $searchModel = new ClinicSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $id);

        return $this->renderAjax('_clinics', [
            'professional' => $professional,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionAddClinic($professionalId)
{
    try {
        // Find the professional model
        $professional = $this->findModel($professionalId);
        $model = new ProfessionalClinic();
        $model->professional_id = $professionalId;
        
        // For GET requests - display the form
        if (Yii::$app->request->isGet) {
            $existingClinicIds = ProfessionalClinic::find()
                ->select('clinic_id')
                ->where(['professional_id' => $professionalId])
                ->column();
            
            $availableClinics = Clinic::find()
                ->where(['not in', 'id', $existingClinicIds])
                ->all();
            
            return $this->renderAjax('_addClinic', [
                'model' => $model,
                'professional' => $professional,
                'availableClinics' => $availableClinics,
            ]);
        }
        
        // For POST requests - handle form submission
        if (Yii::$app->request->isPost) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            
            if ($model->load(Yii::$app->request->post())) {
                // Set created_at manually if needed
                if (isset($model->created_at)) {
                    $model->created_at = date('Y-m-d H:i:s');
                }
                
                if ($model->save()) {
                    return [
                        'success' => true,
                        'message' => 'Clinic added successfully.'
                    ];
                } else {
                    return [
                        'success' => false,
                        'errors' => $model->getErrors(),
                        'message' => 'Failed to save the clinic link.'
                    ];
                }
            } else {
                return [
                    'success' => false,
                    'message' => 'No data received.'
                ];
            }
        }
        
        // Default fallback for other request types
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return [
            'success' => false,
            'message' => 'Invalid request method.'
        ];
    }
    catch (\Exception $e) {
        Yii::error("Exception in actionAddClinic: " . $e->getMessage() . "\n" . $e->getTraceAsString(), 'application');
        
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return [
                'success' => false,
                'message' => 'Exception: ' . $e->getMessage(),
                'trace' => YII_DEBUG ? $e->getTraceAsString() : null
            ];
        }
        
        throw $e;
    }
}
    public function actionDeleteRelation($professionalId, $clinicId){
        $model = ProfessionalClinic::findOne([
            'professional_id' => $professionalId,
            'clinic_id' => $clinicId
        ]);

        if($model) {
            $model->delete();
            Yii::$app->session->setFlash('success', 'Bond deleted.');
        } else {
            Yii::$app->session->setFlash('error', 'Bond not found.');
        }

        if(Yii::$app->request->isPjax) {
            $professional = $this->findModel($professionalId);
            $searchModel = new ClinicSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $professionalId);

        return $this->renderAjax('_clinics', [
            'professional' => $professional,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    return $this->redirect(['view', 'id' => $professionalId]);
}
    /**
     * Finds the Professional model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Professional the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Professional::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
