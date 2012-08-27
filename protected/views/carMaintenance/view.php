<?php
$this->breadcrumbs=array(
	'Car Maintenances'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List CarMaintenance', 'url'=>array('index')),
	array('label'=>'Create CarMaintenance', 'url'=>array('create')),
	array('label'=>'Update CarMaintenance', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete CarMaintenance', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage CarMaintenance', 'url'=>array('admin')),
);
?>

<h1>View CarMaintenance #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'mark_id',
		'model_id',
		'mod_id',
		'maintenance_order',
		'part_id',
		'amount',
		'distance',
		'comment',
	),
)); ?>
