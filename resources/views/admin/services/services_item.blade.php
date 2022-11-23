<script type="text/javascript">
    if (typeof(itemPopup) != "undefined") {
        $(itemPopup).one("loaded", function(e) {
            @if ($mode == 'add')
                Loading.remove($('#add_item'));
            @endif
            

            @if ($mode == 'edit')
            var typePopup = new Popup;
            typePopup.init({
                size:'modal-xl',
                identifier:'type-item',
                class: 'modal notMainModal',
                minHeight: '200',
            })
            window.typePopup = typePopup;

            $('#dataTableTypes').on('click', '.type_edit', function (e) {
                editId = $(this).attr('edit_type_id');
                typePopup.setTitle('Edit service type');
                typePopup.load("{{route('aGetServicesType')}}?id="+editId, function () {
                    this.open();
                });
            });

            $('#add_type').on('click', function (e) {
                Loading.add($('#add_type'));
                typePopup.setTitle('Add service type');
                typePopup.load("{{route('aGetServicesType')}}?parent_id={{$item->id}}", function () {
                    this.open();
                });
            });


            $('#dataTableTypes tbody').on('click', 'tr td:not(.selectOff)', function (e) {
                $(this).parent('tr').toggleClass('selected');
            });

            $("#remove_item_type").on('click', function (e) {
                if(dataTableTypes.rows('.selected').data().length <= 0){
                    toastr['info']("Please select item", 'Information');    
                }else{
                    var rows = [];
                    dataTableTypes.rows('.selected').data().each(function (row) {
                        rows.push(row.id);    
                    })
                    if(rows.length <= 0){
                        toastr['info']("Please select item", 'Information');    
                        return
                    }
                    bootbox.confirm("Are you sure?", function(result) {
                        if(result){
                            $.ajax({
                            type: "POST",
                            url: "{{route('aRemoveServicesType')}}",
                            dataType: 'JSON',
                            data:{_token: "<?php echo csrf_token(); ?>", ids:rows},
                                success: function(response){
                                    if(response.status == 1){
                                        dataTableTypes.ajax.reload(null, false);
                                    }else{
                                        toastr['error'](response.message, 'Error');
                                    }
                                }
                            });	
                        }
                    }); 
                }
            });

            /// Grid
            var dataTableTypes =  $('#dataTableTypes').DataTable({
                "processing": true,
                "serverSide": true,
                'searching': true,
                "ajax": {
                    "url": "{{ route('aServicesTypeData') }}?parent_id={{$item->id}}",
                    "data": function(data){
                        data['sort_field'] = data.columns[data.order[0].column].name;
                        data['sort_dir'] =  data.order[0].dir;
                        data['search'] = data.search.value;

                        delete data.columns;
                        delete data.order;
                    }
                },
                "fnDrawCallback": function( oSettings ) {
                    feather.replace();
                },
                "columns": [
                    { "data": 'ordering', "name":'ordering', "orderable": true },
                    { "data": "id", "name":'id', "orderable": true },
                    { "data": "title", "name":'title', "orderable": true },
                    { "data": "published", "name":'published', "orderable": true , "sClass": "content-middel",
                    render: function ( data, type, row, meta) {
                        switch(row.published){
                            case 1:
                                colorClass = 'badge-success';
                                status = 'Active';
                                break;
                                case 0:
                                colorClass = 'badge-info';
                                status = 'Disabled';
                                break;
                            default:
                                status = 'error' 
                                colorClass = 'badge-danger';
                        }
                        return '<div style="font-size:12px;" class="badge '+colorClass+' badge-pill">'+status+'</div>';
	                }},
                    { "data": "id", "name":'edit', "orderable": false, "sClass": "content-middel selectOff", 
	            	    render: function ( data, type, row, meta) {
	            	    return '<a href="javascript:;" edit_type_id="'+row.id+'" class="type_edit"><button class="btn btn-datatable btn-icon btn-transparent-dark"><i data-feather="edit"></i></button></a>';
	                }},
                ],
                "columnDefs": [
                    {
                        "targets": [ 0 ],
                        "visible": false,
                    },
                    {"width": "5%", "targets": 1},
                    {"width": "45%", "targets": 2},
                    {"width": "45%", "targets": 3},
                    {"width": "5%", "targets": 4},
                ],
                "lengthMenu": [
                    [10, 20, 50, 100, -1],
                    [10, 20, 50, 100, "All"] // change per page values here
                ],
                "order": [
                    ['0', "desc"]
                ],
            });

            window.dataTableTypes = dataTableTypes; 
            ////
            ///////////// Newwww
            var replacementPopup = new Popup;
            replacementPopup.init({
                size:'modal-xl',
                identifier:'replacement-item',
                class: 'modal notMainModal',
                minHeight: '200',
            })
            window.replacementPopup = replacementPopup;

            $('#dataTableReplacement').on('click', '.replacement_edit', function (e) {
                editId = $(this).attr('edit_replacement_id');
                replacementPopup.setTitle('Edit service replacement');
                replacementPopup.load("{{route('aGetServicesReplacement')}}?id="+editId, function () {
                    this.open();
                });
            });

            $('#add_replacement').on('click', function (e) {
                Loading.add($('#add_replacement'));
                replacementPopup.setTitle('Add service replacement');
                replacementPopup.load("{{route('aGetServicesReplacement')}}?parent_id={{$item->id}}", function () {
                    this.open();
                });
            });

            $('#dataTableReplacement tbody').on('click', 'tr td:not(.selectOff)', function (e) {
                $(this).parent('tr').toggleClass('selected');
            });

            $("#remove_replacement").on('click', function (e) {
                if(dataTableReplacement.rows('.selected').data().length <= 0){
                    toastr['info']("Please select item", 'Information');    
                }else{
                    var rows = [];
                    dataTableReplacement.rows('.selected').data().each(function (row) {
                        rows.push(row.id);    
                    })
                    if(rows.length <= 0){
                        toastr['info']("Please select item", 'Information');    
                        return
                    }
                    bootbox.confirm("Are you sure?", function(result) {
                        if(result){
                            $.ajax({
                            type: "POST",
                            url: "{{route('aRemoveServicesReplacement')}}",
                            dataType: 'JSON',
                            data:{_token: "<?php echo csrf_token(); ?>", ids:rows},
                                success: function(response){
                                    if(response.status == 1){
                                        dataTableReplacement.ajax.reload(null, false);
                                    }else{
                                        toastr['error'](response.message, 'Error');
                                    }
                                }
                            });	
                        }
                    }); 
                }
            });

            /// Grid
            var dataTableReplacement =  $('#dataTableReplacement').DataTable({
                "processing": true,
                "serverSide": true,
                'searching': true,
                "ajax": {
                    "url": "{{ route('aServicesReplacementData') }}?parent_id={{$item->id}}",
                    "data": function(data){
                        data['sort_field'] = data.columns[data.order[0].column].name;
                        data['sort_dir'] =  data.order[0].dir;
                        data['search'] = data.search.value;

                        delete data.columns;
                        delete data.order;
                    }
                },
                "fnDrawCallback": function( oSettings ) {
                    feather.replace();
                },
                "columns": [
                    { "data": 'ordering', "name":'ordering', "orderable": true },
                    { "data": "id", "name":'id', "orderable": true },
                    { "data": "title", "name":'title', "orderable": true },
                    { "data": "published", "name":'published', "orderable": true , "sClass": "content-middel",
                    render: function ( data, type, row, meta) {
                        switch(row.published){
                            case 1:
                                colorClass = 'badge-success';
                                status = 'Active';
                                break;
                                case 0:
                                colorClass = 'badge-info';
                                status = 'Disabled';
                                break;
                            default:
                                status = 'error' 
                                colorClass = 'badge-danger';
                        }
                        return '<div style="font-size:12px;" class="badge '+colorClass+' badge-pill">'+status+'</div>';
	                }},
                    { "data": "id", "name":'edit', "orderable": false, "sClass": "content-middel selectOff", 
	            	    render: function ( data, type, row, meta) {
	            	    return '<a href="javascript:;" edit_replacement_id="'+row.id+'" class="replacement_edit"><button class="btn btn-datatable btn-icon btn-transparent-dark"><i data-feather="edit"></i></button></a>';
	                }},
                ],
                "columnDefs": [
                    {
                        "targets": [ 0 ],
                        "visible": false,
                    },
                    {"width": "5%", "targets": 1},
                    {"width": "45%", "targets": 2},
                    {"width": "45%", "targets": 3},
                    {"width": "5%", "targets": 4},
                ],
                "lengthMenu": [
                    [10, 20, 50, 100, -1],
                    [10, 20, 50, 100, "All"] // change per page values here
                ],
                "order": [
                    ['0', "desc"]
                ],
            });

            window.dataTableReplacement = dataTableReplacement; 
            ////
            ////////////////////
            @endif
        });
    }
