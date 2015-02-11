<?php 
class Structure extends Base{

	protected $_page;
	protected $_vars;
	public $_host;
	
	//Define the variable divider
	protected $variableDevider = "/";
	
	//getting the current page the user are viewing
	function __construct() {
		$request = parse_url($_SERVER['REQUEST_URI']);
		$path = $request["path"];

		$this->_vars = explode("/", $path);
		$this->_page = $this->variableDevider.$this->_vars[1];
		$this->_host = $_SERVER['HTTP_HOST'];
	}
	
	// completes the page/file url
	private function _completeUrl($page) {
		return "view/".$page.".php";
	}
	
	//check the if the page exists, if it does not display 404 page
	private function _checkPage() {

		if (!empty($this->_page)) {
			if (array_key_exists($this->_page, $this->pagestructure)) {
				return $this->_page;
			} else {
				return "404";
			}
		} else {
			return "/";	
		}
	}
	
	//gets the correct file to display
	public function get_content() {
		//inclueds
		$page = $this->_checkPage($this->_page);
		
		return $this->_completeUrl($this->pagestructure[$page]['page']);
		
	}
	
	//gets page title
	public function get_title() {
		//echo
		
		$page = $this->_checkPage($this->_page);
		
		return $this->pagestructure[$page]['title'];
		
	}
	
	//gets additional styles to link up
	public function get_styles() {
		//echo
		
		$page = $this->_checkPage($this->_page);
		
		return $this->pagestructure[$page]['style'];
		
	}
	
	//gets the pages name
	public function get_name() {
		//echo
		
		$page = $this->_checkPage($this->_page);
		
		return $this->pagestructure[$page]['name'];
		
	}
	
	public function get_frame() {
		//echo
		
		$page = $this->_checkPage($this->_page);
		
		return $this->pagestructure[$page]['frame'];
		
	}
	
	//gets additional styles to link up
	public function get_page() {
		//echo
		
		return $this->_page;
		
	}
	
	//get a variable assigned to the specific page
	public function get_var($var) {
	
		if (isset($this->_vars[$var + 1])) {
			return $this->_vars[$var + 1];
		} else {
			return false;
		}
			
	}
	
}

