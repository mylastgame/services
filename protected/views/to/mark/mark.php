<? $this->breadcrumbs=array(
	'Запчасти для ТО'=>'/to',
   'Автомобили'=>'/to',
   'Редактирование марки '.$mark->name
); ?>
<? $form = $this->beginWidget('bootstrap.widgets.BootActiveForm', array(
    'id'=>'markForm',
    'type'=>'horizontal',            
    'htmlOptions'=>array('class'=>'well', 'style'=>'text-align:left', 'enctype' => 'multipart/form-data'),
)); ?>
<?php echo $form->errorSummary($mark, 'Не правильный формат данных:'); ?>
<?php echo $form->textFieldRow($mark, 'name', array('class'=>'input-big')); ?>    
<?php echo $form->checkboxRow($mark, 'car_brand'); ?>
<?php echo $form->checkboxRow($mark, 'part_brand'); ?>
<?php echo $form->fileFieldRow($image, 'name'); ?>
<? if($image->name) echo '<img src="/images/'.$image->name.'" style="margin-left:160px">' ?>
<div class="form-actions">
<?php $this->widget('bootstrap.widgets.BootButton', array('buttonType'=>'submit', 'icon'=>'ok', 'label'=>'Сохранить')); ?>
</div>
<?php $this->endWidget(); ?>
