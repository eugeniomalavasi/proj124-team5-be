@extends('layouts.admin')

@section('content')
    <div class="container mt-5 mb-5">
        <h1 class="mb-4 text-center fw-bold text-white">Modifica Appartamento</h1>

        <!-- Messaggi di errore se ci sono problemi con la convalida del modulo -->
        @if ($errors->any())
            <div id="error-alert" class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card shadow-sm rounded border-0">
            <div class="card-body p-4">
                <!-- Inizio del modulo per modificare un appartamento -->
                <form action="{{ route('admin.apartments.update', ['apartment' => $apartment->slug]) }}" method="POST"
                    enctype="multipart/form-data">
                    @method('PUT')
                    @csrf <!-- Protezione CSRF per il modulo -->

                    <div class="mb-3">
                        <label for="title" class="form-label">Titolo*:</label>
                        <input type="text" class="form-control form-control-lg @error('title') is-invalid @enderror"
                            id="title" name="title" value="{{ old('title', $apartment->title) }}" required>
                        @error('title')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="apartment_description" class="form-label">Descrizione:</label>
                        <textarea class="form-control form-control-lg" id="apartment_description" name="apartment_description"
                            placeholder="Scrivi qualcosa sull'appartamento..." rows="4">{{ old('apartment_description', $apartment->apartment_description) }}</textarea>
                    </div>
                    <!-- Sezione con flexbox per disporre i campi in due colonne -->
                    <div class="d-flex flex-wrap">
                        <div class="flex-fill p-2">
                            <div class="form-group mb-3">
                                <label for="address" class="form-label">Indirizzo*:</label>
                                <input type="text" class="form-control" id="address" name="address"
                                    value="{{ old('address', $apartment->address) }}" autocomplete="off" required>
                                <div id="suggestions" class="list-group mt-2"></div>
                            </div>

                            <div class="form-group mb-3">
                                <label for="rooms" class="form-label">Stanze*:</label>
                                <input type="number" class="form-control" min="1" step="1" id="rooms" name="rooms"
                                    value="{{ old('rooms', $apartment->rooms) }}" required>
                            </div>

                            <div class="form-group mb-3">
                                <label for="beds" class="form-label">Posti letto*:</label>
                                <input type="number" class="form-control" min="1" step="1" id="beds" name="beds"
                                    value="{{ old('beds', $apartment->beds) }}" required>
                            </div>
                        </div>
                        <div class="flex-fill p-2">
                            <div class="form-group mb-4">
                                <label for="bathroom" class="form-label">Bagni*:</label>
                                <input type="number" class="form-control" min="1" step="1" id="bathroom" name="bathroom"
                                    value="{{ old('bathroom', $apartment->bathroom) }}" required>
                            </div>

                            <div class="form-group mb-3">
                                <label for="square_mt" class="form-label">Metri Quadrati*:</label>
                                <input type="number" class="form-control" min="1" step="1" id="square_mt" name="square_mt"
                                    value="{{ old('square_mt', $apartment->square_mt) }}" required>
                                </div>
                                
                                <div class="form-group mb-3 d-flex container p-0">
                                    
                                        <div class="w-100 d-flex flex-column align-items-start">
                                            <label for="inp_img" class="form-label">Immagine appartamento</label>
                                            <input type="file" class="form-control" name="inp_img" id="inp_img">
                                        </div>
                                    
                                </div>
                                
                                
                            </div>
                            <div class="col-12 col-md-12 col-sm-12 col-lg-12 mb-2 mt-2 mb-2 "><img src="{{ asset('storage/' . $apartment->img_path) }}" alt="" id="preview" class="container-fluid" style="max-width: 300px; max-height: 300px; min-width: 150px; min-height: 150px; object-fit: cover;"></div>
                    </div>

                    <div class="form-check mb-3">

                            <input class="form-check-input" type="checkbox" value="1" id="available" name="available"
                                @checked(old('available', $apartment->available) ? 'checked' : '')>
                            <label class="form-check-label" for="available">
                                Disponibile
                            </label>
                    </div>

                    <div class="mt-2">

                        <span>Servizi offerti:</span>
                        @foreach ($services as $service)
                            <div class="form-check">
                                @if (old('services') === null)
                                    <input @checked($apartment->services->contains($service)) name="services[]" class="form-check-input"
                                    type="checkbox" value="{{ $service->id }}" id="service-{{ $service->id }}"
                                    autocomplete="off">
                                @else
                                        <input @checked(in_array($service->id, old('services'))) name="services[]" class="form-check-input"
                                        type="checkbox" value="{{ $service->id }}" id="service-{{ $service->id }}"
                                        autocomplete="off">
                                @endif
                                <label class="form-check-label" for="services">
                                    {{ $service->title }}
                                </label>
                            </div>
                        @endforeach
                        <div class="mb-3">
                            <small class="text-muted">Compila i campi contrassegnati con *.</small>
                        </div>
                        <div class="d-flex justify-content-between">
                            <button type="submit" id="submit" class="btn btn-orange">Modifica</button>
                            <a href="{{ route('admin.apartments.index') }}" class="btn btn-secondary">Cancella</a>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .btn {
           background-color:  #FE5D26;
           border-color: #FE5D26
        }
    
        .btn:hover {
           background-color:  #f78660;
           border-color: #FE5D26
        }
    
        a {
            color: #FE5D26;
        }
    
        .btn:first-child:active {
            border-color: #f78660;
            background-color:  #f78660;
        }
    
        .form-control:focus {
        color: var(--bs-body-color);
        background-color: #f5eeeb;
        border-color: #f78660;
        outline: 0;
        box-shadow: 0 0 5px 0.5px #f78660;
        }
    
        .form-check-input:focus {
        box-shadow: 0 0 5px 0.5px #f78660;
        }
    </style>
@endsection
