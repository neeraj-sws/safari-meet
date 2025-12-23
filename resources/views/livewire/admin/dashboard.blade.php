<div class="container">
    <div class="row g-3 row-cols-1 row-cols-md-2 row-cols-xl-4">
        <div class="col">
            <div class="card m-0 h-100 radius-10 border-start border-0 border-3 border-warning">
                <div class="card-body">
                    <a href="{{ route('admin.package.package') }}">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0 text-secondary">National Parks</p>
                                <h4 class="my-1 text-warning">{{$parksCount}}</h4>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card m-0 h-100 radius-10 border-start border-0 border-3 border-info">
                <div class="card-body">
                    <a href="{{ route('admin.species.species') }}">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0 text-secondary">Species</p>
                                <h4 class="my-1 text-info">{{$speciesCount}}</h4>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card m-0 h-100 radius-10 border-start border-0 border-3 border-danger">
                <div class="card-body">
                    <a href="{{ route('admin.sharedsafari.share.safari') }}">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0 text-secondary">Shared Safari</p>
                                <h4 class="my-1 text-danger">{{$safarisCount}}</h4>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card m-0 h-100 radius-10 border-start border-0 border-3 border-success">
                <div class="card-body">
                    <a href="{{ route('admin.package.package') }}">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0 text-secondary">Packages</p>
                                <h4 class="my-1 text-success">{{$packagesCount}}</h4>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
