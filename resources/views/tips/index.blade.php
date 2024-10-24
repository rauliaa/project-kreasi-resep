@extends('layouts.tips')

@section('content')
<div class="container">
    <div class="heading_container heading_center mb-3">
        <h2>Tips dan Trik Makanan</h2>
    </div>

    <div class="mb-4 text-center">
        <a href="{{ route('tips.create') }}" class="btn btn-primary">Tambah Tips</a>
    </div>

    <div class="row">
        @foreach($tips as $tip)
            <div class="col-md-12 mb-4">
                <a href="{{ route('tips.show', $tip->id) }}" style="text-decoration: none; color: inherit;">
                    <div class="tip-box" style="position: relative; overflow: hidden; height: 300px;">
                        <img src="{{ asset($tip->image_url) }}" alt="{{ $tip->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                        <div class="tip-content" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center; background: rgba(0, 0, 0, 0.5);">
                            <h3 style="color: white; font-size: 24px; font-weight: bold; text-align: center;">{{ $tip->title }}</h3>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
</div>
@endsection
