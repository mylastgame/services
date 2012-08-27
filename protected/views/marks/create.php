<?php
$this->breadcrumbs=array(
	'Marks'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Marks', 'url'=>array('index')),
	array('label'=>'Manage Marks', 'url'=>array('admin')),
);
?>

<h1>Create Marks</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>