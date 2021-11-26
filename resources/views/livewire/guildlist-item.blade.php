<div class="row">
    <div class="col-12 col-md-1 text-center">
        @if($guild['icon'])
            <a href="https://cdn.discordapp.com/icons/{{ $guild['id'] }}/{{ $guild['icon'] }}" target="_blank">
                <img src="https://cdn.discordapp.com/icons/{{ $guild['id'] }}/{{ $guild['icon'] }}?size=128" loading="lazy" class="rounded-circle" style="width: 48px; height: 48px;" width="48px" height="48px" alt="guild icon">
            </a>
        @else
            <img src="https://cdn.discordapp.com/embed/avatars/0.png" loading="lazy" class="rounded-circle" style="width: 48px; height: 48px;" width="48px" height="48px" alt="guild icon">
        @endif
    </div>
    <div class="col-12 col-md-6 text-center text-md-start">
        <div>
            {{ $guild['name'] }}

            @if($guild['owner'])
                <img src="{{ asset('images/discord/icons/server/owner.png') }}" class="discord-badge" alt="owner badge" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('You own') }}">
            @elseif((($guild['permissions'] & (1 << 3)) == (1 << 3)))
                <img src="{{ asset('images/discord/icons/server/administrator.png') }}" class="discord-badge" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('You administrate') }}">
            @elseif((
                (($guild['permissions'] & (1 << 1)) == (1 << 1)) || // KICK_MEMBERS
                (($guild['permissions'] & (1 << 2)) == (1 << 2)) || // BAN_MEMBERS
                (($guild['permissions'] & (1 << 4)) == (1 << 4)) || // MANAGE_CHANNELS
                (($guild['permissions'] & (1 << 5)) == (1 << 5)) || // MANAGE_GUILD
                (($guild['permissions'] & (1 << 13)) == (1 << 13)) || // MANAGE_MESSAGES
                (($guild['permissions'] & (1 << 27)) == (1 << 27)) || // MANAGE_NICKNAMES
                (($guild['permissions'] & (1 << 28)) == (1 << 28)) || // MANAGE_ROLES
                (($guild['permissions'] & (1 << 29)) == (1 << 29)) || // MANAGE_WEBHOOKS
                (($guild['permissions'] & (1 << 34)) == (1 << 34)) // MANAGE_THREADS
            ))
                <img src="{{ asset('images/discord/icons/server/moderator.png') }}" class="discord-badge" alt="moderator badge" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('You moderate') }}">
            @endif
            @if(in_array('VERIFIED', $guild['features']))
                <img src="{{ asset('images/discord/icons/server/verified.png') }}" class="discord-badge" alt="verified badge" data-bs-toggle="tooltip" data-bs-placement="top" title="Discord Verified">
            @endif
            @if(in_array('PARTNERED', $guild['features']))
                <img src="{{ asset('images/discord/icons/server/partner.png') }}" class="discord-badge" alt="partner badge" data-bs-toggle="tooltip" data-bs-placement="top" title="Discord Partner">
            @endif
        </div>
        <div class="mt-n1">
            <small class="text-muted">
                {{ $guild['id'] }}
                &bull;
                {{ date('Y-m-d', (($guild['id'] >> 22) + 1420070400000) / 1000) }}
            </small>
        </div>
    </div>
    <div class="col-12 col-md-5 text-center text-md-end">
        <a role="button" href="{{ route('guildlookup', ['snowflake' => $guild['id']]) }}" rel="nofollow" class="btn btn-sm btn-outline-primary mt-2 mt-xl-0">{{ __('Guild Info') }}</a>
        <button wire:click="$emitTo('guild-features-modal', 'update', '{{ urlencode($guild['name']) }}', '{{ json_encode($guild['features']) }}')" class="btn btn-sm btn-outline-success mt-2 mt-xl-0" data-bs-toggle="modal" data-bs-target="#modalFeatures">{{ __('Features') }}</button>
        <button wire:click="$emitTo('guild-permissions-modal', 'update', '{{ urlencode($guild['name']) }}', '{{ $guild['permissions'] }}')" class="btn btn-sm btn-outline-danger mt-2 mt-xl-0" data-bs-toggle="modal" data-bs-target="#modalPermissions">{{ __('Permissions') }}</button>
        <button wire:click="$emitTo('guild-experiments-modal', 'update', '{{ $guild['id'] }}', '{{ urlencode($guild['name']) }}', '{{ json_encode($guild['features']) }}')" class="btn btn-sm btn-outline-warning mt-2 mt-xl-0" data-bs-toggle="modal" data-bs-target="#modalExperiments">{{ __('Experiments') }}</button>
    </div>
</div>
