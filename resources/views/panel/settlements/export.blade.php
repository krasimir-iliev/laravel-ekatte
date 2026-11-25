@php
    $thStyle = 'background-color: #007bff; color: #ffffff;';
    $tdStyle = '';
@endphp
<html>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <table>
        <thead>
            <tr>
                <th style="{{ $thStyle }}">EKATTE</th>
                <th style="{{ $thStyle }}">Kind</th>
                @foreach ($locales as $locale)
                    <th style="{{ $thStyle }}">Name {{ strtoupper($locale) }}</th>
                @endforeach
                @foreach ($locales as $locale)
                    <th style="{{ $thStyle }}">Town Hall {{ strtoupper($locale) }}</th>
                @endforeach
                @foreach ($locales as $locale)
                    <th style="{{ $thStyle }}">Municipality {{ strtoupper($locale) }}</th>
                @endforeach
                @foreach ($locales as $locale)
                    <th style="{{ $thStyle }}">District {{ strtoupper($locale) }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($settlements as $settlement)
                <tr>
                    <td style="{{ $tdStyle }}">{{ $settlement->ekatte }}</td>
                    <td style="{{ $tdStyle }}">{{ $settlement->settlementKind->name }}</td>
                    @foreach ($locales as $locale)
                        <td style="{{ $tdStyle }}">{{ $settlement->translate($locale)?->name }}</td>
                    @endforeach
                    @foreach ($locales as $locale)
                        <td style="{{ $tdStyle }}">{{ $settlement->townHall->translate($locale)?->name }}</td>
                    @endforeach
                    @foreach ($locales as $locale)
                        <td style="{{ $tdStyle }}">{{ $settlement->townHall->municipality->translate($locale)?->name }}</td>
                    @endforeach
                    @foreach ($locales as $locale)
                        <td style="{{ $tdStyle }}">{{ $settlement->townHall->municipality->district->translate($locale)?->name }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</html>
