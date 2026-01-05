<div data-profile-parent>
    <main>
        <!-- Profile Cover Section -->
        <div>
            <livewire:front.profile.user-account-view />
        </div>

        <section id="profile-tabs-list" class="mb-4 border-bottom">
            <div class="container-lg container-inner-padding">
                <nav class="overflow-auto">
                    <ul class="nav nav-pills flex-nowrap flex-sm-nowrap d-flex border-0 gap-2" id="packageTab"
                        role="tablist" style="white-space: nowrap;">
                        <li class="nav-item" role="presentation">
                            <a href="javascript:void(0);" onclick="updateTab('profile')" type="button"
                                class="nav-link {{ $activeTab == 'profile' ? 'active' : '' }} fw-semibold bg-white">Profile</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a href="javascript:void(0);" onclick="updateTab('shared-safari')"
                                class="nav-link  {{ $activeTab == 'shared-safari' ? 'active' : '' }} fw-semibold rounded-pill"
                                type="button"> Safari History </a>
                        </li>
                        <li class="nav-item">
                            <a href="javascript:void(0);" onclick="updateTab('add-media-post')" type="button"
                                class="nav-link {{ $activeTab == 'add-media-post' ? 'active' : '' }} fw-semibold bg-white">
                                Add Media Post
                            </a>
                        </li>
                        <li class="nav-item d-lg-none" role="presentation">
                            <a href="javascript:void(0);" onclick="updateTab('following')"
                                class="nav-link fw-semibold {{ $activeTab === 'following' ? 'active bg-white' : '' }}"
                                id="mobile-following-tab" type="button" role="tab">Following</a>
                        </li>
                        <li class="nav-item d-lg-none" role="presentation">
                            <a href="javascript:void(0);" onclick="updateTab('follower')"
                                class="nav-link fw-semibold {{ $activeTab === 'follower' ? 'active bg-white' : '' }}"
                                id="mobile-follower-tab" type="button" role="tab">Follower
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </section>


        <section class="profile-tabs">
            <div class="container-lg container-inner-padding">
                <div class="row" style="min-height: 250px;" id="profile-main-component">
                    <div class="col-lg-8">
                        <div class="tab-content" id="ParkTabContent">

                            @if ($activeTab == 'profile')
                            <livewire:front.profile.user-account-profile :key="'profile'" />
                            @elseif($activeTab == 'add-media-post')
                            <livewire:front.auth.create-blog-post-component :key="'add-media-post'" />
                            @elseif($activeTab == 'shared-safari')
                            <livewire:front.profile.user-account-shared-safaries :key="'user-safaries'" />
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
    function updateTab(tab, subtab = null, subtabId = null) {
            const url = new URL(window.location);
            url.searchParams.set('tab', tab);

            if (subtab) {
                url.searchParams.set('subtab', subtab);
            } else {
                url.searchParams.delete('subtab');
            }

            window.history.pushState({}, '', url);

            const componentEl = document.querySelector('[data-profile-parent][wire\\:id]');
            if (!componentEl) return;

            const component = Livewire.find(componentEl.getAttribute('wire:id'));

            component.set('activeTab', tab);
            if (subtab) {
                component.set('overviewActiveTabData', subtabId);
                component.set('activeTabForOverview', subtab);
            }
        }
</script>
@endpush
