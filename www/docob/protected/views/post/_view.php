<?php
/* @var $this PostController */
/* @var $data Post */
?>


<div class="view">

    <?php echo CHtml::link(CHtml::encode($data->title), array('view', 'id'=>$data->id)); ?>
    <br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Статус')); ?>:</b>
    <?php echo CHtml::encode(Lookup::item("PostStatus",$data->status)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Дата добавления')); ?>:</b>
    <?php echo CHtml::encode(date("d.m.Y H:i:s",$data->create_time)); ?>
	<br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('Автор')); ?>:</b>
    <?php
    $record=User::model()->findByAttributes(array('id'=>$data->author_id));
    echo CHtml::encode($record->username); ?>
    <br />

</div>