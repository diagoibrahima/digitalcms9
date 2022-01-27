<?php

namespace Drupal\pdf_generator\Plugin\views\style;

use Drupal\views\Plugin\views\style\Table;

/**
 * Default style plugin to render an RSS feed.
 *
 * @ingroup views_style_plugins
 *
 * @ViewsStyle(
 *   id = "pdf_generator_views_style_table",
 *   title = @Translation("PDF table style"),
 *   help = @Translation("Generates an PDF."),
 *   theme = "views_view_table",
 *   display_types = {"normal"}
 * )
 */
class PdfTable extends Table {

  use PdfTrait;

}
