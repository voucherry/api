module Voucherry
  class Reward < Resource
    @url = "/api/v2/campaigns/%{campaign_id}/rewards"
    @resource_name   = "reward"
    @collection_name = "rewards"
    @remote_forbidden_attributes = [:id, :campaign_id]

    def accept(uid)
      url = self.class.url % @attributes
      url = "#{url}/#{self.id}/accept"
      response = Voucherry::API.default_client.put(url, uid: uid)
      @attributes = (@attributes||{}).merge(JSON.parse(response)[self.class.resource_name]||{})
      self
    end

  end


end
