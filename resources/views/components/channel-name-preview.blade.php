<div>
    {{-- TODO: Tooltip channel id --}}
    <a
        href="https://discord.com/channels/{{ $guildId }}/{{ $channelId }}"
        target="_blank"
        rel="noopener"
        class="bg-[#3d4270] hover:bg-[#5865f2] cursor-pointer px-1 py-[1px] duration-100 rounded"
    >
        #{{ $channelName }}
    </a>
</div>
