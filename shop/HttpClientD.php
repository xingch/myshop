<?php      
class HttpClientD{
	protected $_userAgent='Mozilla/5.0 (Windows NT 6.1; rv:7.0.1) Gecko/20100101 Firefox/7.0.1';
	protected $_url='';
	protected $_curl=false;
	protected $_handle=null;
	protected $_referer='';
	protected $_ip='';
	protected $_proxy='';
	public function setUserAgent($userAgent){
		$this->_userAgent=$userAgent;
	}
	private $handle=null;
	private $file=null;
	public function __construct($file,$curl=true){
		$this->_url=$file;
		if($curl!==false){
			$this->_curl=true;
		}
		$this->_handle=null;
	}
	public function setCookiesAsString($str){
		if($this->_curl&&function_exists('curl_init')){
			curl_setopt($this->_handle,CURLOPT_COOKIESESSION,true);
			curl_setopt($this->_handle,CURLOPT_COOKIE,$str);
		}
	}
	public function setCookies($cookiesArrayObject){
		if($this->_curl&&function_exists('curl_init')){
			curl_setopt($this->_handle,CURLOPT_COOKIESESSION,true);
			curl_setopt($this->_handle,CURLOPT_COOKIE,http_build_query($cookiesArrayObject));
		}
	}
	public function getUrlScheme(){
		$pathinfo=parse_url($this->_url);
		if(isset($pathinfo['scheme'])){
			return $pathinfo['scheme'];
		}else{
			if(isset($_SERVER['SERVER_PROTOCOL'])){
				return strtolower(substr($_SERVER['SERVER_PROTOCOL'],0,strpos($_SERVER['SERVER_PROTOCOL'],'/')));
			}
		}
	}
	public function getHost(){
		$pathinfo=parse_url($this->_url);
		if(isset($pathinfo['host'])){
			return $this->getUrlScheme().'://'.$pathinfo['host'];
		}else{
			if(isset($_SERVER['HTTP_HOST'])){
				return $this->getUrlScheme().'://'.$_SERVER['HTTP_HOST'];
			}
		}		
	}
	public function setPostData(array $dataArrayObject){
		if($this->_curl&&function_exists('curl_init')){
			curl_setopt($this->_handle, CURLOPT_POST, 1);
			curl_setopt($this->_handle, CURLOPT_POSTFIELDS,http_build_query($dataArrayObject));
		}
	}
	public function setRederer($referer){
		$this->_referer=$referer;
	}
	public function setIp($ip){
		$this->_ip=$ip;
	}
	public function setProxy($proxy){
		$this->_proxy=$proxy;
	}
	public function open(){
		if($this->_curl&&function_exists('curl_init')){
			$this->_handle=curl_init();
			curl_setopt($this->_handle, CURLOPT_URL, $this->_url);
			curl_setopt($this->_handle, CURLOPT_NOBODY, 0);
			curl_setopt($this->_handle, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($this->_handle, CURLOPT_HEADER,0);
			curl_setopt($this->_handle, CURLOPT_TIMEOUT,3);
			$cookepath=dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'runtime'.DIRECTORY_SEPARATOR.'cookie'.DIRECTORY_SEPARATOR.hash('md4',$this->getHost()).'.txt';
			curl_setopt($this->_handle, CURLOPT_COOKIEJAR,$cookepath);
			curl_setopt($this->_handle, CURLOPT_COOKIEFILE,$cookepath);
			curl_setopt($this->_handle, CURLOPT_USERAGENT,$this->_userAgent);
			/*if($this->_ip===''){
				$this->_ip=mt_rand(1,254).'.'.mt_rand(1,254).'.'.mt_rand(1,254).'.'.mt_rand(1,254);
				curl_setopt ($this->_handle, CURLOPT_HTTPHEADER,array("Client-IP:$this->_ip","X-Forwarded-For:$this->_ip"));
			}else{
				curl_setopt ($this->_handle, CURLOPT_HTTPHEADER,array("Client-IP:$this->_ip","X-Forwarded-For:$this->_ip"));
			}*/ 
			if($this->_referer!==''){
				curl_setopt ($this->_handle, CURLOPT_REFERER, $this->_referer); 
			}
			if($this->_proxy!==''){
				curl_setopt ($this->_handle, CURLOPT_PROXY, $this->_proxy);
			}
		}
	}
	public function excute(){
		if ($this->_curl&&function_exists('curl_init')){
			$content=curl_exec($this->_handle);
			if(!is_string($content)){
				@curl_close($this->_handle);
				return null;
			}
			@curl_close($this->_handle);
			return trim($content);
		}
		return null;
	}
}
?>
