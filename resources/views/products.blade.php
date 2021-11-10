@include('view.header')

    @if ($id > 0)
        <p>Product ID: {{ $id }}</p>
        <p>Product Name: {{ $werkzeuge[$id]["name"] }}</p>
        <p>Product Description: {{ $werkzeuge[$id]["description"] }}</p>
        <p><a href="/products">Zurück zur Auswahl</a></p>
    @else
        <p>Products: {{ $kategorie }}</p>
        @empty ($werkzeuge)
            <p>keine Werkzeuge</p>
        @else
            <ul>
            @foreach ($werkzeuge as $i => $w)
                <li><a style="color: {{ ($loop->even ? "red" : "black") }}" href="/products/{{ $i }}">{{ $w["name"] }}</a></li>
                @if ($loop->last) {{ $loop->count }} @endif
            @endforeach
            </ul>
        @endempty
    @endif
@include('view.footer')