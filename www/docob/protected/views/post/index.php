<?php
/* @var $this PostController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Documents',
);

$this->menu=array(
	array('label'=>'Создать', 'url'=>array('create')),
);
?>

<h1>Документы</h1>

<?php $this->beginWidget('CActiveForm', array(
    'htmlOptions'=>array('enctype'=>'multipart/form-data'),
    'enableAjaxValidation'=>true,
)); ?>
  <div class="row">
  <?php echo 'Выбрать:' ?>
      <?=CHtml::dropDownList('dropdown', $model, Lookup::items('PostStatus'),
      array('ajax' => array('update' => '#docs_list',
          'url' => $this->createUrl('post/ajax'),
          'data' => 'js:"id="+this.value',
          'cache' => false,),'empty' => array('0'=>'Все'))); ?>
  </div>

      <div id="docs_list">
         <?php $this->widget('zii.widgets.CListView', array(
          'dataProvider'=>$dataProvider,
          'itemView'=>'_view',
          'template'=>"{items}\n{pager}",
          ));?>
      </div>



<?php $this->endWidget(); ?>