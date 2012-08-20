<?php
/**
 * Coffee to JS Converter Plugin
 *
 * This plugin compiles your .coffee files to regular JS withouth relying on
 * client- or serverside JavaScript such as node
 *
 * Relies on the coffeescript class in Vendor
 *
 * PHP versions 5.3+ as it uses namespaces and anonymous functions
 *
 * Mindthecode: http://www.mindthecode.com
 * Copyright 2011, Stef van den Ham
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @author        Stef van den Ham
 * @copyright     Copyright 2011, Mindthecode (http://www.mindthecode.com)
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
App::uses('Folder', 'Utility');
App::uses('File', 'Utility');
App::uses('Component', 'Controller');

class CoffeeHelper extends AppHelper {

	public $helpers = array('Html');

	public function __construct(View $View, $options = array()) {
		parent::__construct($View, $options);
		$this->coffeeFolder = new Folder(WWW_ROOT.'coffee');
		$this->jsFolder = new Folder(WWW_ROOT.'js');;
	}

	public function script($file) {
		if (is_array($file)) {
			foreach ($file as $candidate) {
				$source = $this->coffeeFolder->path.DS.$candidate.'.coffee';
				if (file_exists($source)) {
					$target = str_replace('.coffee', '.js', str_replace($this->coffeeFolder->path, $this->jsFolder->path, $source));
					$this->auto_compile_coffee($source, $target);
				}
			}
		} else {
			$source = $this->coffeeFolder->path.DS.$file.'.coffee';
			if (file_exists($source)) {
				$target = str_replace('.coffee', '.js', str_replace($this->coffeeFolder->path, $this->jsFolder->path, $source));
				$this->auto_compile_coffee($source, $target);
			}
		}
		return $this->Html->script($file);
	}

	public function auto_compile_coffee($coffee_fname, $js_fname) {
		if (file_exists($js_fname) === false || filemtime($js_fname) < filemtime($coffee_fname)) {
			$coffeeScript = file_get_contents($coffee_fname);
			if ($coffeeScript !== '') {
				try {
					if (class_exists('CoffeeScript\Compiler') == false) {
						require_once(dirname(__FILE__).'/../../Vendor/CoffeeScript/Init.php');
						CoffeeScript\Init::load();
					}
					$new_cache = CoffeeScript\Compiler::compile($coffeeScript);
					$jsFile = new File($js_fname, TRUE);
					$jsFile->write($new_cache);
				} catch (Exception $e) {
					echo "<pre>";
					echo ($e);
					echo "</pre>";
				}
			}
		}
	}

}
