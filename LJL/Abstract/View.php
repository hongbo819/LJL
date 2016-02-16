<?php

/*
|---------------------------------------------------------------
| Container for output data and renderer strategy.
|---------------------------------------------------------------
| @package LJL
|
*/

abstract class LJL_Abstract_View
{

    /*
    |---------------------------------------------------------------
    | Response object.
    |---------------------------------------------------------------
    | @var LJL_Response
    */
    public $data;

    /*
    |---------------------------------------------------------------
    | Reference to renderer strategy.
    |---------------------------------------------------------------
    | @var LJL_OutputRendererStrategy
    */
    protected $_rendererStrategy;

    /*
    |---------------------------------------------------------------
    | Constructor.
    |---------------------------------------------------------------
    | @param LJL_Response $data
    | @param LJL_OutputRendererStrategy $rendererStrategy
    | @return LJL_View
    */
    public function __construct(LJL_Response $response, LJL_Abstract_OutputRendererStrategy $rendererStrategy)
    {
        $this->data = $response;
        $this->_rendererStrategy = $rendererStrategy;
    }

    /*
    |---------------------------------------------------------------
    | Post processing tasks specific to view type.
    |---------------------------------------------------------------
    | @param LJL_View $view
    | @return boolean
    */
    abstract public function postProcess(LJL_View $view);

    /*
    |---------------------------------------------------------------
    | Delegates rendering strategy based on view.
    |---------------------------------------------------------------
    | @param LJL_View $this
    | @return string   Rendered output data
    */
    public function render()
    {
        return $this->_rendererStrategy->render($this);
    }
}
