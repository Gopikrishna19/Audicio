<?php
    namespace Lib;

    class Boot {
        private $_url = NULL;

        private static $_home = "home";
        private static $_error = "error";
        private static $_default = "index";
    
        public function __construct() {
            $this->getUrl();
            $url = $this->_url;
    
            $controller = NULL;
            $func = self::$_default;
			$param = [];
			
            if(file_exists("Controllers/".$url[0].".php")) {
                require_once "Controllers/".$url[0].".php";
                $controller = new $url[0]();
				$controller->loadModel($url[0]);
				
				switch(sizeof($url)) {
					case 5:
					case 4:
					case 3: $param = array_slice($url, 2);
					case 2: if(method_exists($controller, $url[1])) $func = $url[1];
							else $controller = new self::$_error(400);
							break;
				}
				
            } else {
                $controller = new self::$_error(404);
            }
			
			switch(sizeof($param)) {
				case 0: $controller->$func(); break;
				case 1: $controller->$func($param[0]); break;
				case 2: $controller->$func($param[0],$param[1]); break;
				case 3: $controller->$func($param[0],$param[1],$param[2]); break;
			}
        }
    
        function getUrl() {
            $url = isset($_GET['url']) ? $_GET['url'] : self::$_home;
            $url = trim($url, '/');
            $url = explode('/', $url);
    
            $this->_url = $url;
        }
    }
?>