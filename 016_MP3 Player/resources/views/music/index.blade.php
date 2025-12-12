@extends('layout.app')

@section('content')
    <div class="player-container">
        <!-- Player Controls -->
        <div class="player-controls" style="padding: 30px; border-bottom: 1px solid rgba(255,255,255,0.1);">
            <div class="now-playing" style="margin-bottom: 20px;">
                <div class="album-art" style="width: 140px; height: 140px; border-radius: 12px; overflow: hidden; margin: 0 auto 20px; box-shadow: 0 12px 40px rgba(0,0,0,0.5);">
                    <img id="currentCover" src="https://images.unsplash.com/photo-1493225457124-a3eb161ffa5f?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80&q=80&auto=format&fit=crop&w=500&q=60&blend=1e293b&blend-mode=multiply" 
                         alt="Album Art" style="width: 100%; height: 100%; object-fit: cover;">
                </div>
                <div style="text-align: center;">
                    <h3 id="currentTitle" style="color: #ffffff; font-size: 1.5rem; margin-bottom: 5px; font-weight: 600;">Select a song</h3>
                    <p id="currentArtist" style="color: #94a3b8; font-size: 1.1rem;">Artist</p>
                </div>
            </div>

            <div class="progress-container" style="margin-bottom: 25px;">
                <div class="time-display" style="display: flex; justify-content: space-between; margin-bottom: 12px; color: #cbd5e1; font-size: 0.9rem; font-weight: 500;">
                    <span id="currentTime">0:00</span>
                    <span id="totalTime">0:00</span>
                </div>
                <div class="progress-bar" style="height: 8px; background: rgba(255,255,255,0.1); border-radius: 4px; cursor: pointer; position: relative;">
                    <div id="progress" style="width: 0%; height: 100%; background: linear-gradient(45deg, #3b82f6, #8b5cf6); border-radius: 4px; box-shadow: 0 0 10px rgba(59, 130, 246, 0.5);"></div>
                </div>
            </div>

            <div class="controls" style="display: flex; justify-content: center; gap: 30px; align-items: center;">
                <button id="prevBtn" style="background: rgba(255,255,255,0.1); border: none; width: 50px; height: 50px; border-radius: 50%; color: #3b82f6; font-size: 1.5rem; cursor: pointer; transition: all 0.3s ease;">
                    <i class="fas fa-step-backward"></i>
                </button>
                <button id="playBtn" style="background: linear-gradient(45deg, #3b82f6, #8b5cf6); border: none; width: 70px; height: 70px; border-radius: 50%; color: white; font-size: 2rem; cursor: pointer; box-shadow: 0 8px 25px rgba(59, 130, 246, 0.5); transition: all 0.3s ease;">
                    <i class="fas fa-play"></i>
                </button>
                <button id="nextBtn" style="background: rgba(255,255,255,0.1); border: none; width: 50px; height: 50px; border-radius: 50%; color: #3b82f6; font-size: 1.5rem; cursor: pointer; transition: all 0.3s ease;">
                    <i class="fas fa-step-forward"></i>
                </button>
            </div>

            <div class="volume-control" style="display: flex; align-items: center; gap: 15px; margin-top: 25px; justify-content: center;">
                <i class="fas fa-volume-down" style="color: #3b82f6; font-size: 1.2rem;"></i>
                <input type="range" id="volume" min="0" max="1" step="0.1" value="0.8" 
                       style="width: 200px; height: 6px; background: rgba(255,255,255,0.1); border-radius: 3px; cursor: pointer; appearance: none;">
                <i class="fas fa-volume-up" style="color: #3b82f6; font-size: 1.2rem;"></i>
            </div>
        </div>

        <!-- Playlist -->
        <div class="playlist" style="padding: 30px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
                <h2 style="color: #ffffff; font-size: 1.6rem; font-weight: 600;">Your Playlist</h2>
                <a href="{{ route('music.upload') }}" class="upload-btn">
                    <i class="fas fa-upload"></i> Upload Song
                </a>
            </div>

            <div class="songs-list" style="max-height: 400px; overflow-y: auto;">
                @forelse($songs as $song)
                    <div class="song-item" 
                         data-id="{{ $song->id }}"
                         data-title="{{ $song->title }}"
                         data-artist="{{ $song->artist }}"
                         data-file="{{ asset('storage/' . $song->file_path) }}"
                         data-cover="{{ $song->cover_image ? asset('storage/' . $song->cover_image) : 'https://images.unsplash.com/photo-1493225457124-a3eb161ffa5f?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=60&blend=1e293b&blend-mode=multiply' }}"
                         data-duration="{{ $song->duration }}"
                         style="display: flex; align-items: center; padding: 20px; border-radius: 12px; margin-bottom: 12px; background: rgba(30, 41, 59, 0.6); cursor: pointer; transition: all 0.3s ease; border: 1px solid rgba(255,255,255,0.05);">
                        <div class="song-cover" style="width: 60px; height: 60px; border-radius: 8px; overflow: hidden; margin-right: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.3);">
                            <img src="{{ $song->cover_image ? asset('storage/' . $song->cover_image) : 'https://images.unsplash.com/photo-1493225457124-a3eb161ffa5f?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=60&blend=1e293b&blend-mode=multiply' }}" 
                                 alt="{{ $song->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                        <div style="flex: 1;">
                            <div style="font-weight: 600; color: #ffffff; margin-bottom: 5px; font-size: 1.1rem;">{{ $song->title }}</div>
                            <div style="font-size: 0.95rem; color: #94a3b8;">{{ $song->artist }}</div>
                        </div>
                        <div style="color: #cbd5e1; margin-right: 20px; font-weight: 500; font-size: 1.1rem; min-width: 60px; text-align: right;">
                            {{ floor($song->duration / 60) }}:{{ str_pad($song->duration % 60, 2, '0', STR_PAD_LEFT) }}
                        </div>
                        <form action="{{ route('music.destroy', $song) }}" method="POST" onclick="event.stopPropagation();">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="upload-btn btn-danger" style="padding: 12px; border-radius: 10px; font-size: 1rem;">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                @empty
                    <div style="text-align: center; padding: 50px; color: #94a3b8; background: rgba(30, 41, 59, 0.4); border-radius: 12px; border: 2px dashed rgba(255,255,255,0.1);">
                        <i class="fas fa-music" style="font-size: 3.5rem; margin-bottom: 20px; opacity: 0.5;"></i>
                        <p style="margin-bottom: 10px; font-size: 1.2rem;">No songs in your playlist yet</p>
                        <p style="color: #cbd5e1; margin-bottom: 30px; font-size: 0.95rem;">Upload your favorite tracks to get started</p>
                        <a href="{{ route('music.upload') }}" class="upload-btn">
                            <i class="fas fa-upload"></i> Upload Your First Song
                        </a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <audio id="audioPlayer"></audio>

    <style>
        #prevBtn:hover, #nextBtn:hover {
            background: rgba(59, 130, 246, 0.2) !important;
            transform: scale(1.1);
        }

        #playBtn:hover {
            transform: scale(1.05);
            box-shadow: 0 12px 30px rgba(59, 130, 246, 0.6) !important;
        }

        .song-item:hover {
            background: rgba(59, 130, 246, 0.1) !important;
            border-color: rgba(59, 130, 246, 0.3) !important;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2) !important;
        }

        #volume::-webkit-slider-thumb {
            appearance: none;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background: #3b82f6;
            cursor: pointer;
            box-shadow: 0 0 10px rgba(59, 130, 246, 0.5);
        }

        #volume::-moz-range-thumb {
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background: #3b82f6;
            cursor: pointer;
            border: none;
            box-shadow: 0 0 10px rgba(59, 130, 246, 0.5);
        }

        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(45deg, #3b82f6, #8b5cf6);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(45deg, #2563eb, #7c3aed);
        }
    </style>

    <script>
        // JavaScript remains the same as before, just copy it from the previous version
        document.addEventListener('DOMContentLoaded', function() {
            const audioPlayer = document.getElementById('audioPlayer');
            const playBtn = document.getElementById('playBtn');
            const prevBtn = document.getElementById('prevBtn');
            const nextBtn = document.getElementById('nextBtn');
            const progressBar = document.getElementById('progress');
            const progressContainer = document.querySelector('.progress-bar');
            const currentTimeEl = document.getElementById('currentTime');
            const totalTimeEl = document.getElementById('totalTime');
            const volumeSlider = document.getElementById('volume');
            const currentTitle = document.getElementById('currentTitle');
            const currentArtist = document.getElementById('currentArtist');
            const currentCover = document.getElementById('currentCover');
            
            const songItems = document.querySelectorAll('.song-item');
            let currentSongIndex = 0;
            let songs = [];

            // Convert NodeList to array and extract song data
            songItems.forEach((item, index) => {
                songs.push({
                    id: item.dataset.id,
                    title: item.dataset.title,
                    artist: item.dataset.artist,
                    file: item.dataset.file,
                    cover: item.dataset.cover,
                    duration: parseInt(item.dataset.duration)
                });

                item.addEventListener('click', () => playSong(index));
            });

            // Format time from seconds to MM:SS
            function formatTime(seconds) {
                const mins = Math.floor(seconds / 60);
                const secs = Math.floor(seconds % 60);
                return `${mins}:${secs.toString().padStart(2, '0')}`;
            }

            // Play a specific song
            function playSong(index) {
                if (songs.length === 0) return;
                
                currentSongIndex = index;
                const song = songs[index];
                
                audioPlayer.src = song.file;
                audioPlayer.play();
                
                currentTitle.textContent = song.title;
                currentArtist.textContent = song.artist;
                currentCover.src = song.cover;
                totalTimeEl.textContent = formatTime(song.duration);
                
                // Update active song in playlist
                songItems.forEach(item => {
                    item.style.background = 'rgba(30, 41, 59, 0.6)';
                    item.style.boxShadow = 'none';
                    item.style.borderColor = 'rgba(255,255,255,0.05)';
                });
                songItems[index].style.background = 'linear-gradient(45deg, rgba(59, 130, 246, 0.2), rgba(139, 92, 246, 0.2))';
                songItems[index].style.boxShadow = '0 8px 25px rgba(59, 130, 246, 0.2)';
                songItems[index].style.borderColor = 'rgba(59, 130, 246, 0.3)';
                
                updatePlayButton();
            }

            // Update play/pause button
            function updatePlayButton() {
                const icon = playBtn.querySelector('i');
                if (audioPlayer.paused) {
                    icon.className = 'fas fa-play';
                } else {
                    icon.className = 'fas fa-pause';
                }
            }

            // Play/Pause
            playBtn.addEventListener('click', () => {
                if (audioPlayer.paused) {
                    if (!audioPlayer.src) {
                        playSong(0);
                    } else {
                        audioPlayer.play();
                    }
                } else {
                    audioPlayer.pause();
                }
                updatePlayButton();
            });

            // Previous song
            prevBtn.addEventListener('click', () => {
                if (songs.length === 0) return;
                currentSongIndex = (currentSongIndex - 1 + songs.length) % songs.length;
                playSong(currentSongIndex);
            });

            // Next song
            nextBtn.addEventListener('click', () => {
                if (songs.length === 0) return;
                currentSongIndex = (currentSongIndex + 1) % songs.length;
                playSong(currentSongIndex);
            });

            // Update progress bar
            audioPlayer.addEventListener('timeupdate', () => {
                const currentTime = audioPlayer.currentTime;
                const duration = audioPlayer.duration || songs[currentSongIndex]?.duration || 0;
                const progressPercent = (currentTime / duration) * 100;
                
                progressBar.style.width = `${progressPercent}%`;
                currentTimeEl.textContent = formatTime(currentTime);
                
                if (!audioPlayer.duration && songs[currentSongIndex]) {
                    totalTimeEl.textContent = formatTime(songs[currentSongIndex].duration);
                }
            });

            // Seek in song
            progressContainer.addEventListener('click', (e) => {
                const rect = progressContainer.getBoundingClientRect();
                const percent = (e.clientX - rect.left) / rect.width;
                audioPlayer.currentTime = percent * (audioPlayer.duration || 0);
            });

            // Volume control
            volumeSlider.addEventListener('input', () => {
                audioPlayer.volume = volumeSlider.value;
            });

            // Song ends
            audioPlayer.addEventListener('ended', () => {
                nextBtn.click();
            });

            // Auto-play first song if exists
            if (songs.length > 0) {
                playSong(0);
            }
        });
    </script>
@endsection