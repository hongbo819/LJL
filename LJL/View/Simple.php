<?php

/*
|---------------------------------------------------------------
| Wrapper for simple HTML views.
|---------------------------------------------------------------
| @package LJL
|
*/

class LJL_View_Simple extends LJL_Abstract_View
{
    /*
    |---------------------------------------------------------------
    | HTML renderer decorator
    |---------------------------------------------------------------
    | @param LJL_Response $data
    | @param string $templateEngine
    |
    */
    public function __construct(LJL_Response $response, $templateEngine = null)
    {
        //  prepare renderer class
        if (is_null($templateEngine)) {
            $templateEngine = 'php';
        }
        
        $templateEngine =  ucfirst($templateEngine);
        $rendererClass  = 'LJL_OutputRenderer_' . $templateEngine . 'Strategy';
        
        parent::__construct($response, new $rendererClass);
    }

    public function postProcess(LJL_View $view)
    {
        // do nothing
    }
}
