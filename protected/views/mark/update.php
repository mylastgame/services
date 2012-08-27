<?php
$this->breadcrumbs=array(
	'Marks'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Mark', 'url'=>array('index')),
	array('label'=>'Create Mark', 'url'=>array('create')),
	array('label'=>'View Mark', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Mark', 'url'=>array('admin')),
);
?>

<h1>Update Mark <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>