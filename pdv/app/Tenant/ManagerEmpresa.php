<?php
namespace App\Tenant;


class ManagerEmpresa {
    public function getIdEmpresa() {        
        return auth()->check() ? auth()->user()->empresa_id : '1';
    }
    
    public function getEmpresa()
    {
        return auth()->check() ? auth()->user()->empresa : '';
    }
    
    public function isAdmin(): bool
    {
        return auth()->user()->isAdminMaster();
    }
}