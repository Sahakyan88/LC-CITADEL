@extends('admin.layouts.app')
@section('content')
    <main>
        <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
            <div class="container">
                <div class="page-header-content pt-4">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto mt-4">
                            <h1 class="page-header-title">
                                <div class="page-header-icon"><i data-feather="settings"></i></div>
                                Settings
                            </h1>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <div class="container mt-n10">
            <div class="card">
                <div class="card m-3 p-1 ">
                    <div class="tab-content  ">
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
                        <div id="general" class="tab-pane  active  p-3">
                            <form id="save-item-form" class="p-3" method="post">
                                @csrf
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <div class="tab-content" id="dashboardNavContent">
                                            @foreach (Session::get('bLangs') as $index => $lang)
                                                <?php $address = 'address_' . $lang['lang']; ?>
                                                <!-- Dashboard Tab Pane 1-->
                                                <div class="tab-pane fade @if ($index == 0) show active @endif"
                                                    id="multi_content_{{ $lang['lang'] }}" role="tabpanel"
                                                    aria-labelledby="multi_content_{{ $lang['lang'] }}-pill">
                                                    <label class="small mb-1" for="inputAddress">Address</label>
                                                    <input class="form-control" id="inputAddress" type="text"
                                                        name="address_{{ $lang['lang'] }}" placeholder="Address"
                                                        value="{{ $data->$address }}" />
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="small mb-1" for="inputEmail">Email</label>
                                        <input class="form-control" id="inputEmail" type="text" name="email"
                                            placeholder="Email" value="{{ $data->email }}" />
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="small mb-1" for="inputPhone">Phone</label>
                                        <input class="form-control" id="inputPhone" type="text" name="phone"
                                            placeholder="Phone" value="{{ $data->phone }}" />
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="small mb-1" for="inputInstagram">Instagram</label>
                                        <input class="form-control" id="inputInstagram" type="text" name="instagram"
                                            placeholder="Instagram" value="{{ $data->instagram }}" />
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="small mb-1" for="inputFacebook">Facebook</label>
                                        <input class="form-control" id="inputFacebook" type="text" name="facebook"
                                            placeholder="Facebook" value="{{ $data->facebook }}" />
                                    </div>

                                </div>
                                <div class="form-group">
                                    <button type="button" onclick="save()" id="saveItemBtn"
                                        class="btn btn-success float-right">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </main>

    <script>
        function save() {
            Loading.add($('#saveItemBtn'));
            var data = $('#save-item-form').serializeFormJSON();
            $.ajax({
                type: "POST",
                url: "{{ route('updateSettings') }}",
                data: data,
                dataType: 'json',
                success: function(response) {
                    if (response.status == 0) {
                        toastr['error'](response.message, 'Error');
                    }
                    if (response.status == 1) {
                        toastr['success']('Saved.', 'Success');
                    }
                    Loading.remove($('#saveItemBtn'));
                }
            });
        }
    </script>
@endsection
