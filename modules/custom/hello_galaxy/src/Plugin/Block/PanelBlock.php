<?php

namespace Drupal\hello_galaxy\Plugin\Block;

use Drupal\Core\Block\BlockBase;

use Drupal\Core\Block\BlockPluginInterface;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a 'Hello' Block.
 *
 * @Block(
 *   id = "panel_block",
 *   admin_label = @Translation("Panneau indicateur"),
 * )
 */
class PanelBlock extends BlockBase implements BlockPluginInterface {

  /**
   * {@inheritdoc}
   */
  public function build() {

    $config = $this->getConfiguration();

$silicium_offer = (isset($config['silicium_offer']) AND !empty($config['silicium_offer'])) ? $config['silicium_offer'] : '';



    return array(
      '#theme' => 'panel_block',
      '#message' => $this->t(' '),
      '#offer' => $silicium_offer,
    );
  }

  public function blockForm($form, FormStateInterface $form_state) {

    $form = parent::blockForm($form, $form_state);

    $config = $this->getConfiguration();

    $form['panel_block_silicium_offer'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Réduction sur le silicium'),
      '#description' => $this->t("Renseignez ici l'offre commerciale"),
      '#default_value' => isset($config['silicium_offer']) ? $config['silicium_offer'] : '',
      '#required' => FALSE,
    );

    return $form;
  }

 public function blockSubmit($form, FormStateInterface $form_state) {
    
    $this->configuration['silicium_offer'] = $form_state->getValue('panel_block_silicium_offer');
  }

public function blockValidate($form, FormStateInterface $form_state) {
    
    $silicium_offer = $form_state->getValue('panel_block_silicium_offer');
    
  }

}