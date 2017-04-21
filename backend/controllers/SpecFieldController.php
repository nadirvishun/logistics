<?php

namespace backend\controllers;

use backend\models\RegionPrice;
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
        $model = new SpecField();
        $model->scenario = 'insert';
        //如果是提交数据
        if ($model->load(Yii::$app->request->post())) {
            //mysql中的ddl操作对回滚来说没用，所以事务不起作用
            if ($model->save()) {//如果保存成功
                $id = $model->id;
                try {
                    //创建region_price表中字段
                    Yii::$app->db->createCommand()
                        ->addColumn(RegionPrice::tableName(),
                            $model->field_name,
                            $this->decimal(10, 2)->notNull()->comment($model->name))
                        ->execute();
                    return $this->redirectSuccess(['index'], Yii::t('common', 'Create Success'));
                } catch (\Exception $e) {
                    //如果新增字段失败，手动将本身刚写入的数据删除掉
                    $this->findModel($id)->delete();
                    return $this->redirectError(['create'], '创建失败,可能是字段重复，请核对后再创建');
                }
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

        if ($model->load(Yii::$app->request->post())) {
            //先判定field_name有效性（排除原有自身的情况下，不能与其它字段重复）
            $regionPriceFields = array_keys(Yii::$app->db->getTableSchema(RegionPrice::tableName())->columns);
            foreach ($regionPriceFields as $key => $value) {
                if ($model->getOldAttribute('field_name') == $value) {//不和原值比较
                    continue;
                }
                if ($model->field_name == $value) {//如果新值与字段重复，则不能修改
                    $model->addError('field_name', '名称已存在，请重新选择名称');
                    break;
                }
            }
            if (!$model->hasErrors() && $model->validate()) {
                //如果字段名字发生变动，则修改表字段名称，只判定field_name即可，其余的无需修改
                if ($model->isAttributeChanged('field_name')) {//如果有修改
                    try {
                        //修改region_price表中字段
                        Yii::$app->db->createCommand()
                            ->renameColumn(RegionPrice::tableName(),
                                $model->getOldAttribute('field_name'),
                                $model->field_name)
                            ->execute();
                    } catch (\Exception $e) {
                        //如果修改字段失败，提示错误
                        return $this->redirectError(['create'], '修改失败');
                    }
                }
                //上面先进行验证,以免验证出错，保存时就不需要验证了
                $model->save(false);
                return $this->redirectSuccess(['index'], Yii::t('common', 'Update Success'));
            }
        }
        return $this->render('update', [
            'model' => $model,
        ]);

    }

    /**
     * Deletes an existing SpecField model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        //先删除region_price表中字段，然后在删除自身
        try {
            //修改region_price表中字段
            Yii::$app->db->createCommand()
                ->dropColumn(RegionPrice::tableName(),
                    $model->field_name)
                ->execute();
        } catch (\Exception $e) {
            //如果删除字段失败，提示错误
            return $this->redirectError(['create'], '删除失败');
        }
        $model->delete();
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
