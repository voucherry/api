<?

namespace Voucherry;

/**
* Reward
*/
class Reward extends Resource
{
    public static $url = "api/v2/campaigns/{campaign_id}/rewards";
    public static $resource_name = "reward";
    public static $collection_name = "rewards";
    public static $remote_forbidden_attributes = array("id", "campaign_id");

    public function accept($uid) {
      $resource_url = Resource::interpolate(static::$url, $this->attributes);
      $resource_url = "${resource_url}/{$this->attributes['id']}/accept";
      $response = API::$default_client->put($resource_url, array("uid" => $uid));
      $response->decode_response();
      if (isset($response->decoded_response[static::$resource_name])) {
        $this->attributes = array_merge($this->attributes, $response->decoded_response[static::$resource_name]);
      }
      return $this;
    }

}

?>
