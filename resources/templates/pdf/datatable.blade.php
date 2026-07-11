<x-layouts::pdf>
    <table>
        <thead>
            <tr>
                @foreach ($headings as $heading)
                    <th>{{ $heading }}</th>
                @endforeach
            </tr>
        </thead>

        <tbody>
            @forelse ($rows as $row)
                <!-- chunk -->
                <tr>
                    @foreach ($row as $cell)
                        <td>{!! $cell !!}</td>
                    @endforeach
                </tr>
            @empty
                <tr>
                    <td colspan="{{ count($headings) }}">
                        {{ __('No data available') }}
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</x-layouts::pdf>
