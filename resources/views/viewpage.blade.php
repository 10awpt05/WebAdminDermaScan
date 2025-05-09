@extends('mainapp')

@section('title', 'DermaScan Admin')

@section('content')
    <h2>Tabbed Tables</h2>

    <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="users-tab" data-bs-toggle="tab" data-bs-target="#users" type="button" role="tab">Users</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="products-tab" data-bs-toggle="tab" data-bs-target="#products" type="button" role="tab">Products</button>
        </li>
    </ul>

    <div class="tab-content" id="myTabContent">

        <div class="tab-pane fade show active" id="users" role="tabpanel">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr><th>Name</th><th>Email</th></tr>
                </thead>
                <tbody>
                    <tr><td>Juan Dela Cruz</td><td>juan@example.com</td></tr>
                    <tr><td>Maria Clara</td><td>maria@example.com</td></tr>
                </tbody>
            </table>
        </div>


        <div class="tab-pane fade" id="products" role="tabpanel">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr><th>Product</th><th>Price</th></tr>
                </thead>
                <tbody>
                    <tr><td>Sabon</td><td>₱50</td></tr>
                    <tr><td>Shampoo</td><td>₱80</td></tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
