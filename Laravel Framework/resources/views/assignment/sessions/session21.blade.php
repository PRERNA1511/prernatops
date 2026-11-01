@extends('layouts.assignment')

@section('title', 'Session 21: jQuery AJAX Frontend & Live Search')

@section('content')
<div class="mb-4">
    <a href="{{ route('assignment.home') }}" class="btn btn-outline-secondary btn-sm mb-3">
        <i class="bi bi-arrow-left"></i> Back to Dashboard
    </a>
    <h2><span class="badge bg-secondary me-2">Session 21</span> jQuery AJAX Dynamic Song Search</h2>
    <p class="text-muted">Real-time song search using jQuery <code>$.ajax()</code>, JSON responses, loading spinner indicators, and empty state alerts.</p>
</div>

<div class="row g-4">
    <div class="col-md-5">
        <div class="card">
            <div class="card-header bg-white fw-bold">
                <i class="bi bi-search text-primary me-2"></i> Live Song Search Input
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label fw-bold">Search by Title, Artist, or Album:</label>
                    <div class="input-group">
                        <input type="text" id="searchInput" class="form-control" placeholder="Type song name (e.g. Blinding, Queen)..." autocomplete="off">
                        <button class="btn btn-primary" type="button" id="searchBtn">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                    <div class="form-text">AJAX request dispatches automatically on typing (keyup) or button click.</div>
                </div>

                <div class="p-2 border rounded bg-light small">
                    <strong>Total Available Songs in DB:</strong> {{ $allSongsCount }}<br>
                    <strong>API Endpoint:</strong> <code>GET /session-21/search?q={query}</code><br>
                    <strong>Data Format:</strong> JSON
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-7">
        <div class="card h-100">
            <div class="card-header bg-white fw-bold d-flex justify-content-between align-items-center">
                <span><i class="bi bi-music-player text-success me-2"></i> Search Results</span>
                <span id="resultsCountBadge" class="badge bg-secondary">0 results</span>
            </div>
            <div class="card-body">
                <!-- Loading Spinner -->
                <div id="loadingIndicator" class="text-center py-4" style="display: none;">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading songs...</span>
                    </div>
                    <div class="small text-muted mt-2">Fetching matching songs from server via AJAX...</div>
                </div>

                <!-- Empty State Alert -->
                <div id="noResultsAlert" class="alert alert-warning text-center" style="display: none;">
                    <i class="bi bi-exclamation-triangle-fill fs-4 d-block mb-1"></i>
                    <strong>No songs found!</strong> Try searching with different keywords.
                </div>

                <!-- Results List -->
                <div id="songResultsList" class="list-group"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    let debounceTimer;

    function fetchSongs(query) {
        $('#loadingIndicator').show();
        $('#noResultsAlert').hide();
        $('#songResultsList').empty();

        $.ajax({
            url: "{{ route('session.21.search') }}",
            type: "GET",
            data: { q: query },
            dataType: "json",
            success: function(response) {
                $('#loadingIndicator').hide();
                $('#resultsCountBadge').text(response.count + ' result(s)');

                if (response.count === 0) {
                    $('#noResultsAlert').show();
                } else {
                    $.each(response.data, function(index, song) {
                        let html = `
                            <div class="list-group-item d-flex justify-content-between align-items-center py-2">
                                <div>
                                    <div class="fw-bold">${song.title}</div>
                                    <div class="small text-muted">Artist: ${song.artist} | Album: ${song.album}</div>
                                </div>
                                <span class="badge bg-dark">${song.duration}</span>
                            </div>
                        `;
                        $('#songResultsList').append(html);
                    });
                }
            },
            error: function(xhr, status, error) {
                $('#loadingIndicator').hide();
                alert('AJAX search error: ' + error);
            }
        });
    }

    // Initial load
    fetchSongs('');

    // Trigger on typing with 300ms debounce
    $('#searchInput').on('keyup', function() {
        clearTimeout(debounceTimer);
        let query = $(this).val();
        debounceTimer = setTimeout(function() {
            fetchSongs(query);
        }, 300);
    });

    $('#searchBtn').on('click', function() {
        fetchSongs($('#searchInput').val());
    });
});
</script>
@endpush
