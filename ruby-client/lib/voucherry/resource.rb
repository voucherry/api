require 'json'

module Voucherry
  class Resource
    class << self
      attr_accessor :url
      attr_accessor :resource_name
      attr_accessor :collection_name
      attr_accessor :remote_forbidden_attributes
    end
    @url = nil
    @resource_name = nil
    @remote_forbidden_attributes = [:id]

    class << self

      def find(params={})
        url = self.url % params
        url = "#{url}/#{params[:id]}" unless params[:id].nil?
        response = Voucherry::API.default_client.get(url)
        self.new JSON.parse(response)[self.resource_name]
      end

      def create(params={})
        resource = self.new(params)
        resource.save
        resource
      end

    end

    def initialize(attributes)
      @attributes = attributes
    end

    def save
      resource_url = self.class.url % @attributes
      resource_url = "#{resource_url}/#{@attributes[:id]}" unless @attributes[:id].nil?
      attrs = @attributes.select do |attr,val|
        not self.class.remote_forbidden_attributes.include?(attr.to_sym)
      end
      verb = params[:id].nil? ? :post : put
      response = Voucherry::API.default_client.send(verb, resource_url, self.class.resource_name => attrs)
      @attributes = (@attributes||{}).merge(JSON.parse(response)[self.class.resource_name]||{})
      self
    end

    def method_missing(meth, *args, &block)
      return @attributes[meth] if @attributes.has_key?(meth)
      return @attributes[meth.to_s] if @attributes.has_key?(meth.to_s)
      super
    end

  end
end
