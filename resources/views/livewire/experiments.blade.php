<div id="experiments">
    <h1 class="mb-4 mt-5 text-center text-white">{{ __('Discord Experiments') }}</h1>
    <div class="mt-2 mb-4">
        <div class="row">
            <div class="col-12 col-lg-10 offset-lg-1">
                <div class="row mb-3">
                    <div class="col-12 col-md-3">
                        <select wire:model="category" class="form-select">
                            <option value="all" selected>{{ __('All Experiments') }}</option>
                            <option value="user">{{ __('User Experiments') }}</option>
                            <option value="guild">{{ __('Guild Experiments') }}</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-6 mt-2 mt-md-0">
                        <input wire:model="search" type="text" class="form-control" placeholder="{{ __('Search...') }}">
                    </div>
                    <div class="col-12 col-md-3 mt-2 mt-md-0">
                        <select wire:model="order" class="form-select">
                            <option value="name-asc">{{ __('Name Ascending') }}</option>
                            <option value="name-desc">{{ __('Name Descending') }}</option>
                            <option value="updated-asc">{{ __('Updated Ascending') }}</option>
                            <option value="updated-desc" selected>{{ __('Updated Descending') }}</option>
                            <option value="created-asc">{{ __('Created Ascending') }}</option>
                            <option value="created-desc">{{ __('Created Descending') }}</option>
                        </select>
                    </div>
                </div>

                <div class="card text-white bg-dark border-0">
                    <div class="card-body">
                        <div class="row">
                            @if(empty($this->experimentsJsonSearch))
                                <div>
                                    {{ __('No experiments found.') }}
                                </div>
                            @endif
                            @foreach($this->experimentsJsonSearch as $experiment)
                                <div class="col-12 mt-1 mb-1">
                                    <div class="row">
                                        <div class="col-12 col-md-1 text-center">
                                            @if($experiment['type'] == "user")
                                                <i class="fas fa-user text-primary" style="font-size: 44px;"></i>
                                            @elseif($experiment['type'] == "guild")
                                                <i class="fas fa-server text-success" style="font-size: 44px;"></i>
                                            @else
                                                <i class="fas fa-question text-danger" style="font-size: 44px;"></i>
                                            @endif
                                        </div>
                                        <div class="col-12 col-md-7 text-center text-md-start">
                                            <div>
                                                {{ $experiment['name'] }}
                                            </div>
                                            <div class="mt-n1">
                                                <small class="text-muted">
                                                    {{ $experiment['id'] }}
                                                    &bull;
                                                    {{ date('Y-m-d g:i A', $experiment['updated']) }}
                                                </small>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-4 text-center text-md-end">
                                            {{-- TODO: Soon
                                            @if($experiment['type'] == "guild")
                                                <a role="button" href="{{ route('experiment', ['experimentId' => $experiment['id']]) }}#guilds" class="btn btn-sm btn-outline-warning mt-2 mt-xl-0">{{ __('Guilds') }}</a>
                                            @endif
                                            --}}
                                            <a role="button" href="{{ route('experiment', ['experimentId' => $experiment['id']]) }}" class="btn btn-sm btn-outline-primary mt-2 mt-xl-0">{{ __('Experiment Info') }}</a>
                                        </div>
                                    </div>
                                    @if(!$loop->last)
                                        <hr>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
