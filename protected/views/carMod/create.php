<?php
$this->breadcrumbs=array(
	'Car Mods'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List CarMod', 'url'=>array('index')),
	array('label'=>'Manage CarMod', 'url'=>array('admin')),
);
?>

<h1>Create CarMod</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>