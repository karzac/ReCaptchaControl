<?php

/**
 * This file is part of the ReCaptchaControl package
 *
 * Copyright (c) 2015 Petr Kessler (http://kesspess.1991.cz)
 *
 * @license  MIT
 * @link     https://github.com/uestla/ReCaptchaControl
 */

namespace ReCaptchaControl;

use Nette\Http;
use Nette\Forms;
use Nette\Utils\Html;


/**
 * Nette\Forms reCAPTCHA implementation
 *
 * @author kesspess
 */
class ReCaptchaControl extends Forms\Controls\BaseControl
{

	/** Validation callback */
	const VALID = __CLASS__ . '::validateValid';

	/** @var ReCaptcha */
	private $reCaptcha;

	/** @var Http\Request */
	private $httpRequest;


	/**
	 * @param  ReCaptcha $reCaptcha
	 * @param  Http\Request $httpRequest
	 * @param  string $caption
	 */
	function __construct(ReCaptcha $reCaptcha, Http\Request $httpRequest, $caption = NULL)
	{
		parent::__construct($caption);

		$this->reCaptcha = $reCaptcha;
		$this->httpRequest = $httpRequest;
		$this->control = $reCaptcha->getHtml();
	}


	/** @return Html */
	function getControl()
	{
		$this->setOption('rendered', TRUE);
		$control = clone $this->control;
		$control->id = $this->getHtmlId();
		return $control;
	}


	/**
	 * @param  Forms\IControl $control
	 * @return bool
	 */
	static function validateValid(Forms\IControl $control)
	{
		$httpRequest = $control->getHttpRequest();
		return $control->getReCaptcha()->validate($httpRequest->getRemoteAddress(), $httpRequest->getPost());
	}


	/** @return Http\Request */
	function getHttpRequest()
	{
		return $this->httpRequest;
	}


	/** @return ReCaptcha */
	function getReCaptcha()
	{
		return $this->reCaptcha;
	}


	/**
	 * @param  Http\Request $httpRequest
	 * @param  ReCaptcha $reCaptcha
	 * @param  string
	 * @return void
	 */
	static function register(Http\Request $httpRequest, ReCaptcha $reCaptcha, $method = 'addRecaptcha')
	{
		Forms\Container::extensionMethod($method, function ($container, $name, $label = NULL) use ($httpRequest, $reCaptcha) {
			return $container[$name] = new ReCaptchaControl($reCaptcha, $httpRequest, $label);
		});
	}

}
