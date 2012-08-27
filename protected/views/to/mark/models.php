<? $this->breadcrumbs=array(
	'Запчасти для ТО'=>'/to',
   'Автомобили'=>'/to',
   $mark->name
); ?>
<? $this->widget('bootstrap.widgets.BootGridView', array(
    'type'=>'striped bordered condensed',
    'htmlOptions'=>array('style'=>'width: 500px'),
    'dataProvider'=>$models,
    'summaryText'=>'Модели {start}-{end} из {count}',
    'template'=>'{summary} {items} {pager}',    
    'columns'=>array(
        array('name'=>'name', 'header'=>'Модели', 'type'=>'html', 'value'=>'CHtml::link($data->name, \'/to/model/\'.$data->id)'),
        array(
            'class'=>'bootstrap.widgets.BootButtonColumn',
            'deleteConfirmation'=>'Удалить выбранную модель?',
            'buttons' => array(
            'view' => array(
               'label' => 'Просмотр',
               'url' => '\'/to/model/\'.$data->id',               
            ),
            'update' => array(
               'label' => 'Изменить',
               'url' => '\'/to/model/update/\'.$data->id',               
            ),
            'delete' => array(
               'label' => 'Удалить',
               'url' => '\'/to/model/delete/\'.$data->id',               
            )
         ),
         'template' => '{view} {update} {delete}'
            
        )
    )
));
?>
<? echo CHtml::link('<i class="icon-plus"></i>&nbspДобавить модель', '/to/'.$mark->id.'/model/create', array('class'=>'btn btn-primary')); ?>