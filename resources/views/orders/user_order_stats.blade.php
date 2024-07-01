@extends('layouts.main')

@section('title', 'User Order Stats')



@section('content')
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>User Order Stats</h2>
            <a href="{{ route('orders.create') }}" class="btn btn-primary">Add New Order</a>
        </div>
        <table class="table table-bordered table-striped table-hover">
            <thead class="thead-dark">
                <tr>
                    <th class="text-center">User Name</th>
                    <th class="text-center">User Registration Time</th>
                    <th class="text-center">Number of Purchases</th>
                    <th class="text-center">Last Purchase Date</th>
                    <th class="text-center">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td class="text-center">{{ $user->user_name }}</td>
                        <td class="text-center">{{ $user->user_registration_time }}</td>
                        <td class="text-center">{{ $user->number_of_purchases }}</td>
                        <td class="text-center">{{ $user->last_purchase_date ? $user->last_purchase_date : 'N/A' }}</td>
                        <td class="text-center">{{ $user->status }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
