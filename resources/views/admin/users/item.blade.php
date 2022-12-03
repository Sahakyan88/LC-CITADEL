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
                                                <img data-enlargable  style="width: 100%"
                                                    src="@if ($item->image) {{ $item->image->path_passport }} @else {!! asset('backend/img/no_avatar.jpg') !!} @endif" />
                                            </div>
                                        </div>
                                    </div>
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
                        </script>
