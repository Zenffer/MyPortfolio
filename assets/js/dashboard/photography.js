// Modal helpers for photography management
function openPhotographyModal(mode, data) {
    console.log('openPhotographyModal called', mode, data);
    const modal = document.getElementById('photographyModal');
    if (!modal) {
        console.error('Photography modal not found!');
        alert('Photography modal not found. Please refresh the page.');
        return;
    }
    
    const title = document.getElementById('phm-title');
    const form = document.getElementById('photography-form');
    const titleInput = document.getElementById('phm-title-input');
    const descriptionEl = document.getElementById('phm-description');
    const imageUrlEl = document.getElementById('phm-image-url');
    const imageFileEl = document.getElementById('phm-image-file');
    const imagePathEl = document.getElementById('phm-image-path');
    const altTextEl = document.getElementById('phm-alt-text');
    const photoIdEl = document.getElementById('phm-photo-id');
    const uploadStatus = document.getElementById('phm-image-upload-status');
    const uploadMessage = document.getElementById('phm-upload-message');
    
    if (!form || !titleInput || !imageUrlEl) {
        console.error('Form elements not found!', {form, titleInput, imageUrlEl});
        alert('Form elements not found. Please refresh the page.');
        return;
    }

    // Reset form
    title.textContent = mode === 'edit' ? 'Edit Photo' : 'Add Photo';
    form.reset();
    uploadStatus.style.display = 'none';
    
    // Reset previews and uploaded images
    const thumbnailPreview = document.getElementById('phm-thumbnail-preview');
    const gridUploadStatus = document.getElementById('phm-grid-upload-status');
    
    if (thumbnailPreview) thumbnailPreview.style.display = 'none';
    if (gridUploadStatus) gridUploadStatus.style.display = 'none';
    
    // Reset uploaded images array and display
    if (!window.uploadedPhotographyGalleryImages) {
        window.uploadedPhotographyGalleryImages = [];
    }
    window.uploadedPhotographyGalleryImages = [];
    const uploadedImagesSectionEl = document.getElementById('phm-uploaded-images-section');
    const gridUploadContentEl = document.getElementById('phm-grid-upload-content');
    const gridUploadProgressEl = document.getElementById('phm-grid-upload-progress');
    if (uploadedImagesSectionEl) uploadedImagesSectionEl.style.display = 'none';
    if (gridUploadContentEl) gridUploadContentEl.style.display = 'block';
    if (gridUploadProgressEl) gridUploadProgressEl.style.display = 'none';
    
    if (data && data.id) {
        photoIdEl.value = data.id;
        titleInput.value = data.title || '';
        descriptionEl.value = data.description || '';
        imageUrlEl.value = data.image_path || '';
        imagePathEl.value = data.image_path || '';
        altTextEl.value = data.alt_text || '';
        
        // Show thumbnail preview if image exists
        if (data.image_path) {
            const thumbnailPreview = document.getElementById('phm-thumbnail-preview');
            const thumbnailPreviewImg = document.getElementById('phm-thumbnail-preview-img');
            if (thumbnailPreview && thumbnailPreviewImg) {
                thumbnailPreviewImg.src = data.image_path;
                thumbnailPreview.style.display = 'block';
            }
        }
    } else {
        photoIdEl.value = '';
        titleInput.value = '';
        descriptionEl.value = '';
        imageUrlEl.value = '';
        imagePathEl.value = '';
        altTextEl.value = '';
    }

    // Show modal
    modal.style.setProperty('display', 'flex', 'important');
    modal.style.setProperty('visibility', 'visible', 'important');
    modal.style.setProperty('opacity', '1', 'important');
    
    // Force a reflow
    void modal.offsetWidth;

    // Handle file upload
    const handleFileUpload = (file) => {
        if (!file) return false;
        
        if (file.size > 10 * 1024 * 1024) {
            alert('File too large. Maximum size is 10MB.');
            imageFileEl.value = '';
            return false;
        }
        
        const allowedTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
        if (!allowedTypes.includes(file.type)) {
            alert('Unsupported file type. Please upload JPG, PNG, WebP, or GIF images.');
            imageFileEl.value = '';
            return false;
        }
        
        uploadStatus.style.display = 'block';
        uploadMessage.textContent = 'Uploading...';
        
        const formData = new FormData();
        formData.append('file', file);
        
        fetch('api/admin/upload_photography.php', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(result => {
            if (result.ok && result.url) {
                imagePathEl.value = result.url;
                imageUrlEl.value = result.url;
                uploadMessage.textContent = 'Upload successful!';
                uploadMessage.style.color = '#0a7e07';
                
                // Show thumbnail preview
                const thumbnailPreview = document.getElementById('phm-thumbnail-preview');
                const thumbnailPreviewImg = document.getElementById('phm-thumbnail-preview-img');
                if (thumbnailPreview && thumbnailPreviewImg) {
                    thumbnailPreviewImg.src = result.url;
                    thumbnailPreview.style.display = 'block';
                }
            } else {
                uploadMessage.textContent = result.error || 'Upload failed';
                uploadMessage.style.color = '#b00020';
            }
        })
        .catch(err => {
            console.error('Upload error:', err);
            uploadMessage.textContent = 'Upload failed. Please try again.';
            uploadMessage.style.color = '#b00020';
        })
        .finally(() => {
            setTimeout(() => {
                uploadStatus.style.display = 'none';
            }, 3000);
        });
        
        return true;
    };

    // Remove old event listeners by cloning
    const newImageFileEl = imageFileEl.cloneNode(true);
    imageFileEl.parentNode.replaceChild(newImageFileEl, imageFileEl);
    const newImageFileElRef = document.getElementById('phm-image-file');
    
    newImageFileElRef.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            handleFileUpload(file);
        }
    });
    
    // Handle URL input
    const handleUrlInput = () => {
        const url = imageUrlEl.value.trim();
        if (url) {
            imagePathEl.value = url;
            const preview = document.getElementById('phm-image-preview');
            const previewImg = document.getElementById('phm-image-preview-img');
            if (preview && previewImg) {
                previewImg.src = url;
                preview.style.display = 'block';
            }
        } else {
            imagePathEl.value = '';
            const preview = document.getElementById('phm-image-preview');
            if (preview) preview.style.display = 'none';
        }
    };
    
    // Remove old event listeners
    const newImageUrlEl = imageUrlEl.cloneNode(true);
    imageUrlEl.parentNode.replaceChild(newImageUrlEl, imageUrlEl);
    const newImageUrlElRef = document.getElementById('phm-image-url');
    
    newImageUrlElRef.addEventListener('input', handleUrlInput);
    newImageUrlElRef.addEventListener('blur', handleUrlInput);
    
    // Gallery images upload handling
    const gridImagesInput = document.getElementById('phm-grid-images');
    const gridUploadArea = document.getElementById('phm-grid-upload-area');
    const uploadedImagesGrid = document.getElementById('phm-uploaded-images-grid');
    const uploadedCountSpan = document.getElementById('phm-uploaded-count');
    
    if (gridImagesInput && gridUploadArea) {
        // Click to upload
        gridUploadArea.onclick = function() {
            gridImagesInput.click();
        };
        
        // Drag and drop
        gridUploadArea.ondragover = function(e) {
            e.preventDefault();
            e.stopPropagation();
            this.style.borderColor = '#fff';
            this.style.background = '#1a1d24';
        };
        
        gridUploadArea.ondragleave = function(e) {
            e.preventDefault();
            e.stopPropagation();
            this.style.borderColor = '#A1A69C';
            this.style.background = '#292c3a';
        };
        
        gridUploadArea.ondrop = function(e) {
            e.preventDefault();
            e.stopPropagation();
            this.style.borderColor = '#A1A69C';
            this.style.background = '#292c3a';
            if (e.dataTransfer.files && e.dataTransfer.files.length > 0) {
                gridImagesInput.files = e.dataTransfer.files;
                handlePhotographyGridImagesUpload(e.dataTransfer.files);
            }
        };
        
        // File input change
        gridImagesInput.onchange = function(e) {
            if (e.target.files && e.target.files.length > 0) {
                handlePhotographyGridImagesUpload(e.target.files);
            }
        };
    }
    
    // Function to handle immediate upload of grid images
    function handlePhotographyGridImagesUpload(files) {
        if (!files || files.length === 0) return;
        
        // Check if we have a photography ID (for editing) or if we're creating new
        const photographyId = photoIdEl ? photoIdEl.value : null;
        
        if (!photographyId) {
            // For new photography, store files temporarily and upload after photography is created
            Array.from(files).forEach(file => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    window.uploadedPhotographyGalleryImages.push({
                        file: file,
                        preview: e.target.result,
                        gridSize: document.getElementById('phm-grid-size') ? document.getElementById('phm-grid-size').value : 'medium',
                        tempId: Date.now() + Math.random()
                    });
                    updatePhotographyUploadedImagesDisplay();
                };
                reader.readAsDataURL(file);
            });
            return;
        }
        
        // For existing photography, upload immediately
        uploadPhotographyGridImagesImmediately(files, photographyId);
    }
    
    // Upload grid images immediately for existing photography
    function uploadPhotographyGridImagesImmediately(files, photographyId) {
        const gridSize = document.getElementById('phm-grid-size') ? document.getElementById('phm-grid-size').value : 'medium';
        const formData = new FormData();
        formData.append('photography_id', photographyId);
        formData.append('grid_size', gridSize);
        
        for (let i = 0; i < files.length; i++) {
            formData.append('images[]', files[i]);
        }
        
        // Show upload progress
        if (gridUploadContentEl) gridUploadContentEl.style.display = 'none';
        if (gridUploadProgressEl) gridUploadProgressEl.style.display = 'block';
        
        fetch('api/admin/upload_photography_images.php', {
            method: 'POST',
            credentials: 'same-origin',
            body: formData
        })
        .then(r => r.json())
        .then(json => {
            if (gridUploadContentEl) gridUploadContentEl.style.display = 'block';
            if (gridUploadProgressEl) gridUploadProgressEl.style.display = 'none';
            
            if (json && json.ok && json.uploaded) {
                // Add uploaded images to display
                json.uploaded.forEach(img => {
                    window.uploadedPhotographyGalleryImages.push({
                        id: img.id,
                        image_path: img.image_path,
                        grid_size: img.grid_size,
                        display_order: img.display_order
                    });
                });
                updatePhotographyUploadedImagesDisplay();
                
                // Show success message
                const statusDiv = document.getElementById('phm-grid-upload-status');
                const messageSpan = document.getElementById('phm-grid-upload-message');
                if (statusDiv && messageSpan) {
                    statusDiv.style.display = 'block';
                    messageSpan.textContent = json.uploaded.length + ' image(s) uploaded successfully!';
                    messageSpan.style.color = '#4CAF50';
                    setTimeout(() => {
                        statusDiv.style.display = 'none';
                    }, 3000);
                }
            } else {
                alert('Upload failed: ' + (json.error || 'Unknown error'));
            }
            
            // Reset file input
            if (gridImagesInput) gridImagesInput.value = '';
        })
        .catch(err => {
            console.error('Upload error:', err);
            if (gridUploadContentEl) gridUploadContentEl.style.display = 'block';
            if (gridUploadProgressEl) gridUploadProgressEl.style.display = 'none';
            alert('Failed to upload images. Please try again.');
            if (gridImagesInput) gridImagesInput.value = '';
        });
    }
    
    // Update the uploaded images display
    function updatePhotographyUploadedImagesDisplay() {
        if (!uploadedImagesGrid || !uploadedImagesSectionEl || !uploadedCountSpan) return;
        
        const images = window.uploadedPhotographyGalleryImages || [];
        
        if (images.length === 0) {
            uploadedImagesSectionEl.style.display = 'none';
            return;
        }
        
        uploadedImagesSectionEl.style.display = 'block';
        uploadedCountSpan.textContent = images.length;
        uploadedImagesGrid.innerHTML = '';
        
        images.forEach((img, index) => {
            const item = document.createElement('div');
            item.style.cssText = 'position: relative; width: 100%; aspect-ratio: 1; border-radius: 4px; overflow: hidden; border: 1px solid #A1A69C; background: #08090D;';
            
            const imgEl = document.createElement('img');
            imgEl.src = img.image_path || img.preview;
            imgEl.alt = 'Gallery image';
            imgEl.style.cssText = 'width: 100%; height: 100%; object-fit: cover; display: block;';
            
            const overlay = document.createElement('div');
            overlay.style.cssText = 'position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.7); display: flex; align-items: center; justify-content: center; opacity: 0; transition: opacity 0.3s;';
            
            const deleteBtn = document.createElement('button');
            deleteBtn.className = 'btn btn-secondary';
            deleteBtn.style.cssText = 'padding: 4px 8px; font-size: 11px;';
            deleteBtn.innerHTML = '<i class="fas fa-trash"></i>';
            deleteBtn.onclick = function(e) {
                e.stopPropagation();
                if (confirm('Remove this image?')) {
                    if (img.id) {
                        // Delete from server
                        fetch('api/admin/photography_images.php', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json' },
                            credentials: 'same-origin',
                            body: JSON.stringify({ action: 'delete', id: img.id })
                        })
                        .then(r => r.json())
                        .then(json => {
                            if (json && json.ok) {
                                window.uploadedPhotographyGalleryImages.splice(index, 1);
                                updatePhotographyUploadedImagesDisplay();
                            } else {
                                alert('Failed to delete image');
                            }
                        });
                    } else {
                        // Remove from temp array
                        window.uploadedPhotographyGalleryImages.splice(index, 1);
                        updatePhotographyUploadedImagesDisplay();
                    }
                }
            };
            
            overlay.appendChild(deleteBtn);
            item.appendChild(imgEl);
            item.appendChild(overlay);
            
            item.onmouseenter = function() {
                overlay.style.opacity = '1';
            };
            item.onmouseleave = function() {
                overlay.style.opacity = '0';
            };
            
            uploadedImagesGrid.appendChild(item);
        });
    }
    
    // Load existing images when editing
    if (data && data.id) {
        loadExistingPhotographyGalleryImages(data.id);
    }
    
    function loadExistingPhotographyGalleryImages(photographyId) {
        fetch('api/admin/photography_images.php?photography_id=' + photographyId, { credentials: 'same-origin' })
            .then(r => r.json())
            .then(json => {
                if (json && json.ok && Array.isArray(json.data)) {
                    window.uploadedPhotographyGalleryImages = json.data;
                    updatePhotographyUploadedImagesDisplay();
                }
            })
            .catch(err => {
                console.error('Error loading gallery images:', err);
            });
    }
}

