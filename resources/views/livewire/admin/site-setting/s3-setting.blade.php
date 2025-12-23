<div>
    <div class="card">
        <div class="card-body">
            <form wire:submit="save">
                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label class="form-label">AWS Access Key Id</label>
                        <input type="text" class="form-control" wire:model="key.AWS_ACCESS_KEY_ID">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">AWS Secret Access Key</label>
                        <input type="text" class="form-control" wire:model="key.AWS_SECRET_ACCESS_KEY">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">AWS Default Region</label>
                        <input type="text" class="form-control" wire:model="key.AWS_DEFAULT_REGION">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">AWS Bucket</label>
                        <input type="text" class="form-control" wire:model="key.AWS_BUCKET">
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
