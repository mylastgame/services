<?php
$this->breadcrumbs=array(
	'Car Marks'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List CarMark', 'url'=>array('index')),
	array('label'=>'Create CarMark', 'url'=>array('create')),
	array('label'=>'View CarMark', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage CarMark', 'url'=>array('admin')),
);
?>

<h1>Update CarMark <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>