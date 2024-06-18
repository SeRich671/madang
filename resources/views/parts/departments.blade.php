<div class="container p-2 my-4 bg-white">
    <div class="row">
        <div class="col-lg-12 text-uppercase pt-2 mt-2 text-primary">
            <h3 class="fw-bold">Wybierz interesujący ciebie dział</h3>
            <hr>
        </div>
        @foreach($departments as $department)
            <div class="col-lg-3 mt-2">
                @include('parts.department-card', ['department' => $department])
            </div>
        @endforeach
    </div>
</div>
