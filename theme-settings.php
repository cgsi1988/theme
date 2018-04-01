<?php
/**
 * Implements hook_form_system_theme_settings_alter().
 *
 * @param $form
 *   Nested array of form elements that comprise the form.
 * @param $form_state
 *   A keyed array containing the current state of the form.
 */
function cgsi_form_system_theme_settings_alter(&$form, &$form_state, $form_id = NULL)  {
  // Work-around for a core bug affecting admin themes. See issue #943212.
  if (isset($form_id)) {
    return;
  }

  // Create the form using Forms API: http://api.drupal.org/api/7
  $form['cgsi_banner'] = array(
  		'#type'          => 'fieldset',
  		'#title'         => t('Banner Slide Show Settings'),
  );
  
  $form['cgsi_banner']['cgsi_banner_delay_interval'] = array(  
  		'#type' => 'textfield',  
  		'#title' => t('Slide duration'),  
  		'#default_value' => theme_get_setting('cgsi_banner_delay_interval'),
  		'#description'   => t('How many seconds between each image?'),  
  		'#cols'          => 1,
  		'#size'          => 1,
  );
  
  $form['cgsi_banner']['cgsi_banner_image_urls'] = array(
    '#type'          => 'textarea',
    '#title'         => t('Images for banner slide show'),
    '#description'   => t('Enter URL for images, one per line, that will be cycled through the banner at the top of each page. <br/>Hint: <a href="/node/add/page">create a page</a> to upload and store your own images.'),
  	'#cols'          => 128,
  	'#rows'          => 8,
  	'#default_value' => theme_get_setting('cgsi_banner_image_urls'),
  );
  // */

  // Remove some of the base theme's settings.
  /* -- Delete this line if you want to turn off this setting.
  unset($form['themedev']['zen_wireframes']); // We don't need to toggle wireframes on this site.
  // */

  // We are editing the $form in place, so we don't need to return anything.
}
