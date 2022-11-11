@extends('layouts.master')
@section('content')
    <br>
    <div class="main-body">
        <div class="row">
            <div class="container">
                <div class="mbr-overlay" style="opacity: 0.3; background-color: rgb(255, 255, 255);">
                </div>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="card col-12 col-md-12 col-lg-12">
                            <div class="card-wrapper">
                                <div class="card-box align-center">
                                    <h1 class="card-title mbr-fonts-style mb-3 display-1">
                                        <strong>About us</strong>
                                    </h1>
                                    <p class="mbr-text mbr-fonts-style display-7">Click any text to edit or style it. Select
                                        text to insert a link. Click blue "Gear" icon in the top right corner to hide/show
                                        buttons,
                                        text, title and change the block background. Click red "+" in the bottom right
                                        corner to add
                                        a new block. Use the top left menu to create new pages, sites and add themes.</p>
                                    <p class="mbr-text mbr-fonts-style display-7">Click any text to edit or style it. Select
                                        text to insert a link. Click blue "Gear" icon in the top right corner to hide/show
                                        buttons,
                                        text, title and change the block background. Click red "+" in the bottom right
                                        corner to add
                                        a new block. Use the top left menu to create new pages, sites and add themes.</p>
                                    <p class="mbr-text mbr-fonts-style display-7">Click any text to edit or style it. Select
                                        text to insert a link. Click blue "Gear" icon in the top right corner to hide/show
                                        buttons,
                                        text, title and change the block background. Click red "+" in the bottom right
                                        corner to add
                                        a new block. Use the top left menu to create new pages, sites and add themes.</p>
                                    <div class="mbr-section-btn mt-3">
                                        <a class="btn btn-secondary-outline display-4"
                                            href="{{ route('product.view') }}">Shop ow &gt;</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
