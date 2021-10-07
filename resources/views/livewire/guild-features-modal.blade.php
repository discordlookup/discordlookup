<div>
    <div wire:ignore.self class="modal fade" id="modalFeatures" tabindex="-1" aria-labelledby="modalFeaturesTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-dark border-0">
                <div class="modal-header bg-dark">
                    <h5 class="modal-title" id="modalFeaturesTitle"><b>Features:</b> {{ $guildName }}</h5>
                </div>
                <div class="modal-body bg-dark">
                    <ul style="text-transform: capitalize;">
                        @if(empty($features))
                            No features
                        @endif
                        @foreach($features as $feature)
                            <li>{{ strtolower(str_replace("_", " ", $feature)) }}</li>
                        @endforeach
                    </ul>
                </div>
                <div class="modal-footer bg-dark">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
