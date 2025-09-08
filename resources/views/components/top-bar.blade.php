<!-- Top Bar Component -->
@php
    $contactAddress = \App\Models\Setting::getValue('contact_address', 'Jl. KH. Sholeh Iskandar Km.2 Kd. Badak Bogor');
    $contactAddressLink = \App\Models\Setting::getValue('contact_address_link', '');
    $contactEmail = \App\Models\Setting::getValue('contact_email', 'info@admin.com');
    $contactWhatsapp = \App\Models\Setting::getValue('contact_whatsapp', '628151888930');
@endphp
<div class="top-bar d-none d-md-block">
    <div class="container">
        <div class="top-bar-content">
            <div class="top-bar-info">
                <span class="top-bar-item">
                    <i class="fas fa-map-marker-alt"></i>
                    @if(!empty($contactAddressLink))
                        <a href="{{ $contactAddressLink }}" target="_blank" class="address-link" title="Lihat di Google Maps">
                            {{ $contactAddress }}
                            <i class="fas fa-external-link-alt ms-1" style="font-size: 0.8em;"></i>
                        </a>
                    @else
                        {{ $contactAddress }}
                    @endif
                </span>
            </div>
            <div class="top-bar-contact">
                <span class="top-bar-item">
                    <i class="fas fa-envelope"></i>
                    <a href="mailto:{{ $contactEmail }}">{{ $contactEmail }}</a>
                </span>
                <span class="top-bar-item">
                    <i class="fab fa-whatsapp"></i>
                    <a href="https://wa.me/{{ $contactWhatsapp }}" target="_blank">{{ $contactWhatsapp }}</a>
                </span>
            </div>
        </div>
    </div>
</div>
