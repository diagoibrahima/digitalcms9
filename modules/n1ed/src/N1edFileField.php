<?php
namespace Drupal\n1ed;

use Drupal\Core\Security\TrustedCallbackInterface;
use Drupal\Core\Field\WidgetInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

class N1edFileField implements TrustedCallbackInterface
{
    public static function trustedCallbacks()
    {
        return ['preRenderWidget'];
    }

    /**
     * Processes widget form.
     */
    public static function processWidget(
        $element,
        FormStateInterface $form_state,
        $form
    ) {
        $settings = \Drupal::config('n1ed.settings');
        $apiKey = $settings->get('apikey') ?: 'N1D8DFLT';

        $version = $settings->get('version') ?: '';
        if ($version === '') {
            $version = 'latest';
        }
        $urlCache = $settings->get('urlCache') ?: '';
        if ($urlCache === '') {
            // Fix for: https://www.drupal.org/project/n1ed/issues/3111919
            // Do not start URL with "https:" prefix.
            // Notice about cookies: developers use it to specify debug server to use,
            // all other users will use old known cloud.n1ed.com address
            $standaloneSrc =
                '//' .
                (isset($_COOKIE['N1ED_PREFIX'])
                    ? $_COOKIE['N1ED_PREFIX'] . '.'
                    : '') .
                'cloud.n1ed.com/cdn/' .
                $apiKey .
                '/' .
                'n1flmngr.js';

            $standaloneImgPen =
                '//' .
                (isset($_COOKIE['N1ED_PREFIX'])
                    ? $_COOKIE['N1ED_PREFIX'] . '.'
                    : '') .
                'cloud.n1ed.com/cdn/' .
                $apiKey .
                '/' .
                'n1imgpen.js';
        } else {
            // Fix for: https://www.drupal.org/project/n1ed/issues/3111919
            // Do not start URL with "https:" prefix.
            if (strpos($urlCache, 'http:') === 0) {
                $urlCache = substr($urlCache, 5);
            } elseif (strpos($urlCache, 'https:') === 0) {
                $urlCache = substr($urlCache, 6);
            }
            $standaloneSrc = $urlCache . $apiKey . '/' . 'n1flmngr.js';
            $standaloneSrc = $urlCache . $apiKey . '/' . 'n1imgpen.js';
        }

        $standaloneUrl = Url::fromRoute('n1ed.flmngr')->toString();

        $standaloneCSRF = 'drupal8';

        // Get path to /sites/SITE/files/flmngr
        $standaloneUrlFiles = parse_url(file_create_url('public://flmngr'))[
            'path'
        ];
        $standaloneDirUploads = '/';
        if($settings->get('selfHosted')){
            $standaloneSrc = selfHostedPath . 'Flmngr/flmngr.js';
            $standaloneImgPen = selfHostedPath . 'ImgPen/imgpen.js';
        }
        $standaloneData = [
            'standaloneSrc' => $standaloneSrc,
            'standaloneUrl' => $standaloneUrl,
            'standaloneCSRF' => $standaloneCSRF,
            'standaloneUrlFiles' => $standaloneUrlFiles,
            'standaloneDirUploads' => $standaloneDirUploads,
            'standaloneimgpen' => $standaloneImgPen
        ];
        if($settings->get('selfHosted')){
            $standaloneData['apikey'] = $apiKey;
        }

        $element['n1ed_paths'] = [
            '#type' => 'hidden',
            '#attributes' => [
                'class' => ['flmngrWidget-filefield-paths'],
                'data-extensions' =>
                    $element['#upload_validators'][
                        'file_validate_extensions'
                    ][0],
                'data-standaloneData' => json_encode($standaloneData),
                'data-multiple' => $element['#multiple'] ? 1 : 0,
            ],
            // Reset value to prevent consistent errors.
            '#value' => '',
        ];
        // Library.
        $element['#attached']['library'][] = 'n1ed/drupal.n1ed.filefield';
        // Set the pre-renderer to conditionally disable the elements.
        $element['#pre_render'][] = [get_called_class(), 'preRenderWidget'];

        return $element;
    }

    /**
     * Pre-renders widget form.
     */
    public static function preRenderWidget($element)
    {
        // Hide elements if there is already an uploaded file.
        if (!empty($element['#value']['fids'])) {
            $element['n1ed_paths']['#access'] = false;
        }
        return $element;
    }
}
