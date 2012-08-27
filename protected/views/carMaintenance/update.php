<?php
$this->breadcrumbs=array(
	'Car Maintenances'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List CarMaintenance', 'url'=>array('index')),
	array('label'=>'Create CarMaintenance', 'url'=>array('create')),
	array('label'=>'View CarMaintenance', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage CarMaintenance', 'url'=>array('admin')),
);
?>

<h1>Update CarMaintenance <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>