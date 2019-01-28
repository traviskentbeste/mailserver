# -*- mode: ruby -*-
# vi: set ft=ruby :

# All Vagrant configuration is done below. The "2" in Vagrant.configure
# configures the configuration version (we support older styles for
# backwards compatibility). Please don't change it unless you know what
# you're doing.
Vagrant.configure("2") do |config|
  # The most common configuration options are documented and commented below.
  # For a complete reference, please see the online documentation at
  # https://docs.vagrantup.com.

  # Every Vagrant development environment requires a box. You can search for
  # boxes at https://vagrantcloud.com/search.
  config.vm.box = "/Users/travis/projects/centos/build/7/1804/centos.box"

  # do not install a new key
  config.ssh.insert_key = false

  # Create a private network, which allows host-only access to the machine
  # using a specific IP.
	config.vm.network "private_network", ip: "192.168.23.15"

  # Share an additional folder to the guest VM. The first argument is
  # the path on the host to the actual folder. The second argument is
  # the path on the guest to mount the folder. And the optional third
  # argument is a set of non-required options.
  config.vm.synced_folder "/Users/travis/projects/github/mailserver", "/mailserver",
		type: "nfs",
		mount_options: ['rw', 'vers=3', 'tcp'],
		linux__nfs_options: ['rw','no_subtree_check','all_squash','async']

  # Provider-specific configuration so you can fine-tune various
  # backing providers for Vagrant. These expose provider-specific options.
  # Example for VirtualBox:
  #
	config.vm.provider "virtualbox" do |vb|
		vb.name   = "mailserver"
		vb.memory = "2048"
		vb.cpus   = "4"
	end
  #
  # View the documentation for the provider you are using for more
  # information on available options.

	# because we are using the public ssh key for our box
	config.ssh.insert_key = false

  # Enable provisioning with a shell script. Additional provisioners such as
  # Puppet, Chef, Ansible, Salt, and Docker are also available. Please see the
  # documentation for more information about their specific syntax and use.
	config.vm.provision "shell", inline: <<-SHELL
		/mailserver-postfix-dovecot/information_technology/www/.vagrant/files/bootstrap.sh
	SHELL

	config.vm.provision :shell, :inline => "sudo service httpd start", run: "always"

end
