<script>
    $.ajax({
        type: 'GET',
        url:`{{ route('admin.members.select-client-member', 'false') }}` ,
        success: function (response) {
            if (response) {
                console.log('VIEW: ', response);
                $('#selectClientMember').html(response.view);
            }
        }
    });
</script>
