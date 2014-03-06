<?

namespace Voucherry;

/**
* API
*/
class API
{

  public static $hostname = "https://voucherry.com";
  public static $api_key = null;
  public static $default_client = null;

  public $_api_key;
  public $_hostname;
  public $connection;

  public static function configure($config) {
    if (isset($config["api_key"])) {
      API::$api_key = $config["api_key"];
    }
    if (isset($config["hostname"])) {
      API::$hostname = $config["hostname"];
    }
    API::$default_client = new API(API::$api_key, API::$hostname, array("verify_ssl" => API::$hostname=="https://voucherry.com"));
  }

  public function __construct($api_key, $hostname, $options=array()) {
    $this->_api_key = $api_key;
    $this->_hostname = $hostname;
    $verify_ssl = isset($options["verify_ssl"]) && $options["verify_ssl"]==true;
    $this->connection = new \RestClient(array(
      "base_url" => $hostname,
      "username" => $api_key,
      "password" => "voucherry",
      "format"   => "json",
      "curl_options" => array(
        CURLOPT_SSL_VERIFYHOST => $verify_ssl,
        CURLOPT_SSL_VERIFYPEER => $verify_ssl
      )
    ));
    $this->connection->register_decoder('json', create_function('$a', "return json_decode(\$a, TRUE);"));
  }

  public function get($url) {
    return $this->connection->get($url);
  }

  public function post($url, $params = array()) {
    return $this->connection->post($url, $params);
  }

  public function put($url, $params = array()) {
    return $this->connection->put($url, $params);
  }

}

?>
