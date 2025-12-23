<div>
    <main>

        <div>
            <livewire:front.profile.user-account-view :isprofile="false" />
        </div>

        <section id="profile-tabs-list" class="mb-4 border-bottom">
            <div class="container-lg container-inner-padding">
                <nav class="overflow-auto">
                    <ul class="nav nav-pills flex-nowrap flex-sm-nowrap d-flex border-0 gap-2" id="packageTab"
                        role="tablist" style="white-space: nowrap;">
                        <li class="nav-item" role="presentation">
                            <button type="button"
                                class="nav-link fw-semibold rounded-pill {{ $activeTab === 'information' ? 'active bg-white' : '' }}"
                                wire:click="ChangeTabs('information')">
                                General Information
                            </button>
                        </li>

                        <!-- Cover Photos -->
                        {{-- <li class="nav-item" role="presentation">
                            <button type="button"
                                class="nav-link fw-semibold rounded-pill {{ $activeTab === 'cover-photo' ? 'active bg-white' : '' }}"
                                wire:click="ChangeTabs('cover-photo')">
                                Cover Photos
                            </button>
                        </li> --}}

                        <li class="nav-item d-lg-none" role="presentation">
                            <button
                                class="nav-link fw-semibold {{ $activeTab === 'following' ? 'active bg-white' : '' }}"
                                id="mobile-following-tab" wire:click="ChangeTabs('following')" type="button"
                                role="tab">Following</button>
                        </li>
                        <li class="nav-item d-lg-none" role="presentation">
                            <button
                                class="nav-link fw-semibold {{ $activeTab === 'follower' ? 'active bg-white' : '' }}"
                                wire:click="ChangeTabs('follower')" id="mobile-follower-tab" type="button"
                                role="tab">Follower
                            </button>
                        </li>
                    </ul>
                </nav>
            </div>
        </section>

        <section class="profile-tabs">
            <div class="container-lg container-inner-padding">
                <div class="row" style="min-height: 250px;">
                    <div class="col-lg-8">
                        <div class="tab-content" id="ParkTabContent">

                            <!-- Profile Tab -->
                            @if ($activeTab == 'information')
                                <livewire:front.auth.general-info-form :key="'information'" />
                            @elseif($activeTab == 'cover-photo')
                                <!-- Shared Safari Tab -->
                                {{-- <livewire:front.auth.cover-photo-form :key="'cover-photo'" /> --}}
                            @elseif($activeTab == 'following')
                                <div class="mobile-view" id="mobile-view">
                                    <livewire:front.auth.follow-list-component :type="'following'" :view="'mobile'"
                                        :user-id="auth()->id()" />
                                </div>
                            @elseif($activeTab == 'follower')
                                <livewire:front.auth.follow-list-component :type="'follower'" :view="'mobile'"
                                    :user-id="auth()->id()" />
                            @endif


                        </div>
                    </div>
                    <div class="col-lg-4 d-lg-block d-none">
                        <livewire:front.auth.follow-list-component :type="'following'" :view="'desktop'"
                            :user-id="auth()->id()" />
                    </div>

                </div>
            </div>
        </section>
    </main>
</div>
@push('scripts')
    <script>
        document.addEventListener('livewire:init', function() {
            initDatePicker();
        });

        document.addEventListener('livewire:update', function() {
            initDatePicker();
        });

        function initDatePicker() {
            flatpickr(".datepicker", {
                dateFormat: "Y-m-d",
                onChange: function(selectedDates, dateStr, instance) {
                    @this.set('dob', dateStr);
                }
            });
        }
    </script>

    <script>
        window.addEventListener('clear-file-input', () => {
            const fileInput = document.getElementById('coverImageInput');
            if (fileInput) {
                fileInput.value = ''; // Clear the selected file
            }
        });
    </script>

    <script>
        function validateName(input) {
            const regex = /^[A-Za-z]+(?: [A-Za-z]+)*$/;

            if (!regex.test(input.value)) {

                input.value = input.value
                    .replace(/[^a-zA-Z\s]/g, '')

            }

            input.value = input.value.replace(/\b\w/g, function(c) {
                return c.toUpperCase();
            });
        }
    </script>
@endpush
