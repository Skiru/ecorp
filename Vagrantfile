Vagrant.configure("2") do |config|
  config.vm.box = "ubuntu/trusty64"
  config.vm.network "private_network", ip: "192.168.33.10"
  config.vm.network "forwarded_port", guest: 80, host: 80
  config.ssh.forward_agent = true

  config.vm.provider "virtual_box" do |vb|
      vb.customize ["modifyvm", "id", "--natdnshostresolver1", "on"]
      vb.customize ["modifyvm", "id", "--memory", "2048"]
      vb.customize ["modifyvm", "id", "--cpus", "2"]
      vb.customize ["modifyvm", "id", "--cpuexecutioncap", "80"]
      vb.customize ["modifyvm", "id", "--name", "ecorp"]
   end

  config.vm.provision "ansible" do |ansible|
      ansible.playbook = "./ansible/playbook.yml"
      ansible.limit = "vb"
      ansible.inventory_path = "./ansible/hosts.ini"
  end

  config.vm.synced_folder ".", "/vagrant",
    create: true, group: "vagrant", owner: "vagrant"


end
