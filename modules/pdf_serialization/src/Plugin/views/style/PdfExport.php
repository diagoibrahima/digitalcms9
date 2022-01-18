<?php

namespace Drupal\pdf_serialization\Plugin\views\style;

use Drupal\Core\Url;
use Drupal\views_data_export\Plugin\views\style\DataExport;

/**
 * A style plugin to add encoder styles to data export views.
 *
 * @ingroup views_style_plugins
 */
class PdfExport extends DataExport {

  /**
   * {@inheritdoc}
   */
  public function attachTo(array &$build, $display_id, Url $url, $title) {
    parent::attachTo($build, $display_id, $url, $title);
    $this->view->feedIcons[0]['#attached']['library'][] = 'pdf_serialization/encoder_styles';
  }

}
