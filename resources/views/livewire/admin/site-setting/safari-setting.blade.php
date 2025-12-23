<div>
    <div class="card">
        <div class="card-body">
            <form wire:submit="save">
                <div class="mb-3">
                    <div class="form-check form-switch">
                        <label class="form-label">Auto Publish User Shared Safari</label>
                        <input class="form-check-input" type="checkbox" role="switch" id="checkbox"
                            wire:model="key.publish_user_sharedsafari" @checked(@$key['publish_user_sharedsafari'])>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="form-check form-switch">
                        <label class="form-label">Auto Publish Agent Shared Safari</label>
                        <input class="form-check-input" type="checkbox" role="switch" id="checkbox"
                            wire:model="key.publish_agent_sharedsafari" @checked(@$key['publish_agent_sharedsafari'])>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="form-check form-switch">
                        <label class="form-label">Show Booked All Seat Shared Safari</label>
                        <input class="form-check-input" type="checkbox" role="switch" id="checkbox"
                            wire:model="key.publish_show_booked_shared_safari" @checked(@$key['publish_show_booked_shared_safari'])>
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-success">
                        Save
                        <i class="spinner-border spinner-border-sm" wire:loading></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
