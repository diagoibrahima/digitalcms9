<?php

namespace Drupal\pdf_generator\Plugin\views\style;

use Drupal\views\Plugin\views\style\DefaultStyle;

/**
 * Unformatted style plugin to render pdf.
 *
 * @ingroup views_style_plugins
 *
 * @ViewsStyle(
 *   id = "pdf_generator_views_style_default",
 *   title = @Translation("PDF Unformatted list"),
 *   help = @Translation("Generates a pdf."),
 *   theme = "views_view_unformatted",
 *   display_types = {"normal"}
 * )
 */
class PdfDefault extends DefaultStyle {

  use PdfTrait;

}
