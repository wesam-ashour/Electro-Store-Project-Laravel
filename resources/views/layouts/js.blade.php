
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
<script type="text/javascript">
    // $(".update-cart").change(function(e) {
    //     e.preventDefault();
    //     var myspan = document.getElementById('myspan');
    //     var myid = document.getElementById('myid');
    //     var inputValue = $('#qty').val();
    //     var ele = $(this);
    //     $.ajax({
    //         url: ,
    //         method: "patch",
    //         data: {
    //             _token: '{{ csrf_token() }}',
    //             idItem: myid.getAttribute('data-item-id'),
    //             idCart: myspan.getAttribute('data-cart-id'),
    //             quantity: inputValue,
    //         },
    //         success: function(response) {
    //             window.location.reload();
    //         }
    //     });
    // });
    // $(".remove-from-cart").click(function(e) {

    //     e.preventDefault();



    //     var ele = $(this);
    //     var myid = document.getElementById('myid');


    //     if (confirm("Are you sure want to remove?")) {

    //         $.ajax({

    //             url: '{{ route('remove.from.cart') }}',

    //             method: "DELETE",

    //             data: {

    //                 _token: '{{ csrf_token() }}',

    //                 id: myid.getAttribute('data-item-id'),

    //             },

    //             success: function(response) {

    //                 window.location.reload();

    //             }

    //         });

    //     }

    // });
</script>

<script type="text/javascript" src="https://js.stripe.com/v3/"></script>

<script type="text/javascript">
    $(function() {

        var $form = $(".require-validation");

        $('form.require-validation').bind('submit', function(e) {
            var $form = $(".require-validation"),
                inputSelector = ['input[type=email]', 'input[type=password]',
                    'input[type=text]', 'input[type=file]',
                    'textarea'
                ].join(', '),
                $inputs = $form.find('.required').find(inputSelector),
                $errorMessage = $form.find('div.error'),
                valid = true;
            $errorMessage.addClass('hide');

            $('.has-error').removeClass('has-error');
            $inputs.each(function(i, el) {
                var $input = $(el);
                if ($input.val() === '') {
                    $input.parent().addClass('has-error');
                    $errorMessage.removeClass('hide');
                    e.preventDefault();
                }
            });

            if (!$form.data('cc-on-file')) {
                e.preventDefault();
                Stripe.setPublishableKey($form.data('stripe-publishable-key'));
                Stripe.createToken({
                    number: $('.card-number').val(),
                    cvc: $('.card-cvc').val(),
                    exp_month: $('.card-expiry-month').val(),
                    exp_year: $('.card-expiry-year').val()
                }, stripeResponseHandler);
            }

        });

        function stripeResponseHandler(status, response) {
            if (response.error) {
                $('.error')
                    .removeClass('hide')
                    .find('.alert')
                    .text(response.error.message);
            } else {
                /* token contains id, last4, and card type */
                var token = response['id'];

                $form.find('input[type=text]').empty();
                $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
                $form.get(0).submit();
            }
        }

    });
</script>

<script>

    var stripe = Stripe('pk_test_51LrHn8Lw9BmBv7zEj9Nhvon7h7k71ln6r7Xo97j08cMhN8BBbKPFLg2lpHUfrFZn1yVX4UYaefZfyo5wH6eN1aTe00r2rEXJkE');
    
    var elements = stripe.elements();
    
    var card = elements.create('card');
    
    // Add an instance of the card UI component into the `card-element` <div>
    
    card.mount('#card-element');
    
    </script>
