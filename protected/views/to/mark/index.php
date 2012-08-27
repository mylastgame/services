<? $this->breadcrumbs=array(
	'Запчасти для ТО'=>'/to',
   'Автомобили' 
); ?>
<? $this->widget('bootstrap.widgets.BootGridView', array(
    'type'=>'striped bordered condensed',
    'htmlOptions'=>array('style'=>'width: 500px'),
    'dataProvider'=>$marks,
    'summaryText'=>'Марки {start}-{end} из {count}',
    'template'=>'{summary} {items} {pager}',    
    'columns'=>array(
        array('name'=>'name', 'header'=>'Марки', 'type'=>'html', 'value'=>'CHtml::link($data->name, array(\'/to/mark/\'.$data->id))'),
        array(
            'class'=>'bootstrap.widgets.BootButtonColumn',
            'deleteConfirmation'=>'Удалить выбранную марку?',
            'buttons' => array(
            'view' => array(
               'label' => 'Просмотр',
               'url' => '\'to/mark/\'.$data->id',               
            ),
            'update' => array(
               'label' => 'Изменить',
               'url' => '\'to/mark/update/\'.$data->id',               
            ),
            'delete' => array(
               'label' => 'Удалить',
               'url' => '\'to/mark/delete/\'.$data->id',               
            )
         ),
         'template' => '{view} {update} {delete}'
            
        )
    )
)); ?>
<? echo CHtml::link('<i class="icon-plus"></i>&nbspДобавить марку', '/to/mark/create', array('class'=>'btn btn-primary')); ?>
