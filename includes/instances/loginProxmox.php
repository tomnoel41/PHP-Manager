<?php
require_once '../config.php';
require_once __DIR__ . '/../vendor/autoload.php';
use Proxmox\Request;
use Proxmox\Cluster;
use Proxmox\Nodes;

$proxmox_pve_auth = [
    'hostname' => '10.0.15.2',
    'username' => 'root',
    'password' => 'pass'
];

# Login into PVE
Request::Login($proxmox_pve_auth);