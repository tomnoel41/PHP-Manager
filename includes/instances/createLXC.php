<?php
require_once 'loginProxmox.php';
use Proxmox\Request;
use Proxmox\Cluster;
use Proxmox\Nodes;

# Create container
$configuration = [
  'vmid'            => Cluster::nextVmid()->data,
  'hostname'        => 'PROXMOX-MANAGER', ## Nom d'hôte
  'password'        => 'tomrey', ## Mot de passe
  'cores'           => 4, ## vCores
  'memory'          => 2048, ## RAM en MB
  'swap'            => 0, # SWAP en MB
  'rootfs'          => 'local:8', ## Espace disque
  'start'           => true, ## Allumage
  'nameserver'      => "1.1.1.1", ## Serveur DNS
  'arch'            => "amd64", ## Architecture
  'features'        => "nesting=1", ## Fatures Proxmox
  'unprivileged'    => true,
  'ostemplate'      => 'local:vztmpl/ubuntu-18.04-standard_18.04.1-1_amd64.tar.gz',
  'net0'            => 'bridge=vmbr0,name=eth0,ip=10.0.15.44/32,gw=10.0.15.1'
];

print_r( Nodes::createLxc('elitedesk', $configuration) );