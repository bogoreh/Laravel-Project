@extends('layout.app')

@section('content')
<div class="container">
    <h1 class="text-center mb-5">Pacman Videos</h1>
    
    <div class="row">
        @foreach($videos as $video)
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h4>{{ $video['title'] }}</h4>
                </div>
                <div class="card-body">
                    <div class="video-container">
                        <iframe src="{{ $video['url'] }}" 
                                frameborder="0" 
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                allowfullscreen>
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    
    <div class="row mt-5">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>About Pacman</h3>
                </div>
                <div class="card-body">
                    <p>Pac-Man is an arcade video game first released in 1980. The player controls Pac-Man, who must eat all the dots inside an enclosed maze while avoiding four colored ghosts.</p>
                    <p>The game was created by Japanese video game designer Toru Iwatani. It spawned many sequels and is considered one of the most iconic video games of all time.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection