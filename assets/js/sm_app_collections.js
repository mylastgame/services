SM_APP.collections.Marks = Backbone.Collection.extend({
   model: SM_APP.models.Mark,
   url: function() { return SM_APP.baseUrl+'marks/'; }
});

SM_APP.collections.Models = Backbone.Collection.extend({
   initialize: function(options){
      this.parentId = options.parentId;
   },
   model: SM_APP.models.Model,
   parentId: '',
   url: function() { return SM_APP.baseUrl+'mark/'+this.parentId+'/models'; }
});

SM_APP.collections.Mods = Backbone.Collection.extend({
   initialize: function(options){
      this.parentId = options.parentId;
   },
   model: SM_APP.models.Mod,
   parentId: '',
   url: function() { return SM_APP.baseUrl+'model/'+this.parentId+'/mods'; }
});

SM_APP.collections.Maintenances = Backbone.Collection.extend({
   initialize: function(options){
      this.parentId = options.parentId;
   },
   model: SM_APP.models.Maintenance,
   parentId: '',
   url: function() { return SM_APP.baseUrl+'mod/'+this.parentId+'/maintenances'; }
});

SM_APP.collections.Parts = Backbone.Collection.extend({
   initialize: function(options){
      this.parentId = options.parentId;
      this.order = options.order;
   },
   model: SM_APP.models.Part,
   parentId: '',
   orederId: '',
   url: function() { return SM_APP.baseUrl+'mod/'+this.parentId+'/maintenance/'+this.order; }
});