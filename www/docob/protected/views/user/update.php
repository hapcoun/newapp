<?php
/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs=array(
	'Users'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'Пользователи', 'url'=>array('index')),
	array('label'=>'Просмотр', 'url'=>array('view', 'id'=>$model->id)),
);
?>

<h1>Профиль пользователя - <?php echo $model->username; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>