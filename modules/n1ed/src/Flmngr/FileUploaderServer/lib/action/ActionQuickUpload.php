<?php

/**
 * File Uploader Server package
 * Developer: N1ED
 * Website: https://n1ed.com/
 * License: GNU General Public License Version 3 or later
 **/

namespace Drupal\n1ed\Flmngr\FileUploaderServer\lib\action;

use Exception;
use Drupal\n1ed\Flmngr\FlmngrServer\fs\FMDiskFileSystem;
use Drupal\n1ed\Flmngr\FileUploaderServer\lib\file\FileUploadedQuick;
use Drupal\n1ed\Flmngr\FileUploaderServer\lib\MessageException;
use Drupal\n1ed\Flmngr\FileUploaderServer\lib\action\resp\RespUploadAddFile;
use Drupal\n1ed\Flmngr\FileUploaderServer\lib\action\resp\Message;
class ActionQuickUpload extends AActionUploadId
{
    public function getName()
    {
        return 'upload';
    }
    public function run($req)
    {


        $fileSystem = new FMDiskFileSystem([
            'dirFiles' => $this->config->getBaseDir(),
            'dirCache' => '',
        ]);

        if ($req->file) {
            if (
                array_key_exists('dir', $_POST) &&
                $_POST['dir'] &&
                $_POST['dir'] != '/' &&
                $_POST['dir'] != '' &&
                $_POST['dir'] != '.'
            ) {
                $target_dir = basename($_POST['dir']);
                $path =
                    dirname($_POST['dir']) == '.' ||
                    dirname($_POST['dir']) == '/'
                        ? ''
                        : '/' . dirname($_POST['dir']);

                $fullPath = basename($this->m_config->getBaseDir()) . $path;
                $fileSystem->createDir($fullPath, $target_dir);
                $uploadDir =
                    $fileSystem->getAbsolutePath($fullPath) . '/' . $target_dir;
                $req->m_relativePath = $_POST['dir'];
            } else {
                $target_dir = '';
                $fullPath = basename($this->config->getBaseDir());
                $uploadDir =
                    $fileSystem->getAbsolutePath($fullPath) .
                    '/' .
                    $target_dir .
                    '/';
                $req->relativePath = '/';
            }

            $file = new FileUploadedQuick(
                $this->config,
                $uploadDir,
                $req->fileName,
                $req->fileName,
                $req->relativePath
            );
            $file->upload($req->file);

            $resp = new RespUploadAddFile();
            $resp->file = $file->getData();

            return $resp;
        } else {
          throw new MessageException(Message::createMessage(Message::FILES_NOT_SET));
        }
    }
}
