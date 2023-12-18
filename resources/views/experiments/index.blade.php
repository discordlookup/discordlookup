@section('title', __('Discord Experiments & Rollouts'))
@section('description', __('All Discord Client & Guild Experiments with Rollout Status and detailed information about Treatments, Groups and Overrides.'))
@section('keywords', 'client, guild, experiments, discord experiments, rollout, rollouts, treatments, groups, overrides, population')
@section('robots', 'index, follow')

<div>
    <h2 class="text-3xl md:text-4xl text-center font-extrabold mb-4 text-white">{{ __('Discord Experiments') }}</h2>
    <div class="py-12 space-y-3">
        <div class="grid grid-cols-1 md:grid-cols-4 space-x-0 md:space-x-2 space-y-2 md:space-y-0">
            <div class="col-span-1">
                <x-input-prepend-icon icon="fas fa-flask">
                    <select wire:model="category" class="block border-none rounded pl-12 pr-5 py-3 leading-6 w-full bg-discord-gray-1 focus:outline-none focus:ring-0">
                        <option value="all" selected>{{ __('All Experiments') }} ({{ sizeof($this->experimentsJsonSearch) }})</option>
                        <option value="user" disabled>{{ __('User Experiments') }} ({{ sizeof(array_filter($this->experimentsJsonSearch, fn($item) => $item['type'] === 'user')) }})</option>
                        <option value="guild">{{ __('Guild Experiments') }} ({{ sizeof(array_filter($this->experimentsJsonSearch, fn($item) => $item['type'] === 'guild')) }})</option>
                    </select>
                </x-input-prepend-icon>
            </div>
            <div class="col-span-2">
                <x-input-prepend-icon icon="fas fa-search" class="col-span-2">
                    <input
                        wire:model="search"
                        type="text"
                        placeholder="{{ __('Search...') }}"
                        class="block border-none rounded pl-12 pr-5 py-3 leading-6 w-full bg-discord-gray-1 focus:outline-none focus:ring-0"
                    >
                </x-input-prepend-icon>
            </div>
            <div class="col-span-1">
                <x-input-prepend-icon icon="fas fa-sort-alpha-down">
                    <select wire:model="sorting" class="block border-none rounded pl-12 pr-5 py-3 leading-6 w-full bg-discord-gray-1 focus:outline-none focus:ring-0">
                        <option value="id-asc">{{ __('ID Ascending') }}</option>
                        <option value="id-desc" selected>{{ __('ID Descending') }}</option>
                        <option value="title-asc">{{ __('Title Ascending') }}</option>
                        <option value="title-desc">{{ __('Title Descending') }}</option>
                        <option value="updatedAt-asc" disabled>{{ __('Updated Ascending') }}</option>
                        <option value="updatedAt-desc" disabled>{{ __('Updated Descending') }}</option>
                        <option value="createdAt-asc" disabled>{{ __('Created Ascending') }}</option>
                        <option value="createdAt-desc" disabled>{{ __('Created Descending') }}</option>
                    </select>
                </x-input-prepend-icon>
            </div>
        </div>

        <div class="flex flex-col rounded shadow-sm bg-discord-gray-1 overflow-hidden">
            <div class="p-5 lg:p-6 grow w-full">
                <div class="flex flex-col gap-y-6 md:gap-y-4">
                    @if(empty($this->experimentsJsonSearch))
                        {{ __('No experiments found.') }}
                    @endif
                    @foreach($this->experimentsJsonSearch as $experiment)
                        <x-experiments-table-row
                            :id="$experiment['id']"
                            :type="$experiment['type']"
                            :title="$experiment['title']"
                            :updated="$experiment['updatedAt']"
                        />
                        @if(!$loop->last)
                            <hr class="opacity-10" />
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
