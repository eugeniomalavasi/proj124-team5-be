@extends('layouts.admin')

@section('content')

    <div class="container">
        <h1 class="mt-4 fw-bold">Modifica Appartamento</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.apartments.update', ['apartment' => $apartment->slug]) }}" method="POST">
            @method('PUT')
            @csrf

            <div class="form-group">
                <label for="title">Titolo:<span class="text-black">*</span></label>
                <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $apartment->title) }}">
            </div>

            <div class="form-group">
                <label for="address">Indirizzo:<span class="text-black">*</span></label>
                <input type="text" class="form-control" id="address" name="address" value="{{ old('address', $apartment->address) }}">
            </div>

            <div class="form-group">
                <label for="rooms">Stanze:<span class="text-black">*</span></label>
                <input type="number" class="form-control" id="rooms" name="rooms" value="{{ old('rooms', $apartment->rooms) }}" required>
            </div>

            <div class="form-group">
                <label for="beds">Posti letto:<span class="text-black">*</span></label>
                <input type="number" class="form-control" id="beds" name="beds" value="{{ old('beds', $apartment->beds) }}" required>
            </div>
            <div class="form-group">
                <label for="bathroom">Bagni:<span class="text-black">*</span></label>
                <input type="number" class="form-control" id="bathroom" name="bathroom" value="{{ old('bathroom', $apartment->bathroom) }}" required>
            </div>
            <div class="form-group">
                <label for="square_mt">Metri Quadrati:<span class="text-black">*</span></label>
                <input type="number" class="form-control" id="square_mt" name="square_mt" value="{{ old('square_mt', $apartment->square_mt) }}" required>
            </div>

            <div class="form-group">
                <label for="sponsorship_id">Sponsorship:<span class="text-black">*</span></label>
                <select class="form-select" name="sponsorship_id" id="sponsorship_id" required>
                    <option value=""></option>
                    @foreach ($sponsorships as $sponsorship)
                        <option value="{{ $sponsorship->id }}" {{ old('sponsorship_id', $apartment->sponsorship_id) == $sponsorship->id ? 'selected' : '' }}>
                            {{ $sponsorship->type }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="description">Descrizione:</label>
                <textarea class="form-control" id="description" name="description">{{ old('description', $apartment->description) }}</textarea>
            </div>

            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="1" id="available" name="available" {{ old('available', $apartment->available) ? 'checked' : '' }}>
                <label class="form-check-label" for="available">
                    Disponibile
                </label>
            </div>

            <div class="mt-2">
                <span>Servizi offerti:</span>
                @foreach ($services as $service)
                <div class="form-check">
                    @if (old('services') !== null)
                    <input @checked(in_array($service->id, old('services'))) name="services[]" class="form-check-input" type="checkbox" value="{{ $service->id }}" id="service-{{ $service->id }}">
                    @else
                    <input @checked($apartment->services->contains($service)) name="services[]" class="form-check-input" type="checkbox" value="{{ $service->id }}" id="service-{{ $service->id }}">
                    @endif
                    <label class="form-check-label" for="service-{{ $service->id }}">
                        {{ $service->title }}
                    </label>
                </div>
                @endforeach
            </div>
            
            {{-- <div>
                <span>Slug:</span>
                <p class="fw-bold" id="slug"></p>
            </div> --}}

            <button type="submit" class="btn btn-primary mt-2">Modifica</button>
            <a href="{{ route('admin.apartments.index') }}" class="btn btn-secondary mt-2">Cancella</a>
        </form>

    </div>

@endsection