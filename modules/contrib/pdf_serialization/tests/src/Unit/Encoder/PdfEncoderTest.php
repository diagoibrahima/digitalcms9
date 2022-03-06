<?php

namespace Drupal\Tests\pdf_serialization\Unit\Encoder;

use Drupal\Tests\UnitTestCase;
use Drupal\Core\File\FileSystem;
use Drupal\Core\Render\Renderer;
use Drupal\Core\Site\Settings;
use Drupal\Core\StreamWrapper\StreamWrapperManagerInterface;
use Drupal\pdf_serialization\PdfManager;
use Drupal\pdf_serialization\Encoder\PdfEncoder;

/**
 * Tests the PDF encoder.
 *
 * @group pdf_serialization
 *
 * @coversDefaultClass \Drupal\pdf_serialization\Encoder\PdfEncoder
 */
class PdfEncoderTest extends UnitTestCase {

  /**
   * PDF manager service.
   *
   * @var \Drupal\pdf_serialization\PdfManager
   */
  protected $pdfManager;

  /**
   * The file system service.
   *
   * @var \Drupal\Core\File\FileSystemInterface
   */
  protected $fileSystem;

  /**
   * The file logger channel.
   *
   * @var \Psr\Log\LoggerInterface|\PHPUnit\Framework\MockObject\MockObject
   */
  protected $logger;

  /**
   * The stream wrapper manager.
   *
   * @var \Drupal\Core\StreamWrapper\StreamWrapperInterface|\PHPUnit\Framework\MockObject\MockObject
   */
  protected $streamWrapperManager;

  /**
   * The mock of renderer service.
   *
   * @var \Drupal\Core\Render\Renderer|\PHPUnit\Framework\MockObject\MockObject
   */
  protected $renderer;

  /**
   * {@inheritdoc}
   */
  public function setUp(): void {
    parent::setUp();
    $settings = new Settings([]);
    $this->streamWrapperManager = $this->createMock(StreamWrapperManagerInterface::class);
    $this->logger = $this->createMock('Psr\Log\LoggerInterface');
    $this->fileSystem = new FileSystem($this->streamWrapperManager, $settings, $this->logger);
    $this->renderer = $this->getMockBuilder(Renderer::class)->disableOriginalConstructor()->getMock();

    $this->pdfManager = new PdfManager($this->renderer, $this->fileSystem);
  }

  /**
   * Tests supported encoding format.
   *
   * @covers ::supportsEncoding
   */
  public function testSupportsEncoding(): void {
    $encoder = new PdfEncoder($this->renderer, $this->pdfManager);
    self::assertTrue($encoder->supportsEncoding('pdf'));
    self::assertFalse($encoder->supportsEncoding('xls'));
  }

  /**
   * Tests pdf encoder.
   *
   * @covers ::encode
   */
  public function testEncode(): void {
    $this->renderer->method('render')->willReturn('Pdf Test.');
    $encoder = new PdfEncoder($this->renderer, $this->pdfManager);
    $encoded = $encoder->encode([], 'pdf');
    self::assertNotEmpty($encoded);
    self::assertNotEmpty(strpos($encoded, 'PDF-1.4'));
  }

}
