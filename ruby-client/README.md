Voucherry API - Ruby Sample
==========================



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
  Voucherry::API.get_account
  # Get a reward info
  Voucherry::API.get_reward(campaign_id, reward_id)
  # Creates a reward
  Voucherry::API.create_reward(campaign_id, amount, expires_at, identifier=nil, event=nil, event_description=nil)
  # Creates an email reward
  Voucherry::API.create_email_reward(campaign_id, email, amount, expires_at, identifier=nil, event=nil, event_description=nil)
  # Assigns a reward to a supporter
  Voucherry::API.assign_reward(campaign_id, reward_id, uid)
```

### Notes

- To use this sample code you need to install the [Rest Client](https://github.com/rest-client/rest-client) and [JSON](http://rubygems.org/gems/json) gems
- To quickly test the samples in console fire `pry -r ./lib/voucherry.rb` from the `ruby-client` folder
