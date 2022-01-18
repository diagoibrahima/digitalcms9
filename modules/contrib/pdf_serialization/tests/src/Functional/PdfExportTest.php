<?php

namespace Drupal\Tests\pdf_serialization\Functional;

use Drupal\Tests\views\Functional\ViewTestBase;
use Drupal\views\Tests\ViewTestData;

/**
 * Tests the PDF export.
 *
 * @group pdf_serialization
 */
class PdfExportTest extends ViewTestBase {

  /**
   * {@inheritdoc}
   */
  protected static $modules = [
    'rest',
    'views_data_export',
    'csv_serialization',
    'pdf_serialization',
    'pdf_serialization_test',
  ];

  /**
   * Views used by this test.
   *
   * @var array
   */
  public static $testViews = ['test_data_export_to_pdf'];

  /**
   * {@inheritdoc}
   */
  protected $defaultTheme = 'stark';

  /**
   * {@inheritdoc}
   */
  protected function setUp($import_test_views = TRUE): void {
    parent::setUp($import_test_views);
    ViewTestData::createTestViews(static::class, ['pdf_serialization_test']);

    $account = $this->drupalCreateUser(['access user profiles']);
    $this->drupalLogin($account);
  }

  /**
   * Tests the pdf data export.
   *
   * @throws \Behat\Mink\Exception\ExpectationException
   */
  public function testPdfDataExport(): void {
    // Load the linked page display.
    $this->drupalGet('/test-pdf-serialization');
    $this->assertSession()->statusCodeEquals(200);

    // Click on the link to export.
    $this->clickLink('Download PDF');
    $this->assertSession()->statusCodeEquals(200);
    $this->assertSession()->addressEquals('/test-pdf-serialization/export?page&_format=pdf');
  }

}
