<div class="col-span-1 p-2">
    <div wire:click="changeCategory('{{ $category }}')" class="flex flex-col rounded shadow-sm bg-[#373d4c] overflow-hidden cursor-pointer">
        <div class="py-4 px-5 lg:px-6 w-full text-center text-base font-bold border-b border-discord-gray-3 uppercase">
            <img
                src="{{ $image }}"
                class="inline-block h-4 w-4 mb-1"
                alt="{{ $category }} badge"
            />
            {{ $title }}
        </div>
        <div class="p-3 lg:p-4 grow w-full space-y-4 text-center">
            <p class="text-4xl">{{ $count }}</p>
            <hr class="my-6 opacity-20" />
            <p class="text-2xl">{{ calcPercent($count, $total, 1) }}&percnt;</p>
        </div>
    </div>
</div>
