<?php

namespace App\Catrobat\Listeners;

use App\Catrobat\Requests\AppRequest;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\Routing\RouterInterface;

class ThemeRequestListener
{
  private ParameterBagInterface $parameter_bag;

  private RouterInterface $router;

  private AppRequest $app_request;

  private string $routing_theme;

  private string $flavor;

  public function __construct(ParameterBagInterface $parameter_bag, RouterInterface $router, AppRequest $app_request)
  {
    $this->parameter_bag = $parameter_bag;
    $this->router = $router;
    $this->app_request = $app_request;
    $this->routing_theme = (string) $parameter_bag->get('umbrellaTheme');
    $this->flavor = (string) $parameter_bag->get('defaultFlavor');
  }

  public function onKernelRequest(RequestEvent $event): void
  {
    if (HttpKernelInterface::MASTER_REQUEST !== $event->getRequestType()) {
      // In sub-request we can just re-use the theme from the master request
      $this->setupRouting();
      $this->setupRequestAttributes($event->getRequest());

      return;
    }

    // Themes must be defined in a request, not in the URI!
    $requested_theme = $this->app_request->getThemeDefinedInRequest();

    // URI should not contain a flavor but the umbrella theme
    $this->routing_theme = (string) $this->parameter_bag->get('umbrellaTheme');

    if ('' === $requested_theme) { // - @deprecated
      // However, we still support legacy theming
      $requested_theme = $this->getThemeFromUrl($event);

      // Here we have to keep the flavoring as routing theme
      if ($this->parameter_bag->get('adminTheme') !== $requested_theme) {
        $this->routing_theme = $requested_theme;
      }
    }

    $this->flavor = $this->getFlavorFromTheme($requested_theme);

    $this->setupRouting();
    $this->setupRequestAttributes($event->getRequest());
  }

  private function setupRouting(): void
  {
    $this->router->getContext()->setParameter('theme', $this->routing_theme);
  }

  private function setupRequestAttributes(Request $request): void
  {
    $request->attributes->set('theme', $this->routing_theme);
    $request->attributes->set('flavor', $this->flavor);
  }

  private function getThemeFromUrl(RequestEvent $event): string
  {
    $current_url = $event->getRequest()->getUri();
    preg_match('#http(s)?://(.*?)(/.*?\.php)?/(.*)#', $current_url, $parsed_url);

    return explode('/', $parsed_url[4])[0];
  }

  private function getFlavorFromTheme(string $theme): string
  {
    if (!$this->flavorExists($theme)) {
      return 'pocketcode';
    }

    return $theme;
  }

  private function flavorExists(?string $flavor): bool
  {
    $flavors = $this->parameter_bag->get('flavors');

    return in_array($flavor, $flavors, true);
  }
}
