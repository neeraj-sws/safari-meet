<div>
    <div class="card">
        <div class="card-body">
            <form wire:submit="save">
                <div class="row">

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Mailer</label>
                        <input type="text" class="form-control" wire:model="key.mail_mailer">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Host</label>
                        <input type="text" class="form-control" wire:model="key.mail_host">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Port</label>
                        <input type="number" class="form-control" wire:model="key.mail_port">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" class="form-control" wire:model="key.mail_username">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Password</label>

                        <div class="input-group">
                            <input type="password" id="mailPassword" class="form-control"
                                wire:model="key.mail_password">

                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword()">
                                👁
                            </button>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Encryption</label>
                        <input type="text" class="form-control" wire:model="key.mail_encryption">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">From Email Address</label>
                        <input type="email" class="form-control" wire:model="key.mail_from_address">
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
<script>
    function togglePassword() {
        const input = document.getElementById('mailPassword');
        input.type = input.type === "password" ? "text" : "password";
    }
</script>
