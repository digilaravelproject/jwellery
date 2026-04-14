@extends('layouts.app')

@section('title', 'Dashboard - Jewellery Store')

@section('content')
<div class="my-5">
    <!-- Welcome Header -->
    <div class="row mb-5">
        <div class="col-md-12">
            <div class="card shadow-lg" style="background: linear-gradient(135deg, var(--primary-color)15 0%, #ffffff 100%); border: 2px solid var(--primary-color);">
                <div class="card-body p-5 text-center">
                    <div style="font-size: 60px; margin-bottom: 20px;">
                        <i class="fas fa-crown" style="color: var(--primary-color);"></i>
                    </div>
                    <h1 class="mb-3" style="font-size: 48px; color: var(--dark-bg);">
                        Welcome, <span style="color: var(--primary-color);">{{ Auth::user()->name }}!</span>
                    </h1>
                    <p class="lead mb-0" style="color: #666; font-size: 18px;">
                        You have successfully signed in to your account
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Jewelry Design Generator Section -->
    <div class="row mb-5">
        <div class="col-md-12">
            <div class="card shadow-lg" style="border: 2px solid var(--primary-color); overflow: hidden;">
                <div class="card-header" style="background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-color)dd 100%); color: white; padding: 20px;">
                    <h5 class="mb-0">
                        <i class="fas fa-wand-magic-sparkles"></i> AI Jewelry Design Generator
                    </h5>
                    <small>Upload your sketch and let AI transform it into a stunning jewelry design</small>
                </div>
                <div class="card-body p-5">
                    <div class="row">
                        <!-- Upload Section -->
                        <div class="col-md-6">
                            <h6 class="mb-4" style="color: var(--primary-color); font-weight: bold;">
                                <i class="fas fa-upload"></i> Upload Your Sketch
                            </h6>
                            <form id="sketchUploadForm" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group mb-3">
                                    <div class="upload-area" id="uploadArea" 
                                         style="border: 3px dashed var(--primary-color); border-radius: 10px; padding: 40px; text-align: center; cursor: pointer; transition: all 0.3s ease; background-color: rgba(218, 165, 32, 0.05);">
                                        <div style="font-size: 48px; margin-bottom: 15px;">
                                            <i class="fas fa-cloud-arrow-up" style="color: var(--primary-color);"></i>
                                        </div>
                                        <h6 style="color: var(--primary-color); margin-bottom: 10px;">Drag & Drop Your Sketch</h6>
                                        <p style="color: #666; margin-bottom: 0;">or click to browse</p>
                                        <small style="color: #999;">Supported: JPG, PNG, GIF (Max 5MB)</small>
                                        <input type="file" id="sketchInput" name="sketch" accept="image/*" style="display: none;">
                                    </div>
                                </div>
                                
                                <!-- Preview Section -->
                                <div id="previewSection" style="display: none; margin-top: 20px;">
                                    <div style="border: 1px solid #ddd; border-radius: 8px; padding: 15px; background-color: #f9f9f9;">
                                        <img id="sketchPreview" src="" alt="Sketch Preview" style="max-width: 100%; max-height: 250px; border-radius: 5px;">
                                        <p class="mt-3 mb-1"><small style="color: #666;"><strong>File Selected:</strong> <span id="fileName"></span></small></p>
                                    </div>
                                </div>

                                <button type="submit" id="generateBtn" class="btn btn-primary btn-block mt-4" style="background-color: var(--primary-color); border-color: var(--primary-color); width: 100%; padding: 12px; font-weight: bold; border-radius: 8px;">
                                    <i class="fas fa-magic"></i> Generate Design
                                </button>
                            </form>
                            
                            <!-- Loading Spinner -->
                            <div id="loadingSpinner" style="display: none; text-align: center; margin-top: 20px;">
                                <div class="spinner-border" style="color: var(--primary-color);" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                                <p class="mt-3" style="color: var(--primary-color);">Generating your jewelry design using AI...</p>
                            </div>
                        </div>

                        <!-- Result Section -->
                        <div class="col-md-6">
                            <h6 class="mb-4" style="color: var(--primary-color); font-weight: bold;">
                                <i class="fas fa-gem"></i> Generated Design
                            </h6>
                            <div id="resultSection" style="display: none;">
                                <div style="border: 1px solid #ddd; border-radius: 8px; overflow: hidden; background-color: #f9f9f9;">
                                    <img id="generatedDesign" src="" alt="Generated Jewelry Design" style="max-width: 100%; height: auto; display: block;">
                                    <div style="padding: 15px; border-top: 1px solid #ddd;">
                                        <h6 style="margin-bottom: 10px; color: var(--primary-color);">Design Prompt</h6>
                                        <p id="designPromptText" style="font-size: 13px; color: #666; max-height: 150px; overflow-y: auto; margin-bottom: 0;"></p>
                                        <button class="btn btn-sm mt-3" style="background-color: var(--primary-color); color: white; border-radius: 5px;" onclick="downloadDesign()">
                                            <i class="fas fa-download"></i> Download Design
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- No Design Message -->
                            <div id="noDesignMessage" style="text-align: center; padding: 40px 20px; color: #999;">
                                <i class="fas fa-image" style="font-size: 48px; color: #ddd; display: block; margin-bottom: 15px;"></i>
                                <p>Your generated design will appear here</p>
                            </div>

                            <!-- Error Message -->
                            <div id="errorMessage" style="display: none; padding: 15px; background-color: #f8d7da; border: 1px solid #f5c6cb; border-radius: 5px; color: #721c24; margin-top: 15px;">
                                <i class="fas fa-exclamation-circle"></i> <strong>Error:</strong> <span id="errorText"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .badge-success {
        background-color: #28a745;
        color: white;
    }

    #uploadArea:hover {
        background-color: rgba(218, 165, 32, 0.1);
        border-color: var(--primary-color);
        transform: scale(1.02);
    }

    #uploadArea.drag-over {
        background-color: rgba(218, 165, 32, 0.2);
        border-color: var(--primary-color);
        border-style: solid;
    }

    .btn-primary {
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(218, 165, 32, 0.3);
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const uploadArea = document.getElementById('uploadArea');
        const sketchInput = document.getElementById('sketchInput');
        const sketchUploadForm = document.getElementById('sketchUploadForm');
        const previewSection = document.getElementById('previewSection');
        const resultSection = document.getElementById('resultSection');
        const noDesignMessage = document.getElementById('noDesignMessage');
        const errorMessage = document.getElementById('errorMessage');
        const loadingSpinner = document.getElementById('loadingSpinner');
        const generateBtn = document.getElementById('generateBtn');

        // Click to upload
        uploadArea.addEventListener('click', () => sketchInput.click());

        // Drag and drop
        uploadArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            uploadArea.classList.add('drag-over');
        });

        uploadArea.addEventListener('dragleave', () => {
            uploadArea.classList.remove('drag-over');
        });

        uploadArea.addEventListener('drop', (e) => {
            e.preventDefault();
            uploadArea.classList.remove('drag-over');
            
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                sketchInput.files = files;
                handleFileSelection();
            }
        });

        // File input change
        sketchInput.addEventListener('change', handleFileSelection);

        function handleFileSelection() {
            const file = sketchInput.files[0];
            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    document.getElementById('sketchPreview').src = e.target.result;
                    document.getElementById('fileName').textContent = file.name;
                    previewSection.style.display = 'block';
                    errorMessage.style.display = 'none';
                };
                reader.readAsDataURL(file);
            } else {
                errorMessage.style.display = 'block';
                document.getElementById('errorText').textContent = 'Please select a valid image file.';
            }
        }

        // Form submission
        sketchUploadForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const file = sketchInput.files[0];
            if (!file) {
                errorMessage.style.display = 'block';
                document.getElementById('errorText').textContent = 'Please select a sketch image.';
                return;
            }

            const formData = new FormData();
            formData.append('sketch', file);
            formData.append('_token', document.querySelector('input[name="_token"]').value);

            loadingSpinner.style.display = 'block';
            generateBtn.disabled = true;
            errorMessage.style.display = 'none';

            try {
                const response = await fetch('{{ route("design.generate") }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                    }
                });

                // Get response as text first to handle parsing errors
                const responseText = await response.text();
                
                let data;
                try {
                    data = JSON.parse(responseText);
                } catch (jsonError) {
                    loadingSpinner.style.display = 'none';
                    generateBtn.disabled = false;
                    errorMessage.style.display = 'block';
                    
                    // Log detailed debugging info
                    console.error('=== JSON PARSING ERROR ===');
                    console.error('Status Code:', response.status);
                    console.error('Status Text:', response.statusText);
                    console.error('Response Text:', responseText);
                    console.error('JSON Error:', jsonError.message);
                    console.log('First 500 chars of response:', responseText.substring(0, 500));
                    console.error('========================');
                    
                    // Show appropriate error message
                    if (response.status === 503) {
                        document.getElementById('errorText').textContent = 'AI Service not configured. Administrator needs to set up AI in admin panel.';
                    } else if (response.status >= 500) {
                        document.getElementById('errorText').textContent = 'Server error. Please check the admin panel AI configuration.';
                    } else {
                        document.getElementById('errorText').textContent = 'Invalid server response. Please refresh and try again.';
                    }
                    return;
                }

                loadingSpinner.style.display = 'none';
                generateBtn.disabled = false;

                console.log(data);return false;

                if (data.success) {
                    // document.getElementById('generatedDesign').src = data.design_url;
                    // document.getElementById('designPromptText').textContent = data.design_prompt;

                    document.getElementById('generatedDesign').src = data.sketch_url;
                    document.getElementById('designPromptText').textContent = data.design_specification;
                    resultSection.style.display = 'block';
                    noDesignMessage.style.display = 'none';
                    errorMessage.style.display = 'none';
                    
                    // Store the design URL for download
                    window.currentDesignUrl = data.design_url;
                } else {
                    errorMessage.style.display = 'block';
                    document.getElementById('errorText').textContent = data.message || 'Failed to generate design.';
                }
            } catch (error) {
                loadingSpinner.style.display = 'none';
                generateBtn.disabled = false;
                errorMessage.style.display = 'block';
                
                // Detailed error logging for debugging
                console.error('Fetch Error:', error);
                document.getElementById('errorText').textContent = 'Network error: ' + error.message;
            }
        });
    });

    function downloadDesign() {
        if (window.currentDesignUrl) {
            const link = document.createElement('a');
            link.href = window.currentDesignUrl;
            link.download = 'jewelry-design-' + new Date().getTime() + '.png';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    }
</script>
@endsection
