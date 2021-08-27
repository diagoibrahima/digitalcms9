<?php

namespace Drupal\workflows_field\Plugin\WorkflowType;

use Drupal\workflows\Plugin\WorkflowTypeBase;

/**
 * Workflow field Workflow.
 *
 * @WorkflowType(
 *   id = "workflows_field",
 *   label = @Translation("Workflows Field"),
 *   required_states = {},
 *   forms = {
 *     "configure" = "\Drupal\workflows_field\Form\WorkflowTypeConfigureForm"
 *   },
 * )
 */
class WorkflowsField extends WorkflowTypeBase {

  /**
   * {@inheritdoc}
   */
  public function getInitialState() {
    return $this->getState($this->configuration['initial_state']);
  }

}
