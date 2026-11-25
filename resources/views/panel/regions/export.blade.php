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
            </tr>
        </thead>
        <tbody>
            @foreach ($regions as $region)
                <tr>
                    <td style="{{ $tdStyle }}">{{ $region->code }}</td>
                    @foreach ($locales as $locale)
                        <td style="{{ $tdStyle }}">{{ $region->translate($locale)?->name }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</html>
