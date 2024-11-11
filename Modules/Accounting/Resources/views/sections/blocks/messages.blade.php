@if(session()->get('success'))
<div class="alert alert-success"  {{__('accounting::modules.accounting.rtl')}}>
  {{ session()->get('success') }}
</div><br />
@endif

@if ($errors->any())
    <div class="alert alert-danger"  {{__('accounting::modules.accounting.rtl')}}>
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
    </div><br />
@endif
