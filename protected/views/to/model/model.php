<? $this->breadcrumbs=array(
	'Запчасти для ТО'=>'/to',
   'Автомобили'=>'/to',
   $mark->name=>'/to/mark/'.$mark->id,
   $model->name
); ?>
<? $form = $this->beginWidget('bootstrap.widgets.BootActiveForm', array(
    'id'=>'modelForm',
    'type'=>'inline',            
    'htmlOptions'=>array('class'=>'well', 'style'=>'text-align:left'),
)); ?>
<?php echo $form->errorSummary($model, 'Не правильный формат данных:'); ?>
<?php echo $form->textFieldRow($model, 'name', array('class'=>'span5')); ?>    
<?php echo $form->error($model, 'name'); ?>
<?php $this->widget('bootstrap.widgets.BootButton', array('buttonType'=>'submit', 'icon'=>'ok', 'label'=>'Сохранить')); ?>
<?php $this->endWidget(); ?>
