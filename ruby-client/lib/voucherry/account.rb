module Voucherry
  class Account < Resource
    @url = "/api/v2/account"
    @resource_name = "user"

    class << self

      def create(*args)
        raise Exception
      end

    end

  end
end
