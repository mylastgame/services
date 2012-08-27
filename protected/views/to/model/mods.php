<? $this->breadcrumbs=array(
	'Запчасти для ТО'=>'/to',
   'Автомобили'=>'/to',
   $mark->name=>'/to/mark/'.$mark->id,
   $model->name
); ?>
<? $this->widget('bootstrap.widgets.BootGridView', array(
    'type'=>'striped bordered condensed',
    'htmlOptions'=>array('style'=>'width: 500px'),
    'dataProvider'=>$mods,
    'summaryText'=>'Модели {start}-{end} из {count}',
    'template'=>'{summary} {items} {pager}',    
    'columns'=>array(
        array('name'=>'name', 'header'=>'Модификации', 'type'=>'html', 'value'=>'CHtml::link($data->name, \'/to/mod/\'.$data->id)'),
        array(
            'class'=>'bootstrap.widgets.BootButtonColumn',
            'deleteConfirmation'=>'Удалить выбранную модификацию?',
            'buttons' => array(
            'view' => array(
               'label' => 'Просмотр',
               'url' => '\'/to/mod/\'.$data->id',               
            ),
            'update' => array(
               'label' => 'Изменить',
               'url' => '\'/to/mod/update/\'.$data->id',               
            ),
            'delete' => array(
               'label' => 'Удалить',
               'url' => '\'/to/mod/delete/\'.$data->id',               
            )
         ),
         'template' => '{view} {update} {delete}'
            
        )
    )
));
?>
<? echo CHtml::link('<i class="icon-plus"></i>&nbspДобавить модификацию', '/to/'.$model->id.'/mod/create', array('class'=>'btn btn-primary')); ?>