<?php
/* @var $this PostController */
/* @var $model Post */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
    'htmlOptions'=>array('enctype'=>'multipart/form-data'),
	'id'=>'post-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'Заголовок'); ?>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Комментарий'); ?>
		<?php echo $form->textArea($model,'content',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'content'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Статус'); ?>
        <?php echo $form->dropDownList($model,'status',Lookup::items('PostStatus')); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

    <?php /* поле для загрузки файла */ ?>
    <div class="field">
        <?php if($model->document): ?>
        <p><?php echo CHtml::encode($model->document); ?></p>
        <?php endif; ?>
        <?php echo $form->labelEx($model,'Документ'); ?>
        <?php echo $form->fileField($model,'document'); ?>
        <?php echo $form->error($model,'document'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'Кто может просматривать:'); ?>
        <?php echo CHtml::activeListBox($model, 'dostup', CHtml::listData(User::model()->findAll("id != :id", array(":id" => Yii::app()->user->id)), 'id', 'username'),array('multiple'=>'multiple'));?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->