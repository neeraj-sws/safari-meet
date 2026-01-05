<div>
    <div class="container">
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
            <div class="ms-auto">
                <div class="btn-group">
                    <button type="button" wire:click="clearCache" class="btn btn-warning ms-2">
                        Clear Cache
                        <i class="spinner-border spinner-border-sm" wire:loading wire:target="clearCache"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="fm-menu">
                            <div class="list-group list-group-flush">
                                <a href="javascript:;"  onclick="updateTab('genral_setting')"
                                    class="list-group-item py-1  @if ($activeTab == 'genral_setting') active  text-white @endif"
                                    wire:click="changeTab('genral_setting')"><span>General Setting</span></a>
                                <a href="javascript:;" onclick="updateTab('safari_setting')"
                                    class="list-group-item py-1 @if ($activeTab == 'safari_setting') active  text-white @endif "
                                    wire:click="changeTab('safari_setting')"><span>Safari Setting</span></a>
                                <a href="javascript:;" onclick="updateTab('date_setting')"
                                    class="list-group-item py-1 @if ($activeTab == 'date_setting') active  text-white @endif "
                                    wire:click="changeTab('date_setting')"><span>Date Setting</span></a>
                                <a href="javascript:;" onclick="updateTab('social_link_setting')"
                                    class="list-group-item py-1 @if ($activeTab == 'social_link_setting') active  text-white @endif "
                                    wire:click="changeTab('social_link_setting')"><span>Social Link Setting</span></a>
                                <a href="javascript:;" onclick="updateTab('email_configuration')"
                                    class="list-group-item py-1 @if ($activeTab == 'email_configuration') active  text-white @endif "
                                    wire:click="changeTab('email_configuration')"><span>Email Configuration</span></a>
                                <a href="javascript:;" onclick="updateTab('s3_configuration')"
                                    class="list-group-item py-1 @if ($activeTab == 's3_configuration') active  text-white @endif "
                                    wire:click="changeTab('s3_configuration')"><span>S3 Configuration</span></a>
                                <a href="javascript:;" onclick="updateTab('social_login_configuration')"
                                    class="list-group-item py-1 @if ($activeTab == 'social_login_configuration') active  text-white @endif "
                                    wire:click="changeTab('social_login_configuration')"><span>Social Login Configuration</span></a>
                                <a href="javascript:;" onclick="updateTab('q_r_code_configuration')"
                                    class="list-group-item py-1 @if ($activeTab == 'q_r_code_configuration') active  text-white @endif "
                                    wire:click="changeTab('q_r_code_configuration')"><span>QR Code Configuration</span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-9">
                @if ($activeTab == 'genral_setting')
                    <livewire:admin.site-setting.site-setting-form :key="'genralsetting'" />
                @elseif ($activeTab == 'safari_setting')
                    <livewire:admin.site-setting.safari-setting :key="'safarisetting'" />
                @elseif ($activeTab == 'date_setting')
                    <livewire:admin.site-setting.date-setting :key="'site_setting'" />
                 @elseif ($activeTab == 'social_link_setting')
                    <livewire:admin.site-setting.social-link-setting :key="'social_link_setting'" />
                 @elseif ($activeTab == 'email_configuration')
                    <livewire:admin.site-setting.email-setting :key="'email_configuration'" />
                 @elseif ($activeTab == 's3_configuration')
                    <livewire:admin.site-setting.s3-setting :key="'s3_configuration'" />
                 @elseif ($activeTab == 'social_login_configuration')
                    <livewire:admin.site-setting.social-login-configuration :key="'social_login_configuration'" />
                 @elseif ($activeTab == 'q_r_code_configuration')
                    <livewire:admin.site-setting.q-r-code-configuration :key="'q_r_code_configuration'" />
                @endif
            </div>
        </div>
    </div>
</div>
