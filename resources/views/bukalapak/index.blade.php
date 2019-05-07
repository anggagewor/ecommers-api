@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            Bukalapak Product
                        </h3>
                    </div>
                    <div class="card-body row" style="border-bottom: 1px solid #ddd">
                        <div class="col-md-6">
                            <select name="category" id="bukalapak-category" class="form-control">
                                <option value="0">-- Select Category --</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <nav>
                                <ul class="pagination" id="bukalapak-page">

                                </ul>
                            </nav>
                        </div>
                    </div>
                    <div id="table-hide" style="display: none;">
                        <div class="card-body row">
                            <div class="col-md-3">
                                <select name="" id="bukalapak-filter-limit" class="form-control">
                                    <option value="20">20</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <div class="input-group mb-3">
                                    <select name="" id="bukalapak-page" class="form-control"></select>
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="bukalapak-total-item"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <table class="table card-table table-vcenter"
                               id="bukalapak-product">
                            <thead>
                            <tr>
                                <th colspan="2">Product</th>
                                <th>Price</th>
                                <th>Seller</th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    <div id="loading-table" class="text-center" style="display: none;">
                        <img src="{{asset('Bars-1s-200px.gif')}}" height="50">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        require(['jquery'], function ($) {
            $(document).ready(function () {
                $.getJSON('{{route('api.v1.bukalapak.categories')}}', function (data) {
                    $('#bukalapak-category').empty();
                    $('#bukalapak-category').append('<option value="0">-- Select Category --</option>')
                    $.each(data.data, function (i, v) {
                        $('#bukalapak-category').append('<optgroup label="' + v.name + '">')
                        $('#bukalapak-category').append('<option value="' + v.id + '">' + v.name + '</option>')
                        $.each(v.children, function (a, b) {
                            $('#bukalapak-category').append('<option value="' + b.id + '">' + b.name + '</option>')
                        })
                        $('#bukalapak-category').append('</optgroup>')
                    })
                })

                $('#bukalapak-category').change(function () {
                    if($(this).val() !== 0 || $(this).val() !== '0'){
                        $('#loading-table').show()
                        $('#table-hide').hide()
                        $('#bukalapak-product > tbody').empty()
                        $.getJSON('{{route('api.v1.bukalapak.categories')}}/'+$(this).val(), function (data){
                            var total_page = parseInt(data.meta.total) / parseInt(data.meta.limit)
                            $('#bukalapak-total-item').html('/ '+Math.ceil(total_page)+' Pages')
                            $('#bukalapak-page').empty()

                            $('#loading-table').hide()
                            $('#table-hide').show()
                            $.each(data.data, function (i,v){
                                $('#bukalapak-product > tbody').append(''
                                +'<tr>'
                                    +'<td>'
                                    +'<img src="'+v.images.small_urls[0]+'" alt="" class="img-thumbnail">'
                                    +'</td>'
                                    +'<td>'
                                    +v.name
                                    +'<br>'
                                    +'Kondisi: <span class="badge badge-info">'+v.condition+'</span>&nbsp;'
                                    +'Berminat: <span class="badge badge-info">'+v.stats.interest_count+'</span>&nbsp;'
                                    +'Terjual: <span class="badge badge-info">'+v.stats.sold_count+'</span>&nbsp;'
                                    +'Dilihat: <span class="badge badge-info">'+v.stats.view_count+'</span>'
                                    +'</td>'
                                    +'<td>'
                                    +v.price
                                    +'</td>'
                                    +'<td>'
                                    +v.store.name
                                    +'<br>'
                                    +v.store.address.city
                                    +'</td>'
                                +'</tr>'
                                )

                            })
                        })
                    }
                })
            })

            $('#bukalapak-filter-limit').change(function (){
                $('#loading-table').show()
                $('#bukalapak-product').hide()
                $('#bukalapak-product > tbody').empty()
                $.getJSON('{{route('api.v1.bukalapak.categories')}}/'+$('#bukalapak-category').val()+'?limit='+$(this).val(), function (data){
                    var total_page = parseInt(data.meta.total) / parseInt(data.meta.limit)
                    $('#bukalapak-total-item').html('/ '+Math.ceil(total_page)+' Pages')
                    $("#bukalapak-page").attr("max",Math.ceil(total_page));
                    $('#loading-table').hide()
                    $('#bukalapak-product').show()
                    $.each(data.data, function (i,v){
                        $('#bukalapak-product > tbody').append(''
                            +'<tr>'
                            +'<td>'
                            +'<img src="'+v.images.small_urls[0]+'" alt="" class="img-thumbnail">'
                            +'</td>'
                            +'<td>'
                            +v.name
                            +'<br>'
                            +'Kondisi: <span class="badge badge-info">'+v.condition+'</span>&nbsp;'
                            +'Berminat: <span class="badge badge-info">'+v.stats.interest_count+'</span>&nbsp;'
                            +'Terjual: <span class="badge badge-info">'+v.stats.sold_count+'</span>&nbsp;'
                            +'Dilihat: <span class="badge badge-info">'+v.stats.view_count+'</span>'
                            +'</td>'
                            +'<td>'
                            +v.price
                            +'</td>'
                            +'<td>'
                            +v.store.name
                            +'<br>'
                            +v.store.address.city
                            +'</td>'
                            +'</tr>'
                        )

                    })
                })
            })
        });
    </script>
@endsection
