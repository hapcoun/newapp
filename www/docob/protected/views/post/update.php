<?php
/* @var $this PostController */
/* @var $model Post */

$this->breadcrumbs=array(
	'Documents'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'Документы', 'url'=>array('index')),
	array('label'=>'Создать', 'url'=>array('create')),
	array('label'=>'Посмотреть', 'url'=>array('view', 'id'=>$model->id)),
);
?>

<h1>Обновить документ - <?php echo $model->title; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>