<?php

namespace Drupal\pdf_serialization\Encoder;

use Drupal\Core\Render\Renderer;
use Drupal\pdf_serialization\PdfManager;
use Symfony\Component\Serializer\Encoder\DecoderInterface;
use Symfony\Component\Serializer\Encoder\EncoderInterface;

/**
 * Adds PDF encoder support for the Serialization API.
 */
class PdfEncoder implements EncoderInterface, DecoderInterface {

  /**
   * The format that this pdf_serialization supports.
   *
   * @var string
   */
  protected static $format = 'pdf';

  /**
   * The renderer.
   *
   * @var \Drupal\Core\Render\Renderer
   */
  private $renderer;

  /**
   * Pdf manager.
   *
   * @var \Drupal\pdf_serialization\PdfManager
   */
  protected $pdfManager;

  /**
   * PdfEncoder constructor.
   *
   * @param \Drupal\Core\Render\Renderer $renderer
   *   The renderer.
   * @param \Drupal\pdf_serialization\PdfManager $pdf_manager
   *   Defines a pdf manager service.
   */
  public function __construct(Renderer $renderer, PdfManager $pdf_manager) {
    $this->renderer = $renderer;
    $this->pdfManager = $pdf_manager;
  }

  /**
   * {@inheritdoc}
   */
  public function decode($data, $format, array $context = []) {
    return [];
  }

  /**
   * {@inheritdoc}
   */
  public function supportsDecoding($format) {
    return $format === static::$format;
  }

  /**
   * {@inheritdoc}
   */
  public function encode($data, $format, array $context = []) {
    // Return only message if access is denied.
    if (isset($data['message'])) {
      return $data['message'];
    }

    switch (gettype($data)) {
      case 'array':
        break;

      case 'object':
        $data = (array) $data;
        break;

      // May be bool, integer, double, string, resource, NULL, or unknown.
      default:
        $data = [$data];
        break;
    }

    foreach ($data as $key => $items) {
      foreach ($items as $field_name => $item) {
        $markup = [
          '#markup' => $item,
        ];

        $data[$key][$field_name] = $this->renderer->render($markup);
      }
    }

    // Set output.
    $headers = $this->extractHeaders($data, $context);
    $output = [
      '#theme' => 'pdf_serialization_pdf',
      '#content' => [
        '#type' => 'table',
        '#header' => $headers,
        '#rows' => $data,
        '#format' => 'full_html',
      ],
    ];

    // Get data export method and pdf settings.
    foreach ($context['views_style_plugin']->view->storage->get('display') as $display) {
      if ($display['display_plugin'] === 'data_export') {
        $options['export_method'] = $display['display_options']['export_method'] ?? '';
      }
    }

    $options['pdf_settings'] = $context['views_style_plugin']->options['pdf_settings'] ?? [];

    return $this->pdfManager->getPdf($output, $options);
  }

  /**
   * Extracts the headers using the first row of values.
   *
   * We must make the assumption that each row shares the same set of headers
   * will all other rows. This is inherent in the structure of a PDF.
   *
   * @param array $data
   *   The array of data to be converted to a PDF.
   * @param array $context
   *   Options that normalizers/encoders have access to. For views encoders
   *   this means that we'll have the view available here.
   *
   * @return array
   *   An array of PDF headers.
   */
  protected function extractHeaders(array $data, array $context = []) {
    $headers = [];
    if (!empty($data)) {
      $first_row = $data[0];
      $allowed_headers = array_keys($first_row);

      if (!empty($context['views_style_plugin'])) {
        $fields = $context['views_style_plugin']
          ->view
          ->getDisplay('rest_export_attachment_1')
          ->getOption('fields');
      }

      foreach ($allowed_headers as $allowed_header) {
        $headers[] = !empty($fields[$allowed_header]['label']) ? $fields[$allowed_header]['label'] : $allowed_header;
      }
    }

    return $headers;
  }

  /**
   * {@inheritdoc}
   */
  public function supportsEncoding($format) {
    return $format === static::$format;
  }

}
