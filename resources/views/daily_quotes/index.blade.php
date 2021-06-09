@extends('layouts.app')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Daily Quotes</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Daily Quotes</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <button onClick="document.location.reload(true)" class="btn btn-default">Refresh</button>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            
                            <th>Question</th>
                            <th>Answer</th>
                            <th>H</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                       
                        @foreach($dailyquotes as $d)
                       
                        <tr>
                            
                            <td>
                                {{ $d['q'] }}
                            </td>
                            <td>
                            {{ $d['a'] }}
                            </td>
                            <td>
                            <?php
                                echo $d['h'];
                            ?>
                            </td>
                            <td>
                                
                            </td>
                            
                        </tr>
                        @endforeach
                        
                    </tbody>

                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->
</div>

@endsection