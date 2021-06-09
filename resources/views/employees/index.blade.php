@extends('layouts.app')

@section('content')

@if (Session::has('add_data'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Success!',
        showConfirmButton: false,
        timer: 2000
    })
</script>
@endif
@if (Session::has('edit_data'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Success!',
        showConfirmButton: false,
        timer: 2000
    })
</script>
@endif
@if (Session::has('delete_data'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Success!',
        showConfirmButton: false,
        timer: 2000
    })
</script>
@endif

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Employees</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Employees</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>


    <!-- Main content -->
    <section class="content">
        @foreach ($errors->all() as $error)
        <div class="alert alert-danger alert-dismissible show fade">
            <div class="alert-body">
                <button class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
                {{ $error }}
            </div>
        </div>
        @endforeach
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Filter</h3>
            </div>
            <form class="form-horizontal" action="{{ url('filter-employee') }}" method="GET">
                @csrf
                <div class="card-body">
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Date Added</label>
                        <div class="col-sm-10">
                            <div class="row">
                                <div class="col-6">
                                    <input name="date_form" type="date" class="form-control" placeholder="date">
                                </div>
                                <div class="col-6">
                                    <input name="date_to" type="date" class="form-control" placeholder="date">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword3" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input name="email" type="email" class="form-control" id="inputPassword3" placeholder="email" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword3" class="col-sm-2 col-form-label">First Name</label>
                        <div class="col-sm-10">
                            <input name="first_name" type="text" class="form-control" id="inputPassword3" placeholder="first name" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword3" class="col-sm-2 col-form-label">Last Name</label>
                        <div class="col-sm-10">
                            <input name="last_name" type="text" class="form-control" id="inputPassword3" placeholder="last name" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword3" class="col-sm-2 col-form-label">Company</label>
                        <div class="col-sm-10">
                            <select name="company" class="custom-select" required>
                                @foreach ($companies as $c)
                                <option value="{{ $c->id }}">{{ $c->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary float-right">Filter Data</button>
                </div>
                <!-- /.card-footer -->
            </form>

        </div>
        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <button type="button" class="btn btn-icon icon-left btn-primary" data-toggle="modal" data-target="#modal-add-employe">
                    <i class="fas fa-plus"></i> Add Data
                </button>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Index</th>
                            <th>Full Name</th>
                            <th>Company</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($employees->count() > 0)
                        <?php $no = 0; ?>
                        @foreach($employees as $e)
                        <?php $no++; ?>
                        <tr>
                            <td>
                                {{ $no }}
                            </td>
                            <td>
                                {{ $e->full_name }}
                            </td>
                            <td>
                                <a class="detail_company" data-id="{{ $e->company }}" href="#" data-toggle="modal" data-target="#modal-detail-company">Detail</a>
                            </td>
                            <td>
                                {{ $e->email }}
                            </td>
                            <td>
                                {{ $e->phone }}
                            </td>
                            <td>
                                <button class="btn btn-icon btn-info" onclick="editData( <?php echo $e->id; ?>, '{{ $e->first_name }}', '{{ $e->last_name }}', <?php echo $e->company ?>, '{{ $e->email }}', '{{ $e->phone }}')" data-toggle="modal" data-target="#modal-edit-employe"><i class="fas fa-pencil-alt"></i></button>
                                <button class="btn btn-icon btn-danger" onclick="deleteData( <?php echo $e->id; ?> )"><i class="fas fa-trash"></i></button>
                                <form id="data-{{ $e->id }}" action="{{ route('employees.destroy', $e->id)}}" method="post">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td></td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td></td>
                        </tr>
                        @endif
                    </tbody>

                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->
</div>

<div class="modal fade" id="modal-add-employe">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Employee</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('employees.store') }}" method="post" class="form-horizontal">
                    @csrf
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="inputName3" class="col-sm-2 col-form-label">First Name</label>
                            <div class="col-sm-10">
                                <input name="first_name" type="text" class="form-control" id="inputName3" placeholder="First name" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputName3" class="col-sm-2 col-form-label">Last Name</label>
                            <div class="col-sm-10">
                                <input name="last_name" type="text" class="form-control" id="inputName3" placeholder="Last name" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputName3" class="col-sm-2 col-form-label">Company</label>
                            <div class="col-sm-10">
                                <select name="company" class="custom-select" required>
                                    @foreach ($companies as $c)
                                    <option value="{{ $c->id }}">{{ $c->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-10">
                                <input name="email" type="email" class="form-control" id="inputEmail3" placeholder="Email" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputPassword3" class="col-sm-2 col-form-label">Phone</label>
                            <div class="col-sm-10">
                                <input pattern="[0-9+]+" name="phone" type="text" class="form-control" id="inputPassword3" placeholder="phone" required>
                            </div>
                        </div>
                    </div>

            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal-edit-employe">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Employee</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-edit-employee" action="" method="post" class="form-horizontal">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="inputName3" class="col-sm-2 col-form-label">First Name</label>
                            <div class="col-sm-10">
                                <input id="employee-first_name" name="first_name" type="text" class="form-control" id="inputName3" placeholder="First name" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputName3" class="col-sm-2 col-form-label">Last Name</label>
                            <div class="col-sm-10">
                                <input id="employee-last_name" name="last_name" type="text" class="form-control" id="inputName3" placeholder="Last name" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputName3" class="col-sm-2 col-form-label">Company</label>
                            <div class="col-sm-10">
                                <select id="select_company" name="company" class="custom-select" required>

                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-10">
                                <input id="employee-email" name="email" type="email" class="form-control" id="inputEmail3" placeholder="Email" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputPassword3" class="col-sm-2 col-form-label">Phone</label>
                            <div class="col-sm-10">
                                <input id="employee-phone" pattern="[0-9+]+" name="phone" type="text" class="form-control" id="inputPassword3" placeholder="phone" required>
                            </div>
                        </div>
                    </div>

            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal-detail-company">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Detail Company</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-12 col-sm-6 col-md-12 d-flex align-items-stretch flex-column">
                    <div class="card bg-light d-flex flex-fill">
                        <div class="card-header text-muted border-bottom-0">


                        </div>
                        <div class="card-body pt-0">
                            <div class="row">
                                <div class="col-7">
                                    <h2 class="lead"><b id="show-company-name"></b></h2>

                                    <ul class="ml-4 mb-0 fa-ul text-muted">
                                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-envelope"></i></span> <span id="show-company-email"></span></li>
                                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-globe"></i></span> <span id="show-company-website"></span></li>
                                    </ul>
                                </div>
                                <div class="col-5 text-center">
                                    <img id="show-company-logo" src="" alt="user-avatar" class="img-fluid">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<script type="text/javascript">
    function deleteData(id) {
        Swal.fire({
            title: 'Are you sure?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#007bff',
            cancelButtonColor: '#dc3545',
            confirmButtonText: 'Yes',
            cancelButtonText: 'No'
        }).then((result) => {
            if (result.value) {
                $('#data-' + id).submit();
            }
        })

    }

    function editData(id, first_name, last_name, company, email, phone) {
        document.getElementById('form-edit-employee').action = `employees/${id}`;
        document.getElementById('employee-first_name').value = first_name;
        document.getElementById('employee-last_name').value = last_name;
        document.getElementById('employee-email').value = email;
        document.getElementById('employee-phone').value = phone;

        var id_company = company;
        var option_company = '';
        var selected = '';
        $.ajax({
            url: `/employees/${id}`,
            method: "GET",
            success: function(data) {
                $.each(data, function(index, item) {
                    if (id_company == item.id) {
                        selected = 'selected';
                    } else {
                        selected = '';
                    }
                    option_company = option_company + '<option value="' + item.id + '" ' + selected + '>' + item.name + '</option>';
                })
                $("#select_company").html(option_company);
            },

        })

    }

    $('.detail_company').on('click', function() {

        var id = $(this).data('id');

        $.ajax({
            url: `/companies/${id}`,
            method: "GET",
            success: function(data) {

                document.getElementById('show-company-name').innerHTML = data.name;
                document.getElementById('show-company-email').innerHTML = data.email;
                document.getElementById('show-company-website').innerHTML = data.website;
                document.getElementById('show-company-logo').src = `{{ asset('logo/` + data.logo + `') }}`;

            },
            error: function(data) {
                console.log(error)
            }
        })
    })
</script>
@endsection