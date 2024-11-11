@extends('accounting::layouts.DTList')

{{-- Needed Routes --}}
@section('createRoute'){{ route('admin.accounting.assetsdeprecations.create') }}@endsection
@section('destroyRoute'){{route('admin.accounting.assetsdeprecations.delete')}}@endsection