</script>

    <div class="row">
        <div class="col-xxl-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="tab-content" id="dashboardNavContent">
                        <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-tab">
                            <form id="save-item-form" method="post">
                                <input type="hidden" class="hidden_id" name="id" value="{{ $item->id }}" />
                                @csrf
                                <div class="row">
                                    <div class="col-xl-4">
                                        <div class="card">
                                            <div class="card-header">Image</div>
                                            <div class="card-body text-center">
                                                <div class="image-upload-container" id="cover">
                                                    <div class="image-part">
                                                        <img class="thumbnail"
                                                            src="@if ($item->image) {{ $item->image->path }} @else {!! asset('backend/img/no_avatar.jpg') !!} @endif" />
                                                        <input type="hidden" name="image" class="cover"
                                                            value="@if ($item->image) {{ $item->image->id }} @endif" />
                                                    </div>
                                                    <div class="image-action @if ($item->image) fileExist @else fileNotExist @endif">
                                                        <div>size (370 x 313)</div>
                                                        <div class="img-not-exist">
                                                            <span id="uploadBtn" class="btn btn-success">Select image </span>
                                                        </div>
                                                        <div class="img-exist">
                                                            <span class="btn btn-danger remove-image">Remove </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-8">
                                        <div class="card">
                                            <div class="card-header">Details</div>
                                            <div class="card-body">
                                                <!-- Tab nav start-->
                                                <div class="card-header border-bottom" style="background-color:#fff;">
                                                    <ul class="nav nav-tabs card-header-tabs" id="dashboardNav" role="tablist">
                                                        @foreach (Session::get('bLangs') as $index => $lang)
                                                            <li class="nav-item mr-1"><a
                                                                    class="nav-link @if ($index == 0) active @endif"
                                                                    id="multi_content_{{ $lang['lang'] }}-pill"
                                                                    href="#multi_content_{{ $lang['lang'] }}" data-toggle="tab" role="tab"
                                                                    aria-controls="multi_content_{{ $lang['lang'] }}"
                                                                    aria-selected="@if ($index == 0) true @else false @endif">{{ $lang['title'] }}</a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                                <div class="tab-content" id="dashboardNavContent">
                                                    @foreach (Session::get('bLangs') as $index => $lang)
                                                        <?php $title = 'title_' . $lang['lang']; ?>
                                                        <?php $body = 'body_' . $lang['lang']; ?>
                                                        <!-- Dashboard Tab Pane 1-->
                                                        <div class="tab-pane fade @if ($index == 0) show active @endif"
                                                            id="multi_content_{{ $lang['lang'] }}" role="tabpanel"
                                                            aria-labelledby="multi_content_{{ $lang['lang'] }}-pill">
                                                            <div class="container mt-4">
                                                                <div class="form-row">
                                                                    <div class="form-group col-12">
                                                                        <label class="small mb-1" for="title">Title</label>
                                                                        <input class="form-control" id="title" name="title_{{ $lang['lang'] }}"
                                                                            type="text" placeholder="Title"
                                                                            value="{{ $item->$title }}" />
                                                                    </div>
                                                                </div>
                                                                <div class="form-row">
                                                                        <div class="form-group col-12">
                                                                            <label class="small mb-1" for="title">Text</label>
                                                                            <textarea class="form-control wysihtml5 textarea" id="body" name="body_{{ $lang['lang'] }}"rows="12">{!!html_entity_decode($item->$body)!!}</textarea>
                                                                        </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                    <div class="form-row">
                                                        <div class="form-group col-md-6">
                                                            Status:
                                                            <select class="form-select form-control" name="published"
                                                                aria-label="Default select example">
                                                                <option @if ($item->published == 1) selected @endif value="1">Active
                                                                </option>
                                                                <option @if ($item->published == 0) selected @endif value="0">Disabled
                                                                </option>
                                                            </select>
                                                            </span>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            Price:
                                                            <input class="form-control" type="number" value="{{ $item->price }}" name="price">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<div class="modal-buttons">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <button type="button" onclick="saveItem()" id="saveItemBtn" class="btn btn-success">Save</button>
