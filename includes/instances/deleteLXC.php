<?php
require_once 'loginProxmox.php';
use Proxmox\Request;
use Proxmox\Cluster;
use Proxmox\Nodes;

# Login into PVE
Request::Login($proxmox_pve_auth);

print_r( Nodes::lxcStop('elitedesk', '103') );
sleep('10');
print_r( Nodes::deleteLxc('elitedesk', '103') );
