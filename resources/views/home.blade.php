@extends('layouts.app')

@section('content')
    <div class="px-4 pt-5 my-5 text-center">
        <h1 class="display-4 fw-bold">Olabola</h1>
        <div class="col-lg-6 mx-auto">
            <p class="lead mb-4">Quickly design and customize responsive mobile-first sites with Bootstrap, the world’s most
                popular front-end open source toolkit, featuring Sass variables and mixins, responsive grid system,
                extensive prebuilt components, and powerful JavaScript plugins.</p>
            <div class="d-grid gap-2 d-sm-flex justify-content-sm-center mb-5">
                <a href="/dashboard"><button type="button" class="btn btn-primary btn-lg px-4 me-sm-3">Explore Now</button></a>
                <a href="/faq"><button type="button" class="btn btn-secondary btn-lg px-4">Learn More</button></a>
            </div>
        </div>
        <div class="overflow-hidden" style="max-height: 30vh;">
            <div class="container px-5">
                <img src="bootstrap-docs.png" class="img-fluid border rounded-3 shadow-lg mb-4" alt="Example image"
                    width="700" height="500" loading="lazy">
            </div>
        </div>
    </div>
@endsection