</div>

<script>
    function saveItem() {
        tinyMCE.triggerSave()
        Loading.add($('#saveItemBtn'));
        var data = $('#save-item-form').serializeFormJSON();
        $.ajax({
            type: "POST",
            url: "{{ route('adminServicesSave') }}",
            data: data,
            dataType: 'json',
            success: function(response) {
                if (response.status == 0) {
                    if (response.messages) {
                        toastr['error'](response.message, 'Error');
                    } else {
                        toastr['error'](response.message, 'Error');
                    }
                }
                if (response.status == 1) {
                    toastr['success']('Saved.', 'Success');
                    window.datatable.ajax.reload(null, false);
                    itemPopup.close();
                }
                Loading.remove($('#saveItemBtn'));
            },
            error: function(jqXHR, textStatus, errorThrown) {
                toastr['error'](errorThrown, 'Error');
                Loading.remove($('#saveItemBtn'));
            }
        });
    }
    $(document).ready(function() {
        initTinymce();
        var upload = new SUpload;
        upload.init({
            uploadContainer: 'cover',
            token: "<?php echo csrf_token(); ?>",
            imageIdReturnEl: ".cover",
            services: "{{ $item->id }}"
        });

        $(document).on('focusin', function(e) {
            if ($(e.target).closest(".tox-dialog").length) {
                e.stopImmediatePropagation();
            }
        });
    });
</script>
