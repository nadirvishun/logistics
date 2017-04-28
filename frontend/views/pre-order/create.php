<?php

use backend\models\RegionPrice;
use kartik\widgets\Select2;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\PreOrder */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $this->title = '物流查询提交'; ?>
    <div class="pre-order-form">

        <?php $form = ActiveForm::begin([
            'id' => 'pre-order-form',
            'options' => ['class' => 'box-body']
        ]); ?>


        <?=
        $form->field($model, 'region_id', ['options' => ['class' => 'form-group c-md-5']])->widget(Select2::classname(), [
            'data' => RegionPrice::getRegionOptions(false, '潍坊'),
            'options' => [
                'prompt' => Yii::t('common', 'Please Select...'),
                'encode' => false,
            ],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]) ?>

        <?= $form->field($model, 'contact', ['options' => ['class' => 'form-group c-md-5']])->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'mobile', ['options' => ['class' => 'form-group c-md-5']])->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'address', ['options' => ['class' => 'form-group c-md-5']])->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'goods_name', ['options' => ['class' => 'form-group c-md-5']])->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'goods_weight', ['options' => ['class' => 'form-group c-md-5']])
            ->textInput(['maxlength' => true])
            ->hint('单位：千克')
        ?>

        <?= $form->field($model, 'goods_volume', ['options' => ['class' => 'form-group c-md-5']])
            ->textInput(['maxlength' => true])
            ->hint('单位：方')
        ?>

        <?= $form->field($model, 'goods_number', ['options' => ['class' => 'form-group c-md-5']])->textInput() ?>

        <?php //= $form->field($model, 'estimate_price', ['options' => ['class' => 'form-group c-md-5']])->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'remark', ['options' => ['class' => 'form-group c-md-6']])->textarea(['rows' => 6]) ?>

        <div class="form-group">
            <?= Html::button('估算价格', ['id' => 'calc-price', 'class' => 'btn btn-warning pull-left', 'style' => 'margin-left:15%']) ?>
            <?= Html::submitButton('提交预约', ['class' => 'btn btn-success pull-right', 'style' => 'margin-right:15%']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
<?php
$url = Url::to(['calc-price']);
$js = <<<JS
//todo,这个js验证还是不完善
$('#calc-price').on('click', function(e) {
    $('#pre-order-form').yiiActiveForm('validateAttribute', 'preorder-region_id');
    $('#pre-order-form').yiiActiveForm('validateAttribute', 'preorder-goods_volume');
    $('#pre-order-form').yiiActiveForm('validateAttribute', 'preorder-goods_weight');
    $('#pre-order-form').yiiActiveForm('validateAttribute', 'preorder-goods_number');
    
    var weight=$('#preorder-goods_weight').val();
    var volume=$('#preorder-goods_volume').val();
    var number=$('#preorder-goods_number').val();
    var region_id=$('#preorder-region_id').val();
    if(!weight || !volume || !number || !region_id){
        return false;
    }
    $.ajax({
            url: "{$url}",
            type: 'post',
            dataType: "json",
            data: {
                weight:weight,
                volume:volume,
                number:number,
                region_id:region_id,
            },
            success: function (data) {
                if(data.estimate_price==0){
                    krajeeDialog.alert('未查询到相关价格，您可以提交预约，我们工作人员会尽快联系您');
                }else{
                    krajeeDialog.alert('预计运费价格为：'+data.estimate_price+'元');
                }
            }
        });
})
JS;

$this->registerJs($js);
?>