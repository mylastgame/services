<?php
$this->breadcrumbs=array(
	'Car Models',
);

$this->menu=array(
	array('label'=>'Create CarModel', 'url'=>array('create')),
	array('label'=>'Manage CarModel', 'url'=>array('admin')),
);
?>

<h1>Car Models</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
