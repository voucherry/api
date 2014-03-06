Voucherry API - Ruby Sample
===========================



Configuration
-------------


```ruby
  Voucherry::API.configure do |config|
    config.api_key = "an-api-key"
  end
```

API methods
-----------

```ruby
  # Get your account info
  Voucherry::Account.find()

  # Get a reward info
  Voucherry::Reward.find(campaign_id: campaign_id, id: reward_id)

  # Creates a reward
  Voucherry::Reward.create({
    campaign_id: campaign_id,
    amount: amount,
    expiration_policy: "autofullfill",
    preferred_cause_id: "1",
    expires_at: expires_at,
    identifier: identifier,
    event: event,
    event_description: event_description
  })

  # Creates an email reward
  Voucherry::EmailReward.create({
    campaign_id: campaign_id,
    email: email,
    message: email_message,
    amount: amount,
    expiration_policy: "autofullfill",
    preferred_cause_id: "1",
    expires_at: expires_at,
    identifier: identifier,
    event: event,
    event_description: event_description
  })

  # Assigns a reward to a supporter
  reward = Voucherry::Reward.new(campaign_id: campaign_id, id: reward_id)
  reward.accept(uid)
```

### Notes

- To use this sample code you need to install the [Rest Client](https://github.com/rest-client/rest-client) and [JSON](http://rubygems.org/gems/json) gems
- To quickly test the samples in console fire `pry -r ./lib/voucherry.rb` from the `ruby-client` folder
