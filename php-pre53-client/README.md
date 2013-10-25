Voucherry API - PHP Sample
===========================

PHP sample code that works for PHP < 5.3.0

Usage
-------------

```php
  # require the voucherry code
  require("voucherry.php");
  # Connect to the production API
  $api = new VoucherryAPI("your-api-key");
  # or Connect to the staging API
  $api = new VoucherryAPI("your-api-key", "staging.voucherry.com");

  # Get your account info
  $api->get_account();
  # Get a reward info
  $api->get_reward($campaign_id, $reward_id);
  # Creates a reward
  $api->create_reward($campaign_id, $amount, $expires_at, $identifier="", $event="", $event_description="");
  # Creates an email reward
  $api->create_email_reward($campaign_id, $email, $amount, $expires_at, $identifier="", $event="", $event_description="");
  # Assigns a reward to a supporter
  $api->assign_reward($campaign_id, $reward_id, $uid);
```

### Notes

- To quickly test the samples open the PHP console  with `php -a` and run `require("voucherry.php");` from the `php-pre53-client` folder
