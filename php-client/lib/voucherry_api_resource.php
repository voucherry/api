<?
require_once(__DIR__."/voucherry_api_response.php");


class VoucherryAPIResource {

  const HTTP_GET = "GET";
  const HTTP_POST = "POST";
  const HTTP_PUT = "PUT";
  const HTTP_DELETE = "DELETE";

  public static $site = "https://voucherry.com";
  public static $api_token = null;
  public static $format = "json";


  public static $resource_name  = null;
  public static $resource_path  = null;

  public $statusMessage = null;
  public $statusCode = -1;


  private $_isDirty = true;
  private $attributes;

  function __construct($attributes){
    $this->attributes = $attributes;
  }


  function __get($key)          { return $this->attributes[$key];         }
  function __set($key, $value)  { 
    $this->_isDirty = true;
    $this->attributes[$key] = $value;
  }
  function __isset($key)        { return isset($this->attributes[$key]);  }


  function isValid(){
    return $this->stausCode >= 200 && $this->statusCode < 400;
  }

  function isNewResource(){
    return !isset($this->id);
  }

  function save(){
    if( $this->_isDirty){ 
      $method = $this->isNewResource() ? $this::HTTP_POST : $this::HTTP_PUT;
      $response = $this::$method( $this::getResourceUrl($this->id), array( $this::$resource_name => $this->attributes ));

      $this->statusMessage = $response->getStatusMessage();
      $this->statusCode = $response->getStatusCode();

      if($response->isSuccess()){
        $this->_isDirty = false;
        $this->attributes = $response->json();
      }

    }
    return !$this->_isDirty;
  }

  function destroy(){
    if($this->isNewResource()){
      return true;
    }

    $response = $this::delete($this::getResourceUrl($this->id));

    $this->statusMessage = $response->getStatusMessage();
    $this->statusCode = $response->getStatusCode();
    return $response->isSuccess();

  }

  function reload(){
    self::get($this->getResourceUrl());
  }


  public static function getResourceUrl($id){
    $class = get_called_class();
    $base = $class::$site . $class::$resource_path;
    if( isset($id) ){ $base .= "/" . $id; }

    return $base;
  }


  public static function create($params=array()){
    $class = get_called_class();
    $object = new $class($params);
    $object->save();
    return $object;
  }

  public static function first($id,$params=array()) {
    $class = get_called_class();
    $response = self::get(self::getResourceUrl($id),$params);
    if($response->isSuccess()) {
      $object = new $class($response->json());      

      $object->statusMessage = $response->getStatusMessage();      
      $object->statusCode = $response->getStatusCode();

      $object->_isDirty = false;
      return $object;
    }else{
      return null;
    }
  }

  protected static function get($url,$params=array()){
    return self::perform(self::HTTP_GET, $url, $params);
  }

  protected static function post($url,$params=array()){
    return self::perform(self::HTTP_POST, $url, $params);
  }

  protected static function put($url,$params=array()){
    return self::perform(self::HTTP_PUT, $url, $params);
  }


  protected static function delete($url,$params=array()){
    return self::perform(self::HTTP_DELETE, $url, $params);
  }


  private static function perform($method, $url, $params){
    $class = get_called_class();
    $handle = curl_init();

    $is_post = $method == self::HTTP_PUT || $method == self::HTTP_POST;
    $encoded_params = http_build_query($params);
    $url .=".".self::$format;

    $params["_method"] = strtolower($method);

    $opts = array(
      CURLOPT_HEADER => TRUE,
      CURLOPT_RETURNTRANSFER => TRUE, 
      CURLOPT_USERAGENT => "Voucherry API v0.0.1a",
      CURLOPT_USERPWD => sprintf("%s:x", self::$api_token),
      CURLOPT_POST => $is_post,
      CURLOPT_URL => $url,
      CURLOPT_CUSTOMREQUEST => $method
      );

    if ( ! $opts[CURLOPT_POST] ){
      $opts[CURLOPT_URL] .= strpos($url, '?')? '&' : '?';
      $opts[CURLOPT_URL] .= $encoded_params;
    }else{
      $opts[CURLOPT_POSTFIELDS] = $encoded_params;
    }


    curl_setopt_array($handle, $opts);
    $response = new VoucherryAPIResponse(curl_exec($handle), (object) curl_getinfo($handle), curl_error($handle));
    curl_close($handle);

    return $response;

  }

};

if (!function_exists('http_build_query')) { 
  function http_build_query($data, $prefix='', $sep='', $key='') { 
    $ret = array(); 
    foreach ((array)$data as $k => $v) { 
      if (is_int($k) && $prefix != null) { 
        $k = urlencode($prefix . $k); 
      } 
      if ((!empty($key)) || ($key === 0))  $k = $key.'['.urlencode($k).']'; 
      if (is_array($v) || is_object($v)) { 
        array_push($ret, http_build_query($v, '', $sep, $k)); 
      } else { 
        array_push($ret, $k.'='.urlencode($v)); 
      } 
    } 
    if (empty($sep)) $sep = ini_get('arg_separator.output'); 
    return implode($sep, $ret); 
  }// http_build_query 
}//if

if(!function_exists('get_called_class')) {
  function get_called_class($bt = false,$l = 1) {
    if (!$bt) $bt = debug_backtrace();
    if (!isset($bt[$l])) throw new Exception("Cannot find called class -> stack level too deep.");
    if (!isset($bt[$l]['type'])) {
      throw new Exception ('type not set');
    }
    else switch ($bt[$l]['type']) {
      case '::':
      $lines = file($bt[$l]['file']);
      $i = 0;
      $callerLine = '';
      do {
        $i++;
        $callerLine = $lines[$bt[$l]['line']-$i] . $callerLine;
      } while (stripos($callerLine,$bt[$l]['function']) === false);
      preg_match('/([a-zA-Z0-9\_]+)::'.$bt[$l]['function'].'/',
        $callerLine,
        $matches);
      if (!isset($matches[1])) {
        // must be an edge case.
        throw new Exception ("Could not find caller class: originating method call is obscured.");
      }
      switch ($matches[1]) {
        case 'self':
        case 'parent':
        return get_called_class($bt,$l+1);
        default:
        return $matches[1];
      }
      // won't get here.
      case '->': switch ($bt[$l]['function']) {
        case '__get':
        // edge case -> get class of calling object
        if (!is_object($bt[$l]['object'])) throw new Exception ("Edge case fail. __get called on non object.");
        return get_class($bt[$l]['object']);
        default: return $bt[$l]['class'];
      }

      default: throw new Exception ("Unknown backtrace method type");
    }
  }
}



?>