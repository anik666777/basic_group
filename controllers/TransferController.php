<?php

    namespace app\controllers;

    use app\models\User;
    use Yii;
    use app\models\Transfer;
    use app\models\SearchTransfer;
    use yii\filters\AccessControl;
    use yii\web\Controller;
    use yii\web\NotFoundHttpException;
    use yii\filters\VerbFilter;

    /**
     * TransferController implements the CRUD actions for Transfer model.
     */
    class TransferController extends Controller {
        /**
         * {@inheritdoc}
         */
        public function behaviors() {
            return [
                'access' => [
                    'class' => AccessControl::class,
                    'rules' => [
                        [
                            'actions' => ['history','create','view'],
                            'allow' => true,
                            'roles' => ['@'],
                        ],
                    ],
                ],
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'logout' => ['post'],
                    ],
                ],
            ];
        }

        /**
         * Lists all Transfer models.
         *
         * @return mixed
         */
        public function actionHistory() {
            $searchModel = new SearchTransfer();
            $dataProvider
                = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('history', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }

        /**
         * Displays a single Transfer model.
         *
         * @param integer $id
         *
         * @return mixed
         * @throws NotFoundHttpException if the model cannot be found
         */
        public function actionView($id) {
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }

        /**
         * Creates a new Transfer model.
         * If creation is successful, the browser will be redirected to the
         * 'view' page.
         *
         * @return mixed
         */
        public function actionCreate() {
            $model = new Transfer();

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                    return $this->redirect(['view', 'id' => $model->id]);
            }

            return $this->render('create', [
                'model' => $model,
            ]);
        }

        /**
         * Finds the Transfer model based on its primary key value.
         * If the model is not found, a 404 HTTP exception will be thrown.
         *
         * @param integer $id
         *
         * @return Transfer the loaded model
         * @throws NotFoundHttpException if the model cannot be found
         */
        protected function findModel($id) {
            if (($model = Transfer::findOne($id)) !== null) {
                return $model;
            }

            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