function closePhotographyModal() {
    const modal = document.getElementById('photographyModal');
    if (modal) {
        modal.style.setProperty('display', 'none', 'important');
    }
}

// Load photography for dashboard
function loadDashboardPhotography() {
    console.log('Loading photography for dashboard...');
    const container = document.getElementById('dashboard-photography');
    if (!container) {
        console.error('Dashboard photography container not found');
        return;
    }
    
    fetch('api/admin/photography.php')
        .then(res => res.json())
        .then(result => {
            if (!result.ok) {
                console.error('Failed to load photography:', result.error);
                container.innerHTML = '<p style="color: #b00020;">Failed to load photography: ' + (result.error || 'Unknown error') + '</p>';
                return;
            }
            
            const photos = result.data || [];
            console.log('Loaded photography:', photos);
            
            if (photos.length === 0) {
                container.innerHTML = '<p style="color: #A1A69C; text-align: center; padding: 20px;">No photos yet. Click "Add Photo" to get started.</p>';
                return;
            }
            
            container.innerHTML = '';
            photos.forEach(photo => {
                const card = document.createElement('div');
                card.className = 'content-card';
                card.style.cssText = 'position: relative; background: #292c3a; border-radius: 8px; overflow: hidden; cursor: pointer;';
                
                const img = document.createElement('img');
                img.src = photo.image_path || '';
                img.alt = photo.alt_text || photo.title || 'Photo';
                img.style.cssText = 'width: 100%; height: 200px; object-fit: cover; display: block;';
                img.onerror = function() {
                    this.style.display = 'none';
                    const placeholder = document.createElement('div');
                    placeholder.style.cssText = 'width: 100%; height: 200px; background: #08090D; display: flex; align-items: center; justify-content: center; color: #A1A69C;';
                    placeholder.innerHTML = '<i class="fas fa-image" style="font-size: 32px;"></i>';
                    card.insertBefore(placeholder, card.firstChild);
                };
                
                const overlay = document.createElement('div');
                overlay.style.cssText = 'position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.7); display: flex; flex-direction: column; justify-content: center; align-items: center; opacity: 0; transition: opacity 0.3s; padding: 16px;';
                
                const title = document.createElement('h4');
                title.textContent = photo.title || 'Untitled';
                title.style.cssText = 'color: #fff; margin: 0 0 8px 0; font-size: 16px; font-weight: 600;';
                
                const actions = document.createElement('div');
                actions.style.cssText = 'display: flex; gap: 8px;';
                
                const editBtn = document.createElement('button');
                editBtn.textContent = 'Edit';
                editBtn.className = 'btn btn-secondary';
                editBtn.style.cssText = 'padding: 6px 12px; font-size: 12px;';
                editBtn.onclick = (e) => {
                    e.stopPropagation();
                    openPhotographyModal('edit', photo);
                };
                
                const deleteBtn = document.createElement('button');
                deleteBtn.textContent = 'Delete';
                deleteBtn.className = 'btn btn-danger';
                deleteBtn.style.cssText = 'padding: 6px 12px; font-size: 12px;';
                deleteBtn.onclick = (e) => {
                    e.stopPropagation();
                    if (confirm('Are you sure you want to delete this photo?')) {
                        deletePhotography(photo.id);
                    }
                };
                
                actions.appendChild(editBtn);
                actions.appendChild(deleteBtn);
                overlay.appendChild(title);
                overlay.appendChild(actions);
                
                card.appendChild(img);
                card.appendChild(overlay);
                
                card.addEventListener('mouseenter', () => {
                    overlay.style.opacity = '1';
                });
                card.addEventListener('mouseleave', () => {
                    overlay.style.opacity = '0';
                });
                
                container.appendChild(card);
            });
        })
        .catch(err => {
            console.error('Error loading photography:', err);
            container.innerHTML = '<p style="color: #b00020;">Error loading photography. Please refresh the page.</p>';
        });
}

