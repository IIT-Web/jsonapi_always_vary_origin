<?php
/**
 * @file
 * Contains \Drupal\jsonapi_always_vary_origin\EventSubscriber\AlwaysAddVaryOriginEventSubscriber.
 */

namespace Drupal\jsonapi_always_vary_origin\EventSubscriber;

use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Event Subscriber AlwaysAddVaryOriginEventSubscriber.
 */
class AlwaysAddVaryOriginEventSubscriber implements EventSubscriberInterface {

  /**
   * Code that should be triggered on event specified
   */
  public function onJSONApiResponse(FilterResponseEvent $event) {
    $route = \Drupal::request()->getRequestUri();
    if (preg_match("/^\/jsonapi\/.*/", $route)) {
      $response = $event->getResponse();
      $response->setVary('Origin', false);
    }
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    $events[KernelEvents::RESPONSE][] = ['onJSONApiResponse'];
    return $events;
  }

}