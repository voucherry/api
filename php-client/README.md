Voucherry API - php Client
==========================



Setting up credentials
----------------------


```php
  $api_key = "my api key";
  VoucherryAPI::configure($api_key);
```



Sending cherries to an email account
------------------------------------

```php

  $message = null;
  $transfer = VoucherryAPI::sendCherriesToEmailAddress(
    "exmaple@voucherry.com",
    20,
    "You've got some cherries",
    "Because you're a loyal customer you've been awarded with 20 cherries.",
    array( "purchase-id" => "prd-0001" )
  )
  
  if($transfer->success()){
    $message = "Hoary!!! Congratulations you've got 20 cherries!";
  }else{
    $message = ":( An error has been detected ". $message->statusMessage;
  }

```
Sending cherries to an Invite Id
------------------------------------

```php

  $message = null;
  $transfer = VoucherryAPI::sendCherriesToInviteID(
    "exmaple",
    20,
    "You've got some cherries",
    "Because you're a loyal customer you've been awarded with 20 cherries.",
    array( "purchase-id" => "prd-0001" )
  )
  
  if($transfer->success()){
    $message = "Hoary!!! Congratulations you've got 20 cherries!";
  }else{
    $message = ":( An error has been detected ". $message->statusMessage;
  }

```


Paying with cherries using an email address
-------------------------------------------

```php

  $message = null;
  $transfer = VoucherryAPI::requestCherriesWithEmail(
    "exmaple@voucherry.com",
    20,
    "Item Purchase",
    "You've purchase an usb stone.",
    array( "purchase-id" => "prd-0001" )
  )
  
  if($transfer->success()){
    if( VoucherryAPI::requestCherriesWithInviteId($transfer->id) ){
      $message = "Hoary!!! Congratulations you've used 20 cherries!";
    }else{
      $message = "We couldn't confirm your payment sorry!!!";
    }
  }else{
    $message = ":( An error has been detected ". $message->statusMessage;
  }

```

Paying with cherries using an invite id
---------------------------------------

```php

  $message = null;
  $transfer = VoucherryAPI::requestCherriesWithInviteId(
    "exmaple",
    20,
    "Item Purchase",
    "You've purchase an usb stone.",
    array( "purchase-id" => "prd-0001" )
  )
  
  if($transfer->success()){
    if( VoucherryAPI::requestCherriesWithInviteId($transfer->id) ){
      $message = "Hoary!!! Congratulations you've used 20 cherries!";
    }else{
      $message = "We couldn't confirm your payment sorry!!!";
    }
  }else{
    $message = ":( An error has been detected ". $message->statusMessage;
  }

```