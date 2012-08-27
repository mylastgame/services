<?php
$this->breadcrumbs=array(
	'Car Parts'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List CarPart', 'url'=>array('index')),
	array('label'=>'Create CarPart', 'url'=>array('create')),
	array('label'=>'View CarPart', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage CarPart', 'url'=>array('admin')),
);
?>

<h1>Update CarPart <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>