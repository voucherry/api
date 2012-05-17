<?

class VoucherryAPI {
  public static function configure($api_key, $site = "https://voucherry.com"){
    VoucherryResource::$site = $site;
    VoucherryResource::$api_token = $api_key;

  }

  public static function sendCherriesToEmailAddress($email_address, $cherries_amount, $tracking_number, $notification_title, $notification_body, $metadata){
    $object = CherriesTransfer::create(array(
      "email_address" => $email_address,
      "cherries_amount" => $cherries_amount,
      "email_subject" => $notification_title,
      "email_body" => $notification_body,
      "metadata" => $metadata,
      "tracking-number" => $tracking_number
      ));
    return $object;
  }

  public static function sendCherriesToInviteID($invite_id, $cherries_amount, $tracking_number, $notification_title, $notification_body, $metadata){
    $object = CherriesTransfer::create(array(
      "invite_id" => $invite_id,
      "cherries_amount" => $cherries_amount,
      "email_subject" => $notification_title,
      "email_body" => $notification_body,
      "metadata" => $metadata,
      "tracking-number" => $tracking_number
      ));
    return $object;
  }

  public static function requestCherriesWithEmail($email_address, $cherries_amount $reason, $description, $metadata){
    $object = CherriesRequest::create(array(
      "email_address" => $email_address,
      "cherries_amount" => $cherries_amount,
      "title" => $reason,
      "description" => $description,
      "metadata" => $metadata));
    return $object;
  }

  public static function requestCherriesWithInviteId($invite_id, $cherries_amount, $reason, $description, $metadata){
    $object =  CherriesRequest::create(array(
      "invite_id" => $invite_id,
      "cherries_amount" => $cherries_amount,
      "title" => $reason,
      "description" => $description,
      "metadata" => $metadata));
    return $object;
  }

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