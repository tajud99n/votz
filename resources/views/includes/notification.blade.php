<script>
     @if (Session::has('success')) 
          toastr.success("{{ Session::get('success') }}")
     @endif
</script>