<?

require_once(__DIR__."/resources/cherries_transfer.php");
require_once(__DIR__."/resources/cherries_request.php");

/** 
* API Wrappers to the rest interface published by voucherry.com
* 
* @author Vlad Verestiuc Ovidiu <vlad.verestiuc@voucherry.com> 
* @version 1.0
* @since 1.0
* @access public 
* @copyright Voucherry LLC
* 
*/
class VoucherryAPI {
  /**
  * Sets up credentials for api.
  *
  * @param string $api_id you api key
  * @access public
  * @return none
  */
  public static function configure($api_key, $site = "https://voucherry.com"){
    VoucherryResource::$site = $site;
    VoucherryResource::$api_token = $api_key;
  }

  /**
  * Send Cherries to an email address.
  * 
  *   The email address doesn't need to have an account associated on 
  * voucherry.com platform, an email will be sent to the given email address 
  * that will in your behalf.
  *   In case of errors the $<CherriesTransfer instance>->statusMessage will 
  * be set to the according error Message (eq:validation errors, communication 
  * errors).
  * 
  * @param string $email_address receivers email address
  * @param integer $cherries_amount amount of cherries that the user will receive
  * @param string $notification_title the title of the notification that the user will receive limit to xxx characters.
  * @param string $notification_body the content of the notification that the user will receive limit to xxx characters.
  * @param array $metadata an array that is serialized on our end and allows storing arbitrary data that can be retrieved later.
  * @access public
  * @return CherriesTransfer resource
  */
  public static function sendCherriesToEmailAddress($email_address, $cherries_amount, $notification_title, $notification_body, $metadata){
    $object = CherriesTransfer::create(array(
      "email_address" => $email_address,
      "cherries_amount" => $cherries_amount,
      "email_subject" => $notification_title,
      "email_body" => $notification_body,
      "metadata" => $metadata
      ));
    return $object;
  }

  /**
  * Send Cherries to an invite id.
  * 
  *   The invite id needs to be a valid voucherry.com invite id.
  *   In case of errors the $<CherriesTransfer instance>->statusMessage will 
  * be set to the according error Message (eq:validation errors, communication 
  * errors).
  * 
  * @param string $email_address receivers email address
  * @param integer $cherries_amount amount of cherries that the user will receive
  * @param string $notification_title the title of the notification that the user will receive limit to xxx characters.
  * @param string $notification_body the content of the notification that the user will receive limit to xxx characters.
  * @param array $metadata an array that is serialized on our end and allows storing arbitrary data that can be retrieved later.
  * @access public
  * @return CherriesTransfer resource
  */
  public static function sendCherriesToInviteID($invite_id, $cherries_amount, $notification_title, $notification_body, $metadata){
    $object = CherriesTransfer::create(array(
      "invite_id" => $invite_id,
      "cherries_amount" => $cherries_amount,
      "email_subject" => $notification_title,
      "email_body" => $notification_body,
      "metadata" => $metadata
      ));
    return $object;
  }

  /**
  * Creates a cherries transfer request (cherry charge).
  * 
  *   The email address needs to have a account associated on voucherry.com.
  * If this constrain is not satisfied then the ->statusMessage member
  * of the returned resource will be set to an error message.
  *   In case of errors the $<CherriesRequest instance>->statusMessage will 
  * be set to the according error Message (eq:validation errors, communication 
  * errors).
  * Important: The cherries will not be transferred right away you need to 
  * issue a confirmation call so that the actual transfer really happens.
  * 
  * @param string $email_address receivers email address
  * @param integer $cherries_amount amount of cherries that the user will receive
  * @param string $reason the reason for the charge.
  * @param string $description a detail description of the charge.
  * @param array $metadata an array that is serialized on our end and allows storing arbitrary data that can be retrieved later.
  * @access public
  * @return CherriesRequest resource
  */
  public static function requestCherriesWithEmail($email_address, $cherries_amount, $reason, $description, $metadata){
    $object = CherriesRequest::create(array(
      "email_address" => $email_address,
      "cherries_amount" => $cherries_amount,
      "title" => $reason,
      "description" => $description,
      "metadata" => $metadata));
    return $object;
  }

  /**
  * Creates a cherries transfer request (cherry charge).
  * 
  *   The invite id needs to have an account associated on voucherry.com.
  * of the returned resource will be set to an error message.
  *   In case of errors the $<CherriesRequest instance>->statusMessage will 
  * be set to the according error Message (eq:validation errors, communication 
  * errors).
  * Important: The cherries will not be transferred right away you need to 
  * issue a confirmation call so that the actual transfer really happens.
  *  
  * @param string $email_address receivers email address
  * @param integer $cherries_amount amount of cherries that the user will receive
  * @param string $reason the reason for the charge.
  * @param string $description a detail description of the charge.
  * @param array $metadata an array that is serialized on our end and allows storing arbitrary data that can be retrieved later.
  * @access public
  * @return CherriesRequest resource
  */
  public static function requestCherriesWithInviteId($invite_id, $cherries_amount, $reason, $description, $metadata){
    $object =  CherriesRequest::create(array(
      "invite_id" => $invite_id,
      "cherries_amount" => $cherries_amount,
      "title" => $reason,
      "description" => $description,
      "metadata" => $metadata));
    return $object;
  }

  /**
  * Confirms a cherries transfer request (cherry charge).
  * 
  * @param string $id a resource identifier created using requestCherriesWithInviteId.
  * @see requestCherriesWithInviteId($invite_id, $cherries_amount, $reason, $description, $metadata)
  * @access public
  * @return CherriesRequest resource if the resource is found false otherwise.
  */
  public static function confirmCherriesRequestWithId($id) {
    $request = CherriesRequest::first($id);
    if($request){
      $request->confirm();
      return $request;
    }else{
      return false;
    }
  }

}

?>