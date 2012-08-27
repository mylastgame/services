<?php
$this->breadcrumbs=array(
	'Car Parts'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List CarPart', 'url'=>array('index')),
	array('label'=>'Manage CarPart', 'url'=>array('admin')),
);
?>

<h1>Create CarPart</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>