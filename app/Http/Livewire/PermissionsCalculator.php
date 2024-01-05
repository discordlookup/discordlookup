<?php

namespace App\Http\Livewire;

use F9Web\Meta\Meta;
use Livewire\Component;

class PermissionsCalculator extends Component
{
    public $permissions = 0;
    public $permissionsList = [];
    public $permissionsListSelected = [];
    public $permissionsGroupsList = [];

    protected $rules = [
        'permissions' => 'numeric',
    ];

    public function update()
    {
        $this->validate();
        $this->reset(['permissionsListSelected']);

        if ($this->permissions) {
            foreach ($this->permissionsList as $permission) {
                if (($this->permissions & $permission['bitwise']) == $permission['bitwise'])
                    $this->permissionsListSelected[] = $permission['bitwise'];
            }
        }
    }

    public function calcPermissions()
    {
        $this->validate();
        $this->reset(['permissions']);
        foreach ($this->permissionsListSelected as $value)
        {
            $this->permissions += $value;
        }
    }

    public function addAll($list)
    {
        foreach ($list as $item)
        {
            if (!in_array($item, $this->permissionsListSelected))
                $this->permissionsListSelected[] = $item;
        }
        $this->calcPermissions();
    }

    public function removeAll($list)
    {
        foreach ($list as $item)
        {
            if (($key = array_search($item, $this->permissionsListSelected)) !== false) {
                unset($this->permissionsListSelected[$key]);
            }
        }
        $this->calcPermissions();
    }

    public function mount()
    {
        $this->permissionsList = getPermissionList();
        $this->permissionsGroupsList = array_unique(array_column(getPermissionList(), 'group'));
        usort($this->permissionsList, fn($a, $b) => $a['name'] <=> $b['name']);
        $this->update();

        Meta::set('title', __('Permissions Calculator'))
            ->set('og:title', __('Permissions Calculator'))
            ->set('description', __('Calculate Discord permissions integer based on the required bot permissions.'))
            ->set('og:description', __('Calculate Discord permissions integer based on the required bot permissions.'))
            ->set('keywords', 'permission, permissions, bitwise, flags, rights, oauth, generator, code grant, ' . getDefaultKeywords());
    }

    public function render()
    {
        sort($this->permissionsListSelected);
        return view('permissions-calculator')->extends('layouts.app');
    }
}
