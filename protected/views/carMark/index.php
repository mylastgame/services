<?php
$this->breadcrumbs=array(
	'Car Marks',
);

$this->menu=array(
	array('label'=>'Create CarMark', 'url'=>array('create')),
	array('label'=>'Manage CarMark', 'url'=>array('admin')),
);
?>

<h1>Car Marks</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
