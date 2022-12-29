<?php

namespace App\Http\Livewire;

use Livewire\Component;

class PermissionsCalculator extends Component
{
    public $permissions = 0;
    public $permissionsList = [];
    public $permissionsListSelected = [];

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
        usort($this->permissionsList, fn($a, $b) => $a['name'] <=> $b['name']);
        $this->update();
    }

    public function render()
    {
        sort($this->permissionsListSelected);
        return view('permissions-calculator')->extends('layouts.app');
    }
}