function deletePhotography(id) {
    fetch('api/admin/photography.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            action: 'delete',
            id: id
        })
    })
    .then(res => res.json())
    .then(result => {
        if (result.ok) {
            loadDashboardPhotography();
        } else {
            alert('Failed to delete photo: ' + (result.error || 'Unknown error'));
        }
    })
    .catch(err => {
        console.error('Error deleting photo:', err);
        alert('Error deleting photo. Please try again.');
    });
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    // Form submission handler
    const form = document.getElementById('photography-form');
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const photoId = document.getElementById('phm-photo-id').value;
            const title = document.getElementById('phm-title-input').value.trim();
            const description = document.getElementById('phm-description').value.trim();
            const imagePath = document.getElementById('phm-image-path').value.trim();
            const altText = document.getElementById('phm-alt-text').value.trim();
            
            if (!title || !imagePath) {
                alert('Title and image are required');
                return;
            }
            
            const action = photoId ? 'update' : 'create';
            const payload = {
                action: action,
                title: title,
                description: description,
                image_path: imagePath,
                alt_text: altText
            };
            
            if (photoId) {
                payload.id = parseInt(photoId);
            }
            
            fetch('api/admin/photography.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                credentials: 'same-origin',
                body: JSON.stringify(payload)
            })
            .then(res => res.json())
            .then(result => {
                if (result.ok) {
                    const newPhotoId = result.id || parseInt(photoId);
                    
                    // If there are temporary gallery images, upload them now
                    const hasUploadedImages = window.uploadedPhotographyGalleryImages && window.uploadedPhotographyGalleryImages.length > 0;
                    if (hasUploadedImages && !photoId) {
                        // Upload temporary images for new photography
                        const tempImages = (window.uploadedPhotographyGalleryImages || []).filter(img => !img.id && img.file);
                        if (tempImages.length > 0) {
                            const gridSize = document.getElementById('phm-grid-size') ? document.getElementById('phm-grid-size').value : 'medium';
                            const formData = new FormData();
                            formData.append('photography_id', newPhotoId);
                            formData.append('grid_size', gridSize);
                            
                            tempImages.forEach(img => {
                                formData.append('images[]', img.file);
                            });
                            
                            return fetch('api/admin/upload_photography_images.php', {
                                method: 'POST',
                                credentials: 'same-origin',
                                body: formData
                            })
                            .then(r => r.json())
                            .then(uploadResult => {
                                if (uploadResult && uploadResult.ok) {
                                    // Update temp images with uploaded IDs
                                    uploadResult.uploaded.forEach((uploadedImg, idx) => {
                                        const tempIdx = window.uploadedPhotographyGalleryImages.findIndex(img => !img.id && img.file);
                                        if (tempIdx >= 0) {
                                            window.uploadedPhotographyGalleryImages[tempIdx] = uploadedImg;
                                        }
                                    });
                                }
                                closePhotographyModal();
                                loadDashboardPhotography();
                            });
                        }
                    }
                    
                    closePhotographyModal();
                    loadDashboardPhotography();
                } else {
                    alert('Failed to save photo: ' + (result.error || 'Unknown error'));
                }
            })
            .catch(err => {
                console.error('Error saving photo:', err);
                alert('Error saving photo. Please try again.');
            });
        });
    }
    
    // Cancel button
    const cancelBtn = document.getElementById('phm-cancel');
    if (cancelBtn) {
        cancelBtn.addEventListener('click', closePhotographyModal);
    }
    
    // Add Photo button
    const addBtn = document.getElementById('btnAddPhotography');
    if (addBtn) {
        addBtn.addEventListener('click', function() {
            openPhotographyModal('create', null);
        });
    }
    
    // Close modal on outside click
    const modal = document.getElementById('photographyModal');
    if (modal) {
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                closePhotographyModal();
            }
        });
    }
});

