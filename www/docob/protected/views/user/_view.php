<?php
/* @var $this UserController */
/* @var $data User */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('Логин')); ?>:</b>
    <?php echo CHtml::link(CHtml::encode($data->username), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Электронная почта')); ?>:</b>
	<?php echo CHtml::encode($data->email); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Профиль')); ?>:</b>
	<?php echo CHtml::encode($data->profile); ?>
	<br />


</div>