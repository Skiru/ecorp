
Vagrant.configure("2") do |config|
  config.vm.box = "debian/stretch64"

  # config.vm.box_check_update = false
  # config.vm.network "forwarded_port", guest: 80, host: 8080
  # config.vm.network "forwarded_port", guest: 80, host: 8080, host_ip: "127.0.0.1"
  # config.vm.network "public_network"

  config.vm.provider :virtualbox do |v|
    v.customize [
        "modifyvm", :id,
        "--name", "ecorp",
        "--memory", 4096,
        "--natdnshostresolver1", "on",
        "--cpus", 2,
    ]
  end

  config.vm.network "private_network", ip: "192.168.33.10"
  config.ssh.forward_agent = true

  config.vm.provision "ansible" do |ansible|
      ansible.playbook = "./ansible/playbook.yml"
      ansible.limit = "vb"
      ansible.inventory_path = "./ansible/hosts.ini"
  end

  config.vm.synced_folder ".", "/vagrant"
end
