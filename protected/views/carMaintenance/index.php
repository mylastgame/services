<?php
$this->breadcrumbs=array(
	'Car Maintenances',
);

$this->menu=array(
	array('label'=>'Create CarMaintenance', 'url'=>array('create')),
	array('label'=>'Manage CarMaintenance', 'url'=>array('admin')),
);
?>

<h1>Car Maintenances</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
