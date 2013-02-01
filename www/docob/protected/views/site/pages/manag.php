<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name . ' - Manager';
$this->breadcrumbs=array(
    'Manager',
);
?>
<h1>Администратор</h1>

<p>Инструменты управления:)</p>
<ul>
    <?php echo CHtml::link("Документация", Yii::app()->request->baseUrl.'/index.php?r=post/admin')?>
    <?php echo CHtml::link("Пользователи", Yii::app()->request->baseUrl.'/index.php?r=user/admin')?>
</ul>
