<?php

use backend\models\RegionPrice;
use kartik\widgets\Select2;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\dialog\Dialog;

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

        <?=$form->field($model,'region_id', ['options' => ['class' => 'form-group c-md-5']])
            ->dropDownList(RegionPrice::getRegionOptions(false, '潍坊'),['prompt' => Yii::t('common', 'Please Select...')])
        ?>

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

        <?= $form->field($model, 'remark', ['options' => ['class' => 'form-group c-md-6']])
            ->textarea(['rows' => 6])
            ->hint('如需上门取货，送货上门等增值业务具体费用请咨询客服。最终解释权归华昶物流所有。')
        ?>

        <div class="form-group">
            <?= Html::button('估算价格', ['id' => 'calc-price', 'class' => 'btn btn-warning pull-left', 'style' => 'margin-left:15%']) ?>
            <?= Html::submitButton('提交预约', ['class' => 'btn btn-success pull-right', 'style' => 'margin-right:15%']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
    <!--引入弹出框小部件-->
<?= Dialog::widget([
    'libName' => 'krajeeDialog',
    'options' => [
        'draggable' => true,
        'title' => '估算运费',
        'type'=>Dialog::TYPE_WARNING
    ]
]);
?>
<?= \common\widgets\Popup::widget([
    'second'=>0//设置为一直存在
]) ?>
<?php
$url = Url::to(['calc-price']);
//todo，通过设置延迟来实现正确的判定，但这仅仅是个取巧的方法
$js = <<<JS
$('#calc-price').on('click', function(e) {
    $('#pre-order-form').yiiActiveForm('validateAttribute', 'preorder-region_id');
    $('#pre-order-form').yiiActiveForm('validateAttribute', 'preorder-goods_volume');
    $('#pre-order-form').yiiActiveForm('validateAttribute', 'preorder-goods_weight');
    $('#pre-order-form').yiiActiveForm('validateAttribute', 'preorder-goods_number');
    setTimeout(function(){
        if($('#pre-order-form').find('.has-error').length){
            return false;
        }
        var weight=$('#preorder-goods_weight').val();
        var volume=$('#preorder-goods_volume').val();
        var number=$('#preorder-goods_number').val();
        var region_id=$('#preorder-region_id').val();
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
    }, 1000);
})
JS;

$this->registerJs($js);
?>