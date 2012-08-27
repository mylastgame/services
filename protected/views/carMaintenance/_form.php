<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'car-maintenance-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'mark_id'); ?>
		<?php echo $form->textField($model,'mark_id'); ?>
		<?php echo $form->error($model,'mark_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'model_id'); ?>
		<?php echo $form->textField($model,'model_id'); ?>
		<?php echo $form->error($model,'model_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'mod_id'); ?>
		<?php echo $form->textField($model,'mod_id'); ?>
		<?php echo $form->error($model,'mod_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'maintenance_order'); ?>
		<?php echo $form->textField($model,'maintenance_order',array('size'=>3,'maxlength'=>3)); ?>
		<?php echo $form->error($model,'maintenance_order'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'part_id'); ?>
		<?php echo $form->textField($model,'part_id'); ?>
		<?php echo $form->error($model,'part_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'amount'); ?>
		<?php echo $form->textField($model,'amount'); ?>
		<?php echo $form->error($model,'amount'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'distance'); ?>
		<?php echo $form->textField($model,'distance'); ?>
		<?php echo $form->error($model,'distance'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'comment'); ?>
		<?php echo $form->textField($model,'comment',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'comment'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->