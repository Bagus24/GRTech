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
                    <h1>Companies</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Companies</li>
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
        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <button type="button" class="btn btn-icon icon-left btn-primary" data-toggle="modal" data-target="#modal-add-company">
                    <i class="fas fa-plus"></i> Add Data
                </button>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Index</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Logo</th>
                            <th>Website</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($companies->count() > 0)
                        <?php $no = 0; ?>
                        @foreach($companies as $c)
                        <?php $no++; ?>
                        <tr>
                            <td>
                                {{ $no }}
                            </td>
                            <td>
                                {{ $c->name }}
                            </td>
                            <td>
                                {{ $c->email }}
                            </td>
                            <td>
                                <img alt="image" src="{{ asset('logo/'. $c->logo) }}" class="img-fluid" style="max-width: 100px; max-height: 100px;" data-toggle="tooltip">
                            </td>
                            <td>
                                <a target="_blank" href="{{ $c->website }}">{{ $c->website }}</a>
                            </td>
                            <td>
                                <button class="btn btn-icon btn-info" onclick="editData( <?php echo $c->id; ?>, '{{ $c->name }}', '{{ $c->email }}', '{{ $c->website }}' )" data-toggle="modal" data-target="#modal-edit-company"><i class="fas fa-pencil-alt"></i></button>
                                <button class="btn btn-icon btn-danger" onclick="deleteData( <?php echo $c->id; ?> )"><i class="fas fa-trash"></i></button>
                                <form id="data-{{ $c->id }}" action="{{ route('companies.destroy', $c->id)}}" method="post">
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

<div class="modal fade" id="modal-add-company">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Company</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('companies.store') }}" method="post" enctype="multipart/form-data" class="form-horizontal">
                    @csrf
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="inputName3" class="col-sm-2 col-form-label">Name</label>
                            <div class="col-sm-10">
                                <input name="name" type="text" class="form-control" id="inputName3" placeholder="Name" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-10">
                                <input name="email" type="email" class="form-control" id="inputEmail3" placeholder="Email" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputLogo3" class="col-sm-2 col-form-label">Logo</label>
                            <div class="col-sm-10">
                                <div class="custom-file">
                                    <input name="logo" type="file" class="custom-file-input" id="InputLogoEdit" accept="image/jpeg,image/jpg,image/png," required>
                                    <label class="custom-file-label" for="exampleInputFile">Choose File</label>
                                </div>
                            </div>
                        </div>
                        <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
                        <script type="text/javascript">
                            $('#InputLogoEdit').on('change', function() {
                                // Ambil nama file 
                                let fileName = $(this).val().split('\\').pop();
                                // Ubah "Choose a file" label sesuai dengan nama file yag akan diupload
                                $(this).next('.label-logo-edit').addClass("selected").html(fileName);
                            });
                        </script>
                        <div class="form-group row">
                            <label for="inputPassword3" class="col-sm-2 col-form-label">Website</label>
                            <div class="col-sm-10">
                                <input name="website" type="text" class="form-control" id="inputPassword3" placeholder="https://your_domain" required>
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

<div class="modal fade" id="modal-edit-company">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Company</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-edit-company" action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="inputName3" class="col-sm-2 col-form-label">Name</label>
                            <div class="col-sm-10">
                                <input id="company-name" name="name" type="text" class="form-control" placeholder="Name" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-10">
                                <input id="company-email" name="email" type="email" class="form-control" id="inputEmail3" placeholder="Email" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputLogo3" class="col-sm-2 col-form-label">Logo</label>
                            <div class="col-sm-10">
                                <div class="custom-file">
                                    <input name="logo" type="file" class="custom-file-input" id="InputLogo" accept="image/jpeg,image/jpg,image/png,">
                                    <label id="company-logo" class="custom-file-label" for="exampleInputFile">Choose File</label>
                                </div>
                            </div>
                        </div>
                        <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
                        <script type="text/javascript">
                            $('#InputLogo').on('change', function() {
                                // Ambil nama file 
                                let fileName = $(this).val().split('\\').pop();
                                // Ubah "Choose a file" label sesuai dengan nama file yag akan diupload
                                $(this).next('.custom-file-label').addClass("selected").html(fileName);
                            });
                        </script>
                        <div class="form-group row">
                            <label for="inputPassword3" class="col-sm-2 col-form-label">Website</label>
                            <div class="col-sm-10">
                                <input id="company-website" name="website" type="text" class="form-control" placeholder="domain" required>
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

    function editData(id, name, email, website) {
        document.getElementById('form-edit-company').action = `companies/${id}`;
        document.getElementById('company-name').value = name;
        document.getElementById('company-email').value = email;
        document.getElementById('company-website').value = website;

    }
</script>
@endsection