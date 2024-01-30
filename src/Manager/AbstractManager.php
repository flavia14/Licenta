<?php

declare(strict_types=1);

namespace App\Manager;

use ReflectionClass;
use ReflectionException;
use Symfony\Component\Routing\Exception\InvalidParameterException;

/**
 * Class AbstractManager.
 */
abstract class AbstractManager
{
    /**
     * ForwarderManager will be extended by managers that respect the naming convention
     * Scope + Manager. Ex: TaskManager.
     *
     * If we call the manager with an unexisting method, we will try to get the main
     * service of the manager and if there is a method with that name callable, call it.
     *
     * @return mixed
     *
     * @throws ReflectionException
     * @throws InvalidParameterException
     */
    public function __call(string $methodName, array $arguments)
    {
        // we create a reflection class so we can get the unqualified short name of the class
        $reflection = new ReflectionClass($this);

        // lower case first character and then replace Manager to Service to get
        // the main service's name. Ex: CorePartnerManager -> corePartnerService
        $mainService = (lcfirst(str_replace('Manager', 'Service', $reflection->getShortName())));

        // check if main service has a callable method with the same name as the on that we tried to execute
        if (is_callable([$this->{$mainService}, $methodName])) {
            return call_user_func_array([$this->{$mainService}, $methodName], $arguments);
        }

        // if method is not found we have to throw an exception so we are warned
        throw new InvalidParameterException($methodName);
    }
}
