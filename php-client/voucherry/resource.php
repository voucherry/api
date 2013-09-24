<?

namespace Voucherry;

/**
* Resource
*/
class Resource
{

  public static $url;
  public static $resource_name;
  public static $collection_name;
  public static $remote_forbidden_attributes = array("id");
  public $attributes;

  public static function find($params = array()) {
    $resource_url = Resource::interpolate(static::$url, $params);
    if (isset($params["id"])) {
      $resource_url = "${resource_url}/${params['id']}";
    }
    $response = API::$default_client->get($resource_url);
    $response->decode_response();
    return new static(array_merge($params, $response->decoded_response[static::$resource_name]));
  }

  public static function create($params = array()) {
    $resource = new static($params);
    $resource->save();
    return $resource;
  }

  function __construct($attributes) {
    $this->attributes = $attributes;
  }

  function __get($key) {
    return $this->attributes[$key];
  }

  function __set($key, $value)  {
    $this->attributes[$key] = $value;
  }

  function __isset($key) {
    return isset($this->attributes[$key]);
  }

  function save() {
    $resource_url = Resource::interpolate(static::$url, $this->attributes);
    if (isset($this->attributes["id"])) {
      $resource_url = "${resource_url}/{$this->attributes['id']}";
    }
    $attrs = array();
    foreach ($this->attributes as $attr => $value) {
      if (!in_array($attr, static::$remote_forbidden_attributes)) {
        $attrs[$attr] = $value;
      }
    }
    $response = null;
    if (isset($this->attributes["id"])) {
      $response = API::$default_client->put($resource_url, array(static::$resource_name => $attrs));
    } else {
      $response = API::$default_client->post($resource_url, array(static::$resource_name => $attrs));
    }
    $response->decode_response();
    if (isset($response->decoded_response[static::$resource_name])) {
      $this->attributes = array_merge($this->attributes, $response->decoded_response[static::$resource_name]);
    }
    return $this;
  }

  public static function interpolate($string, $vars) {
    foreach ($vars as $key => $value) {
      $string = str_replace("{".$key."}", $value, $string);
    }
    return $string;
  }


}

?>
