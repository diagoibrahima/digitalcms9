<?php

namespace Drupal\pdf_generator\Plugin\views\style;

use Drupal\Core\Url;

/**
 * This trait prevent duplicated code on every style.
 */
trait PdfTrait {

  /**
   * {@inheritdoc}
   */
  public function attachTo(array &$build, $display_id, Url $url, $title) {
    $url_options = [];
    $input = $this->view->getExposedInput();
    if ($input) {
      $url_options['query'] = $input;
    }
    $url_options['absolute'] = TRUE;
    if (!empty($this->options['formats'])) {
      $url_options['query']['_format'] = reset($this->options['formats']);
    }

    $url = $url->setOptions($url_options)->toString();

    $this->view->feedIcons[] = [
      '#theme' => 'pdf_generator_feed_icon',
      '#url' => $url,
      '#title' => $title,
      '#theme_wrappers' => [
        'container' => [
          '#attributes' => [
            'class' => [
              'pdf-feed',
              'pdf-generator-feed',
            ],
          ],
        ],
      ],
      '#attached' => [
        'library' => [
          'pdf_generator/pdf_generator',
        ],
      ],
    ];

    // Attach a link to the CSV feed, which is an alternate representation.
    $build['#attached']['html_head_link'][][] = [
      'rel' => 'alternate',
      'type' => 'application/pdf',
      'title' => $title,
      'href' => $url,
    ];
  }

}
