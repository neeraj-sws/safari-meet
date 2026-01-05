<div>
    <div class="container">
        @include('livewire.components.breadcrumb', [
            'menu' => $pageTitle,
            'submenus' => [$pageTitle],
        ])
        <div class="card">
            <div class="card-body">
                <ul class="nav nav-pills mb-3" role="tablist">
                    @foreach ($notificationTemplates as $templates)
                        @php $slug = Str::slug($templates?->name, '_'); @endphp
                        <a onclick="updateTab('{{ $slug }}')"
                            class="nav-link pe-auto  {{ $activeTamp == $templates->template_code ? 'active' : '' }}"
                            href="javascript:void(0)" wire:click="toggleStatus('{{ $templates->template_code }}')"
                            role="tab">
                            <div class="d-flex align-items-center">
                                <div class="tab-title">{{ $templates->name }}</div>
                            </div>
                        </a>
                    @endforeach

                </ul>
            </div>
        </div>


        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade active show" role="tabpanel">
                @if ($activeTamp == 'USERENQUIRY')
                    <livewire:admin.notification.user-enquiry-template :activeTamp="$activeTamp" :key="'USERENQUIRY'" />
                @elseif ($activeTamp == 'ADMINENQURY')
                    <livewire:admin.notification.a-t-r-enquiry :activeTamp="$activeTamp" :key="'ADMINENQURY'" />
                @elseif ($activeTamp == 'AGENTEMAILVERIFY')
                    <livewire:admin.notification.agent-verify-email :activeTamp="$activeTamp" :key="'AGENTEMAILVERIFY'" />
                @elseif ($activeTamp == 'AFTERREGISTRATION')
                    <livewire:admin.notification.successfully-registration :activeTamp="$activeTamp" :key="'AFTERREGISTRATION'" />
                @elseif ($activeTamp == 'REGISTRATIONSTATUS')
                    <livewire:admin.notification.registration-status :activeTamp="$activeTamp" :key="'REGISTRATIONSTATUS'" />
                @elseif($activeTamp == 'FORGOTPASSWORD')
                    <livewire:admin.notification.forgot-password :activeTamp="$activeTamp" :key="'FORGOTPASSWORD'" />
                @elseif($activeTamp == 'SEATALLOTED')
                    <livewire:admin.notification.alloted-seats-to-user :activeTamp="$activeTamp" :key="'SEATALLOTED'" />
                @elseif($activeTamp == 'SEAT_STATUS_UPDATE')
                    <livewire:admin.notification.seat-status-update :activeTamp="$activeTamp" :key="'SEAT_STATUS_UPDATE'" />
                @elseif($activeTamp == 'SHAREDSAFARI')
                    <livewire:admin.notification.create-update-shared-safari :activeTamp="$activeTamp" :key="'SHAREDSAFARI'" />
                @elseif($activeTamp == 'PAYMENTRECEIVED')
                    <livewire:admin.notification.payment-received :activeTamp="$activeTamp" :key="'PAYMENTRECEIVED'" />
                @elseif($activeTamp == 'PAYMENTSUBMITTED')
                    <livewire:admin.notification.payment-submitted :activeTamp="$activeTamp" :key="'PAYMENTSUBMITTED'" />
                @endif
            </div>
        </div>
    </div>
</div>
