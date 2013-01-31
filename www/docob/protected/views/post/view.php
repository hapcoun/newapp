<?php
/* @var $this PostController */
/* @var $model Post */

$this->breadcrumbs=array(
	'Documents'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'Документы', 'url'=>array('index')),
	array('label'=>'Создать', 'url'=>array('create')),
	array('label'=>'Обновить', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Удалить', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
);
?>

<h1><?php echo $model->title; ?></h1>

<?php echo 'Автор ';
$record=User::model()->findByAttributes(array('id'=>$model->author_id));
echo CHtml::encode($record->username); ?>

<?php $this->widget('zii.widgets.CDetailView', array(
    'data'=>$model,
    'attributes'=>array(
        array(
            'label'=>'Комментарий',
            'name'=>'content',
        ),
        array(
            'label'=>'Статус',
            'name'=>'status',
            'value'=>CHtml::encode(Lookup::item('PostStatus',$model->status)),
        ),
        array(
            'label'=>'Дата добавления',
            'name'=>'create_time',
            'type'=>'datetime',
        ),
        array(
            'label'=>'Дата обновления',
            'name'=>'update_time',
            'type'=>'datetime',
        ),
        array(
            'label'=>'Документ',
            'name'=>'document',
            'type'=>'raw',
            'value'=>CHtml::link("Скачать", 'http://newapp/docob/protected/upload/'.$model->create_time.'_'. $model->document)
        ),

    ),
)); ?>

