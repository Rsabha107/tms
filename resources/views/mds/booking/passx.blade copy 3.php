<!doctype html>
<html lang='en'>

<head>
    <title>Invoice for {{ $to }}</title>
    <meta charset='utf-8'>

    {{-- Use an absolute path when specifying the CSS so it works in the PDF --}}
    <link href="{{ $css }}" rel='stylesheet'>
</head>

<body>
    <h1>Invoice</h1>
    <img src="{{ asset('assets/img/gallery/afc-asian-cup-qatar-2023.jpg')}}" class='invoice-icon' alt='Invoice icon'>
    <p><span class='label'>Billed to:</span> {{ $to }}</p>
    <p><span class='label'>Subtotal:</span> ${{ $subtotal }}</p>
    <p><span class='label'>Tax:</span> ${{ $tax }}</p>
    <p><span class='label'>Total:</span> ${{ $total }}</p>
</body>

</html>
