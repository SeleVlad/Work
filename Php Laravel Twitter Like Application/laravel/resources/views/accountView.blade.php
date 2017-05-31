@extends('layouts.master')
@section('title')
    Account
@endsection

@section('content')
    <section class="row new-post">
        <div class="col-md-6 col-md-offset-5">
            <header><h3>Account of {{ $user->first_name }}</h3></header>

        </div>
    </section>
    @if (Storage::disk('local')->has($user->first_name . '-' . $user->id . '.jpg'))
        <section class="row new-post">
            <div class="col-md-6 col-md-offset-3">
                <img src="{{ route('account.image', ['filename' => $user->first_name . '-' . $user->id . '.jpg']) }}"
                     alt="" class="img-responsive">
            </div>
        </section>
    @endif


    <section class="row posts">
        <div class="col-md-6 col-md-offset-5">
            <header><h3> {{ $user->first_name }}'s Posts</h3></header>
            @foreach($posts as $post)
                @if ($post->user->first_name == $user->first_name)
                    <article class="post" data-postid="{{ $post->id }}">
                        <p>{{ $post->body }}</p>
                        <div class="info">
                            Posted by {{ $post->user->first_name }} on {{ $post->created_at }}
                        </div>
                        <div class="interaction">
                            <a href="#" class="like">{{ Auth::user()->likes()->where('post_id', $post->id)->first() ? Auth::user()->likes()->where('post_id', $post->id)->first()->like == 1 ? 'Liked' : 'Like' : 'Like'  }}</a> |
                            <a href="#" class="like">{{ Auth::user()->likes()->where('post_id', $post->id)->first() ? Auth::user()->likes()->where('post_id', $post->id)->first()->like == 0 ? 'Disliked' : 'Dislike' : 'Dislike'  }}</a>
                            @if(Auth::user() == $post->user)
                                |
                                <a href="#" class="edit">Edit</a> |
                                <a href="{{ route('post.delete' , ['post_id' => $post->id]) }}">Delete</a>
                            @endif


                        </div>
                    </article>
                @endif
            @endforeach
        </div>
    </section>
@endsection