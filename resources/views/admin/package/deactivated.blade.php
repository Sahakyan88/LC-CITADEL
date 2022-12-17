
@extends('admin.layouts.app')
@section('content')

<main>
    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
        <div class="container">
            <div class="page-header-content pt-4">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4">
                        <h1 class="page-header-title">
                        <div class="page-header-icon"><i data-feather="users"></i></div>
                        Deactivated
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="container mt-n10">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>F.Name</th>
                                <th>L.Name</th>
                                <th>Registered</th>
                                <th>Phone</th>
                                <th>Service</th>
                                <th>Price</th>
                                <th>Paid</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>F.Name</th>
                                <th>L.Name</th>
                                <th>Registered</th>
                                <th>Phone</th>
                                <th>Service</th>
                                <th>Price</th>
                                <th>Paid</th>
                        </tfoot>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Main page content-->    
</main>
@push('css')
    <link href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
@endpush
@push('script')
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
    <script>
      
        $(document).ready(function() {
            const capitalize = (s) => {
                if (typeof s !== 'string') return ''
                return s.charAt(0).toUpperCase() + s.slice(1)
            }
            var dataTable =  $('#dataTable').DataTable({
                
                "processing": true,
                "serverSide": true,
                'searching': true,
                "ajax": {
                    "url": "{{ route('aDeactivatedData') }}",
                    "data": function(data){
                     
                        data['sort_field'] = data.columns[data.order[0].column].name;
                        data['sort_dir'] =  data.order[0].dir;
                        data['search'] = data.search.value;

                        delete data.columns;
                        delete data.order;

                        var filter_status = $('#filter_status').val();
                        data.filter_status = filter_status;
                        
                        var filter_verification = $('#filter_verification').val();
                        data.filter_verification = filter_verification;
                    }
                   
                },
                "fnDrawCallback": function( oSettings ) {
                    feather.replace();
                    $('[data-toggle="popover"]').popover();
                },
                
                "columns": [
                    { "data": "id", "name":'id', "orderable": true },
                    { "data": "first_name", "name":'first_name', "orderable": true },
                    { "data": "last_name", "name":'last_name', "orderable": true },
                    { "data": "date", "name":'date', "orderable": true },
                    { "data": "phone", "name":'phone', "orderable": true },
                    { "data": "title", "name":'title', "orderable": true },
                    { "data": "amount", "name":'amount', "orderable": true },
                    { "data": "paid", "name":'paid', "orderable": true },
                   
                ],
                "columnDefs": [
                    {"width": "1%", "targets": 0},
                    {"width": "10%", "targets": 1},
                    {"width": "10%", "targets": 2},
                    {"width": "10%", "targets": 3},
                    {"width": "40%", "targets": 4},
                    {"width": "10%", "targets": 5},
                    {"width": "1%", "targets": 6},
                    {"width": "25%", "targets": 7},
                ],
                "order": [
                    ['0', "desc"]
                ]
            });

            window.datatable = dataTable;
            $('#filter_status').change(function(){
                dataTable.draw();
            });
            $('#filter_verification').change(function(){
                dataTable.draw();
            });

            var itemPopup = new Popup;
            itemPopup.init({
                size:'modal-lg',
                identifier:'edit-item',
                class: 'modal',
                minHeight: '200',
            })
            
        });
    </script>
@endpush
@endsection