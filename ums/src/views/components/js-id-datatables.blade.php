<script>
    $(document).ready(function () {
        // Setup - add a text input to each footer cell
        $('#{{$id}} thead tr').clone(true).appendTo('#{{$id}} thead');
        $('#{{$id}} thead tr:eq(1) th').each(function (i) {
            var title = $(this).text();
            $(this).html('<input type="text" placeholder="Search ' + title + '" />');

            $('input', this).on('keyup change', function () {
                if (table.column(i).search() !== this.value) {
                    table
                        .column(i)
                        .search(this.value)
                        .draw();
                }
            });
        });

        var table = $('#{{$id}}').DataTable({
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 25
        });
    });
</script>
