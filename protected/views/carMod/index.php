<?php
$this->breadcrumbs=array(
	'Car Mods',
);

$this->menu=array(
	array('label'=>'Create CarMod', 'url'=>array('create')),
	array('label'=>'Manage CarMod', 'url'=>array('admin')),
);
?>

<h1>Car Mods</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
