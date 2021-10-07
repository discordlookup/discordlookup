<div>
    <div wire:ignore.self class="modal fade" id="modalPermissions" tabindex="-1" aria-labelledby="modalPermissionsTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-dark border-0">
                <div class="modal-header bg-dark">
                    <h5 class="modal-title" id="modalPermissionsTitle"><b>Permissions:</b> {{ $guildName }}</h5>
                </div>
                <div class="modal-body bg-dark">
                    <ul style="text-transform: capitalize;">
                        @foreach($permissionsList as $permission)
                            <li>{{ strtolower(str_replace("_", " ", $permission)) }}</li>
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
