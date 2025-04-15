@extends('layouts.app')

@section('title')
    Pekerjaan Saya
@endsection

@section('content')
    @push('css-plugins')
    <!-- plugin css -->
    <link href="{{ asset('assets/admin/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css') }}" rel="stylesheet" type="text/css" />

    <!-- preloader css -->
    <link rel="stylesheet" href="{{ asset('assets/admin/css/preloader.min.css') }}" type="text/css" />

    <!-- Bootstrap Css -->
    <link href="{{ asset('assets/admin/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('assets/admin/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('assets/admin/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10">

        <!-- DataTables -->
        <link href="{{ asset('assets/admin/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
            type="text/css" />
        <link href="{{ asset('assets/admin/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet"
            type="text/css" />

        <!-- Responsive datatable examples -->
        <link href="{{ asset('assets/admin/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}"
            rel="stylesheet" type="text/css" />

        <style>
            .list-pekerjaan {
                cursor: grab;
            }

            .list-pekerjaan:active {
                cursor: grabbing;
            }
        </style>
    @endpush

    <!-- Begin page -->
    <div id="layout-wrapper">

        <!-- sidebar left -->
        @include('components.navbar')

        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0 font-size-18">Pekerjaan Saya ({{ $pekerjaanSayas->count() }})</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                                        <li class="breadcrumb-item active">Pekerjaan Saya</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-border-left alert-dismissible fade show" role="alert">
                            <i class="mdi mdi-check-all me-3 align-middle"></i><strong>Success</strong> -
                            {{ $message }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @elseif ($message = Session::get('alert'))
                        <div class="alert alert-danger alert-border-left alert-dismissible fade show" role="alert">
                            <i class="mdi mdi-block-helper me-3 align-middle"></i><strong>Danger</strong> -
                            {{ $message }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                </div>

                @if (Auth::user()->pegawai_id)
                    <div class="mb-3">
                        <select class="form-select form-select-sm w-auto" id="filterSemester">
                            @foreach ($semesters as $semester)
                                <option value="{{ $semester->id }}" {{ $semester->id == $selectedSemester ? 'selected' : '' }}>
                                    {{ $semester->tahun_ajaran }} {{ $semester->semester }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#firstmodal"><i
                            class="bx bx-plus me-1"></i> Tambah Pekerjaan</button>

                    <!-- First modal dialog -->
                    <div class="modal fade" id="firstmodal" aria-hidden="true" aria-labelledby="exampleModalToggleLabel"
                        tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalToggleLabel">Tambah Pekerjaan</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form method="POST" action="/pekerjaan-saya">
                                    <div class="modal-body">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="deadline">Nama Pekerjaan <span style="color: red;">*</span> </label>
                                            <input type="text" name="nama_tugas" class="form-control" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="deadline">Deadline Pekerjaan <span style="color: red;">*</span></label>
                                            <input type="date" name="deadline" placeholder="Deadline" class="form-control"
                                                required min="{{ date('Y-m-d') }}">
                                        </div>

                                        <div class="mb-3">
                                            <label for="keterangan">Deskripsi Pekerjaan (opsional)</label>
                                            <textarea name="keterangan" class="form-control" rows="4"></textarea>
                                        </div>

                                        <div class="modal-footer">
                                            <!-- Toogle to second dialog -->
                                            <button type="submit" class="btn btn-success">Simpan</button>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>

                    <!-- Kanban Board -->
                    <div class="row my-4">
                        @foreach (['todo' => 'Daftar Pekerjaan', 'in-progress' => 'Dalam Progres', 'done' => 'Selesai'] as $progres => $label)
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header text-center bg-primary text-white">
                                        <h5 class="mb-0">{{ $label }}</h5>
                                    </div>
                                    <div class="card-body kanban-column" id="{{ $progres }}">
                                        @foreach ($pekerjaanSayas->where('progres', $progres) as $pekerjaanSaya)
                                            <div class="list-pekerjaan mb-2 p-2 border-left border-primary"
                                                data-id="{{ $pekerjaanSaya->id }}"
                                                data-has-bukti="{{ $pekerjaanSaya->buktiTugas->isNotEmpty() ? 'true' : 'false' }}">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <span style="font-size: 16px" class="fw-bold mb-2">{{ $pekerjaanSaya->nama_tugas }}
                                                        @role('Ketua')({{ $pekerjaanSaya->points }})@endrole</span>
                                                    <div class="d-flex">
                                                        @role('Ketua')
                                                        @if ($pekerjaanSaya->progres === 'done')
                                                            <button class="btn btn-success btn-sm p-1 me-1 btn-input-points"
                                                                title="Beri Poin" data-id="{{ $pekerjaanSaya->id }}"
                                                                data-nama_tugas="{{ $pekerjaanSaya->nama_tugas }}"
                                                                data-keterangan_tugas="{{ $pekerjaanSaya->keterangan }}">
                                                                <i class="fas fa-spell-check"></i>
                                                            </button>
                                                        @endif
                                                        @endrole

                                                        <button class="btn btn-warning btn-sm p-1 me-1" onclick="editTask(
                                                                                                                        {{ $pekerjaanSaya->id }}, 
                                                                                                                        '{{ $pekerjaanSaya->nama_tugas }}', 
                                                                                                                        '{{ $pekerjaanSaya->prioritas }}', 
                                                                                                                        '{{ $pekerjaanSaya->deadline ? \Carbon\Carbon::parse($pekerjaanSaya->deadline)->format('Y-m-d') : '' }}'
                                                                                                                    )"
                                                            title="Edit Pekerjaan"> <i class="fas fa-edit"></i>
                                                        </button>


                                                        <button class="btn btn-danger btn-sm p-1" title="Hapus Pekerjaan"
                                                            onclick="deleteTask({{ $pekerjaanSaya->id }})"> <i
                                                                class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </div>
                                                </div>

                                                <small style="font-size: 14px;" class="d-block">Jenis Pekerjaan:
                                                    {{ $pekerjaanSaya->jenis_pekerjaan ?? '-' }}</small>

                                                <small style="font-size: 14px;" class="d-block my-2">Deskripsi:
                                                    {{ $pekerjaanSaya->keterangan ?? '-' }}</small>

                                                <small style="font-size: 14px;">Prioritas:
                                                    <div class="badge 
                                                                                                        @if($pekerjaanSaya->prioritas == 'penting') bg-danger 
                                                                                                        @elseif($pekerjaanSaya->prioritas == 'normal') bg-warning 
                                                                                                        @elseif($pekerjaanSaya->prioritas == 'rendah') bg-success 
                                                                                                        @else bg-secondary @endif 
                                                                                                        d-inline-block">
                                                        {{ ucfirst($pekerjaanSaya->prioritas) }}
                                                    </div>
                                                    Deadline:
                                                    <div class="badge bg-success d-inline-block">
                                                        {{ $pekerjaanSaya->formatted_deadline }}
                                                    </div>
                                                </small>

                                                <small style="font-size: 13px;" class="d-block text-muted my-2">Dibuat pada:
                                                    {{ $pekerjaanSaya->created_at->translatedFormat('d F Y') }}</small>

                                                @if ($pekerjaanSaya->buktiTugas->isNotEmpty())
                                                    <ul style="list-style: none; padding-left: 0; margin-bottom: 0;">
                                                        @foreach ($pekerjaanSaya->buktiTugas as $bukti)
                                                            <li style="margin-bottom: 5px;"> <!-- Beri sedikit jarak antar item -->
                                                                <small style="font-size: 13px;" class="text-muted">
                                                                    @if ($bukti->berkas_path)
                                                                        <a href="{{ asset($bukti->berkas_path) }}" target="_blank">
                                                                            <i class="fas fa-file"></i> Lihat File
                                                                        </a>
                                                                    @endif
                                                                    @if ($bukti->link_eksternal)
                                                                        <a href="{{ $bukti->link_eksternal }}" target="_blank">
                                                                            <i class="fas fa-link"></i> Buka Link
                                                                        </a>
                                                                    @endif
                                                                </small>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </div>

                                            <hr style="border: 1px solid #c0c0c0; opacity: 1; margin: 5px 0;">

                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Modal Edit -->
                    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editModalLabel">Edit Pekerjaan</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" id="editTaskId">

                                    <div class="mb-3">
                                        <label class="form-label">Nama Pekerjaan</label>
                                        <input type="text" id="editTaskNamaTugas" class="form-control">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Deadline</label>
                                        <input type="date" id="editTaskDeadline" class="form-control" min="{{ date('Y-m-d') }}">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Prioritas</label>
                                        <select id="editTaskPrioritas" class="form-select">
                                            <option value="penting">Penting</option>
                                            <option value="normal">Normal</option>
                                            <option value="rendah">Rendah</option>
                                        </select>
                                    </div>

                                    <hr>

                                    <!-- Tampilkan Bukti Tugas (Link & File) -->
                                    <div id="buktiTugasContainer">
                                        <h6 class="fw-bold">Bukti Pekerjaan</h6>

                                        <div id="success-alert" class="alert alert-success alert-dismissible fade show d-none"
                                            role="alert">
                                            <span id="alert-message"></span>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                        </div>

                                        <ul id="buktiTugasList" style="list-style: none; padding-left: 0;"></ul>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="button" class="btn btn-success" onclick="saveTask()">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Modal Bukti Tugas -->
                    <div class="modal fade" id="modalBuktiTugas" tabindex="-1" aria-labelledby="modalBuktiTugasLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalBuktiTugasLabel">Bukti Penyelesaian Pekerjaan</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="formBuktiTugas">
                                        <input type="hidden" id="modalTaskId" name="tugas_pegawai_id">

                                        <div class="mb-3">
                                            <label for="linkEksternal" class="form-label">Masukkan Link</label>
                                            <input type="url" class="form-control" id="linkEksternal" name="link_eksternal"
                                                placeholder="Masukkan link bukti pekerjaan">
                                            <span id="errorLink" style="color: red; font-size: 14px; display: none;">Masukkan
                                                URL yang valid.</span>
                                        </div>
                                        <p>atau</p>
                                        <div class="mb-3">
                                            <label for="berkasBukti" class="form-label">Upload Berkas</label>
                                            <input type="file" class="form-control" id="berkasBukti" name="berkas_path">
                                        </div>

                                        <button type="button" class="btn btn-primary" onclick="submitBuktiTugas()">Simpan
                                            Bukti</button>
                                        <p id="errorMessage" style="color: red; display: none; margin-top: 10px;">Harap isi
                                            salah satu: link
                                            atau unggah berkas.</p>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Input Points -->
                    <div class="modal fade" id="modalInputPoints" tabindex="-1" aria-labelledby="modalInputPointsLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalInputPointsLabel">Masukkan Point</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="formUpdatePoints">
                                        @csrf
                                        <input type="hidden" id="tugasPegawaiId">
                                        <div class="mb-3">
                                            <label for="nama_tugas" class="form-label">Nama Pekerjaan</label>
                                            <input type="text" class="form-control" id="nama_tugas" name="nama_tugas" readonly>
                                        </div>

                                        <div class="mb-3">
                                            <label for="keterangan_tugas">Deskripsi Pekerjaan</label>
                                            <textarea name="keterangan_tugas" id="keterangan_tugas" class="form-control"
                                                rows="4" readonly></textarea>
                                        </div>

                                        <div class="mb-3">
                                            <label for="points" class="form-label">Point <span style="color: red">*</span>
                                            </label>
                                            <input type="number" class="form-control" id="points" name="points" required>
                                        </div>
                                        <button type="submit" class="btn btn-success">Simpan</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>


                @else
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        <strong>Info!</strong> Harap isikan NIPY untuk melakukan verifikasi data anda.
                    </div>

                    <form action="{{ route('validate-nipy') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                name="email" value="{{ old('email', Auth::user()->email) }}" disabled required>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="nipy" class="form-label">NIPY <span style="color: red">*</span></label>
                            <input type="number" class="form-control @error('nipy') is-invalid @enderror" id="nipy" name="nipy"
                                value="{{ old('nipy') }}" required>

                            @error('nipy')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <p>Keterangan: <span style="color: red">*</span>) wajib diisi</p>

                        <button type="submit" class="btn btn-primary">Verifikasi Data</button>
                    </form>
                @endif




            </div>
            <!-- container-fluid -->
        </div>
        <!-- End Page-content -->

        <!-- footer -->


    </div>
    <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    @push('javascript-plugins')
    <script src="{{ asset('assets/admin/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/admin/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/admin/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('assets/admin/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/admin/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('assets/admin/libs/feather-icons/feather.min.js') }}"></script>
    <!-- pace js -->
    <script src="{{ asset('assets/admin/libs/pace-js/pace.min.js') }}"></script>

        
    <!-- apexcharts -->
    <script src="{{ asset('assets/admin/libs/apexcharts/apexcharts.min.js') }}"></script>

    <!-- Plugins js-->
    <script src="{{ asset('assets/admin/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
    <script src="{{ asset('assets/admin/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-world-mill-en.js') }}"></script>

    <script src="{{ asset('assets/admin/js/pages/allchart.js') }}"></script>
    <!-- dashboard init -->
    <script src="{{ asset('assets/admin/js/pages/dashboard.init.js') }}"></script>

    <script src="{{ asset('assets/admin/js/app.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>


        <!-- Required datatable js -->
        <script src="{{ asset('assets/admin/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('assets/admin/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>

        <!-- Responsive examples -->
        <script src="{{ asset('assets/admin/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('assets/admin/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>

        <!-- Datatable init js -->
        <script src="{{ asset('assets/admin/js/pages/datatables.init.js') }}"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.8/clipboard.min.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>

        <script>
            // Drag and Drop
            document.querySelectorAll('.kanban-column').forEach(column => {
                new Sortable(column, {
                    group: "tasks",
                    animation: 150,
                    onEnd: function (evt) {
                        let taskId = evt.item.getAttribute('data-id');
                        let newStatus = evt.to.id;
                        let hasBukti = evt.item.getAttribute('data-has-bukti') === 'true';

                        fetch(`/tugas-pegawai/${taskId}/status`, {
                            method: 'PATCH',
                            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' },
                            body: JSON.stringify({ progres: newStatus }) // Pastikan field sesuai dengan database
                        }).then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    console.log("Status task berhasil diperbarui!");

                                    // Jika status dipindah ke "done" dan belum ada bukti, baru tampilkan modal
                                    if (newStatus === "done" && !hasBukti) {
                                        document.getElementById("modalTaskId").value = taskId;
                                        let modal = new bootstrap.Modal(document.getElementById("modalBuktiTugas"));
                                        modal.show();
                                    }
                                } else {
                                    console.error("Gagal memperbarui status task.");
                                }
                            });
                    }
                });
            });


            // Hapus Tugas
            function deleteTask(taskId) {
                if (!confirm("Apakah Anda yakin ingin menghapus pekerjaan ini?")) return;

                fetch(`/tugas-pegawai/${taskId}`, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            document.querySelector(`[data-id='${taskId}']`).remove();
                        }
                    });
            }

            // Edit Pekerjaan
            function editTask(taskId, taskTitle, taskPriority, taskDeadline) {
                document.getElementById("editTaskId").value = taskId;
                document.getElementById("editTaskNamaTugas").value = taskTitle;

                let deadlineInput = document.getElementById("editTaskDeadline");
                deadlineInput.value = taskDeadline;

                let prioritySelect = document.getElementById("editTaskPrioritas");
                prioritySelect.value = taskPriority;

                // Kosongkan list bukti tugas sebelum memuat yang baru
                let buktiTugasList = document.getElementById("buktiTugasList");
                buktiTugasList.innerHTML = '';

                // Fetch data bukti tugas dari backend
                fetch(`/tugas-pegawai/${taskId}/bukti-tugas`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(bukti => {
                            let listItem = document.createElement("li");
                            listItem.classList.add("d-flex", "justify-content-between", "align-items-center", "mb-2");

                            if (bukti.berkas_path) {
                                listItem.innerHTML = `
                                            <a href="/storage/${bukti.berkas_path}" target="_blank"><i class="fas fa-file"></i> Lihat File</a>
                                            <button class="btn btn-danger btn-sm" onclick="hapusBukti(${bukti.id})"><i class="fas fa-trash-alt"></i></button>
                                        `;
                            } else if (bukti.link_eksternal) {
                                listItem.innerHTML = `
                                            <input type="text" class="form-control form-control-sm d-inline-block w-70" value="${bukti.link_eksternal}" id="link_${bukti.id}">
                                            <button class="btn btn-primary btn-sm ms-2" onclick="updateLink(${bukti.id})" title="Simpan"><i class="fas fa-save"></i></button>
                                            <button class="btn btn-danger btn-sm ms-2" onclick="hapusBukti(${bukti.id})" title="Hapus"><i class="fas fa-trash-alt"></i></button>
                                        `;
                            }

                            buktiTugasList.appendChild(listItem);
                        });
                    });

                let modal = new bootstrap.Modal(document.getElementById("editModal"));
                modal.show();
            }

            function updateLink(buktiId) {
                let inputField = document.getElementById(`link_${buktiId}`);
                let newLink = inputField.value;

                fetch(`/update-bukti-tugas/${buktiId}`, {
                    method: "PUT",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ link_eksternal: newLink })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showSuccessAlert("Link berhasil diperbarui!");
                        } else {
                            alert("Gagal memperbarui link.");
                        }
                    })
                    .catch(error => console.error("Error:", error));
            }




            // Hapus Bukti Tugas
            function hapusBukti(buktiId) {
                if (!confirm("Apakah Anda yakin ingin menghapus bukti ini?")) return;

                fetch(`/tugas-pegawai/bukti/${buktiId}`, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            document.querySelector(`#buktiTugasList li button[onclick="hapusBukti(${buktiId})"]`).parentElement.remove();
                        }
                    });
            }





            // Simpan Edit
            function saveTask() {
                let taskId = document.getElementById('editTaskId').value;
                let nama_tugas = document.getElementById('editTaskNamaTugas').value;
                let prioritas = document.getElementById('editTaskPrioritas').value;
                let deadline = document.getElementById('editTaskDeadline').value; // Ambil nilai deadline

                fetch(`/tugas-pegawai/${taskId}`, {
                    method: 'PATCH',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' },
                    body: JSON.stringify({ nama_tugas: nama_tugas, prioritas: prioritas, deadline: deadline })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload(); // Refresh halaman agar perubahan terlihat
                        } else {
                            alert("Gagal menyimpan perubahan!");
                        }
                    });
            }

            function isValidURL(string) {
                let pattern = /^(https?:\/\/)?([\w\d-]+\.)+[\w\d]{2,}(\/.*)?$/i;
                return pattern.test(string);
            }

            function submitBuktiTugas() {
                let link = document.getElementById("linkEksternal").value;
                let file = document.getElementById("berkasBukti").files.length;
                let errorLink = document.getElementById("errorLink");
                let errorMessage = document.getElementById("errorMessage");

                // Validasi URL jika diisi
                if (link && !isValidURL(link)) {
                    errorLink.style.display = "block";
                    return;
                } else {
                    errorLink.style.display = "none";
                }

                // Cek apakah salah satu input diisi
                if (!link && file === 0) {
                    errorMessage.style.display = "block";
                    return;
                } else {
                    errorMessage.style.display = "none";
                }

                let formData = new FormData(document.getElementById("formBuktiTugas"));

                fetch('/bukti-tugas', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.error) {
                            alert(data.error);
                        } else {
                            // alert("Bukti tugas berhasil disimpan!");
                            location.reload();
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }

        </script>

        <script>
            $(document).ready(function () {
                // Ketika tombol edit diklik
                $('.btn-input-points').click(function () {
                    let tugasPegawaiId = $(this).data('id');
                    let namaTugas = $(this).data('nama_tugas');
                    let keteranganTugas = $(this).data('keterangan_tugas');

                    $('#tugasPegawaiId').val(tugasPegawaiId);
                    $('#nama_tugas').val(namaTugas);
                    $('#keterangan_tugas').val(keteranganTugas);

                    $('#modalInputPoints').modal('show');
                });

                // Ketika form disubmit
                $('#formUpdatePoints').submit(function (e) {
                    e.preventDefault();
                    let tugasPegawaiId = $('#tugasPegawaiId').val();
                    let points = $('#points').val();

                    $.ajax({
                        url: "/tugas-pegawai/update-points/" + tugasPegawaiId,
                        type: "PUT",
                        data: {
                            _token: "{{ csrf_token() }}",
                            points: points
                        },
                        success: function (response) {
                            if (response.success) {
                                // alert("Points berhasil diperbarui!");
                                $('#modalInputPoints').modal('hide');
                                location.reload(); // Refresh data
                            }
                        },
                        error: function (xhr) {
                            alert("Gagal mengupdate points.");
                        }
                    });
                });
            });
        </script>

        <script>
            function showSuccessAlert(message) {
                let alertBox = document.getElementById("success-alert");
                let alertMessage = document.getElementById("alert-message");

                alertMessage.textContent = message;
                alertBox.classList.remove("d-none");

                setTimeout(() => {
                    alertBox.classList.add("d-none");
                }, 3000);
            }

        </script>

        <script>
            document.getElementById('filterSemester').addEventListener('change', function () {
                let selectedSemester = this.value;
                window.location.href = `?semester_id=${selectedSemester}`;
            });
        </script>

    @endpush
@endsection