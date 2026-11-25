<?php

namespace App\Routing;

use Illuminate\Routing\ResourceRegistrar as BaseResourceRegistrar;
use Illuminate\Routing\Route;

class ResourceRegistrar extends BaseResourceRegistrar
{
    /**
     * The default actions for a resourceful controller.
     *
     * @var string[]
     */
    protected $resourceDefaults = ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy', 'restore', 'forceDelete'];

    /**
     * Add the restore method for a resourceful route.
     */
    public function addResourceRestore(string $name, string $base, string $controller, array $options): Route
    {
        $name = $this->getShallowName($name, $options);

        $uri = $this->getResourceUri($name) . '/{' . $base . '}/restore';

        $action = $this->getResourceAction($name, $controller, 'restore', $options);

        return $this->router->patch($uri, $action);
    }

    /**
     * Add the forceDelete method for a resourceful route.
     */
    public function addResourceForceDelete(string $name, string $base, string $controller, array $options): Route
    {
        $name = $this->getShallowName($name, $options);

        $uri = $this->getResourceUri($name) . '/{' . $base . '}/force-delete';

        $action = $this->getResourceAction($name, $controller, 'forceDelete', $options);

        return $this->router->delete($uri, $action);
    }
}
