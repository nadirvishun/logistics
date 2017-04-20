<?php

namespace backend\controllers;

use Yii;
use backend\models\SpecField;
use backend\models\search\SpecFieldSearch;
use yii\db\SchemaBuilderTrait;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * SpecFieldController implements the CRUD actions for SpecField model.
 */
class SpecFieldController extends BaseController
{
    //引入trait，方便来组装字段属性
    use SchemaBuilderTrait;
    const REGION_PRICE_TABLE = '{{%region_price}}';

    /**
     * @inheritdoc
     * @since 2.0.6
     */
    protected function getDb()
    {
        return Yii::$app->db;
    }

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
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all SpecField models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SpecFieldSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SpecField model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new SpecField model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
//        print_r(Yii::$app->db->getTableSchema(self::REGION_PRICE_TABLE));exit;
        $model = new SpecField();
        //
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            //mysql中的ddl操作对回滚来说没用，所以事务不起作用
            try {
                //创建region_price表中字段，尽量先创建，如果出错直接终止了
                Yii::$app->db->createCommand()
                    ->addColumn(self::REGION_PRICE_TABLE,
                        $model->field_name,
                        $this->decimal(10, 2)->notNull()->comment($model->name))
                    ->execute();
                //保存自身，由于上面已经验证了，所以这里就不验证了
                $model->save(false);
                return $this->redirectSuccess(['index'], Yii::t('common', 'Create Success'));
            } catch (\Exception $e) {
                return $this->redirectError(['create'], '创建失败,可能是字段重复，请核对后再创建');
            }
        }
        //获取默认状态
        $model->loadDefaultValues();
        return $this->render('create', [
            'model' => $model,
        ]);

    }

    /**
     * Updates an existing SpecField model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //return $this->redirect(['view', 'id' => $model->id]);
            return $this->redirectSuccess(['index'], Yii::t('common', 'Update Success'));
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing SpecField model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirectSuccess(['index'], Yii::t('common', 'Delete Success'));
    }

    /**
     * Finds the SpecField model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SpecField the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SpecField::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('common', 'The requested page does not exist.'));
        }
    }
}
