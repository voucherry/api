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
    $this->connection = new \RestClient(array(
      "base_url" => $hostname,
      "username" => $api_key,
      "password" => "voucherry",
      "format"   => "json"
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

  public static function get_account() {
    return Account::find();
  }

  public static function get_reward($campaign_id, $reward_id) {
    return Reward::find(array("campaign_id" => $campaign_id, "id" => $reward_id));
  }

  public static function create_reward($campaign_id, $amount, $expires_at, $identifier="", $event="", $event_description="") {
    return Reward::create(array(
          "campaign_id" => $campaign_id,
          "amount" => $amount,
          "expires_at" => $expires_at,
          "identifier" => $identifier,
          "event" => $event,
          "event_description" => $event_description
    ));
  }

  public static function create_email_reward($campaign_id, $email, $amount, $expires_at, $identifier="", $event="", $event_description="") {
    return EmailReward::create(array(
          "campaign_id" => $campaign_id,
          "email" => $email,
          "amount" => $amount,
          "expires_at" => $expires_at,
          "identifier" => $identifier,
          "event" => $event,
          "event_description" => $event_description
    ));
  }

  public static function assign_reward($campaign_id, $reward_id, $uid) {
    $reward = new Reward(array("campaign_id" => $campaign_id, "id" => $reward_id));
    return $reward->accept($uid);
  }

}

?>
