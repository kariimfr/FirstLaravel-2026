@extends('layouts.app') {{-- Sesuaikan dengan nama layout template lu --}}

@section('content')
    <div class="container py-4">
        {{-- success --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">Paket Langganan</h2>

            {{-- mengarahkan (link) -> route khusus (create) menggunakan method GET --}}
            <a href="{{ route('admin.subscriptions.create') }}" class="btn btn-primary">Tambah Data</a>
        </div>

        <div class="card border-0 shadow-sm rounded-4 p-4">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="subscriptions-table">
                    <thead>
                        <tr>
                            <th width="5%">NO</th>
                            <th>Nama Paket</th>
                            <th>Warna Paket</th>
                            <th>Harga</th>
                            <th>Deskripsi</th>
                            <th width="15%">AKSI</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    {{-- Push Script Yajra DataTables --}}
    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#subscriptions-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('admin.subscriptions.index') }}",
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'name_package',
                            name: 'name_package'
                        },
                        {
                            data: 'color',
                            name: 'color',
                            render: function(data, type, row) {
                                if (!data) return '<span class="text-muted">-</span>';

                                // Menampilkan kotak warna + teks kode 
                                return `
                                    <div style="display: flex; align-items: center; gap: 8px;">
                                        <span style="width: 20px; height: 20px; background-color: ${data}; display: inline-block; border: 1px solid #ccc; border-radius: 4px;"></span>
                                        <span>${data}</span>
                                    </div>
                                `;
                            }
                        },
                        {
                            data: 'price',
                            name: 'price',
                            render: function(data, type, row) {
                                // Mengubah angka (misal: 40000) jadi format "Rp 40.000"
                                let formattedPrice = new Intl.NumberFormat('id-ID', {
                                    style: 'currency',
                                    currency: 'IDR',
                                    minimumFractionDigits: 0
                                }).format(data);

                                // Ganti 'IDR' jadi 'Rp' supaya tampilannya rapi
                                return formattedPrice.replace('IDR', 'Rp');
                            }
                        },
                        {
                            data: 'description',
                            name: 'description',
                            render: function(data, type, row) {
                                return data ? data : '<span class="text-muted">-</span>';
                            }
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        }
                    ]
                });
            });
        </script>
    @endpush
@endsection
