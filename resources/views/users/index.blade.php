@extends('layout.master')
@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <!-- Datatables css -->
    <link href="assets/vendor/datatables.net-bs5/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css"/>
    <link href="assets/vendor/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css" rel="stylesheet"
          type="text/css"/>
    <link href="assets/vendor/datatables.net-fixedcolumns-bs5/css/fixedColumns.bootstrap5.min.css" rel="stylesheet"
          type="text/css"/>
    <link href="assets/vendor/datatables.net-fixedheader-bs5/css/fixedHeader.bootstrap5.min.css" rel="stylesheet"
          type="text/css"/>
    <link href="assets/vendor/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css" rel="stylesheet"
          type="text/css"/>
    <link href="assets/vendor/datatables.net-select-bs5/css/select.bootstrap5.min.css" rel="stylesheet"
          type="text/css"/>

    <!-- Select2 css -->
    <link href="{{ asset('assets/vendor/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css"/>

    <style>
        .select2-container--open {
            z-index: 9999999 !important;
        }
    </style>
@endsection

@section('content')
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="header-title">Users</h4>
                    <input type="search" id="search" onchange="" class="form-control form-control-sm" placeholder="search">

                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#standard-modal">Add User
                    </button>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive-sm">
                    <table id="table-striped" class="table table-striped dt-responsive nowrap w-100">
                        <thead>
                        <tr>
                            <th>User Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Sensors</th>
                            <th>Created At</th>
                            <th>action</th>
                        </tr>
                        </thead>
                        <tbody id="users-data">
                        @include('users.data', [ 'users' => $users->items() ])
                        </tbody>

                    </table>
                    <div class="row">
                        <div class="col">
                            <ul class="pagination pagination-rounded mb-0">
                                <li class="page-item">
                                    <a class="page-link" href="javascript: void(0);" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                <li class="page-item"><a class="page-link" href="javascript: void(0);">1</a></li>
                                <li class="page-item"><a class="page-link" href="javascript: void(0);">2</a></li>
                                <li class="page-item active"><a class="page-link" href="javascript: void(0);">3</a></li>
                                <li class="page-item"><a class="page-link" href="javascript: void(0);">4</a></li>
                                <li class="page-item"><a class="page-link" href="javascript: void(0);">5</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="javascript: void(0);" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div> <!-- end table-responsive-->

            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->

    <div id="standard-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="standard-modalLabel">Add User</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addUserForm">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                   name="email" value="{{ old('email') }}">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select id="role" name="role" class="form-control">
                                <option value="cleaner">Select Role</option>
                                <option value="admin">Admin</option>
                                <option value="cleaner">Cleaner</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="sensor" class="form-label">Add Sensor</label>
                            <select id="sensor" name="sensor[]" class="select2 form-control select2-multiple"
                                    data-toggle="select2"
                                    multiple="multiple" data-placeholder="Choose ..." multiple>
                                @foreach($sensors as $sensor)
                                    <option value="{{ $sensor->id }}">{{ $sensor->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div id="edit-user-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="edit-user-modalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="edit-user-modalLabel">Edit User</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="edit-user-form" method="POST">
                        <input type="hidden" id="edit-user-id">
                        <div class="mb-3">
                            <label for="edit-name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="edit-name" name="name">
                        </div>
                        <div class="mb-3">
                            <label for="edit-email" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="edit-email" name="email">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3">
                            <label for="edit-role" class="form-label">Role</label>
                            <select id="edit-role" name="role" class="form-control">
                                <option value="admin">Admin</option>
                                <option value="cleaner">Cleaner</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit-sensor" class="form-label">Add Sensor</label>
                            <select id="edit-sensor" name="edit-sensor[]" class="select2 form-control select2-multiple"
                                    data-toggle="select2"
                                    multiple="multiple">
                                @foreach($sensors as $sensor)
                                    <option value="{{ $sensor->id }}">{{ $sensor->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->


    <div id="success-alert-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content modal-filled bg-success">
                <div class="modal-body p-4">
                    <div class="text-center">
                        <i class="ri-check-line h1"></i>
                        <h4 class="mt-2">Well Done!</h4>
                        <p class="mt-3">Your process done with successfully</p>
                        <button type="button" class="btn btn-light my-2" data-bs-dismiss="modal">Continue</button>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div id="danger-alert-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content modal-filled bg-danger">
                <div class="modal-body p-4">
                    <div class="text-center">
                        <i class="ri-close-circle-line h1"></i>
                        <h4 class="mt-2">Error!</h4>
                        <p class="mt-3"></p>
                        <button type="button" class="btn btn-light my-2" data-bs-dismiss="modal">Continue</button>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->


    {{--    <div class="modal fade" id="change-password-modal" tabindex="-1" aria-labelledby="change-password-modalLabel" aria-hidden="true">--}}
    {{--        <div class="modal-dialog">--}}
    {{--            <div class="modal-content">--}}
    {{--                <div class="modal-header">--}}
    {{--                    <h5 class="modal-title" id="change-password-modalLabel">Change Password</h5>--}}
    {{--                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>--}}
    {{--                </div>--}}
    {{--                <div class="modal-body">--}}
    {{--                    <form id="change-password-form">--}}
    {{--                        @csrf--}}
    {{--                        <div class="mb-3">--}}
    {{--                            <label for="current-password" class="form-label">Current Password</label>--}}
    {{--                            <input type="password" class="form-control" id="current-password" name="current-password">--}}
    {{--                            <div class="invalid-feedback"></div>--}}

    {{--                        </div>--}}
    {{--                        <div class="mb-3">--}}
    {{--                            <label for="new-password" class="form-label">New Password</label>--}}
    {{--                            <input type="password" class="form-control" id="new-password" name="new-password">--}}
    {{--                            <div class="invalid-feedback"></div>--}}
    {{--                        </div>--}}
    {{--                        <div class="mb-3">--}}
    {{--                            <label for="confirm-password" class="form-label">Confirm Password</label>--}}
    {{--                            <input type="password" class="form-control" id="confirm-password" name="confirm-password">--}}
    {{--                            <div class="invalid-feedback"></div>--}}

    {{--                        </div>--}}
    {{--                        <div class="modal-footer">--}}
    {{--                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>--}}
    {{--                            <button type="submit" class="btn btn-primary">Save changes</button>--}}
    {{--                        </div>--}}
    {{--                    </form>--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </div>--}}

@endsection

@section('script')

    <script>

        function getData( offset, limit ) {
            $.ajax ( {
                type: 'GET',
                url: '/users/data/' + offset + '/' + limit,
                success: function ( data ) {
                    $ ( '#users-data' ).html ( data )
                },
            } );
        }


        $ ( document ).ready ( function () {


            // $.ajaxSetup({
            //     headers: {
            //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //     }
            // });
            // $('#addUserForm').submit(function(e) {
            //     e.preventDefault();
            //     var name = $('#name').val();
            //     var email = $('#email').val();
            //     var password = $('#password').val();
            //     var role = $('#role').val();
            //     var sensor = $('#sensor').val();
            //
            //     $.ajax({
            //         type: 'POST',
            //         url: '/users/create',
            //         data: {
            //             name: name,
            //             email: email,
            //             password: password,
            //             role: role,
            //             sensor: sensor
            //         },
            //         success: function(data) {
            //             window.location.reload();
            //             $('#standard-modal').modal('hide');
            //             $('#success-alert-modal').modal('show');
            //
            //         },
            //         error: function(xhr, status, error) {
            //             console.error(xhr.responseText);
            //             var errors = xhr.responseJSON.errors;
            //             if (errors && errors.email) {
            //                 $('#email').addClass('is-invalid');
            //                 $('#email + .invalid-feedback').html(errors.email[0]);
            //                 $('#password').addClass('is-invalid');
            //                 $('#password + .invalid-feedback').html(errors.password[0]);
            //             }else{
            //                 $('#danger-alert-modal').modal('show');
            //             }
            //
            //         }
            //     });
            // });
            //
            //
            // $('.edit-user').click(function(e) {
            //     e.preventDefault();
            //     var userId = $(this).data('id');
            //     var row = $(this).closest('tr');
            //
            //     $.ajax({
            //         type: 'GET',
            //         url: '/users/edit/' + userId,
            //         success: function(data) {
            //             $('#edit-user-form').attr('action', '/users/update/' + userId);
            //             $('#edit-user-id').val(userId)
            //             $('#edit-name').val(data.name);
            //             $('#edit-email').val(data.email);
            //             $('#edit-role').val(data.role);
            //             $('#edit-sensor').empty();
            //             $.each(data.sensors, function(index, sensor) {
            //                 var option = new Option(sensor.name, sensor.id, true, true);
            //                 $('#edit-sensor').append(option).trigger('change');
            //             });
            //             $('#edit-user-modal').data('row', row);
            //         },
            //         error: function(xhr, status, error) {
            //             console.error(xhr.responseText);
            //             $('#danger-alert-modal').modal('show');
            //         }
            //     });
            // });
            //
            //
            // $('#edit-user-form').submit(function (e) {
            //     e.preventDefault();
            //     var userId = $('#edit-user-id').val()
            //     var name = $('#edit-name').val();
            //     var email = $('#edit-email').val();
            //     var role = $('#edit-role').val();
            //     var sensor = $('#edit-sensor').val();
            //     var row = $('#edit-user-modal').data('row');
            //
            //     $.ajax({
            //         type: 'POST',
            //         url: '/users/update/' + userId,
            //         data: {
            //             name: name,
            //             email: email,
            //             role: role,
            //             sensor: sensor
            //         },
            //         success: function(data) {
            //             $('#edit-user-modal').modal('hide');
            //             window.location.reload();
            //             $('#success-alert-modal').modal('show');
            //         },
            //         error: function(xhr, status, error) {
            //             console.error(xhr.responseText);
            //             var errors = xhr.responseJSON.errors;
            //             if (errors && errors.email) {
            //                 $('#email').addClass('is-invalid');
            //                 $('#email + .invalid-feedback').html(errors.email[0]);
            //             }else{
            //                 $('#danger-alert-modal').modal('show');
            //             }
            //
            //         }
            //     });
            // });
            //
            // $('#change-password-form').submit(function(e) {
            //     e.preventDefault();
            //     var userId = $(this).data('id');
            //     var currentPassword = $('#current-password').val();
            //     var newPassword = $('#new-password').val();
            //     var confirmPassword = $('#confirm-password').val();
            //
            //     if (newPassword !== confirmPassword) {
            //         $('#new-password').addClass('is-invalid');
            //         $('#confirm-password').addClass('is-invalid');
            //         $('#new-password + .invalid-feedback').html('passwords are not matches');
            //         $('#confirm-password + .invalid-feedback').html('passwords are not matches');
            //         return;
            //     }
            //
            //     $.ajax({
            //         type: 'POST',
            //         url: '/change-password',
            //         data: {
            //             id: userId,
            //             current_password: currentPassword,
            //             new_password: newPassword
            //         },
            //         success: function(data) {
            //             $('#change-password-modal').modal('hide');
            //             $('#success-alert-modal').modal('show');
            //         },
            //         error: function(xhr, status, error) {
            //             console.error(xhr.responseText);
            //                 $('#current-password').addClass('is-invalid')
            //                 $('#new-password + .invalid-feedback').html('current-password is false');
            //         }
            //     });
            // });
            //
            // $('.delete-user').click(function(e) {
            //     e.preventDefault();
            //     var userId = $(this).data('id');
            //     var row = $(this).closest('tr');
            //
            //     $.ajax({
            //         type: 'DELETE',
            //         url: '/users/delete/' + userId,
            //         success: function(data) {
            //             row.remove();
            //             $('#success-alert-modal').modal('show');
            //         },
            //         error: function(xhr, status, error) {
            //             console.error(xhr.responseText);
            //             $('#danger-alert-modal').modal('show');
            //         }
            //     });
            // });
        } );

    </script>
    <!-- Vendor js -->
    <script src="assets/js/vendor.min.js"></script>
    <!-- Datatables js -->
    <script src="{{ asset('assets/vendor/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js') }}"></script>
    <script
        src="{{ asset('assets/vendor/datatables.net-fixedcolumns-bs5/js/fixedColumns.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables.net-buttons-bs5/js/buttons.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables.net-buttons/js/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables.net-keytable/js/dataTables.keyTable.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables.net-select/js/dataTables.select.min.js') }}"></script>


    <!--  Select2 Plugin Js -->
    <script src="assets/vendor/select2/js/select2.min.js"></script>

    <!-- Datatable Demo Aapp js -->
    <script src="{{ asset('assets/js/pages/datatable.init.js') }}"></script>
@endsection


