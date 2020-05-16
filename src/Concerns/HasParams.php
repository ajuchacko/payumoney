<?php

namespace Ajuchacko\Payu\Concerns;

trait HasParams {

    public function setParams(array $params): void
    {
        $this->params = $params;
    }

    public function getParams(): array
    {
        return $this->params;
    }

    public function __get($name)
    {
        if (!isset($this->params[$name])) {
             throw new Exception ("Property {$name} is not defined");
        }

        return $this->params[$name];
    }
}