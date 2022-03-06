<?php

namespace Drupal\pdf_serialization;

use Drupal\Core\File\FileSystem;
use Drupal\Core\Render\Renderer;
use Mpdf\Mpdf;
use Mpdf\Output\Destination;

/**
 * Provides PDF manager service to generate content.
 */
class PdfManager {

  /**
   * The renderer.
   *
   * @var \Drupal\Core\Render\Renderer
   */
  private $renderer;

  /**
   * Provides helpers to operate on files and stream wrappers.
   *
   * @var \Drupal\Core\File\FileSystem
   */
  protected $fileSystem;

  /**
   * PdfManager constructor.
   *
   * @param \Drupal\Core\Render\Renderer $renderer
   *   The renderer.
   * @param \Drupal\Core\File\FileSystem $file_system
   *   Provides helpers to operate on files and stream wrappers.
   */
  public function __construct(Renderer $renderer, FileSystem $file_system) {
    $this->renderer = $renderer;
    $this->fileSystem = $file_system;
  }

  /**
   * Get generated PDF content.
   *
   * @param array $content
   *   PDF content.
   * @param array $options
   *   (optional) Pdf export settings. Defaults to [].
   * @param string $destination
   *   (optional) The file destination. Defaults to Destination::STRING_RETURN.
   *
   * @return string
   *   The PDF output.
   *
   * @throws \Mpdf\MpdfException
   * @throws \Exception
   */
  public function getPdf(array $content, array $options = [], $destination = Destination::STRING_RETURN) {
    $mpdf = new Mpdf([
      'mode' => 'utf-8',
      'format' => $options['pdf_settings']['format'] ?? 'A4',
      'tempDir' => $this->fileSystem->getTempDirectory(),
    ]);

    if (!empty($options['pdf_settings']['show_page_number'] && $options['export_method'] === 'standard')) {
      $mpdf->defaultfooterline = 0;
      $mpdf->setFooter('{PAGENO}');
    }

    $content_rendered = $this->renderer->render($content);
    $mpdf->WriteHTML($content_rendered);

    return $mpdf->Output('', $destination);
  }

}
