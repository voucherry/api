Voucherry API - PHP Sample
===========================



Configuration
-------------


```php
  Voucherry\API::configure(array(
    "api_key" => "an-api-key"
  ));
```

API methods
-----------

```PHP
  # Get your account info
  Voucherry\API::get_account()
  # Get a reward info
  Voucherry\API::get_reward($campaign_id, $reward_id)
  # Creates a reward
  Voucherry\API::create_reward($campaign_id, $amount, $expires_at, $identifier="", $event="", $event_description="")
  # Creates an email reward
  Voucherry\API::create_email_reward($campaign_id, $email, $amount, $expires_at, $identifier="", $event="", $event_description="")
  # Assigns a reward to a supporter
  Voucherry\API::assign_reward($campaign_id, $reward_id, $uid)
```

### Notes

- To use this sample code you need PHP >= 5.3.0.
- To quickly test the samples open the PHP console  with `php -a` and run `require("voucherry.php");` from the `php-client` folder
