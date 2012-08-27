<? Yii::app()->clientScript->registerScript('maintenancePartDelete', '
   var part = {};
   part.maintenance = '.$maintenance_json.';       
   part.maintenance_order = '.$maintenance_order_json.';       
   part.showDeleteModal = function(el, order, all){      
      order = order ? order : part.maintenance_order;
      if(!confirm("Убрать запчасть?"))
         return;
      $.ajax({
         url: "/to/maintenance/"+part.maintenance.id+"/order/"+order+"/delete",
         data: {part_id: $(el).attr("part_id"), all: all},
         type: "POST",
         success: function(data){            
            $.fn.yiiGridView.update($(el).parents("table").parent().attr("id"));
         }
      });
   }
', CClientScript::POS_READY ) ?>
<? $this->breadcrumbs=array(
	'Запчасти для ТО'=>'/to',
   'Автомобили'=>'/to',
   $maintenance->CarMark->name=>'/to/mark/'.$maintenance->CarMark->id,
   $maintenance->CarModel->name=>'/to/model/'.$maintenance->CarModel->id,
   $maintenance->CarMod->name
); ?>
<? echo CHtml::link('<i class="icon-wrench"></i>&nbspРедактировать информацию о ТО', '/to/'.$maintenance->CarMod->id.'/maintenance/update', array('class'=>'btn btn-primary')); ?>
<? $this->widget('application.components.MaintenanceList', array('maintenance'=>$maintenance, 'maintenance_order'=>$maintenance_order)); ?>
ТО №<?=$maintenance_order?>, пробег - <?=$maintenance->maintenance_interval*$maintenance_order?> 000 км.
<div class="divider"></div>
<? $this->widget('bootstrap.widgets.BootGridView', array(
    'type'=>'striped bordered condensed',
    'htmlOptions'=>array('class'=>'span10'),
    'dataProvider'=>$parts,    
    'template'=>'{items}',    
    'columns'=>array(
        array('header'=>'Артикул', 'type'=>'text', 'value'=>'$data->CarPart->article'),
        array('header'=>'Наименование', 'type'=>'text', 'value'=>'$data->CarPart->name'),
        array('name'=>'amount', 'header'=>'Количество', 'type'=>'text', 'sortable'=>false),        
        array('name'=>'comment', 'header'=>'Комментарий', 'type'=>'text', 'sortable'=>false),
        array(
            //'class'=>'bootstrap.widgets.BootButtonColumn',
            'class'=>'application.components.DataButtonColumn',
            'deleteConfirmation'=>'Убрать выбранную деталь?',
            'buttons' => array(            
            'update' => array(
               'label' => 'Изменить',
               'url' => '\'/to/maintenance/\'.$data->maintenance_id.\'/part/\'.$data->CarPart->id.\'/edit\'',               
            ),
            'delete' => array(
               'label' => 'Убрать',
               'options'=>array('data'=>array('part_id'=>'id')),               
               'icon'=>'remove',
               'click'=>'function(event){ 
                           event.preventDefault(); 
                           part.showDeleteModal(this, false, \'one\');                           
                        }'                
            ),
            'delete_all' => array(
               'label' => 'Убрать из всех ТО',                       
               'icon'=>'remove-sign',
               'options'=>array('data'=>array('part_id'=>'id')),     
               'click'=>'function(event){ 
                           event.preventDefault(); 
                           part.showDeleteModal(this, false, \'all\');
                        }'
            )
         ),
         'template' => '{update} {delete} {delete_all}'
            
        )
    )
)); ?>
<div class="margin_bottom"><? echo CHtml::link('<i class="icon-plus"></i>&nbspДобавить деталь', '/to/maintenance/'.$maintenance->id.'/order/'.$maintenance_order.'/create', array('class'=>'btn btn-primary')); ?></div>
Замена по мере износа:
<? $this->widget('bootstrap.widgets.BootGridView', array(
    'type'=>'striped bordered condensed',
    'htmlOptions'=>array('class'=>'span10'),
    'dataProvider'=>$parts_all,    
    'template'=>'{items}',    
    'columns'=>array(
        array('header'=>'Артикул', 'type'=>'text', 'value'=>'$data->CarPart->article'),
        array('header'=>'Наименование', 'type'=>'text', 'value'=>'$data->CarPart->name'),
        array('name'=>'amount', 'header'=>'Количество', 'type'=>'text', 'sortable'=>false),        
        array('name'=>'comment', 'header'=>'Комментарий', 'type'=>'text', 'sortable'=>false),
        array(
            'class'=>'application.components.DataButtonColumn',
            'deleteConfirmation'=>'Удалить выбранную модификацию?',
            'buttons' => array(            
            'update' => array(
               'label' => 'Изменить',
               'url' => '\'/to/maintenance/\'.$data->maintenance_id.\'/part/\'.$data->CarPart->id.\'/edit\'',         
            ),
            'delete' => array(
               'label' => 'Убрать',
               'options'=>array('data'=>array('part_id'=>'id')),               
               'icon'=>'remove',
               'click'=>'function(event){ 
                           event.preventDefault(); 
                           part.showDeleteModal(this, \'all\', \'one\');                           
                        }'                
            )          
         ),
         'template' => '{update} {delete}'
            
        )
    )
)); ?>
<div class="margin_bottom"><? echo CHtml::link('<i class="icon-plus"></i>&nbspДобавить деталь', '/to/maintenance/'.$maintenance->id.'/order/all/create', array('class'=>'btn btn-primary')); ?></div>