@php
    $socialLinks = array_filter([
        'Facebook' => $settings['facebook_url'],
        'YouTube' => $settings['youtube_url'],
        'Instagram' => $settings['instagram_url'],
        'WhatsApp' => $settings['whatsapp'] ? 'https://wa.me/'.preg_replace('/\D/', '', $settings['whatsapp']) : null,
    ]);
@endphp

@if ($socialLinks)
    <p class="social-links">
        @foreach ($socialLinks as $label => $url)
            <a href="{{ $url }}" target="_blank" rel="noopener">{{ $label }}</a>
        @endforeach
    </p>
@endif
