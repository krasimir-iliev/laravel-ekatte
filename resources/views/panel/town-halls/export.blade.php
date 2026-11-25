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
                    <th style="{{ $thStyle }}">Municipality {{ strtoupper($locale) }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($townHalls as $townHall)
                <tr>
                    <td style="{{ $tdStyle }}">{{ $townHall->code }}</td>
                    @foreach ($locales as $locale)
                        <td style="{{ $tdStyle }}">{{ $townHall->translate($locale)?->name }}</td>
                    @endforeach
                    @foreach ($locales as $locale)
                        <td style="{{ $tdStyle }}">{{ $townHall->municipality->translate($locale)?->name }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</html>
