<!-- {{-- @if(!@empty(session('success')))
    <p class="text-success" role="alert">{{ session('success') }}</p>
@endif

@if(!@empty(session('error')))
    <p class="text-danger" role="alert">{{ session('error') }}</p>
@endif --}} -->

<script>
    @if(session('success'))
    swal("Success", "{{ session('success') }}", "success");
    @endif

    @if(session('error'))
    swal("Error", "{{ session('error') }}", "error");
    @endif
</script>