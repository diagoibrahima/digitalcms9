<?php

/**
 * @file
 * Hooks and documentation related to pdf_generator module.
 */

/**
 * Alter Dompdf object before rendering.
 *
 * @param $dompdf
 *   Dompdf instance.
 */
function hook_mymodule_pdf_generator_pre_render_alter(&$dompdf) {
  // allows other modules to alter the Dompdf instance before it is rendered
}
