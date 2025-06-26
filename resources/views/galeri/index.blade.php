@extends('layout.master')

@section('title', 'Galeri')
<style>/* Gaya pagination */
    .pagination {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        margin-top: 20px;
        gap: 8px;
    }

    .pagination .page-item .page-link {
        color: #007bff;
        border: 1px solid #dee2e6;
        padding: 6px 12px;
        border-radius: 4px;
        transition: all 0.2s ease;
    }

    .pagination .page-item.active .page-link {
        background-color: #007bff;
        color: #fff;
        border-color: #007bff;
    }

    .pagination .page-item.disabled .page-link {
        color: #6c757d;
        pointer-events: none;
        background-color: #f8f9fa;
    }
    </style>
@section('content')
    <!-- Container for Gallery -->
    <div class="container mt-5">
        <h2 class="text-center mb-4">Galeri</h2>

        <!-- Button Tambah Galeri -->
        <div class="text-center mb-4">
            <a href="{{ route('galeris.create') }}" class="btn btn-success">+ Tambah Galeri</a>
        </div>

        <!-- Gallery Grid -->
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
            @foreach ($galeris as $galeri)
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <!-- Media Section -->
                        @if ($galeri->foto && file_exists(public_path('storage/' . $galeri->foto)))
                            <img src="{{ asset('storage/' . $galeri->foto) }}" class="card-img-top img-fluid"
                                 style="height: 150px; object-fit: cover;" alt="{{ $galeri->judul }}">
                        @elseif ($galeri->videoyoutube)
                            @php
                                // Ekstrak ID video YouTube menggunakan regex
                                $youtubeId = null;
                                if (
                                    preg_match(
                                        '/(?:https?:\/\/(?:www\.)?youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/',
                                        $galeri->videoyoutube,
                                        $matches
                                    )
                                ) {
                                    $youtubeId = $matches[1];
                                }
                            @endphp

                            @if ($youtubeId)
                                <!-- Embed YouTube Video with iframe (without thumbnail) -->
                                <div class="ratio ratio-16x9">
                                    <iframe src="https://www.youtube.com/embed/{{ $youtubeId }}"
                                            title="YouTube video" frameborder="0" allowfullscreen
                                            class="w-100 h-100">
                                    </iframe>
                                </div>
                            @else
                                <div class="bg-secondary text-white text-center d-flex align-items-center justify-content-center"
                                     style="height: 150px;">
                                    Video YouTube Tidak Valid
                                </div>
                            @endif
                        @elseif ($galeri->videolokal && file_exists(public_path('storage/' . $galeri->videolokal)))
                            <!-- Local Video -->
                            <video class="card-img-top" style="height: 150px; object-fit: cover;" controls>
                                <source src="{{ asset('storage/' . $galeri->videolokal) }}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        @else
                            <div class="bg-secondary text-white text-center d-flex align-items-center justify-content-center"
                                 style="height: 150px;">
                                No Media
                            </div>
                        @endif

                        <!-- Card Body -->
                        <div class="card-body">
                            <h5 class="card-title text-truncate">{{ $galeri->judul }}</h5>
                            <p class="card-text">{{ Str::limit($galeri->deskripsi, 80) }}</p>
                        </div>

                        <!-- Card Footer -->
                        <div class="card-footer d-flex justify-content-between">
                            <form id="delete-form-{{ $galeri->id }}" action="{{ route('galeris.destroy', $galeri->id) }}" method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                            <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $galeri->id }})">Hapus</button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination Links -->
      <!-- Pagination -->
<div class="d-flex justify-content-center mt-4">
    {!! $galeris->links('pagination::bootstrap-4') !!}
</div>


    </div>

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: "Yakin ingin menghapus?",
                text: "Data galeri ini akan dihapus secara permanen!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Ya, hapus!",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }
    </script>
@endsection

