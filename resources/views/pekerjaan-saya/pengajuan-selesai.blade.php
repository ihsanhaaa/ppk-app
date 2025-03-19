@extends('layouts.app')

@section('title')
    Data Pengajuan Poin Mahasiswa Selesai
@endsection

@section('content')
    @push('css-plugins')
    @endpush

    <!-- Begin page -->
    <div id="layout-wrapper">

        <!-- header -->
        @include('components.navbar')

        <!-- Start right Content here -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                @role('Akademik')
                                    <h4 class="mb-sm-0">Pengajuan Poin Mahasiswa Sudah ACC ({{ $mahasiswas->count() }})</h4>
                                @endrole

                                @role('Mahasiswa')
                                    <h4 class="mb-sm-0">Data Pengajuan Poin Saya</h4>
                                @endrole

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                                        <li class="breadcrumb-item active"><a href="javascript: void(0);">Data Pengajuan
                                                Poin Mahasiswa</a></li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    @if (count($errors) > 0)
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            @foreach ($errors->all() as $error)
                                <strong>{{ $error }}</strong><br>
                            @endforeach
                        </div>
                    @endif

                    @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            <strong>Success!</strong> {{ $message }}.
                        </div>
                    @endif

                    @if ($message = Session::get('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            <strong>Error!</strong> {{ $message }}.
                        </div>
                    @endif

                    {{-- <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                            aria-label="Close"></button>
                        <strong>Informasi!</strong> Diperlukan 6 Orang Mahasiswa Untuk Melakukan Input Data Lab di Hari Senin tanggal 16 Desember 2024, silahkan konfirmasi ke UPT PUSKOM
                    </div> --}}

                    <div class="row">
                        <div class="col-lg-12">

                            {{-- @role('Mahasiswa')
                                @if (Auth::user()->mahasiswa_id)
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-success btn-sm mb-3 mx-1" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal">
                                        <i class="fas fa-plus"></i> Tambah Pengajuan Poin
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                                        aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Tambah Data Pengajuan Poin
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">

                                                    <form action="{{ route('pengajuan-poin.store') }}" method="POST"
                                                        enctype="multipart/form-data">
                                                        @csrf

                                                        <div class="mb-3">
                                                            <label for="nama_poin" class="form-label">Kegiatan Yang Pernah
                                                                Diikuti <span style="color: red">*</span> </label>
                                                            <select
                                                                class="form-control @error('nama_poin') is-invalid @enderror"
                                                                id="nama_poin" name="nama_poin" required>
                                                                <option value="">-- Pilih Kegiatan --</option>
                                                                @foreach ($poins as $poin)
                                                                    <option value="{{ $poin->id }}">{{ $poin->nama_poin }}
                                                                        ({{ $poin->nilai }} Poin)</option>
                                                                @endforeach
                                                                <option value="lainnya">Lainnya</option>
                                                            </select>

                                                            @error('nama_poin')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>

                                                        <div class="mb-3" id="form-kegiatan-lainnya" style="display: none;">
                                                            <label for="kegiatan_lainnya" class="form-label">Kegiatan Lainnya
                                                                <span style="color: red">*</span></label>
                                                            <input type="text"
                                                                class="form-control @error('kegiatan_lainnya') is-invalid @enderror"
                                                                id="kegiatan_lainnya" name="kegiatan_lainnya"
                                                                value="{{ old('kegiatan_lainnya') }}">
                                                            @error('kegiatan_lainnya')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="berkas_path" class="form-label">
                                                                Foto Sertifikat/Kegiatan <span style="color: red">*</span>
                                                                (image, pdf) File Maks: 2MB
                                                            </label>
                                                            <input type="file"
                                                                class="form-control @error('berkas_path') is-invalid @enderror"
                                                                id="berkas_path" name="berkas_path[]" multiple required>
                                                            @error('berkas_path')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>

                                                        <p>Keterangan: <span style="color: red">*</span>) wajib diisi</p>

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                                        </div>

                                                    </form>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endrole --}}

                            <div class="card">
                                <div class="card-body">

                                    @role('Akademik')
                                        <ul class="nav nav-tabs nav-tabs-custom nav-justified">
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{ route('pengajuan-poin.index') }}">
                                                    <span class="d-block d-sm-none"><i class="fas fa-tint"></i></span>
                                                    <span class="d-none d-sm-block">Pengajuan Baru</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link active" href="{{ route('pengajuan-selesai.index') }}">
                                                    <span class="d-block d-sm-none"><i class="fas fa-window-maximize"></i></span>
                                                    <span class="d-none d-sm-block">Pengajuan Selesai</span>
                                                </a>
                                            </li>
                                        </ul>

                                        <!-- Tab panes -->
                                        <div class="tab-content p-3 text-muted">
                                            <table id="datatable2" class="table table-bordered dt-responsive nowrap"
                                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Nama Mahasiswa</th>
                                                            <th>Nama Kegiatan/Poin</th>
                                                            <th>Berkas</th>
                                                            <th>Status</th>
                                                            <th>Tanggal Pengajuan</th>
                                                            <th>Aksi</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        @foreach ($mahasiswas as $key => $mahasiswa)
                                                            <tr>
                                                                <th scope="row">{{ ++$key }}</th>
                                                                <td>{{ $mahasiswa->mahasiswa->nama_mahasiswa }}
                                                                    ({{ $mahasiswa->mahasiswa->nim }})</td>
                                                                <td
                                                                    style="white-space: normal; word-wrap: break-word; max-width: 200px;">
                                                                    {{ $mahasiswa->poin->nama_poin ?? $mahasiswa->keterangan }}
                                                                    ({{ $mahasiswa->points }})

                                                                    <!-- Tombol Edit -->
                                                                    <button class="badge bg-primary btn-sm" style="border: none;" data-bs-toggle="modal" data-bs-target="#editModal{{ $mahasiswa->id }}">
                                                                        Edit
                                                                    </button>

                                                                    <!-- Modal Edit -->
                                                                    <div class="modal fade" id="editModal{{ $mahasiswa->id }}" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                                                                        <div class="modal-dialog">
                                                                            <div class="modal-content">
                                                                                <form action="{{ route('update.points', $mahasiswa->id) }}" method="POST">
                                                                                    @csrf
                                                                                    <div class="modal-header">
                                                                                        <h5 class="modal-title" id="editModalLabel">Edit Nilai Mahasiswa</h5>
                                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                    </div>
                                                                                    <div class="modal-body">
                                                                                        <div class="mb-3">
                                                                                            <label for="points" class="form-label">Nilai</label>
                                                                                            <input type="number" class="form-control" id="points" name="points" value="{{ $mahasiswa->points }}" required>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="modal-footer">
                                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                                                        <button type="submit" class="btn btn-success">Simpan</button>
                                                                                    </div>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </td>

                                                                <td>
                                                                    @if ($mahasiswa->fotoPengajuans->isNotEmpty())
                                                                        @foreach ($mahasiswa->fotoPengajuans as $fotoPengajuan)
                                                                            <a href="{{ asset($fotoPengajuan->berkas_path) }}"
                                                                                class="btn btn-info btn-sm"
                                                                                title="Lihat Berkas" target="_blank">
                                                                                <i class="fas fa-file-image"></i>
                                                                            </a>
                                                                        @endforeach
                                                                    @else
                                                                        -
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    <span
                                                                        class="badge {{ $mahasiswa->status == 'Approved' ? 'bg-success' : ($mahasiswa->status == 'Rejected' ? 'bg-danger' : 'bg-warning') }}"
                                                                        title="{{ $mahasiswa->keterangan_ditolak }}"
                                                                        style="cursor: pointer">
                                                                        {{ $mahasiswa->status }}
                                                                    </span>
                                                                </td>
                                                                <td>
                                                                    @if ($mahasiswa->created_at->diffInDays() > 14)
                                                                        {{ $mahasiswa->created_at->format('d-m-Y') }}
                                                                    @else
                                                                        <span
                                                                            title="{{ $mahasiswa->created_at->format('d-m-Y') }}"
                                                                            style="cursor: pointer">{{ $mahasiswa->created_at->diffForHumans() }}</span>
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if ($mahasiswa->status == 'Pending')
                                                                        @if (!$mahasiswa->poin)
                                                                            <!-- Tombol untuk menyetujui dengan form -->
                                                                            <button class="btn btn-success btn-sm"
                                                                                onclick="openPoinForm({{ $mahasiswa->id }}, '{{ $mahasiswa->keterangan }}')"><i
                                                                                    class="fas fa-check-circle"></i> Setujui
                                                                                dengan Poin</button>
                                                                        @else
                                                                            <button class="btn btn-success btn-sm"
                                                                                onclick="confirmAction('{{ route('pengajuan.approve', $mahasiswa->id) }}', 'Terima')"><i
                                                                                    class="fas fa-check-circle"></i>
                                                                                Terima</button>
                                                                        @endif
                                                                        <button class="btn btn-danger btn-sm"
                                                                            onclick="confirmAction('{{ route('pengajuan.reject', $mahasiswa->id) }}', 'Tolak')"><i
                                                                                class="fas fa-times"></i> Tolak</button>
                                                                    @else
                                                                        <span>-</span>
                                                                    @endif

                                                                    <button class="btn btn-danger btn-sm"
                                                                        onclick="confirmDelete('{{ route('pengajuan.delete', $mahasiswa->id) }}')">
                                                                        <i class="fas fa-trash"></i> Hapus
                                                                    </button>

                                                                    <!-- Tombol download berkas -->
                                                                    {{-- @if ($mahasiswa->status == 'Approved')
                                                                                <a href="{{ route('downloadAdminPDF', $mahasiswa->id) }}" class="btn btn-primary btn-sm">Download Berkas</a>
                                                                            @endif --}}

                                                                </td>
                                                            </tr>
                                                        @endforeach

                                                        <div class="modal fade" id="poinFormModal" tabindex="-1"
                                                            aria-labelledby="poinFormLabel" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <form action="{{ route('pengajuan.setPoin') }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        <input type="hidden" name="mahasiswa_id"
                                                                            id="modalMahasiswaId">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="poinFormLabel">Setujui
                                                                                dengan Poin</h5>
                                                                            <button type="button" class="btn-close"
                                                                                data-bs-dismiss="modal"
                                                                                aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <div class="mb-3">
                                                                                <label for="keterangan"
                                                                                    class="form-label">Kegiatan</label>
                                                                                <textarea class="form-control" id="modalKeterangan" name="keterangan" readonly></textarea>
                                                                            </div>
                                                                            <div class="mb-3">
                                                                                <label for="nilai" class="form-label">Nilai
                                                                                    Poin</label>
                                                                                <input type="number" class="form-control"
                                                                                    id="modalNilai" name="nilai" required>
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary"
                                                                                data-bs-dismiss="modal">Batal</button>
                                                                            <button type="submit"
                                                                                class="btn btn-primary">Simpan</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </tbody>
                                                </table>
                                        </div>
                                    @endrole

                                    @role('Mahasiswa')
                                        <div class="alert alert-primary" role="alert">
                                            Pengajuan Poin Sudah Ditutup Sementara
                                        </div>

                                        <div style="position: relative; padding-top: 56.25%; /* 16:9 Aspect Ratio */">
                                            <iframe src="{{ asset('Himbauan Sistem Poin Mahasiswa Periode TA 20252025.pdf') }}" 
                                                    style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: none;">
                                            </iframe>
                                        </div>
                                        

                                        {{-- @if (Auth::user()->mahasiswa_id)
                                            <table id="datatable" class="table table-bordered dt-responsive nowrap"
                                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Keterangan</th>
                                                        <th>Berkas</th>
                                                        <th>Status</th>
                                                        <th>Tanggal Pengajuan</th>
                                                        <th>Keterangan</th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    @foreach ($pengajuanSaya as $key => $mahasiswa)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td
                                                                style="white-space: normal; word-wrap: break-word; max-width: 200px;">
                                                                {{ $mahasiswa->poin->nama_poin ?? $mahasiswa->keterangan }}
                                                                ({{ $mahasiswa->poin->nilai ?? $mahasiswa->points }} Poin)
                                                            </td>
                                                            <td>
                                                                @if ($mahasiswa->fotoPengajuans->isNotEmpty())
                                                                    @foreach ($mahasiswa->fotoPengajuans as $fotoPengajuan)
                                                                        <a href="{{ asset($fotoPengajuan->berkas_path) }}"
                                                                            class="btn btn-info btn-sm" title="Lihat Berkas"
                                                                            target="_blank">
                                                                            <i class="fas fa-file-image"></i>
                                                                        </a>
                                                                    @endforeach
                                                                @else
                                                                    -
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <span
                                                                    class="badge {{ $mahasiswa->status == 'Approved' ? 'bg-success' : ($mahasiswa->status == 'Rejected' ? 'bg-danger' : 'bg-warning') }}">
                                                                    {{ $mahasiswa->status }}
                                                                </span>
                                                            </td>
                                                            <td>
                                                                @if ($mahasiswa->created_at->diffInDays() > 14)
                                                                    {{ $mahasiswa->created_at->format('d-m-Y') }}
                                                                @else
                                                                    <span
                                                                        title="{{ $mahasiswa->created_at->format('d-m-Y') }}"
                                                                        style="cursor: pointer">{{ $mahasiswa->created_at->diffForHumans() }}</span>
                                                                @endif
                                                            </td>

                                                            <td>{{ $mahasiswa->keterangan_ditolak }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        @else
                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                    aria-label="Close"></button>
                                                <strong>Alert!</strong> Akun anda belum terverifikasi, silahkan lakukan
                                                verifikasi terlebih dahulu pada halaman <a
                                                    href="{{ route('home') }}">Dashboard</a> .
                                            </div>
                                        @endif --}}
                                    @endrole

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->

                </div>

            </div>
            <!-- End Page-content -->

            <!-- footer -->
            @include('components.footer')

        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    @push('javascript-plugins')
        <script>
            function openPoinForm(mahasiswaId, keterangan) {
                document.getElementById('modalMahasiswaId').value = mahasiswaId;
                document.getElementById('modalKeterangan').value = keterangan;
                document.getElementById('modalNilai').value = ''; // Reset nilai poin
                new bootstrap.Modal(document.getElementById('poinFormModal')).show();
            }
        </script>

        {{-- <script>
            function confirmAction(url, action) {
                const actionText = action === 'Terima' ? 'menyetujui' : 'menolak';
                const buttonColor = action === 'Terima' ? '#28a745' : '#dc3545';
        
                Swal.fire({
                    title: `Apakah Anda yakin ingin ${actionText} pengajuan ini?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: buttonColor,
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, ' + action,
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Redirect ke URL aksi
                        window.location.href = url;
                    }
                });
            }
        </script> --}}

        <script>
            function confirmAction(url, action) {
                if (action === 'Tolak') {
                    Swal.fire({
                        title: 'Masukkan alasan penolakan:',
                        html: `
                            <textarea id="keterangan_ditolak" class="form-control" rows="3" placeholder="Alasan penolakan"></textarea>
                        `,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc3545',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Kirim',
                        cancelButtonText: 'Batal',
                        preConfirm: () => {
                            const alasan = document.getElementById('keterangan_ditolak').value.trim();
                            if (!alasan) {
                                Swal.showValidationMessage('Alasan penolakan tidak boleh kosong');
                            }
                            return alasan;
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const alasan = result.value;

                            // Kirim form menggunakan POST
                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.action = url;

                            const csrfInput = document.createElement('input');
                            csrfInput.type = 'hidden';
                            csrfInput.name = '_token';
                            csrfInput.value = '{{ csrf_token() }}';
                            form.appendChild(csrfInput);

                            const alasanInput = document.createElement('input');
                            alasanInput.type = 'hidden';
                            alasanInput.name = 'keterangan_ditolak';
                            alasanInput.value = alasan;
                            form.appendChild(alasanInput);

                            document.body.appendChild(form);
                            form.submit();
                        }
                    });
                } else {
                    // Logika untuk aksi "Terima"
                    Swal.fire({
                        title: 'Apakah Anda yakin ingin menyetujui pengajuan ini?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#28a745',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Ya, Terima',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = url;
                        }
                    });
                }
            }
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const selectPoin = document.getElementById('nama_poin');
                const formKegiatanLainnya = document.getElementById('form-kegiatan-lainnya');

                selectPoin.addEventListener('change', function() {
                    if (selectPoin.value === 'lainnya') {
                        formKegiatanLainnya.style.display = 'block';
                    } else {
                        formKegiatanLainnya.style.display = 'none';
                        // Optional: Clear input value when hidden
                        formKegiatanLainnya.querySelector('input').value = '';
                    }
                });
            });
        </script>

        <script>
            function confirmDelete(url) {
                if (confirm('Apakah Anda yakin ingin menghapus pengajuan ini?')) {
                    // Mengirim permintaan DELETE menggunakan AJAX atau form
                    var form = document.createElement('form');
                    form.method = 'POST';
                    form.action = url;

                    var csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = '{{ csrf_token() }}';
                    form.appendChild(csrfToken);

                    var methodField = document.createElement('input');
                    methodField.type = 'hidden';
                    methodField.name = '_method';
                    methodField.value = 'DELETE';
                    form.appendChild(methodField);

                    document.body.appendChild(form);
                    form.submit();
                }
            }
        </script>
    @endpush
@endsection
