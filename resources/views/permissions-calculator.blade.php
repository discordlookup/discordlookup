@section('title', __('Permissions Calculator'))
@section('description', __('Calculate Discord permissions integer based on the required bot permissions.'))
@section('keywords', 'permission, permissions, bitwise, flags, rights, oauth, generator, code grant')
@section('robots', 'index, follow')

<div>
    <h1 class="mb-4 mt-5 text-center text-white">{{ __('Permissions Calculator') }}</h1>
    <div class="mb-4">
        <div class="input-group input-group-lg">
            <span class="input-group-text bg-dark">
                <i class="fas fa-sort-numeric-down"></i>
            </span>
            <input wire:keyup="update()" wire:model="permissions" class="form-control form-control-lg" type="text">
        </div>
        @error('permissions') <span class="invalid-feedback d-block">{{ __('Input must be a number!') }}</span> @enderror
    </div>
    <div class="mb-4">
        <div class="card text-white bg-dark">
            <div class="card-body">
                <div class="row">
                    <div class="small mb-3">
                        <span class="cursor-pointer text-primary" wire:click="addAll([{{ implode(', ', array_column($permissionsList, 'bitwise')) }}])">{{ __('Select all') }}</span>
                        /
                        <span class="cursor-pointer text-primary" wire:click="removeAll([{{ implode(', ', array_column($permissionsList, 'bitwise')) }}])">{{ __('Deselect all') }}</span>
                    </div>

                    <div class="col-sm">
                        <div class="fw-bold mb-2">{{ __('General Permissions') }}</div>

                        @php($values = [])
                        @foreach($permissionsList as $key => $permission)
                            @if($permission['group'] != 'general') @continue @endif
                            @php($values[] = $permission['bitwise'])
                            <div class="form-check">
                                <input wire:model="permissionsListSelected" wire:change.lazy="calcPermissions()" class="form-check-input" type="checkbox" value="{{ $permission['bitwise'] }}" id="checkbox_{{ $key }}">
                                <label class="form-check-label @if($permission['requireTwoFactor']) text-warning @endif" for="checkbox_{{ $key }}">{{ $permission['name'] }}</label>
                            </div>
                        @endforeach

                        <div class="small">
                            <span class="cursor-pointer text-primary" wire:click="addAll([{{ implode(', ', $values) }}])">{{ __('Select group') }}</span>
                            /
                            <span class="cursor-pointer text-primary" wire:click="removeAll([{{ implode(', ', $values) }}])">{{ __('Deselect group') }}</span>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="fw-bold mb-2">{{ __('Text Permissions') }}</div>

                        @php($values = [])
                        @foreach($permissionsList as $key => $permission)
                            @if($permission['group'] != 'text') @continue @endif
                            @php($values[] = $permission['bitwise'])
                            <div class="form-check">
                                <input wire:model="permissionsListSelected" wire:change.lazy="calcPermissions()" class="form-check-input" type="checkbox" value="{{ $permission['bitwise'] }}" id="checkbox_{{ $key }}">
                                <label class="form-check-label @if($permission['requireTwoFactor']) text-warning @endif" for="checkbox_{{ $key }}">{{ $permission['name'] }}</label>
                            </div>
                        @endforeach

                        <div class="small">
                            <span class="cursor-pointer text-primary" wire:click="addAll([{{ implode(', ', $values) }}])">{{ __('Select group') }}</span>
                            /
                            <span class="cursor-pointer text-primary" wire:click="removeAll([{{ implode(', ', $values) }}])">{{ __('Deselect group') }}</span>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="fw-bold mb-2">{{ __('Voice Permissions') }}</div>

                        @php($values = [])
                        @foreach($permissionsList as $key => $permission)
                            @if($permission['group'] != 'voice') @continue @endif
                            @php($values[] = $permission['bitwise'])
                            <div class="form-check">
                                <input wire:model="permissionsListSelected" wire:change.lazy="calcPermissions()" class="form-check-input" type="checkbox" value="{{ $permission['bitwise'] }}" id="checkbox_{{ $key }}">
                                <label class="form-check-label @if($permission['requireTwoFactor']) text-warning @endif" for="checkbox_{{ $key }}">{{ $permission['name'] }}</label>
                            </div>
                        @endforeach

                        <div class="small">
                            <span class="cursor-pointer text-primary" wire:click="addAll([{{ implode(', ', $values) }}])">{{ __('Select group') }}</span>
                            /
                            <span class="cursor-pointer text-primary" wire:click="removeAll([{{ implode(', ', $values) }}])">{{ __('Deselect group') }}</span>
                        </div>
                    </div>
                </div>
                <div class="mt-3 small text-white-50">
                    {{ __('Yellow colored') }} = These permissions require the owner account to use <a class="text-decoration-none" target="_blank" rel="noopener" href="https://discord.com/developers/docs/topics/oauth2#twofactor-authentication-requirement">two-factor authentication</a> when used on a guild that has server-wide 2FA enabled.
                </div>
            </div>
        </div>
    </div>
    @if($permissionsListSelected)
        <div class="mb-4">
            <div class="card text-white bg-dark">
                <div class="card-body">
                    <code class="text-white">
                        @foreach($permissionsListSelected as $value)
                            0x{{ dechex($value) }}
                            @if(!$loop->last) | @endif
                        @endforeach
                    </code>
                </div>
            </div>
        </div>
    @endif
</div>
