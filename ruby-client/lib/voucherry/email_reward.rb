module Voucherry
  class EmailReward < Reward
    @url = "/api/v2/campaigns/%{campaign_id}/email_rewards"
    @resource_name   = "reward"
    @collection_name = "rewards"
    @remote_forbidden_attributes = [:id, :campaign_id]
  end
end
