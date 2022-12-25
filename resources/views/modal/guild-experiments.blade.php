<div>
    <div wire:ignore.self class="modal fade" id="modalExperiments" tabindex="-1" aria-labelledby="modalExperimentsTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content bg-dark border-0">
                <div class="modal-header bg-dark">
                    <h5 class="modal-title" id="modalExperimentsTitle"><b>{{ __('Experiments') }}:</b> {{ $guildName }}</h5>
                </div>
                <div class="modal-body bg-dark">
                    <ul>
                        @if(empty($experiments))
                            {{ __('No experiments found') }}
                        @endif
                        @foreach($experiments as $experiment)
                            <li class="mt-3">
                                <span class="fw-bold">
                                    <a class="text-decoration-none" href="{{ route('experiments.show', $experiment['id']) }}">{{ $experiment['title'] }}</a><br>
                                </span>
                                {{ $experiment['treatment'] }}<br>
                                @if($experiment['override'])
                                    <span class="text-success">({{ __('This Guild has an override for this experiment') }})</span><br>
                                @else
                                    @foreach($experiment['filters'] as $filters)
                                        <span class="text-muted">{{ $filters }}</span><br>
                                    @endforeach
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="modal-footer bg-dark">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
                </div>
            </div>
        </div>
    </div>
</div>
