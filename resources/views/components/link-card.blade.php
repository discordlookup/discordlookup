<div>
    <a href="{{ $url }}" class="block rounded-lg bg-discord-gray-1 hover:-translate-y-1 transition duration-300 ease-in-out p-4 shadow-md">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-y-3 md:gap-y-0">
            <div class="col-span-1 inline-flex">
                <i class="{{ $icon }} text-4xl m-auto"></i>
            </div>
            <div class="col-span-10 text-center md:text-left">
                <div class="flex flex-col">
                    <span class="text-lg font-bold text-white">{{ $title }}</span>
                    <span class="text-base text-white">{!! $description !!}</span>
                </div>
            </div>
            <div class="col-span-1 inline-flex">
                <i class="fas fa-arrow-right text-4xl m-auto"></i>
            </div>
        </div>
    </a>
</div>
