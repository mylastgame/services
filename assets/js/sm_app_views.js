//Models Views
SM_APP.views.Item = Backbone.View.extend({
   tagName: 'span',            
   render: function(){      
      $(this.el).html(this.model.get('name'));
      return this;
   }   
});

SM_APP.views.MarkView = SM_APP.views.Item.extend({   
   initialize: function(options){
      this.on('markPage', SM_APP.controller.initialize, SM_APP.controller);
   },
   events: {
      'click': function(){ this.trigger('markPage', { mark: this.model } )}
   }
});

SM_APP.views.ModelView = SM_APP.views.Item.extend({
   initialize: function(options){
      this.on('modelPage', SM_APP.controller.initialize, SM_APP.controller);
   },
   events: {
      'click': function(){ this.trigger('modelPage', { model: this.model } )}
   }
});

SM_APP.views.ModView = SM_APP.views.Item.extend({
   initialize: function(options){
      this.on('modPage', SM_APP.controller.initialize, SM_APP.controller);
   },
   events: {
      'click': function(){ this.trigger('modPage', { mod: this.model } )}
   }
});

SM_APP.views.MaintenanceView = Backbone.View.extend({
   initialize: function(options){
      this.on('modPage', SM_APP.controller.initialize, SM_APP.controller);
   },
   tagName: 'span', 
   render: function(){      
      $(this.el).html(this.model.get('maintenance_order'));
      return this;
   },  
   events: {
      'click': function(){ this.trigger('modPage', { mod: SM_APP.controller.history.mod, maintenance: this.model } )}
   }
});

SM_APP.views.PartView = Backbone.View.extend({
   initialize: function(options){
      
   },
   template: '<td class=\'sm_app-parts-article-cell\'><%= article %></td><td><%= name %></td><td><%= amount %></td><td><%= comment %></td>',   
   tagName: 'tr', 
   render: function(){            
      $(this.el).html(_.template(this.template, this.model.attributes));
      return this;
   },  
   events: {
      
   }
});


//Collections views
SM_APP.views.CollectionView = Backbone.View.extend({   
   childClass: '',
   render: function(){            
      var that = this;        
      _(this._childViews).each(function(cV){             
         $(that.el).append(cV.render().el);
      });                              
      return this;
   }
});  

SM_APP.views.MarksView = SM_APP.views.CollectionView.extend({
   childClass: 'sm_app-marks-set',
   initialize: function(options){            
      var that = this;
      this._childViews = [];        
      this.collection.each(function(child){                  
         that._childViews.push(new SM_APP.views.MarkView({
            model: child,
            className: that.childClass
         }));
      });
   }
});

SM_APP.views.ModelsView = SM_APP.views.CollectionView.extend({
   childClass: 'sm_app-models-set',
   initialize: function(options){            
      var that = this;
      this._childViews = [];        
      this.collection.each(function(child){                  
         that._childViews.push(new SM_APP.views.ModelView({
            model: child,
            className: that.childClass
         }));
      });
   }
});

SM_APP.views.ModsView = SM_APP.views.CollectionView.extend({
   childClass: 'sm_app-mods-set',
   initialize: function(options){            
      var that = this;
      this._childViews = [];        
      this.collection.each(function(child){             
         that._childViews.push(new SM_APP.views.ModView({
            model: child,
            className: that.childClass
         }));
      });
   }
});

SM_APP.views.MaintenancesView = SM_APP.views.CollectionView.extend({
   childClass: 'sm_app-maintenances-set',
   initialize: function(options){            
      var that = this;
      this._childViews = [];        
      this.collection.each(function(child){                   
         if(child.get('maintenance_order') == options.current.get('maintenance_order'))
            that.childClass = 'sm_app-maintenances-set-current';
         else
            that.childClass = 'sm_app-maintenances-set';
         that._childViews.push(new SM_APP.views.MaintenanceView({
            model: child,
            className: that.childClass
         }));
      });
   }
});

SM_APP.views.PartsView = SM_APP.views.CollectionView.extend({
   childClass: 'sm_app-parts-row',
   tagName: 'table',
   initialize: function(options){            
      var that = this;
      this._childViews = [];        
      this.collection.each(function(child){             
         that._childViews.push(new SM_APP.views.PartView({
            model: child,
            className: that.childClass
         }));
      });
   }
});


//Page views
SM_APP.views.PageView = Backbone.View.extend({
   template: "<div id='sm_app-header'></div><div id='sm_app-collection'></div>",
   initialize: function(options){
      
   },   
   render: function(){        
      $(this.el).html(_.template(this.template, {}));         
      return this;
   }
});

SM_APP.views.IndexPageView = SM_APP.views.PageView.extend({
   template: "<div id='sm_app-header-wrap'>Выбирете марку:</div><div id='sm_app-collection'></div>"
});

SM_APP.views.MarkPageView = SM_APP.views.PageView.extend({
   template: "<div id='sm_app-header-wrap'><span id='sm_app-back-button'></span><span class='sm_app-header'>Выбирете модель:</span></div><div id='sm_app-collection'></div>"
});

SM_APP.views.ModelPageView = SM_APP.views.PageView.extend({
   template: "<div id='sm_app-header-wrap'><span id='sm_app-back-button'></span>Выбирете модификацию:</div><div id='sm_app-collection'></div>"
});

SM_APP.views.ModPageView = SM_APP.views.PageView.extend({
   initialize: function(options){
      this.model = options.model;
   },
   template: "<div id='sm_app-header-wrap'><span id='sm_app-back-button'></span>Выбирете номер ТО:</div><div id='sm_app-collection'></div>\n\
<div class='maintenance_info'>ТО №<%= order %>, пробег: <%= distance %> 000 км.</div>\n\
<table class='sm_app-parts-table' id='sm_app-parts-table'><tr><th>Код</th><th>Название</th><th>Количество</th><th>Комментарий</th></tr></table>\n\
<div class='maintenance_info'>Замена по мере износа:</div>\n\
<table class='sm_app-parts-table' id='sm_app-parts-table-all'><tr><th>Код</th><th>Название</th><th>Количество</th><th>Комментарий</th></tr></table>",
   render: function(){        
      $(this.el).html(_.template(this.template, { order: this.model.get('maintenance_order'), 
         distance: this.model.get('distance') }));         
      return this;
   }
});

//Other views
SM_APP.views.BackButtonView = Backbone.View.extend({
   eventData: {},
   initialize: function(options){
      this.eventData = options.eventData;
      this.on('backEvent', SM_APP.controller.initialize, SM_APP.controller);
   },          

   events: {
      'click': function(){ this.trigger('backEvent', this.eventData) }
   },

   render: function(){
      //$(this.el).html('back');      
      $(this.el).button({
         text: false,
         icons: {
            primary: 'ui-icon-arrowthick-1-w'
         }
      });
      return this;
   }   
});


//Layout
SM_APP.views.Layout = Backbone.View.extend({   
   tagName: 'div',
   render: function(){                 
      $(this.el).html(_.template($('#sm_app-layout-template').html(), {}));      
      $(this.el).dialog({
         title: 'Запчасти для ТО',
         modal: true,
         width: 800,
         height: 600
      });
      return this;
   }
});