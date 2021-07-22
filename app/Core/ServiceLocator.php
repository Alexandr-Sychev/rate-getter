<?php

namespace App\Core;

use Exception;
use Throwable;

class ServiceLocator
{
    protected array $singletonServices = [];
    protected bool $configIsReaded = false;
    protected array $config = [];

    protected const CONFIG_FILE = '../config/di.php';

    public function getService(string $className)
    {
        $classInfo = $this->resolve($className);

        return $this->getInstance($classInfo);
    }

    protected function getInstance(array $classInfo)
    {
        if (array_key_exists('singleton', $classInfo) && $classInfo['singleton'] === true) {
            $instance = $this->getOrCreateInstance($classInfo['class']);
        } else {
            $instance = $this->createInstance($classInfo['class']);
        }

        return $instance;
    }

    protected function getOrCreateInstance(string $className)
    {
        if (!array_key_exists($className, $this->singletonServices)) {
            $this->singletonServices[$className] = $this->createInstance($className);
        }

        return $this->singletonServices[$className];
    }

    protected function resolve(string $className)
    {
        if (!$this->configIsReaded) {
            $this->readConfig();
        }

        $classInfo = $this->findImplementation($className);

        if (!$classInfo) {
            $classInfo = ['class' => $className];
        }

        if (!$this->classInfoIsValid($classInfo)) {
            throw new Exception('Class was not resolved');
        }

        return $classInfo;
    }

    protected function classInfoIsValid($classInfo): bool
    {
        if (!is_array($classInfo)) {
            return false;
        }

        if (!array_key_exists('class', $classInfo)) {
            return false;
        }

        return true;
    }

    protected function findImplementation(string $className)
    {
        if (!array_key_exists($className, $this->config)) {
            return null;
        } else {
            return $this->config[$className];
        }
    }

    protected function createInstance(string $className)
    {
        try {
            return new $className();
        } catch (Throwable $exception) {
            throw new Exception("Не удалось создать экземпляр $className");
        }
    }

    protected function readConfig()
    {
        $this->config = require self::CONFIG_FILE;
        $this->configIsReaded = true;
    }
}