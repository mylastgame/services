<?php
$this->breadcrumbs=array(
	'Car Maintenances'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List CarMaintenance', 'url'=>array('index')),
	array('label'=>'Manage CarMaintenance', 'url'=>array('admin')),
);
?>

<h1>Create CarMaintenance</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>