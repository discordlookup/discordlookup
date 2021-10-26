<div>
    <div wire:ignore.self class="modal fade" id="modalExperiments" tabindex="-1" aria-labelledby="modalExperimentsTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
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
                            <li class="mt-2">
                                <b>{{ $experiment['title'] }}</b><br>
                                @foreach($experiment['treatments'] as $treatment)
                                    {{ $treatment }}<br>
                                @endforeach
                                @if($experiment['override'])
                                    <span class="text-success">({{ __('This Guild has an override for this experiment') }})</span><br>
                                @else
                                    @foreach($experiment['filters'] as $filters)
                                        {!! $filters !!}<br>
                                    @endforeach
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="modal-footer bg-dark  justify-content-between">
                    <span class="text-muted small">
                        {{ __('Powered by') }} <a href="https://rollouts.advaith.io/" target="_blank" rel="noopener" class="text-decoration-none">Advaith's Experiment Rollout Site</a>
                    </span>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
                </div>
            </div>
        </div>
    </div>
</div>
