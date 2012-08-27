<? $this->breadcrumbs=array(
	'Запчасти для ТО'=>'/to',
   'Запчасти'=>'/to/part',
   'Редактирование запчасти '.$part->name
); ?>
<? $form = $this->beginWidget('bootstrap.widgets.BootActiveForm', array(
    'id'=>'partForm',
    'type'=>'horizontal',            
    'htmlOptions'=>array('class'=>'well', 'style'=>'text-align:left'),
)); ?>
<?php echo $form->errorSummary($part, 'Не правильный формат данных:'); ?>
<?php echo $form->textFieldRow($part, 'article', array('class'=>'input-big')); ?>    
<?php echo $form->textFieldRow($part, 'name', array('class'=>'input-big')); ?>    
<?php echo $form->dropDownListRow($part, 'brand_id', $marks, array('empty'=>'Нет производителя')); ?>
<div class="form-actions">
<?php $this->widget('bootstrap.widgets.BootButton', array('buttonType'=>'submit', 'type'=>'primary', 'icon'=>'ok', 'label'=>'Сохранить')); ?>
</div>
<?php $this->endWidget(); ?>