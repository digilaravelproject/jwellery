@extends('layouts.app')

@section('title', 'Dashboard - Jewellery Store')

@section('content')
<div class="dashboard-container">
    <!-- Welcome Header -->
    <?php /*<div class="welcome-section mb-5">
        <div class="welcome-card">
            <div class="welcome-icon">
                <i class="fas fa-crown"></i>
            </div>
            <h1 class="welcome-title">Welcome, <span>{{ Auth::user()->name }}!</span></h1>
            <p class="welcome-subtitle">You have successfully signed in to your account</p>
        </div>
    </div>*/ ?>

    <!-- Jewelry Design Generator Section -->
    <div class="design-generator-section">
        <div class="design-card">
            <div class="design-card-header">
                <h5 class="design-title">
                    <i class="fas fa-wand-magic-sparkles"></i> AI Jewelry Design Generator
                </h5>
                <p class="design-subtitle">Upload your sketch and let AI transform it into a stunning jewelry design</p>
            </div>
            <div class="design-card-body">
                <div class="design-content">
                    <!-- Upload Section -->
                    <div class="upload-section">
                        <h6 class="section-title">
                            <i class="fas fa-upload"></i> Upload Your Sketch
                        </h6>
                        <form id="sketchUploadForm" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <div class="upload-area" id="uploadArea">
                                    <div class="upload-icon">
                                        <i class="fas fa-cloud-arrow-up"></i>
                                    </div>
                                    <h6 class="upload-label">Drag & Drop Your Sketch</h6>
                                    <p class="upload-sublabel">or click to browse</p>
                                    <small class="upload-hint">Supported: JPG, PNG, GIF (Max 5MB)</small>
                                    <input type="file" id="sketchInput" name="sketch" accept="image/*" style="display: none;">
                                </div>
                            </div>

                            <!-- Selections - Display in One Row -->
                            <div id="selectionsContainer" class="selections-container mt-3">
                                <h6 class="selections-title">
                                    <i class="fas fa-sliders-h"></i> Design Options
                                </h6>
                                <div id="selectionsContent" class="selections-content"></div>
                            </div>
                            
                            <!-- Preview Section -->
                            <div id="previewSection" class="preview-section">
                                <div class="preview-container">
                                    <img id="sketchPreview" src="" alt="Sketch Preview" class="preview-image">
                                    <p class="preview-label"><small><strong>File Selected:</strong> <span id="fileName"></span></small></p>
                                </div>
                            </div>

                            <button type="submit" id="generateBtn" class="btn-generate">
                                <i class="fas fa-magic"></i> Generate Design
                            </button>
                        </form>
                        
                        <!-- Loading Spinner -->
                        <div id="loadingSpinner" class="loading-spinner">
                            <div class="spinner-border"></div>
                            <p>Generating your jewelry design using AI...</p>
                        </div>
                    </div>

                    <!-- Result Section -->
                    <div class="result-section">
                        <h6 class="section-title">
                            <i class="fas fa-gem"></i> Generated Design
                        </h6>
                        <div id="resultSection" class="result-container">
                            <div class="result-content">
                                <img id="generatedDesign" src="" alt="Generated Jewelry Design" class="result-image">
                                <div class="result-info">
                                    <h6 class="result-label">Design Prompt</h6>
                                    <p id="designPromptText" class="result-text"></p>
                                    <button class="btn-download" onclick="downloadDesign()">
                                        <i class="fas fa-download"></i> Download Design
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- No Design Message -->
                        <div id="noDesignMessage" class="no-design-message">
                            <i class="fas fa-image"></i>
                            <p>Your generated design will appear here</p>
                        </div>

                        <!-- Error Message -->
                        <div id="errorMessage" class="error-message">
                            <i class="fas fa-exclamation-circle"></i> <strong>Error:</strong> <span id="errorText"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    :root {
        --primary-yellow: #FFD966;
        --text-main: #2D2D2D;
        --text-secondary: #666;
        --bg-light: #FAFAFA;
        --border-light: #E0E0E0;
        --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.08);
        --shadow-md: 0 8px 20px rgba(0, 0, 0, 0.12);
        --shadow-lg: 0 15px 40px rgba(0, 0, 0, 0.1);
    }

    .dashboard-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 40px 20px;
    }

    /* Welcome Section */
    .welcome-section {
        margin-bottom: 50px;
    }

    .welcome-card {
        background: linear-gradient(135deg, rgba(255, 217, 102, 0.15) 0%, rgba(255, 217, 102, 0.1) 100%);
        border-radius: 40px;
        padding: 60px 40px;
        text-align: center;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 217, 102, 0.3);
        box-shadow: 0 10px 30px rgba(255, 217, 102, 0.1);
    }

    .welcome-icon {
        font-size: 80px;
        margin-bottom: 20px;
        color: var(--primary-yellow);
    }

    .welcome-title {
        font-size: 48px;
        font-weight: 700;
        color: var(--text-main);
        margin-bottom: 15px;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .welcome-title span {
        color: var(--primary-yellow);
    }

    .welcome-subtitle {
        font-size: 18px;
        color: var(--text-secondary);
        margin-bottom: 0;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    /* Design Generator Section */
    .design-generator-section {
        margin-bottom: 30px;
    }

    .design-card {
        background: white;
        border-radius: 40px;
        overflow: hidden;
        box-shadow: var(--shadow-lg);
    }

    .design-card-header {
        background: linear-gradient(135deg, var(--primary-yellow) 0%, #f2cc5b 100%);
        padding: 35px 40px;
        color: var(--text-main);
    }

    .design-title {
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 12px;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .design-subtitle {
        font-size: 15px;
        color: rgba(45, 45, 45, 0.8);
        margin-bottom: 0;
        font-family: 'Inter', sans-serif;
    }

    .design-card-body {
        padding: 45px;
    }

    .design-content {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 50px;
    }

    .upload-section,
    .result-section {
        display: flex;
        flex-direction: column;
    }

    .section-title {
        font-size: 18px;
        font-weight: 700;
        color: var(--text-main);
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        gap: 10px;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    /* Selections */
    .selections-container {
        margin-bottom: 25px;
    }

    .selections-title {
        font-size: 14px;
        font-weight: 700;
        color: var(--text-main);
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 8px;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .selections-content {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    .selections-content select {
        background-color: #f0f0f0;
        color: var(--text-main);
        border: 2px solid transparent;
        border-radius: 25px;
        padding: 12px 18px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        flex: 1;
        min-width: 180px;
        font-size: 13px;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .selections-content select:hover {
        background-color: #e8e8e8;
        border-color: var(--primary-yellow);
    }

    .selections-content select:focus {
        outline: none;
        background-color: white;
        border-color: var(--primary-yellow);
        box-shadow: 0 0 12px rgba(255, 217, 102, 0.4);
    }

    /* Upload Area */
    .form-group {
        margin-bottom: 0;
    }

    .upload-area {
        border: 3px dashed #ddd;
        border-radius: 30px;
        padding: 50px 30px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        background-color: var(--bg-light);
    }

    .upload-area:hover {
        background-color: #f5f5f5;
        border-color: var(--primary-yellow);
        transform: translateY(-3px);
    }

    .upload-area.drag-over {
        background-color: rgba(255, 217, 102, 0.15);
        border-color: var(--primary-yellow);
        border-style: solid;
    }

    .upload-icon {
        font-size: 60px;
        margin-bottom: 15px;
        color: var(--primary-yellow);
    }

    .upload-label {
        color: var(--text-main);
        margin-bottom: 8px;
        font-weight: 600;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .upload-sublabel {
        color: var(--text-secondary);
        margin-bottom: 8px;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .upload-hint {
        color: #999;
        display: block;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    /* Preview Section */
    .preview-section {
        display: none;
        margin-top: 25px;
    }

    .preview-container {
        border: 2px solid var(--border-light);
        border-radius: 25px;
        padding: 15px;
        background-color: var(--bg-light);
    }

    .preview-image {
        max-width: 100%;
        max-height: 280px;
        border-radius: 20px;
        display: block;
        margin: 0 auto;
    }

    .preview-label {
        margin-top: 12px;
        margin-bottom: 0;
        color: var(--text-secondary);
        font-size: 13px;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    /* Buttons */
    .btn-generate,
    .btn-download {
        background: linear-gradient(135deg, var(--primary-yellow) 0%, #f2cc5b 100%);
        border: none;
        color: var(--text-main);
        font-weight: 600;
        border-radius: 25px;
        padding: 15px 28px;
        transition: all 0.3s ease;
        cursor: pointer;
        font-size: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        margin-top: 25px;
        box-shadow: var(--shadow-sm);
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .btn-generate {
        width: 100%;
    }

    .btn-generate:hover,
    .btn-download:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 30px rgba(255, 217, 102, 0.4);
    }

    .btn-download {
        width: auto;
    }

    /* Loading Spinner */
    .loading-spinner {
        display: none;
        text-align: center;
        margin-top: 30px;
    }

    .loading-spinner .spinner-border {
        width: 50px;
        height: 50px;
        border: 4px solid #f0f0f0;
        border-top: 4px solid var(--primary-yellow);
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin: 0 auto;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    .loading-spinner p {
        margin-top: 15px;
        color: var(--text-main);
        font-weight: 500;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    /* Result Section */
    .result-container {
        display: none;
        margin-top: 0;
    }

    .result-content {
        border: 2px solid var(--border-light);
        border-radius: 25px;
        overflow: hidden;
        background-color: var(--bg-light);
    }

    .result-image {
        max-width: 100%;
        height: auto;
        display: block;
    }

    .result-info {
        padding: 25px;
        border-top: 2px solid var(--border-light);
    }

    .result-label {
        margin-bottom: 10px;
        color: var(--text-main);
        font-weight: 600;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .result-text {
        font-size: 13px;
        color: var(--text-secondary);
        max-height: 150px;
        overflow-y: auto;
        margin-bottom: 0;
        font-family: 'Plus Jakarta Sans', sans-serif;
        line-height: 1.6;
    }

    /* No Design Message */
    .no-design-message {
        text-align: center;
        padding: 60px 30px;
        color: #ddd;
    }

    .no-design-message i {
        font-size: 70px;
        display: block;
        margin-bottom: 15px;
        color: #e0e0e0;
    }

    .no-design-message p {
        margin: 0;
        color: #bbb;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    /* Error Message */
    .error-message {
        display: none;
        padding: 18px 22px;
        background-color: rgba(220, 53, 69, 0.1);
        border: 2px solid rgba(220, 53, 69, 0.3);
        border-radius: 20px;
        color: #dc3545;
        margin-top: 20px;
        font-size: 14px;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    /* Responsive Design */
    @media (max-width: 1024px) {
        .design-content {
            grid-template-columns: 1fr;
            gap: 40px;
        }

        .design-card-body {
            padding: 35px;
        }
    }

    @media (max-width: 768px) {
        .dashboard-container {
            padding: 20px 15px;
        }

        .welcome-card {
            padding: 40px 20px;
            border-radius: 30px;
        }

        .welcome-icon {
            font-size: 60px;
        }

        .welcome-title {
            font-size: 32px;
        }

        .welcome-subtitle {
            font-size: 16px;
        }

        .design-card-body {
            padding: 25px;
        }

        .design-content {
            gap: 30px;
        }

        .selections-content select {
            min-width: 140px;
            padding: 10px 15px;
        }

        .upload-area {
            padding: 35px 20px;
            border-radius: 25px;
        }

        .upload-icon {
            font-size: 50px;
        }

        .btn-generate {
            padding: 13px 24px;
        }
    }

    @media (max-width: 480px) {
        .dashboard-container {
            padding: 15px 10px;
        }

        .welcome-title {
            font-size: 24px;
        }

        .design-title {
            font-size: 20px;
        }

        .section-title {
            font-size: 16px;
        }

        .selections-content {
            gap: 8px;
        }

        .selections-content select {
            flex: 0 1 100%;
            min-width: auto;
        }
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
        const selectionsContainer = document.getElementById('selectionsContainer');
        const selectionsContent = document.getElementById('selectionsContent');

        let allSelections = [];
        let userSelections = {};
        let generatedDesignUrl = null;

        // Load selections on page load
        loadSelections();

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

        function loadSelections() {
            fetch('{{ route("selections.active") }}')
                .then(response => {
                    if (!response.ok) throw new Error('Failed to load selections');
                    return response.json();
                })
                .then(data => {
                    if (data.success && data.selections && data.selections.length > 0) {
                        allSelections = data.selections;
                        renderSelections();
                    }
                })
                .catch(error => {
                    console.warn('Warning: Could not load selections -', error.message);
                });
        }

        function renderSelections() {
            selectionsContent.innerHTML = '';
            
            allSelections.forEach((selection, index) => {
                const select = document.createElement('select');
                select.name = 'selection_' + selection.id;
                select.id = 'selection_' + selection.id;
                select.addEventListener('change', (e) => {
                    userSelections[selection.id] = {
                        title: selection.title,
                        value: e.target.value,
                        template: selection.prompt_template
                    };
                });
                
                // Add default option
                const defaultOption = document.createElement('option');
                defaultOption.value = '';
                defaultOption.textContent = `Select ${selection.title}...`;
                select.appendChild(defaultOption);
                
                // Add selection values
                if (selection.values && Array.isArray(selection.values)) {
                    selection.values.forEach(value => {
                        const option = document.createElement('option');
                        option.value = value;
                        option.textContent = value;
                        select.appendChild(option);
                    });
                }
                
                selectionsContent.appendChild(select);
            });
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

            // Add user selections to form data
            let customPromptPart = '';
            for (const selectionId in userSelections) {
                const selection = userSelections[selectionId];
                if (selection.value) {
                    const promptText = selection.template.replace('{value}', selection.value);
                    customPromptPart += promptText + ' ';
                }
            }
            
            if (customPromptPart) {
                formData.append('user_selections', customPromptPart.trim());
            }

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

                console.log('AI Response:', data);

                if (data.success) {
                    if (data.design_type === 'image') {
                        document.getElementById('generatedDesign').src = data.design_url;
                        generatedDesignUrl = data.design_url;
                    } else {
                        document.getElementById('generatedDesign').src = data.sketch_url;
                        generatedDesignUrl = data.sketch_url;
                    }
                    document.getElementById('designPromptText').textContent = data.design_specification;
                    resultSection.style.display = 'block';
                    noDesignMessage.style.display = 'none';
                    errorMessage.style.display = 'none';
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
        // Get the current design URL from the img element
        const designImg = document.getElementById('generatedDesign');
        const designUrl = designImg ? designImg.src : null;
        
        if (designUrl && designUrl.trim() !== '') {
            // Create a link element and trigger download
            const link = document.createElement('a');
            link.href = designUrl;
            link.download = 'jewelry-design-' + new Date().getTime() + '.png';
            link.crossOrigin = 'anonymous';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        } else {
            console.warn('No design URL available for download');
            alert('No design to download. Please generate a design first.');
        }
    }
</script>
@endsection
