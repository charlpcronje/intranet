<?php
namespace system\base;
class View {
	static $blocks = [];
	static $cacheEnabled = false;
	static $ns = 'app.views';
	static $fileExtensions = ['phtml','html','htm'];
	static $viewExtention = 'phtml';
    /**
     * render function
     *
     * @param string $file
     * @param array $data
	 * @param string $ns namespace of view
     * @return void
     */
	static function render($file,$data = []) {
		self::clearCache();
		if (is_string($file) && strlen($file) > 0) {
			$cachedFile = self::cache($file);
			if (is_array($data)) {
				extract($data, EXTR_SKIP);
			}
			require $cachedFile;
		}
	}

	/**
	 * getFileExtension of the $file sent in the argument
	 * The is easily achieved by revering the extension and the file strings
	 * The extension will then be at string position 0, if no file extension
	 * was specified then it will return the default set in self::viewExtension
	 *
	 * @param string $file
	 * @return string
	 */
	static function addFileExtension($file) {
		foreach(self::$fileExtensions as $ext) {
			$pos = strpos(strrev($file),strrev($ext));
			if ($pos !== false) {
				self::$viewExtention = $ext;
				return $file;
			}
		}
		return $file.'.'.self::$viewExtention;
	}

	static function buildFileName($file) {
		return str_replace('.',DS,$file);
	}

    /**
     * cache function
     *
     * @param string $file
     * @return string
     */
	static function cache($file) {
		if (!file_exists(env('app.cache.path'))) {
		  	mkdir(env('app.cache.path'), 0744,true);
		}
	    $cachedFile = env('app.cache.path') . str_replace(['/', self::$viewExtention],['_', ''], $file . '.php');
	    //if (!self::$cacheEnabled || !file_exists($cachedFile) || filemtime($cachedFile) < filemtime($file)) {
			$code = self::includeFiles($file);
			$code = self::compileCode($code);
	        file_put_contents($cachedFile, '<?php class_exists(\'' . __CLASS__ . '\') or exit; ?>' . PHP_EOL . $code);
	    //}
		return $cachedFile;
	}

    /**
     * clearCache function
     *
     * @return void
     */
	static function clearCache() {
		foreach(glob(env('app.cache.path') . '*') as $file) {
			if (!is_dir($file)) {
				unlink($file);
			}
		}
	}

    /**
     * compileCode function
     *
     * @param string $code
     * @return string
     */
	static function compileCode($code) {
		$code = self::compileBlock($code);
		$code = self::compileYield($code);
		$code = self::compileEscapedEchos($code);
		$code = self::compileEchos($code);
		$code = self::compilePHP($code);
		return $code;
	}

    /**
     * includeFiles function
     * For the files being included in the views it will use the same namespace as the main view
	 * unless specified differently
     * @param string $file
     * @return string
     */
	static function includeFiles($file) {
		$file = self::buildFileName(self::$ns.'.'.$file);
		$file = self::addFileExtension($file);
		
		$code = file_get_contents($file);
		preg_match_all('/{% ?(extends|include) ?\'?(.*?)\'? ?%}/i', $code, $matches, PREG_SET_ORDER);
		foreach ($matches as $value) {
			$code = str_replace($value[0], self::includeFiles($value[2]), $code);
		}
		$code = preg_replace('/{% ?(extends|include) ?\'?(.*?)\'? ?%}/i', '', $code);
		return $code;
	}

    /**
     * compilePHP function
     *
     * @param string $code
     * @return string
     */
	static function compilePHP($code) {
		return preg_replace('~\{%\s*(.+?)\s*\%}~is', '<?php $1 ?>', $code);
	}

    /**
     * compileEchos function
     *
     * @param string $code
     * @return string
     */
	static function compileEchos($code) {
		return preg_replace('~\{{\s*(.+?)\s*\}}~is', '<?php echo $1 ?>', $code);
	}

    /**
     * compileEscapedEchos function
     *
     * @param string $code
     * @return string
     */
	static function compileEscapedEchos($code) {
		return preg_replace('~\{{{\s*(.+?)\s*\}}}~is', '<?php echo htmlentities($1, ENT_QUOTES, \'UTF-8\') ?>', $code);
	}

    /**
     * compileBlock function
     *
     * @param string $code
     * @return string
     */
	static function compileBlock($code) {
		preg_match_all('/{% ?block ?(.*?) ?%}(.*?){% ?endblock ?%}/is', $code, $matches, PREG_SET_ORDER);
		foreach ($matches as $value) {
			if (!array_key_exists($value[1], self::$blocks)) self::$blocks[$value[1]] = '';
			if (strpos($value[2], '@parent') === false) {
				self::$blocks[$value[1]] = $value[2];
			} else {
				self::$blocks[$value[1]] = str_replace('@parent', self::$blocks[$value[1]], $value[2]);
			}
			$code = str_replace($value[0], '', $code);
		}
		return $code;
	}

    /**
     * compileYield function
     *
     * @param string $code
     * @return string
     */
	static function compileYield($code) {
		foreach(self::$blocks as $block => $value) {
			$code = preg_replace('/{% ?yield ?' . $block . ' ?%}/', $value, $code);
		}
		$code = preg_replace('/{% ?yield ?(.*?) ?%}/i', '', $code);
		return $code;
	}

}
