<div class="grid grid-cols-1 md:grid-cols-12 py-2 gap-y-3">
    <div class="col-span-1 inline-flex items-center justify-center text-sm">
        @if($guild['icon'])
            <a href="{{ getGuildIconUrl($guild['id'], $guild['icon'], 1024, 'png') }}" target="_blank">
                <img src="{{ getGuildIconUrl($guild['id'], $guild['icon']) }}" loading="lazy" class="inline-block h-12 w-12 rounded-full" alt="guild icon">
            </a>
        @else
            <img src="{{ getDefaultUserAvatarUrl() }}" loading="lazy" class="inline-block h-12 w-12 rounded-full" alt="guild default icon">
        @endif
    </div>
    <div class="col-span-6 text-center md:text-left my-auto text-sm">
        <p class="font-bold">
            {{ cutString($guild['name'], 80) }}
            @if($guild['owner'])
                {!! getDiscordBadgeServerIcons('owner', __('You own')) !!}
            @elseif(hasAdministrator($guild['permissions']))
                {!! getDiscordBadgeServerIcons('administrator', __('You administrate')) !!}
            @elseif(hasModerator($guild['permissions']))
                {!! getDiscordBadgeServerIcons('moderator', __('You moderate')) !!}
            @endif
            @if(in_array('VERIFIED', $guild['features']))
                {!! getDiscordBadgeServerIcons('verified', __('Discord Verified')) !!}
            @endif
            @if(in_array('PARTNERED', $guild['features']))
                {!! getDiscordBadgeServerIcons('partner', __('Discord Partner')) !!}
            @endif
        </p>
        <p class="text-gray-400">
            {{ $guild['id'] }} &bull; {{ date('Y-m-d', getTimestamp($guild['id']) / 1000) }}
        </p>
        <p>
            @if(array_key_exists('approximate_presence_count', $guild) && $guild['approximate_presence_count'] !== null)
                <span class="inline-block h-2 w-2 rounded-full bg-[#3ba55d] mb-px mr-0.5"></span>
                <span class="text-sm">{{ number_format($guild['approximate_presence_count'], 0, '', '.') }} {{ __('Online') }}</span>
            @endif

            @if(array_key_exists('approximate_member_count', $guild) && $guild['approximate_member_count'] !== null)
                <span class="inline-block h-2 w-2 rounded-full bg-[#747f8d] mb-px mr-0.5 ml-3"></span>
                <span class="text-sm">{{ number_format($guild['approximate_member_count'], 0, '', '.') }} {{ __('Members') }}</span>
            @endif
        </p>
        @if(isset($override) && $override)
            <p class="text-green-400">({{ __('This Guild has an override for this experiment') }})</p>
        @endif
        @if(isset($filters) && $filters)
            <p class="text-gray-300">
                @foreach($filters as $filter)
                    {{ $filter }}
                @endforeach
            </p>
        @endif
    </div>
    <div class="col-span-5 text-center md:text-right my-auto text-sm space-y-1 md:space-y-0">
        <a role="button"
           href="{{ route('guildlookup', ['snowflake' => $guild['id']]) }}"
           target="_blank"
           class="inline-flex justify-center items-center gap-2 border font-semibold rounded px-2 py-1 leading-5 text-sm border-discord-blurple bg-discord-blurple text-white hover:text-white hover:bg-[#4e5acb] hover:border-[#4e5acb] focus:ring-opacity-50 active:bg-[#414aa5] active:border-[#414aa5]"
        >
            {{ __('Guild Lookup') }}
        </a>

        <button
            x-on:click="modalFeaturesOpen = true"
            wire:click="$emitTo('modal.guild-features', 'update', '{{ urlencode($guild['name']) }}', '{{ json_encode($guild['features']) }}')"
            class="inline-flex justify-center items-center gap-2 border font-semibold rounded px-2 py-1 leading-5 text-sm border-discord-blurple bg-discord-blurple text-white hover:text-white hover:bg-[#4e5acb] hover:border-[#4e5acb] focus:ring-opacity-50 active:bg-[#414aa5] active:border-[#414aa5]"
        >
            {{ __('Features') }}
        </button>

        <button
            x-on:click="modalPermissionsOpen = true"
            wire:click="$emitTo('modal.guild-permissions', 'update', '{{ urlencode($guild['name']) }}', '{{ $guild['permissions'] }}')"
            class="inline-flex justify-center items-center gap-2 border font-semibold rounded px-2 py-1 leading-5 text-sm border-discord-blurple bg-discord-blurple text-white hover:text-white hover:bg-[#4e5acb] hover:border-[#4e5acb] focus:ring-opacity-50 active:bg-[#414aa5] active:border-[#414aa5]"
        >
            {{ __('Permissions') }}
        </button>

        <button
            x-on:click="modalExperimentsOpen = true"
            wire:click="$emitTo('modal.guild-experiments', 'update', '{{ $guild['id'] }}', '{{ urlencode($guild['name']) }}', '{{ $guild['approximate_presence_count'] }}', '{{ $guild['approximate_member_count'] }}', '{{ json_encode($guild['features']) }}')"
            class="inline-flex justify-center items-center gap-2 border font-semibold rounded px-2 py-1 leading-5 text-sm border-discord-blurple bg-discord-blurple text-white hover:text-white hover:bg-[#4e5acb] hover:border-[#4e5acb] focus:ring-opacity-50 active:bg-[#414aa5] active:border-[#414aa5]"
        >
            {{ __('Experiments') }}
        </button>
    </div>
</div>
