/**
 * @file
 * Javascript to handle diving trip view
 */

(function ($, _, Drupal, drupalSettings) {

  'use strict';

  var unloadEntityModelQueue = [];
  var unloadFieldElementQueue = [];

  var fieldsMetadataQueue = [];
  var fieldsAvailableQueue = [];
  
  // removes quickedit detach behavior to use our own
  Drupal.behaviors.quickedit.detach=null;
  
  function clickAgain(entityElement, entityModel, clickSourceElement) {
    if (entityModel.get('state') == 'opened') {
      $(clickSourceElement).click();
    }
    else {
      setTimeout(clickAgain, 20, entityElement, entityModel, clickSourceElement);
    }
  }
  
  function prepareInitializeField(fieldElement){
    var metadata = Drupal.quickedit.metadata;
    var fieldID = fieldElement.getAttribute('data-quickedit-field-id');
    var entityID = extractEntityID(fieldID);

    var entityElementSelector = '[data-quickedit-entity-id="' + entityID + '"]';
    var $entityElement = $(entityElementSelector);

    if (!$entityElement.length) {
      throw new Error('Quick Edit could not associate the rendered entity field markup (with [data-quickedit-field-id="' + fieldID + '"]) with the corresponding rendered entity markup: no parent DOM node found with [data-quickedit-entity-id="' + entityID + '"]. This is typically caused by the theme\'s template for this entity type forgetting to print the attributes.');
    }
    var entityElement = $(fieldElement).closest($entityElement);

    if (entityElement.length === 0) {
      var $lowestCommonParent = $entityElement.parents().has(fieldElement).first();
      entityElement = $lowestCommonParent.find($entityElement);
    }
    var entityInstanceID = entityElement.get(0).getAttribute('data-quickedit-entity-instance-id');

    if (!metadata.has(fieldID)) {
      setTimeout(prepareInitializeField, 200, fieldElement);
      return;
    }

    if (metadata.get(fieldID, 'access') !== true) {
      return;
    }

    // have the metadata  about the etnity been added yet?
    if (Drupal.quickedit.metadata.has(entityID)) {
      if (! Drupal.quickedit.collections.entities.findWhere({
        entityID: entityID,
        entityInstanceID: entityInstanceID
      })) {
        var entityModel = new Drupal.quickedit.EntityModel({
          el: entityElement.get(0),
          entityID: entityID,
          entityInstanceID: entityInstanceID,
          id: entityID + '[' + entityInstanceID + ']',
          label: Drupal.quickedit.metadata.get(entityID, 'label')
        });
        Drupal.quickedit.collections.entities.add(entityModel);

        var entityDecorationView = new Drupal.quickedit.EntityDecorationView({
          el: entityElement.get(0),
          model: entityModel
        });
        entityModel.set('entityDecorationView', entityDecorationView);
 
      }

      initializeField(fieldElement, fieldID, entityID, entityInstanceID);
    }
    else {
      setTimeout(prepareInitializeField, 200, fieldElement);
      return;
    }
    
  }
  
  function initializeField(fieldElement, fieldID, entityID, entityInstanceID) {
    // if the element has not yet been added
    if (! Drupal.quickedit.collections.fields.findWhere({
        id:  fieldID + '[' + entityInstanceID + ']'
     })) {
      $(fieldElement).addClass('quickedit-field');
      var entity = Drupal.quickedit.collections.entities.findWhere({
        entityID: entityID,
        entityInstanceID: entityInstanceID
      });
        
      var field = new Drupal.quickedit.FieldModel({
        el: fieldElement,
        fieldID: fieldID,
        id: fieldID + '[' + entityInstanceID + ']',
        entity: entity,
        metadata: Drupal.quickedit.metadata.get(fieldID),
        acceptStateChange: _.bind(Drupal.quickedit.app.acceptEditorStateChange, Drupal.quickedit.app)
      });

      Drupal.quickedit.collections.fields.add(field);
      
      // and add the editor
      loadMissingEditors();
    }
    
    // add the handlers
    if ($(fieldElement).hasClass('simpler_quickedit_click')) {
      addClickHandler(fieldElement);
    }
    if ($(fieldElement).is('.simpler_quickedit_edit, .simpler_quickedit_editHover')) {
      addEditHandler(fieldElement);
    }
  }
  
  function addClickHandler(fieldElement) {
    $(fieldElement).click(function(e) {
      let fieldID = $(this).attr('data-quickedit-field-id');
      let thisEntityID = extractEntityID(fieldID);
      let thisEntityElement = $(this).closest('[data-quickedit-entity-id="' + thisEntityID + '"]').get(0);
      var entityModel = Drupal.quickedit.collections.entities.findWhere({
        el: thisEntityElement
      });
      
      if ( ! entityModel) {
        console.log('issue with model');
      }
      
      if (entityModel && entityModel.get('state') == 'closed') {
        entityModel.set('state', 'launching');
        clickAgain(thisEntityElement, entityModel, this); 
      }
    });
  }
  
  function addEditHandler(fieldElement) {
    let edit = $('<div />').addClass('contextual simpler_quickedit-do');
    $('<button/>').addClass('trigger focusable').attr('type','button').html(Drupal.t('Edit')).appendTo(edit);
    
    // wrap the field in a div so that it doesn't break quickedit + easier for theming
    // only if it hasn't yet been done
    let $parent = $(fieldElement).parent();
    if ( ! $parent.hasClass('simpler_quickedit-element')) {
      $(fieldElement).wrap('<div class="simpler_quickedit-element"></div>');
      $parent = $(fieldElement).parent();
      $parent.append(edit);

      if ($(fieldElement).hasClass('simpler_quickedit_editHover')) {
        $parent.addClass('simpler_quickedit-editHover');
      }

      Drupal.attachBehaviors($parent.get(0));
    }
    else {
      // happens when a field gets edited (so already has a parent with the simpler_quickedit-editHover class, we don't want to add it again)
      Drupal.attachBehaviors(edit.get(0));
    }

    edit.click(function(e) {
      let fieldID = $(this).closest('.simpler_quickedit-element').find('[data-quickedit-field-id]').attr('data-quickedit-field-id');
      let thisEntityID = extractEntityID(fieldID);
      let thisEntityElement = $(this).closest('[data-quickedit-entity-id="' + thisEntityID + '"]').get(0);
      var entityModel = Drupal.quickedit.collections.entities.findWhere({
        el: thisEntityElement
      });
      
      if ( ! entityModel) {
        console.log('issue with model');
      }
      
      if (entityModel && entityModel.get('state') == 'closed') {
        entityModel.set('state', 'launching');
        clickAgain(thisEntityElement, entityModel, $(this).prev().get(0));
      }
    });
  }
  
  function loadMissingEditors() {
    var loadedEditors = _.keys(Drupal.quickedit.editors);
    var missingEditors = [];
    Drupal.quickedit.collections.fields.each(function (fieldModel) {
      var metadata = Drupal.quickedit.metadata.get(fieldModel.get('fieldID'));
      if (metadata.access && _.indexOf(loadedEditors, metadata.editor) === -1) {
        missingEditors.push(metadata.editor);

        Drupal.quickedit.editors[metadata.editor] = false;
      }
    });
    missingEditors = _.uniq(missingEditors);
    if (missingEditors.length === 0) {
      return;
    }

    var loadEditorsAjax = Drupal.ajax({
      url: Drupal.url('quickedit/attachments'),
      submit: { 'editors[]': missingEditors }
    });

    var realInsert = Drupal.AjaxCommands.prototype.insert;
    loadEditorsAjax.commands.insert = function (ajax, response, status) {
      realInsert(ajax, response, status);
    };

    loadEditorsAjax.execute();
  }

  function extractEntityID(fieldID) {
    return fieldID.split('/').slice(0, 2).join('/');
  }

  /* Handling attach / detach behaviors */
  var waitingForDeletion = 0;
  var readyToAttach = true;

  function prepateDelete($context) {

    // Closing popups and not attaching new behaviors until everything is properly deleted
    // Probably easier to use promises
    readyToAttach = false;

    // Find all impacted entities
    $context.find('[data-quickedit-field-id]').addBack('[data-quickedit-field-id]').closest('[data-quickedit-entity-id]').each(function (index, entityElement) {
      var entityModel = Drupal.quickedit.collections.entities.findWhere({
        el: entityElement
      });
      if (entityModel) {

        // closing opened quickedit toolbar popup before proceeding
        if (entityModel.get('state') !== 'closed') {

          waitingForDeletion++;
          entityModel.set('state', 'deactivating', { confirmed: true });

          checkModelClosed(entityModel);
        }
      }
    });

    // Set-up the queues of models to be removed after the quickedit toolbar popup is closed
    $context.find('[data-quickedit-entity-id]').addBack('[data-quickedit-entity-id]').each(function (index, entityElement) {
      var entityModel = Drupal.quickedit.collections.entities.findWhere({
        el: entityElement
      });
      if (entityModel) {
        unloadEntityModelQueue.push(entityModel);
      }
    });

    $context.find('[data-quickedit-field-id]').addBack('[data-quickedit-field-id]').each(function (index, fieldElement) {
      unloadFieldElementQueue.push(fieldElement);
    });

    checkReadyToDelete();
  }

  function checkModelClosed(entityModel) {
    if (entityModel.get('state') !== 'closed') {
      setTimeout(checkModelClosed, 20, entityModel);
    }
    else {
      waitingForDeletion--;
    }
  }

  function checkReadyToDelete() {
    if (waitingForDeletion !== 0) {
      setTimeout(checkReadyToDelete, 20);
    }
    else {
      deleteContainedModelsAndQueues();
    }
  }

  function deleteContainedModelsAndQueues() {

    /* Processing the queues */
    $.each(unloadEntityModelQueue, function(index, entityModel) {
      entityModel.get('entityDecorationView').remove();
      entityModel.destroy();
    });
    unloadEntityModelQueue = [];

    $.each(unloadFieldElementQueue, function(index, fieldElement) {
      Drupal.quickedit.collections.fields.chain().filter(function (fieldModel) {
        return fieldModel.get('el') === fieldElement;
      }).invoke('destroy');

      function hasOtherFieldElement(field) {
        return field.el !== fieldElement;
      }

      fieldsMetadataQueue = _.filter(fieldsMetadataQueue, hasOtherFieldElement);
      fieldsAvailableQueue = _.filter(fieldsAvailableQueue, hasOtherFieldElement);
    });
    unloadFieldElementQueue = [];

    readyToAttach = true;
  }

  function waitReadyInitialize(context) {
    if (! readyToAttach) {
      setTimeout(waitReadyInitialize, 20, context);
    }
    else {
      $('.simpler_quickedit[data-quickedit-field-id]', context).once().each(function() {
        prepareInitializeField(this);
      });
    }
  }

  Drupal.behaviors.simplerquickedit = {
    attach: function (context, drupalSettings) {
      waitReadyInitialize(context);
    },
    detach: function detach(context, settings, trigger) {
      if (trigger === 'unload') {
        prepateDelete($(context));
      }
    }
  }

  
}) (jQuery, _, Drupal, drupalSettings);