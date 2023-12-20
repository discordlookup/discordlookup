<div class="flex flex-col rounded shadow-sm bg-discord-gray-1 overflow-hidden">
    <div class="py-4 px-5 lg:px-6 w-full flex items-center border-b border-discord-gray-4" id="{{ Str::slug($title) }}">
        <h3 class="font-semibold text-xl">
            {{ $title }}
            <a href="#{{ Str::slug($title) }}" class="text-discord-blurple opacity-75 hover:opacity-50">#</a>
        </h3>
    </div>
    <div class="p-5 lg:p-6 grow w-full">
        {{ $slot }}
    </div>
</div>
