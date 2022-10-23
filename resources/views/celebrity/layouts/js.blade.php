<script src="http://code.jquery.com/jquery-3.4.1.js"></script>
<script>
    $(document).ready(function () {
        $('#sub_category_name').on('change', function () {
            let id = $(this).val();
            $('#sub_category').empty();
            $('#sub_category').append(`<option value="0" disabled selected>Processing...</option>`);
            $.ajax({
                type: 'GET',
                {{--url:'{{route("admin/GetSubCatAgainstMainCatEdit/")}}',--}}
                url: '/celebrity/GetSubCatAgainstMainCatEdit/' + id,
                success: function (response) {
                    var response = JSON.parse(response);
                    console.log(response);
                    $('#sub_category').empty();
                    // $('#sub_category').append(`<option value="0" disabled selected>Select Sub Category*</option>`);
                    response.forEach(element => {
                        $('#sub_category').append(`<option value="${element['id']}">${element['name']}</option>`);
                    });
                }
            });
        });
    });
</script>
<!-- Back-to-top -->
<a href="#top" id="back-to-top"><i class="las la-angle-double-up"></i></a>

<!-- JQuery min js -->
{{--<script src="{{asset('assets/plugins/jquery/jquery.min.js')}}"></script>--}}

<!-- Bootstrap Bundle js -->
<script src="{{asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

<!--Internal  Chart.bundle js -->
<script src="{{asset('assets/plugins/chart.js/Chart.bundle.min.js')}}"></script>

<!-- Ionicons js -->
<script src="{{asset('assets/plugins/ionicons/ionicons.js')}}"></script>

<!-- Moment js -->
<script src="{{asset('assets/plugins/moment/moment.js')}}"></script>

<!--Internal Sparkline js -->
<script src="{{asset('assets/plugins/jquery-sparkline/jquery.sparkline.min.js')}}"></script>

<!-- Moment js -->
<script src="{{asset('assets/plugins/raphael/raphael.min.js')}}"></script>

<!--Internal  Flot js-->
<script src="{{asset('assets/plugins/jquery.flot/jquery.flot.js')}}"></script>
<script src="{{asset('assets/plugins/jquery.flot/jquery.flot.pie.js')}}"></script>
<script src="{{asset('assets/plugins/jquery.flot/jquery.flot.resize.js')}}"></script>
<script src="{{asset('assets/plugins/jquery.flot/jquery.flot.categories.js')}}"></script>
<script src="{{asset('assets/js/dashboard.sampledata.js')}}"></script>
<script src="{{asset('assets/js/chart.flot.sampledata.js')}}"></script>

<!-- Custom Scroll bar Js-->
<script src="{{asset('assets/plugins/mscrollbar/jquery.mCustomScrollbar.concat.min.js')}}"></script>

{{--<!--Internal Apexchart js-->--}}
{{--<script src="{{asset('assets/js/apexcharts.js')}}"></script>--}}

<!-- Rating js-->
<script src="{{asset('assets/plugins/rating/jquery.rating-stars.js')}}"></script>
<script src="{{asset('assets/plugins/rating/jquery.barrating.js')}}"></script>

<!--Internal  Perfect-scrollbar js -->
{{--<script src="{{asset('assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>--}}
{{--<script src="{{asset('assets/plugins/perfect-scrollbar/p-scroll.js')}}"></script>--}}

<!-- Eva-icons js -->
<script src="{{asset('assets/js/eva-icons.min.js')}}"></script>

<!-- right-sidebar js -->
{{--<script src="{{asset('assets/plugins/sidebar/sidebar.js')}}"></script>--}}
<script src="{{asset('assets/plugins/sidebar/sidebar-custom.js')}}"></script>

<!-- Sticky js -->
<script src="{{asset('assets/js/sticky.js')}}"></script>
<script src="{{asset('assets/js/modal-popup.js')}}"></script>

<!-- Left-menu js-->
<script src="{{asset('assets/plugins/side-menu/sidemenu.js')}}"></script>

<!-- Internal Map -->
<script src="{{asset('assets/plugins/jqvmap/jquery.vmap.min.js')}}"></script>
<script src="{{asset('assets/plugins/jqvmap/maps/jquery.vmap.usa.js')}}"></script>

<!--Internal  index js -->
{{--<script src="{{asset('assets/js/index-dark.js')}}"></script>--}}

{{--<!-- Apexchart js-->--}}
{{--<script src="{{asset('assets/js/apexapexcharts.js')}}"></script>--}}

<!-- custom js -->
<script src="{{asset('assets/js/custom.js')}}"></script>
<script src="{{asset('assets/js/jquery.vmap.sampledata.js')}}"></script>

<script src="{{asset('assets/plugins/fileuploads/js/fileupload.js')}}"></script>
<script src="{{asset('assets/plugins/fileuploads/js/file-upload.js')}}"></script>

<!--Internal Fancy uploader js-->
<script src="{{asset('assets/plugins/fancyuploder/jquery.ui.widget.js')}}"></script>
<script src="{{asset('assets/plugins/fancyuploder/jquery.fileupload.js')}}"></script>
<script src="{{asset('assets/plugins/fancyuploder/jquery.iframe-transport.js')}}"></script>
<script src="{{asset('assets/plugins/fancyuploder/jquery.fancy-fileupload.js')}}"></script>
<script src="{{asset('/assets/plugins/fancyuploder/fancy-uploader.js')}}"></script>

