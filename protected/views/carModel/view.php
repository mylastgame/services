<?php
$this->breadcrumbs=array(
	'Car Models'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List CarModel', 'url'=>array('index')),
	array('label'=>'Create CarModel', 'url'=>array('create')),
	array('label'=>'Update CarModel', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete CarModel', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage CarModel', 'url'=>array('admin')),
);
?>

<h1>View CarModel #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'mark_id',
		'name',
	),
)); ?>
