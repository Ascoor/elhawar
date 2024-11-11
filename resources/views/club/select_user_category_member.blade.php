<script>
    $.ajax({
        type: 'GET',
        url:`{{ route('admin.members.select-user', 'true') }}` ,
        success: function (response) {
            if (response) {
                $('#selectUser').html(response.view);
            }
        }
    });
</script>
