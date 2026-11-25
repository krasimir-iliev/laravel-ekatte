@php
    $thStyle = 'background-color: #007bff; color: #ffffff;';
    $tdStyle = '';
@endphp
<html>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <table>
        <thead>
            <tr>
                <th style="{{ $thStyle }}">Code</th>
                @foreach ($locales as $locale)
                    <th style="{{ $thStyle }}">Name {{ strtoupper($locale) }}</th>
                @endforeach
                @foreach ($locales as $locale)
                    <th style="{{ $thStyle }}">District {{ strtoupper($locale) }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($municipalities as $municipality)
                <tr>
                    <td style="{{ $tdStyle }}">{{ $municipality->code }}</td>
                    @foreach ($locales as $locale)
                        <td style="{{ $tdStyle }}">{{ $municipality->translate($locale)?->name }}</td>
                    @endforeach
                    @foreach ($locales as $locale)
                        <td style="{{ $tdStyle }}">{{ $municipality->district->translate($locale)?->name }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</html>
