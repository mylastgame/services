<?php
$this->breadcrumbs=array(
	'Car Mods'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List CarMod', 'url'=>array('index')),
	array('label'=>'Create CarMod', 'url'=>array('create')),
	array('label'=>'View CarMod', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage CarMod', 'url'=>array('admin')),
);
?>

<h1>Update CarMod <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>