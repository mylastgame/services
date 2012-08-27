<?php
$this->breadcrumbs=array(
	'Car Parts',
);

$this->menu=array(
	array('label'=>'Create CarPart', 'url'=>array('create')),
	array('label'=>'Manage CarPart', 'url'=>array('admin')),
);
?>

<h1>Car Parts</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
