<? $this->breadcrumbs=array(
	'Запчасти для ТО'=>'/to',
   'Автомобили'=>'/to',
   $maintenance->CarMark->name=>'/to/mark/'.$maintenance->CarMark->id,
   $maintenance->CarModel->name=>'/to/model/'.$maintenance->CarModel->id,
   $maintenance->CarMod->name=>'/to/mod/'.$maintenance->id,
   'Редактирование информации о ТО' 
); ?>
<?php $form = $this->beginWidget('bootstrap.widgets.BootActiveForm', array('type'=>'horizontal', 'htmlOptions'=>array('class'=>'well')));?>
<?php echo $form->errorSummary($maintenance, 'Не правильный формат данных:'); ?>
<?php echo $form->textFieldRow($maintenance, 'maintenance_interval', array('class'=>'span1', 'append'=>' 000км')); ?>    
<?php echo $form->error($maintenance, 'maintenance_interval'); ?>
<?php echo $form->textFieldRow($maintenance, 'number', array('class'=>'span1')); ?>    
<?php echo $form->error($maintenance, 'number'); ?>
<div class="form-actions">
<?php $this->widget('bootstrap.widgets.BootButton', array('buttonType'=>'submit', 'type'=>'primary', 'icon'=>'ok', 'label'=>'Сохранить', 'htmlOptions'=>array(''))); ?>
</div>
<?php $this->endWidget();?>
