<?php
$this->breadcrumbs=array(
	'Car Marks'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List CarMark', 'url'=>array('index')),
	array('label'=>'Manage CarMark', 'url'=>array('admin')),
);
?>

<h1>Create CarMark</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>