Voucherry API - PHP Sample
===========================

Configuration
-------------

```php
  Voucherry\API::configure(array(
    "api_key" => "an-api-key",
    "hostname" => "https://voucherry.com"
  ));
```

API methods
-----------

```PHP
  # Get your account info
  Voucherry\Account::find()

  # Get a vReward info
  Voucherry\Reward::find(array(
    "campaign_id" => $campaign_id,
    "id"          => $reward_id
  ));

  # Creates a vReward
  Voucherry\Reward::create(array(
    "campaign_id" => $campaign_id,
    "amount" => $amount,
    "expiration_policy" => "autofullfill",
    "preferred_cause_id" => $cause_uid,
    "expires_at" => $expires_at,
    "identifier" => $identifier,
    "event" => $event,
    "event_description" => $event_description
  ));

  # Creates an Email vReward
  Voucherry\EmailReward::create(array(
    "email"       => $email,
    "message"     => $email_message,
    "campaign_id" => $campaign_id,
    "amount" => $amount,
    "expiration_policy" => "autofullfill",
    "preferred_cause_id" => $cause_uid,
    "expires_at" => $expires_at,
    "identifier" => $identifier,
    "event" => $event,
    "event_description" => $event_description
  ));

  # Assigns a vReward to a supporter
  $reward = Voucherry\Reward::find(array(
    "campaign_id" => $campaign_id,
    "id"          => $reward_id
  ));
  $reward->accept($supporter_uid);
```

### Notes

- To use this sample code you need PHP >= 5.3.0.
- To quickly test the samples open the PHP console  with `php -a` and run `require("voucherry.php");` from the `php-client` folder
