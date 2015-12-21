<?php

class LJL_OutputRenderer_PhpStrategy extends LJL_Abstract_OutputRendererStrategy
{

	public function render(LJL_Abstract_View $view)
	{
		$php = $this->_initEngine($view->data);
		if (!LJL_File::exists($php->getTemplate()))
		{
			throw new LJL_Exception('The template dose not exist or is not readable: ' . $php->getTemplate());
		}
		$variables = $php->getBody();
		if (!empty($variables))
		{
			extract($variables);
		}
		ob_start();
		include $php->getTemplate();
		$content = ob_get_contents();
		ob_end_clean();
		return $content;
	}

	protected function _initEngine(LJL_Response $response)
	{
		return $response;
	}
}


