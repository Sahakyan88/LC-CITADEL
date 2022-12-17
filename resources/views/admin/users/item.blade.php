<script type="text/javascript">
    if (typeof(itemPopup) != "undefined") {
        $(itemPopup).one("loaded", function(e) {
            initTinymce();
            @if ($mode == 'add')
            Loading.remove($('#add_item'));
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
                        <div class="row">
                            <div class="col-xl-4">
                                <div class="card">
                                    <div class="card-header">Image</div>
                                    <div class="card-body text-center">
                                        <div class="image-upload-container" id="cover">
                                            <div class="image-part">
                                                <img data-enlargable style="width: 100%"
                                                    src="@if ($item->image) {{ $item->image->path_passport }} @else {!! asset('backend/img/no_avatar.jpg') !!} @endif" />
                                            </div>
                                        </div>
                                    </div>
                                    @if (count($packages) > 0)
                                        <div class="card-header">Packages</div>
                                        @foreach ($packages as $package)
                                            <div class="prof-order-block  mt-5">
                                                <div class="php-email-form order-profile">
                                                    <div class="col-sm-12 title-order">{{ $package->title }}</div>
                                                    <div class="col-sm-12 amount">{{ $package->amount }}
                                                        դր</div>
                                                    <div class="col-sm-2 mt-3 "></div>
                                                    <hr>
                                                    <div class="col-sm-12 date-prof">Առաջին Վճարումը կատարվել է՝
                                                        {{ $package->date }}
                                                    </div>
                                                    <div class="col-sm-12 date-prof">Հաջորդ Վճարումը կատարվել է՝
                                                        {{ $package->paid }}
                                                    </div>
                                                </div>
                                                <div class="text-center">
                                                    <form id="save-item-form" method="post">
                                                        @csrf
                                                    <input type="hidden" class="hidden_id" name="user_id" value="{{ $package->user_id }}" />

                                                    <button type="button" onclick="saveItem()" id="saveItemBtn"
                                                        class="btn btn-success mt-4 ">Ապակտիվացնել</button>
                                                    </form>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="prof-order-block  mt-5">
                                            <div class="php-email-form order-profile">
                                                <div class="php-email-form text-center">
                                                    <p> Ակտիվ փաթեթներ չկան </p>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-xl-8">
                                <div class="card">
                                    <div class="card-header">Details</div>
                                    <div class="card-body">
                                        <div class="tab-content" id="dashboardNavContent">
                                            <div class="tab-pane fade @if (!$page) show active @endif"
                                                id="users" role="tabpanel" aria-labelledby="users-tab">
                                                <div class="container mt-4">
                                                    <div class="row">
                                                        <div class="col-xl-12">
                                                            <div class="card">
                                                                <div class="card-header">Details</div>
                                                                <div class="card-body">
                                                                    <div class="form-row">
                                                                        <div class="form-group col-md-6">
                                                                            <input type="hidden" name="id"
                                                                                value="{{ $item->id }}" />
                                                                            <label class="small mb-1"
                                                                                for="inputUsername">First
                                                                                name</label>
                                                                            <input disabled class="form-control"
                                                                                id="inputUsername" type="text"
                                                                                name="first_name"
                                                                                placeholder="First Name"
                                                                                value="{{ $item->first_name }}" />
                                                                        </div>
                                                                        <div class="form-group col-md-6">
                                                                            <label class="small mb-1"
                                                                                for="inputUsername">Last
                                                                                name</label>
                                                                            <input disabled class="form-control"
                                                                                id="inputUsername" type="text"
                                                                                name="last_name" placeholder="Last Name"
                                                                                value="{{ $item->last_name }}" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-row">
                                                                        <div class="form-group col-md-6">
                                                                            <label class="small mb-1"
                                                                                for="inputFirstName">Email</label>
                                                                            <input disabled class="form-control"
                                                                                id="email" name="email"
                                                                                type="email" placeholder="Email"
                                                                                value="{{ $item->email }}" />
                                                                        </div>
                                                                        <div class="form-group col-md-6">
                                                                            <label class="small mb-1"
                                                                                for="inputFirstName">Phone</label>
                                                                            <input disabled class="form-control"
                                                                                id="email" name="email"
                                                                                type="email" placeholder="Phone"
                                                                                value="{{ $item->phone }}" />
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- end form -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal-buttons">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Close</button>
                                    </div>

                                </div>

                            </div>

                        </div>
                        <script>
                            $('img[data-enlargable]').addClass('img-enlargable').click(function() {
                                var src = $(this).attr('src');
                                $('<div>').css({
                                    background: 'RGBA(0,0,0,.5) url(' + src + ') no-repeat center',
                                    backgroundSize: 'contain',
                                    width: '100%',
                                    height: '100%',
                                    position: 'fixed',
                                    zIndex: '10000',
                                    top: '0',
                                    left: '0',
                                    cursor: 'zoom-out'
                                }).click(function() {
                                    $(this).remove();
                                }).appendTo('body');
                            });

                            function saveItem() {
                                tinyMCE.triggerSave()
                                Loading.add($('#saveItemBtn'));
                                var data = $('#save-item-form').serializeFormJSON();
                                $.ajax({
                                    type: "POST",
                                    url: "{{ route('cancelRequest') }}",
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
                        </script>
