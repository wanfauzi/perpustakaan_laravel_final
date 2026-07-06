<div class="card border-0 border-top border-primary border-4 shadow-sm h-100">

    <div class="card-body p-4 d-flex flex-column">

        {{-- Baris Kategori, Status, dan Checkbox --}}
        <div class="d-flex justify-content-between align-items-start gap-3 mb-3">

            <div class="d-flex flex-wrap gap-2">

                <span class="badge bg-light text-dark border">
                    <i class="bi bi-tag me-1 text-primary"></i>
                    {{ $buku->kategori }}
                </span>

                @if($buku->stok > 5)
                    <span class="badge text-bg-success">
                        Tersedia
                    </span>
                @elseif($buku->stok > 0)
                    <span class="badge text-bg-warning">
                        Menipis
                    </span>
                @else
                    <span class="badge text-bg-danger">
                        Habis
                    </span>
                @endif

            </div>

            @if($selectable)
                <div class="form-check flex-shrink-0">
                    <input
                        class="form-check-input"
                        type="checkbox"
                        name="buku_ids[]"
                        value="{{ $buku->id }}"
                        id="buku-{{ $buku->id }}">

                    <label
                        class="visually-hidden"
                        for="buku-{{ $buku->id }}">
                        Pilih {{ $buku->judul }}
                    </label>
                </div>
            @endif

        </div>

        {{-- Judul --}}
        <h5 class="fw-bold text-dark mb-2">
            {{ $buku->judul }}
        </h5>

        {{-- Pengarang --}}
        <p class="text-secondary mb-4">
            <i class="bi bi-person me-1"></i>
            {{ $buku->pengarang }}
        </p>

        {{-- Informasi --}}
        <div class="row g-3 mb-4">

            <div class="col-6">
                <div class="d-flex align-items-center gap-2">

                    <div class="bg-primary bg-opacity-10 text-primary rounded p-2">
                        <i class="bi bi-upc-scan"></i>
                    </div>

                    <div>
                        <div class="text-secondary small">
                            Kode
                        </div>

                        <div class="fw-semibold small">
                            {{ $buku->kode_buku }}
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-6">
                <div class="d-flex align-items-center gap-2">

                    <div class="bg-info bg-opacity-10 text-info rounded p-2">
                        <i class="bi bi-calendar3"></i>
                    </div>

                    <div>
                        <div class="text-secondary small">
                            Tahun
                        </div>

                        <div class="fw-semibold small">
                            {{ $buku->tahun_terbit }}
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-6">
                <div class="d-flex align-items-center gap-2">

                    <div class="bg-warning bg-opacity-10 text-warning rounded p-2">
                        <i class="bi bi-building"></i>
                    </div>

                    <div class="overflow-hidden">
                        <div class="text-secondary small">
                            Penerbit
                        </div>

                        <div class="fw-semibold small text-truncate"
                             title="{{ $buku->penerbit }}">
                            {{ $buku->penerbit }}
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-6">
                <div class="d-flex align-items-center gap-2">

                    <div class="bg-success bg-opacity-10 text-success rounded p-2">
                        <i class="bi bi-box-seam"></i>
                    </div>

                    <div>
                        <div class="text-secondary small">
                            Stok
                        </div>

                        <div class="fw-semibold small">
                            {{ $buku->stok }} buku
                        </div>
                    </div>

                </div>
            </div>

        </div>

        {{-- Harga --}}
        <div class="mt-auto pt-3 border-top">
            <div class="text-secondary small">
                Harga
            </div>

            <div class="fs-5 fw-bold text-primary">
                {{ $buku->harga_format }}
            </div>
        </div>

    </div>

    @if($showActions)
        <div class="card-footer bg-white border-top p-3">
            <div class="d-flex gap-2">

                <a href="{{ route('buku.show', $buku->id) }}"
                   class="btn btn-primary btn-sm flex-grow-1">
                    <i class="bi bi-eye me-1"></i>
                    Detail
                </a>

                <a href="{{ route('buku.edit', $buku->id) }}"
                   class="btn btn-outline-warning btn-sm flex-grow-1">
                    <i class="bi bi-pencil me-1"></i>
                    Edit
                </a>

            </div>
        </div>
    @endif

</div>