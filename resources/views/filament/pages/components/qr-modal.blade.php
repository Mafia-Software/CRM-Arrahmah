<div class="flex justify-center">
    @if (isset($qrCode))
        <img src="data:image/png;base64, {{ $qr }}" alt="QR Code" />
    @elseif (isset($message))
        <p>{{ $message }}</p>
    @endif
</div>
