<?php
$this->breadcrumbs=array(
	'Car Mods'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List CarMod', 'url'=>array('index')),
	array('label'=>'Create CarMod', 'url'=>array('create')),
	array('label'=>'Update CarMod', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete CarMod', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage CarMod', 'url'=>array('admin')),
);
?>

<h1>View CarMod #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'model_id',
		'name',
	),
)); ?>
