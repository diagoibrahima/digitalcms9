<?php

namespace Drupal\download_all_files\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\File\FileSystemInterface;
use Drupal\Core\Messenger\Messenger;
use Drupal\download_all_files\Plugin\Archiver\Zip;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Drupal\Core\Entity\EntityTypeManagerInterface;

/**
 * Class DownloadController.
 *
 * @package Drupal\download_all_files\Controller
 */
class DownloadController extends ControllerBase {

  /**
   * The file system.
   *
   * @var \Drupal\Core\File\FileSystemInterface
   */
  protected $fileSystem;

  /**
   * The messenger service.
   *
   * @var \Drupal\Core\Messenger\MessengerInterface
   */
  protected $messenger;

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   *   The entity type manager.
   */
  protected $entityTypeManager;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new self(
      $container->get('file_system'),
      $container->get('messenger'),
      $container->get('entity_type.manager')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function __construct(FileSystemInterface $file_system, Messenger $messenger, EntityTypeManagerInterface $entityTypeManager) {
    $this->fileSystem = $file_system;
    $this->messenger = $messenger;
    $this->entityTypeManager = $entityTypeManager;
  }

  /**
   * Method archive all file associated with node and stream it for download.
   *
   * @param int $node_id
   *   Node id.
   * @param string $field_name
   *   Node file field name.
   *
   * @return \Symfony\Component\HttpFoundation\BinaryFileResponse|\Symfony\Component\HttpFoundation\RedirectResponse
   *   Downloads the file.
   */
  public function downloadAllFiles($node_id, $field_name) {
    $node = $this->entityTypeManager->getStorage('node')->load($node_id);
    $zip_files_directory = DRUPAL_ROOT . '/sites/default/files/daf_zips';
    $file_path = $zip_files_directory . '/' . $node->getTitle() . ' - ' . $field_name . '.zip';

    // If zip file is already present and node is not been changed since
    // Then just stream it directly.
    if (file_exists($file_path)) {
      $file_last_modified = filemtime($file_path);
      $node_changed = $node->getChangedTime();
      if ($node_changed < $file_last_modified) {
        return $this->streamZipFile($file_path);
      }
    }

    $redirect_on_error_to = empty($_SERVER['HTTP_REFERER']) ? '/' : $_SERVER['HTTP_REFERER'];
    $files = [];

    // Construct zip archive and add all files, then stream it.
    $node_field_files = $node->get($field_name)->getValue();
    foreach ($node_field_files as $file) {
      $file_obj = $this->entityTypeManager->getStorage('file')->load($file['target_id']);
      if ($file_obj) {
        $files[] = $file_obj->getFileUri();
      }
    }

    $file_zip = NULL;
    if ($this->fileSystem->prepareDirectory($zip_files_directory, FileSystemInterface::CREATE_DIRECTORY)) {
      foreach ($files as $file) {
        $file = $this->fileSystem->realpath($file);
        if (!$file_zip instanceof Zip) {

          $file_zip = new Zip($file_path);
        }
        $file_zip->add($file);
      }

      if ($file_zip instanceof Zip) {
        $file_zip->close();
        return $this->streamZipFile($file_path);
      }
      else {
        $this->messenger->addMessage('No files found for this node to be downloaded', 'error', TRUE);
        return new RedirectResponse($redirect_on_error_to);
      }
    }
    else {
      $this->messenger->addMessage('Zip file directory not found.', 'error', TRUE);
      return new RedirectResponse($redirect_on_error_to);
    }
  }

  /**
   * Method to stream created zip file.
   *
   * @param string $file_path
   *   File physical path.
   *
   * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
   *   Downloads the file.
   */
  protected function streamZipFile($file_path) {
    $binary_file_response = new BinaryFileResponse($file_path);
    $binary_file_response->setContentDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT, basename($file_path));

    return $binary_file_response;
  }

}
