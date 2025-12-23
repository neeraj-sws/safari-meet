<div>
    <div class="container">
        <div class="row">
            <div class="col-lg-2">
                <div class="card">
                    <div class="card-body">
                        <div class="d-grid my-3">
                            <div class="form-check form-switch form-check-info">
                                <label class="form-check-label">Show In Front</label>
                                <input class="form-check-input"
                                    wire:change.live="toggleStatus({{ $characterDetails['package_details_tabs_id'] }})"
                                    @checked($characterDetails['status']) id="{{ $characterDetails['package_details_tabs_id'] }}"
                                    type="checkbox" role="switch">
                            </div>
                        </div>
                        <div class="fm-menu">
                            <div class="list-group list-group-flush">
                                @php $slug = Str::slug($characterDetails['title'], '_'); @endphp
                                <a href="javascript:;" onclick="updateTab('{{ $slug }}','ratingsheading')"
                                    class="list-group-item py-1 {{ $activeTabe == 'ratingsheading' ? 'active text-white' : '' }}"
                                    wire:click="changeTab('ratingsheading')"><span>Add Rating Headings</span></a>
                                <a href="javascript:;" onclick="updateTab('{{ $slug }}','ratingsdetails')"
                                    class="list-group-item py-1 {{ $activeTabe == 'ratingsdetails' ? 'active text-white' : '' }}"
                                    wire:click="changeTab('ratingsdetails')"><span>Add Rating</span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-10">
                @if ($activeTabe == 'ratingsheading')
                    <livewire:admin.common.rateing-headings :type="'2'" :id="$package->id" :key="'heading'">
                    @elseif ($activeTabe == 'ratingsdetails')
                        <livewire:admin.common.safari-ratings :type="'2'" :model="$package" :key="'ratings'">
                @endif
            </div>
        </div>
    </div>
</div>
