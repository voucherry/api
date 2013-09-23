module Voucherry

  class Configuration

    attr_accessor :api_key,
                  :hostname,
                  :verify_ssl

    def verify_ssl
      hostname == "https://voucherry.com"
    end

  end
end
