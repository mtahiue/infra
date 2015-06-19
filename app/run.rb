require 'rubygems'
require 'bundler/setup'

require 'azure'
require 'yaml'

require './Kinoulink/Infra/utility'

Logger = Kinoulink::Utility::Logger

Logger.info("Reading infra.yaml")

infra = YAML::load_file(File.join(__dir__, 'infra.yml'))

Azure.configure do |config|
    config.management_certificate = infra.config.management_certificate
    config.subscription_id        = infra.config.subscription_id
    config.management_endpoint    = infra.config.management_endpoint
end

virtual_machine_service = Azure::VirtualMachineManagementService.new
base_management_service = Azure::BaseManagementService.new
cloud_service = Azure::CloudServiceManagementService.new
storage_service = Azure::StorageManagementService.new
blob_service = Azure::BlobService.new

Logger.info("")
Logger.info("- Affinity groups")

infra.affinity_groups.each do |name, group|
  begin
    base_management_service.create_affinity_group(name, infra.defaults.region, group.label, {:description => ''})
  rescue Exception => e
    Logger.error("Cannot create affinity group: " + e.message)
  end
end

Logger.info("")
Logger.info("- Cloud services")

infra.cloud_services.each do |name, service|
  cloud_service.create_cloud_service(name, {
    :location => infra.defaults.region,
    :label => service.label
  })
end

Logger.info("")
Logger.info("- Storage account")

infra.storage.each do |name, account|

    options = {
        :label => account.label,
        :affinity_group_name => account.affinity_group,
        :geo_replication_enabled => account.geo_replication_enabled
    }

    storage_service.create_storage_account(name, options)

	blob_service.initialize({
		:client => {
			:storage_account_name => name
		}
	})

    container = blob_service.create_container("$root")

end

return

Logger.info("")
Logger.info("- Virtual machines")

infra.virtual_machines.each do |name, vm|

  params = {
    :vm_name => name,
    :vm_user => infra.defaults.vm.ssh.user,
    :image => infra.defaults.vm.image,
    :location => infra.defaults.region
  }

  options = {
    :storage_account_name => infra.defaults.vm.storage,
    :certificate_file => infra.defaults.vm.certificate_file,
    :cloud_service_name => vm.service,
    :deployment_name => name,
    :private_key_file => infra.defaults.vm.ssh.private_key,
    :ssh_port => infra.defaults.vm.ssh.port,
    :vm_size => 'Small',
    :affinity_group_name => infra.defaults.affinity_group,
    :virtual_network_name => vm.network.net,
    :subnet_name => vm.network.subnet,
    :availability_set_name => vm.service
  }

  #virtual_machine_service.delete_virtual_machine(name, vm.service)
  #virtual_machine_service.create_virtual_machine(params,options)

  vm.endpoints.each do |endpoint_name, endpoint|

    virtual_machine_service.update_endpoints(name, vm.service, {
       :name => endpoint_name,
       :public_port => endpoint.public_port,
       :local_port => endpoint.local_port,
       :protocol => 'TCP'
    })

  end


  return ;

end

return 








#

virtual_machine_service.list_virtual_machines.each do |vm|
    puts vm.cloud_service_name + ' ' + vm.vm_name
end