<?php

namespace Drupal\Tests\localgov_microsites_group\Functional;

use Drupal\Tests\BrowserTestBase;
use Drupal\Tests\localgov_microsites_group\Traits\GroupCreationTrait;
use Drupal\Tests\localgov_microsites_group\Traits\InitializeGroupsTrait;
use Drupal\Tests\node\Traits\NodeCreationTrait;

/**
 * Tests caching of site settings.
 *
 * @group localgov_microsites_group
 */
class MicrositeCachingTest extends BrowserTestBase {

  use GroupCreationTrait;
  use InitializeGroupsTrait;
  use NodeCreationTrait;

  /**
   * Will be removed when issue #3204455 on Domain Site Settings gets merged.
   *
   * See https://www.drupal.org/project/domain_site_settings/issues/3204455.
   *
   * @var bool
   *
   * @see \Drupal\Core\Config\Development\ConfigSchemaChecker
   * phpcs:disable DrupalPractice.Objects.StrictSchemaDisabled.StrictConfigSchema
   */
  protected $strictConfigSchema = FALSE;

  /**
   * {@inheritdoc}
   */
  protected $profile = 'localgov_microsites';

  /**
   * {@inheritdoc}
   */
  protected $defaultTheme = 'localgov_microsites_base';

  /**
   * {@inheritdoc}
   */
  protected static $modules = [
    'localgov_microsites_group',
  ];

  /**
   * {@inheritdoc}
   */
  protected function setUp(): void {
    parent::setUp();

    // Set base hostname.
    $this->setBaseHostname();

    // Create some microsites.
    $this->group = $this->createGroup([
      'label' => 'group-1',
      'type' => 'microsite',
    ]);
    $this->domain = \Drupal::entityTypeManager()->getStorage('domain')->create([
      'id' => 'group_' . $this->group->id(),
      'name' => $this->group->label(),
      'hostname' => $this->group->label() . '.' . $this->baseHostname,
      'third_party_settings' => [
        'group_context_domain' => ['group_uuid' => $this->group->uuid()],
      ],
    ]);
    $this->domain->save();

    // Login as admin user.
    $user = $this->drupalCreateUser(['use group_sites admin mode'], NULL, TRUE);
    $this->group->addMember($user, ['group_roles' => ['microsite-admin']]);
    $this->drupalLogin($user);
    \Drupal::service('group_sites.admin_mode')->setAdminMode(TRUE);
  }

  /**
   * Test changes to site settings.
   */
  public function testSiteSettings() {

    // Check changes to footer blocks.
    $footer_text = $this->randomString();
    $this->drupalGet('group/' . $this->group->id() . '/edit');
    $this->submitForm([
      'lgms_footer_text_block_1[0][value]' => $footer_text,
    ], 'Save');
    $this->drupalGet($this->domain->getUrl());
    $this->assertSession()->pageTextContains($footer_text);

    // Check menu changes appear.
    $link_title = $this->randomString();
    $this->drupalGet('group/' . $this->group->id() . '/menu/2/add-link');
    $this->submitForm([
      'title[0][value]' => $link_title,
      'link[0][uri]' => '<front>',
    ], 'Save');
    $this->drupalGet($this->domain->getUrl());
    $this->assertSession()->pageTextContains($link_title);
  }

}
