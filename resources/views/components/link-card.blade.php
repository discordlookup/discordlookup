<div>
    <a href="{{ $url }}" class="block rounded-lg bg-discord-gray-1 hover:-translate-y-1 transition duration-300 ease-in-out p-4">
        <div class="flex items-center justify-between">
            <div class="w-1/12 text-center">
                <i class="{{ $icon }} text-4xl ms-auto me-auto"></i>
            </div>
            <div class="flex w-10/12 flex-row justify-between">
                <div class="flex flex-col">
                    <span class="text-lg font-bold text-white">{{ $title }}</span>
                    <span class="text-base text-white">{{ $description }}</span>
                </div>
            </div>
            <div class="w-1/12 text-center">
                <i class="fas fa-arrow-right text-4xl ms-auto"></i>
            </div>
        </div>
    </a>
</div>
