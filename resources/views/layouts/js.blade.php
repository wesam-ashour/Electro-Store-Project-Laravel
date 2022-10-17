<!-- jQuery Plugins -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>

{{--<script src="{{asset('assets/home/js/jquery.min.js')}}"></script>--}}
<script src="{{asset('assets/home/js/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/home/js/slick.min.js')}}"></script>
<script src="{{asset('assets/home/js/nouislider.min.js')}}"></script>
<script src="{{asset('assets/home/js/jquery.zoom.min.js')}}"></script>
<script src="{{asset('assets/home/js/main.js')}}"></script>

<script type="text/javascript">
    $(document).ready(function(){
        $("#category").on('change',function (){
            var category = $(this).val();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:"get",
            url: "{{ route('filter.view') }}",
            cache:"false",
            data:{'category':category},
            datatype:"html",
            success:function (data) {
                $('.viewRender').html(data.html);
            }
        });
        });
    });
</script>
<script type="text/javascript">
    $(".update-cart").change(function (e) {
        e.preventDefault();
        var myspan = document.getElementById('myspan');
        var myid = document.getElementById('myid');
        var inputValue = $('#qty').val();
        var ele = $(this);
        $.ajax({
            url: '{{ route('update.cart') }}',
            method: "patch",
            data: {
                _token: '{{ csrf_token() }}',
                idItem: myid.getAttribute('data-item-id'),
                idCart: myspan.getAttribute('data-cart-id'),
                quantity: inputValue,
            },
            success: function (response) {
                window.location.reload();
            }
        });
    });
    $(".remove-from-cart").click(function (e) {

        e.preventDefault();



        var ele = $(this);
        var myid = document.getElementById('myid');


        if(confirm("Are you sure want to remove?")) {

            $.ajax({

                url: '{{ route('remove.from.cart') }}',

                method: "DELETE",

                data: {

                    _token: '{{ csrf_token() }}',

                    id: myid.getAttribute('data-item-id'),

                },

                success: function (response) {

                    window.location.reload();

                }

            });

        }

    });
</script>
