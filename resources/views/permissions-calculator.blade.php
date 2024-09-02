<div>
    <h2 class="text-3xl md:text-4xl text-center font-extrabold mb-4 text-white">{{ __('Permissions Calculator') }}</h2>
    <div class="py-12 space-y-3">
        <x-input-prepend-icon icon="fas fa-sort-numeric-down">
            <input
                wire:keyup="update()"
                wire:model="permissions"
                id="webhookUrl"
                type="number"
                min="0"
                placeholder="{{ __('Bitfield') }}"
                class="block border-none rounded pl-12 pr-5 py-3 leading-6 w-full bg-discord-gray-1 focus:outline-none focus:ring-0"
                autofocus
            />
        </x-input-prepend-icon>

        @error('permissions')
            <x-error-message>
                {{ __('Input must be a number!') }}
            </x-error-message>
        @enderror

        <div class="flex flex-col rounded shadow-sm bg-discord-gray-1 overflow-hidden">
            <div class="p-5 lg:p-6 grow w-full space-y-4">
                <div class="text-sm">
                    <button class="text-discord-blurple hover:text-[#4e5acb] active:text-[#414aa5]" wire:click="addAll([{{ implode(', ', array_column($permissionsList, 'bitwise')) }}])">
                        {{ __('Select all') }}
                    </button>
                    /
                    <button class="text-discord-blurple hover:text-[#4e5acb] active:text-[#414aa5]" wire:click="removeAll([{{ implode(', ', array_column($permissionsList, 'bitwise')) }}])">
                        {{ __('Deselect all') }}
                    </button>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-x-12 gap-y-8">
                    @foreach($permissionsGroupsList as $group)
                        <div class="col-span-1">
                            <div class="space-y-2">
                                <div class="font-semibold"><span class="capitalize">{{ $group }}</span> {{ __('Permissions') }}</div>
                                <div class="space-y-1">
                                    @php($values = [])
                                    @foreach($permissionsList as $key => $permission)
                                        @continue($permission['group'] != $group)
                                        @php($values[] = $permission['bitwise'])
                                        <label class="flex items-center">
                                            <input
                                                wire:model="permissionsListSelected"
                                                wire:change.lazy="calcPermissions()"
                                                id="checkbox_{{ $key }}"
                                                value="{{ $permission['bitwise'] }}"
                                                type="checkbox"
                                                class="border-none rounded h-4 w-4 text-discord-blurple focus:outline-none focus:ring-0 !outline-none"
                                            />
                                            <span class="ml-2 {{ $permission['requireTwoFactor'] ? 'text-yellow-300' : 'text-gray-100' }}">
                                                {{ $permission['name'] }}
                                            </span>
                                        </label>
                                    @endforeach
                                    <div class="text-sm">
                                        <button wire:click="addAll([{{ implode(', ', $values) }}])" class="text-discord-blurple hover:text-[#4e5acb] active:text-[#414aa5]">
                                            {{ __('Select group') }}
                                        </button>
                                        /
                                        <button wire:click="removeAll([{{ implode(', ', $values) }}])" class="text-discord-blurple hover:text-[#4e5acb] active:text-[#414aa5]">
                                            {{ __('Deselect group') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="text-sm text-gray-400">
                    {{ __('Yellow colored') }} = These permissions require the application owner account to use <a href="https://discord.com/developers/docs/topics/oauth2#twofactor-authentication-requirement" target="_blank" rel="noopener" class="text-discord-blurple hover:text-[#4e5acb] active:text-[#414aa5]">two-factor authentication</a> when used on a guild that has server-wide 2FA enabled.
                </div>
            </div>
        </div>

        @if($permissionsListSelected)
            <div class="flex flex-col rounded shadow-sm bg-discord-gray-1 overflow-hidden">
                <div class="p-5 lg:p-6 grow w-full space-y-4">
                    <p class="font-mono text-sm">
                        @foreach($permissionsListSelected as $value)
                            0x{{ dechex($value) }}
                            @if(!$loop->last) | @endif
                        @endforeach
                    </p>
                </div>
            </div>
        @endif
    </div>
</div>
