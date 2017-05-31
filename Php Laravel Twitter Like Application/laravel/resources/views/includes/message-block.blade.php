@if(count($errors)>0)

    <div class="row">
                @foreach($errors->all() as $error)
            <div class="alert alert-danger alert-dismissable fade in col-md-4 col-md-offset-4 error">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>{{$error}}</strong>
            </div>
                @endforeach
    </div>


@endif

@if(Session::has('message'))

    <div class="row">
            <div class="alert alert-success alert-dismissable fade in col-md-4 col-md-offset-4 succes">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong>{{ Session::get('message') }}</strong>
            </div>
    </div>
    <script>console.log("OK")</script>
@endif


@if(Session::has('flash_message'))
    <div class="alert alert-danger alert-dismissable fade in col-md-4 col-md-offset-4 error">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>{!! session('flash_message') !!}</strong>
    </div>
@endif