<? $this->breadcrumbs=array(
	'Запчасти для ТО'=>'/to',
   'Запчасти'
); ?>
<div class="margin_bottom"><? echo CHtml::link('<i class="icon-plus"></i>&nbspДобавить запчасть', '/to/part/create', array('class'=>'btn btn-primary')); ?></div>
<? $this->widget('bootstrap.widgets.BootGridView', array(
    'type'=>'striped bordered condensed',
    'htmlOptions'=>array('class'=>'span12', 'style'=>'display:block;'),
    'dataProvider'=>$model->search(),
    'summaryText'=>'Запчасти {start}-{end} из {count}',
    'template'=>'{summary} {items} {pager}',    
    'filter'=>$model,
    'pager'=>array(
        'class'=>'bootstrap.widgets.BootPager',
        'displayFirstAndLast'=>true,
        'maxButtonCount'=>5,
        'nextPageLabel'=>'&rarr;',
        'prevPageLabel'=>'&larr;',
        'firstPageLabel'=>1        
        
    ),
    'columns'=>array(
        array('name'=>'article', 'header'=>'Артикул', 'type'=>'text'),
        array('name'=>'name', 'header'=>'Наименование', 'type'=>'text'),
        array(
            'name'=>'brand_id',
            'sortable'=>true,
            'header'=>'Производитель', 
            'type'=>'text', 
            'value'=>'$data->CarMark ? $data->CarMark->name : ""',
            'filter'=>$marks
        ),
        array(
            'class'=>'bootstrap.widgets.BootButtonColumn',
            'deleteConfirmation'=>'Удалить выбранную запчасть?',
            'buttons' => array(
               'update' => array(
                  'label' => 'Изменить',
                  'url' => '\'/to/part/update/\'.$data->id',               
               ),
               'delete' => array(
                  'label' => 'Удалить',
                  'url' => '\'/to/part/delete/\'.$data->id',               
               )
         ),
         'template' => '{update} {delete}'
            
        )
    )
));
?>
