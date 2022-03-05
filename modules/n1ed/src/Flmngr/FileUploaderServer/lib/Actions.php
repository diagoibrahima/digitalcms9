<?php

namespace Drupal\n1ed\Flmngr\FileUploaderServer\lib;

use Drupal\n1ed\Flmngr\FileUploaderServer\lib\action\ActionError;
use Drupal\n1ed\Flmngr\FileUploaderServer\lib\action\ActionUploadAddFile;
use Drupal\n1ed\Flmngr\FileUploaderServer\lib\action\ActionUploadCancel;
use Drupal\n1ed\Flmngr\FileUploaderServer\lib\action\ActionUploadCommit;
use Drupal\n1ed\Flmngr\FileUploaderServer\lib\action\ActionUploadInit;
use Drupal\n1ed\Flmngr\FileUploaderServer\lib\action\ActionUploadRemoveFile;
use Drupal\n1ed\Flmngr\FileUploaderServer\lib\action\ActionQuickUpload;

/**
 * Actions list.
 * This class helps to understand which type of request Uploader received
 * by checking all available handlers' names.
 */
class Actions
{
    protected $actions = [];

    /**
     * Creates the list.
     */
    public function __construct()
    {
        $this->actions[] = new ActionError();

        $this->actions[] = new ActionUploadInit();
        $this->actions[] = new ActionUploadAddFile();
        $this->actions[] = new ActionUploadRemoveFile();
        $this->actions[] = new ActionUploadCommit();
        $this->actions[] = new ActionUploadCancel();
        $this->actions[] = new ActionQuickUpload();
    }

    /**
     * Gets action for error.
     */
    public function getActionError()
    {
        return $this->getAction('error');
    }

    /**
     * Gets action by name.
     */
    public function getAction($name)
    {

        for ($i = 0; $i < count($this->actions); $i++) {
            if ($this->actions[$i]->getName() === $name) {
                return $this->actions[$i];
            }
        }
        return null;
    }
}
