<div class="row">
    <div class="col-xxl-12">
        <div class="card mb-4">
            <div class="card-header border-bottom">
                <ul class="nav nav-tabs card-header-tabs" id="dashboardNav" role="tablist">
                    <li class="nav-item mr-1" role="presentation">
                        <a class="nav-link @if (!$page) active @endif" id="users-tab"
                            data-toggle="tab" href="#users" role="tab" aria-controls="users"
                            aria-selected="@if (!$page) true @else false @endif">Users</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="dashboardNavContent">
                    <div class="tab-pane fade @if (!$page) show active @endif" id="users"
                        role="tabpanel" aria-labelledby="users-tab">
                        <div class="container mt-4">
                            <form id="save-item-form" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="card">
                                            <div class="card-header">Details</div>
                                            <div class="card-body">
                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <input type="hidden" name="id"
                                                            value="{{ $item->id }}" />
                                                        <label class="small mb-1" for="inputUsername">First name</label>
                                                        <input disabled class="form-control" id="inputUsername"
                                                            type="text" name="first_name" placeholder="First Name"
                                                            value="{{ $item->first_name }}" />
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label class="small mb-1" for="inputUsername">Last name</label>
                                                        <input disabled class="form-control" id="inputUsername"
                                                            type="text" name="last_name" placeholder="Last Name"
                                                            value="{{ $item->last_name }}" />
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <label class="small mb-1" for="inputFirstName">Email</label>
                                                        <input disabled class="form-control" id="email"
                                                            name="email" type="email" placeholder="Email"
                                                            value="{{ $item->email }}" />
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label class="small mb-1" for="inputFirstName">Phone</label>
                                                        <input disabled class="form-control" id="email"
                                                            name="email" type="email" placeholder="Phone"
                                                            value="{{ $item->phone }}" />
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label class="small mb-1" for="inputFirstName">Address</label>
                                                        <input disabled class="form-control" id="email"
                                                            name="address" type="text" placeholder="address"
                                                            value="{{ $item->address }}" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <!-- end form -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-buttons">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
