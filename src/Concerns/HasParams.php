<?php

namespace Ajuchacko\Payu\Concerns;

trait HasParams {
    /**
     * Set Params provided.
     *
     * @param  array $params
     * @return void
     */
    public function setParams(array $params): void
    {
        $this->params = $params;
    }

    /**
     * Get Params provided.
     *
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * Get values in params as properties of object.
     *
     * @param  string $name
     * @return string
     * @throws \Exception
     */
    public function __get($name)
    {
        if (!isset($this->params[$name])) {
             throw new Exception ("Property {$name} is not defined");
        }

        return $this->params[$name];
    }
}