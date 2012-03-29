<?
require_once(__DIR__."/../lib/voucherry_api_resource.php");

class CherriesRequest extends VoucherryAPIResource {

  public static $resource_path = "/api/v1/cherries_requests";
  public static $resource_name = "cherries_request";

  function confirm(){
    $response = $this::get($this::getResourceUrl($this->id)."/confirm");
    if($response->isSuccess()){
      $this->attributes = $response->json();
      return true;
    }else{
      $this->statusMessage = $response->getStatusMessage();
      $this->statusCode = $response->getStatusCode();
      return false;
    }
  }

  function isConfirmed(){
    return $this->status === "confirmed";
  }
};



?>