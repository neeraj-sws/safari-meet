<div>
    <div class="card">
        <div class="card-body">
            <form wire:submit="save">
                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Google Client Id</label>
                        <input type="text" class="form-control" wire:model="key.GOOGLE_CLIENT_ID">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Google Client Secret</label>
                        <input type="text" class="form-control" wire:model="key.GOOGLE_CLIENT_SECRET">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Facebook Client Id</label>
                        <input type="text" class="form-control" wire:model="key.FACEBOOK_CLIENT_ID">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Facebook Client Secret</label>
                        <input type="text" class="form-control" wire:model="key.FACEBOOK_CLIENT_SECRET">
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
