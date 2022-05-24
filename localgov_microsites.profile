<?php

/**
 * @file
 * Customisations for the LocalGov Microsites install profile.
 */

use Drupal\Core\Form\FormStateInterface;

/**
 * Implements hook_form_FORM_ID_alter() for install_configure_form().
 *
 * Allows the profile to alter the site configuration form.
 */
function localgov_microsites_form_install_configure_form_alter(&$form, FormStateInterface $form_state) {

  // Set the default domain during a site install.
  $form['site_information']['hostname'] = [
    '#type' => 'textfield',
    '#title' => t('Hostname'),
    '#size' => 40,
    '#maxlength' => 80,
    '#description' => t('The canonical hostname, using the full <em>subdomain.example.com</em> format. Leave off the http:// and the trailing slash and do not include any paths.<br />If this domain uses a custom http(s) port, you should specify it here, e.g.: <em>subdomain.example.com:1234</em><br />The hostname may contain only lowercase alphanumeric characters, dots, dashes, and a colon (if using alternative ports).'),
    '#default_value' => \Drupal::request()->getHost(),
    '#required' => TRUE,
  ];

  // Add our own submit handler.
  $form['#submit'][] = 'localgov_microsites_form_install_configure_submit';
}

/**
 * Install form custom submit handler.
 */
function localgov_microsites_form_install_configure_submit($form, FormStateInterface $form_state) {

  // Create default domain record.
  if ($hostname = $form_state->getValue('hostname')) {
    $site_name = $form_state->getValue('site_name');
    $values = [
      'name' => $site_name,
      'hostname' => $hostname,
      'scheme' => 'variable',
      'status' => 1,
      'weight' => -1,
      'is_default' => 1,
      'id' => \Drupal::entityTypeManager()->getStorage('domain')->createMachineName($hostname),
    ];
    $domain = \Drupal::entityTypeManager()->getStorage('domain')->create($values);
    $domain->save();
  }
}
