<?php

/*
|---------------------------------------------------------------
| output renderer strategy
|---------------------------------------------------------------
| @package LJL
|
*/

abstract class LJL_Abstract_OutputRendererStrategy
{

    public function __construct()
    {
    }

    abstract protected function _initEngine(LJL_Response $data);


    abstract public function render(LJL_Abstract_View $view);
}

