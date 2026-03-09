<div>
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">{{ $pageTitle }}</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $pageTitle }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row row-cols-1 row-cols-md-3 row-cols-lg-3 row-cols-xl-3">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <div>
                        <h5 class="card-title">Species Data Clear</h5>
                    </div>
                    <p class="card-text">Data related to species will be permanently deleted, and there will be no
                        option to recover it.</p>
                    <a title="Delete Permanently" wire:click="confirmDelete(1)" class="btn btn-danger">Delete
                        Permanently</a>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <div>
                        <h5 class="card-title">Park Data Clear</h5>
                    </div>
                    <p class="card-text">Data related to Park will be permanently deleted, and there will be no
                        option to recover it.</p>
                    <a title="Delete Permanently" wire:click="confirmDelete(2)" class="btn btn-danger">Delete
                        Permanently</a>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card">
                <div class="card-body">
                    <div>
                        <h5 class="card-title">Package Safari Data Clear</h5>
                    </div>
                    <p class="card-text">Data related to Package Safari will be permanently deleted, and there will be no
                        option to recover it.</p>
                    <a title="Delete Permanently" wire:click="confirmDelete(3)" class="btn btn-danger">Delete
                        Permanently</a>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <div>
                        <h5 class="card-title">Shared Safari Data Clear</h5>
                    </div>
                    <p class="card-text">Data related to Shared Safari will be permanently deleted, and there will be no
                        option to recover it.</p>
                    <a title="Delete Permanently" wire:click="confirmDelete(4)" class="btn btn-danger">Delete
                        Permanently</a>
                </div>
            </div>
        </div>
<<<<<<< HEAD
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <div>
                        <h5 class="card-title">All Data Clear</h5>
                    </div>
                    <p class="card-text">All data will be permanently deleted, and there will be no
                        option to recover it.</p>
                    <a title="Delete Permanently" wire:click="confirmDelete(5)" wire:loading.attr="disabled"
                        wire:target="confirmDelete(5),deleteAllData" class="btn btn-danger">
                        <span wire:loading.remove wire:target="confirmDelete(5),deleteAllData">Delete Permanently</span>
                        <span wire:loading wire:target="confirmDelete(5),deleteAllData">
                            <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                            Processing...
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

=======
    </div>
</div>
>>>>>>> 89a5c42040adfeb70ab0b1e6118742b9b6d90d5b
