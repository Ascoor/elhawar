<script>
    $.ajax({
        type: 'GET',
        url:`{{ route('admin.members.select-user', 'false') }}` ,
        success: function (response) {
            if (response) {
                console.log('VIEW: ', response);
                $('#selectUser').html(response.view);
            }
        }
    });
</script>
