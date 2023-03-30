<?php

namespace Drupal\Tests\localgov_microsites\Functional;

use Drupal\Tests\BrowserTestBase;
use Symfony\Component\HttpFoundation\Response;

/**
 * Functional tests for LocalGovDrupal install profile.
 */
class MicrositesProfileTest extends BrowserTestBase {

  /**
   * Disabled schema checking for now.
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
  protected $defaultTheme = 'stark';

  /**
   * Test localgov_microsites profile installs okay.
   */
  public function testLocalGovDrupalProfile() {

    // Test front page loads after site install.
    $this->drupalGet('<front>');
    $this->assertSession()->statusCodeEquals(Response::HTTP_OK);
  }

}
