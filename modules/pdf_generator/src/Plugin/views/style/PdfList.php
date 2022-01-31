<?php

namespace Drupal\pdf_generator\Plugin\views\style;

use Drupal\views\Plugin\views\style\HtmlList;

/**
 * Default style plugin to render an RSS feed.
 *
 * @ingroup views_style_plugins
 *
 * @ViewsStyle(
 *   id = "pdf_generator_views_style_list",
 *   title = @Translation("PDF list style"),
 *   help = @Translation("Generates an PDF."),
 *   theme = "views_view_list",
 *   display_types = {"normal"}
 * )
 */
class PdfList extends HtmlList {

  use PdfTrait;

}
