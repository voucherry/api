<?php

require_once(__DIR__."/lib/restclient.php");

class VoucherryAPI
{

  private $connection;

  function __construct($api_key, $hostname = "voucherry.com")
  {
    $verify_ssl = $hostname=="voucherry.com";
    $this->connection = new \RestClient(array(
      "base_url" => "https://$hostname/api/v2",
      "username" => $api_key,
      "password" => "voucherry",
      "format"   => "json",
      "curl_options" => array(
        CURLOPT_SSL_VERIFYHOST => $verify_ssl,
        CURLOPT_SSL_VERIFYPEER => $verify_ssl
      )
    ));
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

  public function get_account() {
    $response = $this->get("account");
    $response->decode_response();
    return $response->decoded_response;
  }

  public function get_reward($campaign_id, $reward_id) {
    $response = $this->get("campaigns/{$campaign_id}/rewards/{$reward_id}");
    $response->decode_response();
    return $response->decoded_response;
  }

  public function create_reward($campaign_id, $amount, $expires_at, $expiration_policy, $cause_uid, $identifier="", $event="", $event_description="") {
    $response = $this->post("campaigns/{$campaign_id}/rewards", array("reward" => array(
      "amount" => $amount,
      "expires_at" => $expires_at,
      "identifier" => $identifier,
      "event" => $event,
      "event_description" => $event_description,
      "expiration_policy" => $expiration_policy,
      "preferred_cause_id" => $cause_uid
    )));
    $response->decode_response();
    return $response->decoded_response;
  }

  public function create_email_reward($campaign_id, $email, $message, $amount, $expires_at, $expiration_policy, $cause_uid, $identifier="", $event="", $event_description="") {
    $response = $this->post("campaigns/{$campaign_id}/email_rewards", array("reward" => array(
      "email" => $email,
      "message" => $message,
      "amount" => $amount,
      "expires_at" => $expires_at,
      "identifier" => $identifier,
      "event" => $event,
      "event_description" => $event_description,
      "expiration_policy" => $expiration_policy,
      "preferred_cause_id" => $cause_uid
    )));
    $response->decode_response();
    return $response->decoded_response;
  }

  public function assign_reward($campaign_id, $reward_id, $uid) {
    $response = $this->put("campaigns/{$campaign_id}/rewards/{$reward_id}/accept", array("uid" => $uid));
    $response->decode_response();
    return $response->decoded_response;
  }




}

?>
