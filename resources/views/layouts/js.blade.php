<!-- jQuery Plugins -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>

{{-- <script src="{{asset('assets/home/js/jquery.min.js')}}"></script> --}}
<script src="{{ asset('assets/home/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/home/js/slick.min.js') }}"></script>
<script src="{{ asset('assets/home/js/nouislider.min.js') }}"></script>
<script src="{{ asset('assets/home/js/jquery.zoom.min.js') }}"></script>
<script src="{{ asset('assets/home/js/main.js') }}"></script>

<script type="text/javascript">
    var url = "{{ route('changeLang') }}";



    $(".changeLang").change(function() {

        window.location.href = url + "?lang=" + $(this).val();

    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $("#category").on('change', function() {
            var category = $(this).val();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "get",
                url: "{{ route('filter.view') }}",
                cache: "false",
                data: {
                    'category': category
                },
                datatype: "html",
                success: function(data) {
                    $('.viewRender').html(data.html);
                }
            });
        });
    });
</script>


<script src="https://js.stripe.com/v3/"></script>

<script>
    var stripe = Stripe(
        'pk_test_51LrHn8Lw9BmBv7zEj9Nhvon7h7k71ln6r7Xo97j08cMhN8BBbKPFLg2lpHUfrFZn1yVX4UYaefZfyo5wH6eN1aTe00r2rEXJkE'
        );

    var elements = stripe.elements();

    var card = elements.create('card');

    // Add an instance of the card UI component into the `card-element` <div>

    card.mount('#card-element');
</script>
