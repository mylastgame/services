<? $this->breadcrumbs=array(
	'Запчасти для ТО'=>'/to',
   'Автомобили'=>'/to',
   $mark->name=>'/to/mark/'.$mark->id,
   $model->name=>'/to/model/'.$model->id,
   $mod->name
); ?>
<? $form = $this->beginWidget('bootstrap.widgets.BootActiveForm', array(
    'id'=>'modForm',
    'type'=>'inline',            
    'htmlOptions'=>array('class'=>'well', 'style'=>'text-align:left'),
)); ?>
<?php echo $form->errorSummary($mod, 'Не правильный формат данных:'); ?>
<?php echo $form->textFieldRow($mod, 'name', array('class'=>'span5')); ?>    
<?php echo $form->error($mod, 'name'); ?>
<?php $this->widget('bootstrap.widgets.BootButton', array('buttonType'=>'submit', 'icon'=>'ok', 'label'=>'Сохранить')); ?>
<?php $this->endWidget(); ?>
