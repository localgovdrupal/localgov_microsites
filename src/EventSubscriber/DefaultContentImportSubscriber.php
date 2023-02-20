<?php

namespace Drupal\localgov_microsites\EventSubscriber;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\default_content\Event\ImportEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * LocalGov Drupal Microsites event subscriber.
 */
class DefaultContentImportSubscriber implements EventSubscriberInterface {

  /**
   * Config Factory.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * Constructs event subscriber.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The config factory service.
   */
  public function __construct(ConfigFactoryInterface $config_factory) {
    $this->configFactory = $config_factory;
  }

  /**
   * Kernel request event handler.
   *
   * @param \Drupal\default_content\Event\ImportEvent $event
   *   Response event.
   */
  public function onContentImport(ImportEvent $event) {
    if ($event->getModule() == 'localgov_microsites') {
      foreach ($event->getImportedEntities() as $entity) {
        if ($entity->uuid() == 'f7e60359-efb1-4cd1-a4c8-b120fb4f5c41') {
          $config = $this->configFactory->getEditable('localgov_microsites_group.settings');
          $config->set('default_group_node', $entity->id());
          $config->save();
          break;
        }
      }
    }
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    return [
      'default_content.import' => ['onContentImport'],
    ];
  }

}
