# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant.configure(2) do |config|

  config.vm.box = "ubuntu/trusty64"

  config.vm.provider "virtualbox" do |v|
    v.memory = 1024
  end

  config.vm.network "forwarded_port", guest: 80, host: 8888
  #config.vm.network "forwarded_port", guest: 3306, host: 8889
  
  config.vm.provision "shell", path: "provision.sh"
end
