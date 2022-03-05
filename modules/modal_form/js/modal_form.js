(function ($) {
  'use strict';

  Drupal.behaviors.modalForm = {
    attach: function () {
      $.each(Drupal.ajax.instances, function () {
        if (this !== null) {
          var $element = $(this.element);

          if ($element.hasClass('use-modal-form')) {
            this.submit.currentQuery = window.location.search;
            this.submit.queryParameters = $element.data('queryParameters') || {};
          }
        }
      });
    }
  };
})(jQuery);
