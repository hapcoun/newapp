<?php
/* @var $this PostController */
/* @var $model Post */

$this->breadcrumbs=array(
	'Documents'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Документы', 'url'=>array('index')),
);
?>

<h1>Создать документ</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>