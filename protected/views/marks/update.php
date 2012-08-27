<?php
$this->breadcrumbs=array(
	'Marks'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Marks', 'url'=>array('index')),
	array('label'=>'Create Marks', 'url'=>array('create')),
	array('label'=>'View Marks', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Marks', 'url'=>array('admin')),
);
?>

<h1>Update Marks <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>