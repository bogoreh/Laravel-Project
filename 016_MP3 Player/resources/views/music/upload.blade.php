@extends('layout.app')

@section('content')
    <div class="player-container" style="max-width: 600px; margin: 0 auto;">
        <div style="padding: 40px;">
            <div style="text-align: center; margin-bottom: 30px;">
                <h2 style="color: #ffffff; font-size: 1.8rem; margin-bottom: 10px; font-weight: 600;">Upload New Song</h2>
                <p style="color: #94a3b8;">Add your favorite music to the playlist</p>
            </div>

            <form action="{{ route('music.store') }}" method="POST" enctype="multipart/form-data" style="display: flex; flex-direction: column; gap: 25px;">
                @csrf
                
                <div>
                    <label style="display: block; color: #e2e8f0; margin-bottom: 10px; font-weight: 500;">Song Title *</label>
                    <input type="text" name="title" required 
                           style="width: 100%; padding: 16px; background: rgba(30, 41, 59, 0.6); border: 2px solid rgba(255,255,255,0.1); border-radius: 12px; font-size: 1rem; color: #ffffff; transition: all 0.3s ease;"
                           placeholder="Enter song title"
                           onfocus="this.style.borderColor='#3b82f6'; this.style.boxShadow='0 0 0 3px rgba(59, 130, 246, 0.1)'"
                           onblur="this.style.borderColor='rgba(255,255,255,0.1)'; this.style.boxShadow='none'">
                </div>

                <div>
                    <label style="display: block; color: #e2e8f0; margin-bottom: 10px; font-weight: 500;">Artist *</label>
                    <input type="text" name="artist" required 
                           style="width: 100%; padding: 16px; background: rgba(30, 41, 59, 0.6); border: 2px solid rgba(255,255,255,0.1); border-radius: 12px; font-size: 1rem; color: #ffffff;"
                           placeholder="Enter artist name"
                           onfocus="this.style.borderColor='#3b82f6'; this.style.boxShadow='0 0 0 3px rgba(59, 130, 246, 0.1)'"
                           onblur="this.style.borderColor='rgba(255,255,255,0.1)'; this.style.boxShadow='none'">
                </div>

                <div>
                    <label style="display: block; color: #e2e8f0; margin-bottom: 10px; font-weight: 500;">Album (Optional)</label>
                    <input type="text" name="album" 
                           style="width: 100%; padding: 16px; background: rgba(30, 41, 59, 0.6); border: 2px solid rgba(255,255,255,0.1); border-radius: 12px; font-size: 1rem; color: #ffffff;"
                           placeholder="Enter album name"
                           onfocus="this.style.borderColor='#3b82f6'; this.style.boxShadow='0 0 0 3px rgba(59, 130, 246, 0.1)'"
                           onblur="this.style.borderColor='rgba(255,255,255,0.1)'; this.style.boxShadow='none'">
                </div>

                <div>
                    <label style="display: block; color: #e2e8f0; margin-bottom: 10px; font-weight: 500;">MP3 File *</label>
                    <div style="border: 2px dashed #3b82f6; border-radius: 12px; padding: 30px; text-align: center; background: rgba(59, 130, 246, 0.05);">
                        <i class="fas fa-music" style="font-size: 2.5rem; color: #3b82f6; margin-bottom: 15px;"></i>
                        <div style="position: relative; display: inline-block;">
                            <input type="file" name="song_file" accept=".mp3" required 
                                   style="position: absolute; width: 100%; height: 100%; opacity: 0; cursor: pointer;"
                                   onchange="previewFileName(this, 'mp3')">
                            <div class="file-upload-btn" style="background: rgba(59, 130, 246, 0.2); color: #3b82f6; padding: 12px 24px; border-radius: 8px; font-weight: 500; transition: all 0.3s ease;">
                                <i class="fas fa-cloud-upload-alt"></i> Choose MP3 File
                            </div>
                        </div>
                        <p id="mp3FileName" style="color: #94a3b8; margin-top: 15px; font-size: 0.9rem;">Select an MP3 file (max 50MB)</p>
                    </div>
                </div>

                <div>
                    <label style="display: block; color: #e2e8f0; margin-bottom: 10px; font-weight: 500;">Cover Image (Optional)</label>
                    <div style="border: 2px dashed #8b5cf6; border-radius: 12px; padding: 30px; text-align: center; background: rgba(139, 92, 246, 0.05);">
                        <i class="fas fa-image" style="font-size: 2.5rem; color: #8b5cf6; margin-bottom: 15px;"></i>
                        <div style="position: relative; display: inline-block;">
                            <input type="file" name="cover_image" accept="image/*"
                                   style="position: absolute; width: 100%; height: 100%; opacity: 0; cursor: pointer;"
                                   onchange="previewFileName(this, 'image')">
                            <div class="file-upload-btn" style="background: rgba(139, 92, 246, 0.2); color: #8b5cf6; padding: 12px 24px; border-radius: 8px; font-weight: 500; transition: all 0.3s ease;">
                                <i class="fas fa-cloud-upload-alt"></i> Choose Image
                            </div>
                        </div>
                        <p id="imageFileName" style="color: #94a3b8; margin-top: 15px; font-size: 0.9rem;">Select a cover image (JPG, PNG, GIF)</p>
                    </div>
                </div>

                <div style="display: flex; gap: 15px; margin-top: 10px;">
                    <a href="{{ route('music.index') }}" 
                       style="flex: 1; text-align: center; background: rgba(71, 85, 105, 0.6); color: #e2e8f0; padding: 16px; border-radius: 12px; text-decoration: none; font-weight: 500; transition: all 0.3s ease; border: 1px solid rgba(255,255,255,0.1);"
                       onmouseover="this.style.background='rgba(71, 85, 105, 0.8)'; this.style.transform='translateY(-2px)'"
                       onmouseout="this.style.background='rgba(71, 85, 105, 0.6)'; this.style.transform='translateY(0)'">
                        <i class="fas fa-arrow-left"></i> Back to Player
                    </a>
                    <button type="submit" class="upload-btn" style="flex: 1;">
                        <i class="fas fa-upload"></i> Upload Song
                    </button>
                </div>
            </form>
        </div>
    </div>

    <style>
        .file-upload-btn:hover {
            background: rgba(59, 130, 246, 0.3) !important;
            transform: translateY(-2px);
        }

        input[type="file"] {
            z-index: 2;
        }

        input:focus {
            outline: none;
        }

        ::placeholder {
            color: #64748b;
        }
    </style>

    <script>
        function previewFileName(input, type) {
            const file = input.files[0];
            if (file) {
                const p = document.getElementById(type + 'FileName');
                p.innerHTML = `<i class="fas fa-check-circle" style="color: #10b981;"></i> ${file.name} (${(file.size / 1024 / 1024).toFixed(2)} MB)`;
                p.style.color = '#10b981';
            }
        }

        // Add hover effects to file upload buttons
        document.querySelectorAll('.file-upload-btn').forEach(btn => {
            btn.addEventListener('mouseover', function() {
                this.style.transform = 'translateY(-2px)';
            });
            
            btn.addEventListener('mouseout', function() {
                this.style.transform = 'translateY(0)';
            });
        });
    </script>
@endsection