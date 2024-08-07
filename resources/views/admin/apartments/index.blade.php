@extends('layouts.admin')

@section('content')
    <div class="container mb-4">
        @if (session('message'))
            <div id="success-alert" class="alert alert-success mt-2 bg-white text-orange">
                {{ session('message') }}
            </div>
        @endif

        @if (session('success'))
            <div id="success-alert-2" class="alert alert-success mt-2 mt-2 bg-white text-orange">
                {{ session('success') }}
            </div>
        @endif

        <div class="ms-table-container mt-5">
            <div class="d-flex justify-content-between align-items-center flex-column flex-md-row">
                <h1 class="fw-bold text-white mb-3 mb-md-0">Appartamenti</h1>
                <div class="d-flex flex-column align-items-center">
                    <a href="{{ route('admin.apartments.create') }}" class="btn btn-orange fw-bold mb-2 mb-md-0">Aggiungi</a>
                    <span class="fw-bold text-white">Attuali: {{ count($apartments) }}</span>
                </div>
            </div>

            <div class="bg-white p-4 rounded-3 mt-2" id="apartment_list_index">
                <div class="table-responsive">
                    <table class="table">
                        <thead class="fw-bold">
                            <tr>
                                <th style="vertical-align: middle" class="ps-3 rounded-start-3">Titolo</th>
                                <th style="vertical-align: middle" class="text-center d-none d-lg-table-cell">stanze</th>
                                <th style="vertical-align: middle" class="text-center d-none d-lg-table-cell">letti</th>
                                <th style="vertical-align: middle" class="text-center d-none d-lg-table-cell">bagni</th>
                                <th style="vertical-align: middle" class="text-center d-none d-lg-table-cell">mq</th>
                                <th style="vertical-align: middle" class="text-center d-none d-lg-table-cell">disponibilità</th>
                                <th style="vertical-align: middle" class="ps-3 rounded-end-3 text-center">azioni</th>
                            </tr>
                        </thead>
                        <tbody class="scroll-box">
                            @foreach ($apartments as $curApartment)
                                <tr>
                                    <td style="vertical-align: middle" class="pl-3">
                                        <div class="d-flex align-items-center">
                                            <a class="d-none d-md-table-cell" href="{{ route('admin.apartments.show', ['apartment' => $curApartment->slug]) }}">
                                                @if ($curApartment->img_path)
                                                    <img style="min-width: 80px" class="img-fluid"
                                                        src="{{ asset('storage/' . $curApartment->img_path) }}"
                                                        alt="{{ $curApartment->title }}">
                                                @else
                                                    <img style="min-width: 80px" class="img-fluid"
                                                        src="https://salonlfc.com/wp-content/uploads/2018/01/image-not-found-1-scaled.png"
                                                        alt="{{ $curApartment->title }}">
                                                @endif
                                            </a>
                                            <div class="ps-4">
                                                <p class="fw-medium m-0">
                                                    <a class=""
                                                        href="{{ route('admin.apartments.show', ['apartment' => $curApartment->slug]) }}">{{ $curApartment->title }}</a>
                                                </p>
                                                <p class="muted m-0">{{ $curApartment->address }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="vertical-align: middle" class="text-center d-none d-lg-table-cell" style="vertical-align: middle;">{{ $curApartment->rooms }}</td>
                                    <td style="vertical-align: middle" class="text-center d-none d-lg-table-cell" style="vertical-align: middle;">{{ $curApartment->beds }}</td>
                                    <td style="vertical-align: middle" class="text-center d-none d-lg-table-cell" style="vertical-align: middle;">{{ $curApartment->bathroom }}</td>
                                    <td style="vertical-align: middle" class="text-center d-none d-lg-table-cell" style="vertical-align: middle;">{{ $curApartment->square_mt }}</td>
                                    <td style="vertical-align: middle" class="text-center d-none d-lg-table-cell" style="vertical-align: middle;">
                                        {!! $curApartment->available
                                            ? '<i class="fa-solid fa-circle-check fs-2 fw-bold" style="color: #00c524;"></i>'
                                            : '<i class="fa-solid fa-circle-xmark fs-2 fw-bold" style="color: #ff0000;"></i>' !!}
                                    </td>
                                    <td style="vertical-align: middle" class="text-center" style="vertical-align: middle;">
                                        <a href="{{ route('admin.apartments.show', ['apartment' => $curApartment->slug]) }}" class="btn btn-sm btn-show rounded-circle me-1">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.apartments.edit', ['apartment' => $curApartment->slug]) }}" class="btn btn-sm btn-edit rounded-circle me-1">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-delete rounded-circle" data-bs-toggle="modal"
                                                data-bs-target="#confirmModal"
                                                data-action="{{ route('admin.apartments.destroy', ['apartment' => $curApartment->slug]) }}">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirm Deletion Modal -->
    <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmModalLabel">Conferma Eliminazione</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Sei sicuro di voler eliminare questo appartamento?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                    <form id="deleteForm" method="POST" action="">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Elimina</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let successAlert = document.getElementById('success-alert');
            if (successAlert) {
                setTimeout(function() {
                    successAlert.style.opacity = 0;
                    setTimeout(function() {
                        successAlert.style.display = 'none';
                    }, 600); // Extra timeout to allow fade-out effect
                }, 4000); // Adjust the time as needed
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            let successAlert = document.getElementById('success-alert-2');
            if (successAlert) {
                setTimeout(function() {
                    successAlert.style.opacity = 0;
                    setTimeout(function() {
                        successAlert.style.display = 'none';
                    }, 600); // Extra timeout to allow fade-out effect
                }, 4000); // Adjust the time as needed
            }
        });
    </script>
@endsection