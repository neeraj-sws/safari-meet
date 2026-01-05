<div>
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-12">
                <div x-data="{ showForm: false }">
                    <div class="text-end mb-3">
                        <button class="btn btn-primary" type="button" x-show="!showForm"
                            x-on:click=" showForm = true; $wire.call('resetForm') ">Add Images</button>
                        <button class="btn btn-danger" type="button" x-show="showForm"
                            x-on:click="showForm = false">Hide Form</button>
                    </div>

                    <div x-show="showForm" x-transition class="card mb-3">
                        <form wire:submit.prevent="store">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label">
                                                Upload Banner Images <span class="text-danger">*</span>
                                            </label>
                                            <input type="file" wire:model="banner_images" multiple
                                                accept=".jpg,.jpeg,.png,.webp,.JPG,.JPEG,.PNG,.WEBP"
                                                class="form-control @error('banner_images.*') is-invalid @enderror">
                                            <small>Expected aspect ratio is 16:9 (e.g. 1600*900 px).</small> <br>
                                            @error('banner_images.*')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <label class="form-label">
                                            {{ $isEditing ? 'Current' : 'Preview' }}
                                        </label>
                                        <div class="border bg-light text-center p-2 position-relative"
                                            style="min-height: 143px; overflow-y: auto; max-height: 300px;">

                                            <div wire:loading.remove wire:target="banner_images"
                                                class="d-flex flex-wrap gap-2">
                                                @if ($banner_images)
                                                    @foreach ($banner_images as $index => $image)
                                                        <div class="position-relative"
                                                            style="width: 100px; height: 100px;">
                                                            <img src="{{ $image->temporaryUrl() }}"
                                                                class="img-fluid object-fit-contain w-100 h-100 rounded">
                                                            <button type="button"
                                                                class="btn btn-sm btn-danger position-absolute top-0 end-0 rounded-circle z-3"
                                                                style="padding: 0.2rem 0.4rem;"
                                                                wire:click="removeBannerImage({{ $index }})">×</button>
                                                        </div>
                                                    @endforeach
                                                @elseif ($isEditing && !empty($bannerpreviousImage))
                                                    <img src="{{ asset($bannerpreviousImage) }}"
                                                        class="img-fluid h-100 object-fit-contain">
                                                @else
                                                    <span
                                                        class="text-muted d-flex align-items-center justify-content-center h-100">
                                                        No Images Selected
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 text-end mt-4">
                                    <button type="submit" wire:target="store" wire:loading.attr="disabled"
                                        class="btn btn-primary" id="submitOverview">
                                        <span wire:loading.remove="" wire:target="store">
                                            Submit
                                        </span>
                                        <span wire:loading="" wire:target="store">
                                            <span class="spinner-border spinner-border-sm me-1" role="status"
                                                aria-hidden="true"></span>
                                            Submitting...
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="border bg-light text-center p-2 position-relative"
                            style="min-height: 143px; overflow-y: auto; max-height: 500px;">
                            <div class="d-flex flex-wrap gap-2">
                                @if (count($bannerImages) > 0)
                                    @foreach ($bannerImages as $index => $banner)
                                        <div class="position-relative" style="width: 200px; height: 200px;">
                                            <img src="{{ asset($banner->image) }}"
                                                class="img-fluid object-fit-contain w-100 h-100 rounded">
                                            <button type="button"
                                                class="btn btn-sm btn-danger position-absolute top-0 end-0 rounded-circle z-3"
                                                style="padding: 0.2rem 0.4rem;"
                                                wire:click="deleteBannerImage({{ $banner->id }})">×</button>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
