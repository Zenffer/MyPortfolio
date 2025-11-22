// Modal helpers for cosplay management
function openCosplayModal(mode, data) {
    console.log('openCosplayModal called', mode, data);
    const modal = document.getElementById('cosplayModal');
    if (!modal) {
        console.error('Cosplay modal not found!');
        alert('Cosplay modal not found. Please refresh the page.');
        return;
    }
    
    const title = document.getElementById('cm-title');
    const form = document.getElementById('cosplay-form');
    const titleInput = document.getElementById('cm-title-input');
    const descriptionEl = document.getElementById('cm-description');
    const imageUrlEl = document.getElementById('cm-image-url');
    const imageFileEl = document.getElementById('cm-image-file');
    const imagePathEl = document.getElementById('cm-image-path');
    const altTextEl = document.getElementById('cm-alt-text');
    const cosplayIdEl = document.getElementById('cm-cosplay-id');
    const uploadStatus = document.getElementById('cm-image-upload-status');
    const uploadMessage = document.getElementById('cm-upload-message');
    
    if (!form || !titleInput || !imageUrlEl) {
        console.error('Form elements not found!', {form, titleInput, imageUrlEl});
        alert('Form elements not found. Please refresh the page.');
        return;
    }

    // Reset form
    title.textContent = mode === 'edit' ? 'Edit Cosplay' : 'Add Cosplay';
    form.reset();
    uploadStatus.style.display = 'none';
    
    // Reset previews and uploaded images
    const thumbnailPreview = document.getElementById('cm-thumbnail-preview');
    const gridUploadStatus = document.getElementById('cm-grid-upload-status');
    
    if (thumbnailPreview) thumbnailPreview.style.display = 'none';
    if (gridUploadStatus) gridUploadStatus.style.display = 'none';
    
    // Reset uploaded images array and display
    if (!window.uploadedCosplayGalleryImages) {
        window.uploadedCosplayGalleryImages = [];
    }
    window.uploadedCosplayGalleryImages = [];
    const uploadedImagesSectionEl = document.getElementById('cm-uploaded-images-section');
    const gridUploadContentEl = document.getElementById('cm-grid-upload-content');
    const gridUploadProgressEl = document.getElementById('cm-grid-upload-progress');
    if (uploadedImagesSectionEl) uploadedImagesSectionEl.style.display = 'none';
    if (gridUploadContentEl) gridUploadContentEl.style.display = 'block';
    if (gridUploadProgressEl) gridUploadProgressEl.style.display = 'none';
    
    if (data && data.id) {
        cosplayIdEl.value = data.id;
        titleInput.value = data.title || '';
        descriptionEl.value = data.description || '';
        imageUrlEl.value = data.image_path || '';
        imagePathEl.value = data.image_path || '';
        altTextEl.value = data.alt_text || '';
        
        // Show thumbnail preview if image exists
        if (data.image_path) {
            const thumbnailPreview = document.getElementById('cm-thumbnail-preview');
            const thumbnailPreviewImg = document.getElementById('cm-thumbnail-preview-img');
            if (thumbnailPreview && thumbnailPreviewImg) {
                thumbnailPreviewImg.src = data.image_path;
                thumbnailPreview.style.display = 'block';
            }
        }
    } else {
        cosplayIdEl.value = '';
        titleInput.value = '';
        descriptionEl.value = '';
        imageUrlEl.value = '';
        imagePathEl.value = '';
        altTextEl.value = '';
    }

    // Show modal - use !important to override inline styles
    modal.style.setProperty('display', 'flex', 'important');
    modal.style.setProperty('visibility', 'visible', 'important');
    modal.style.setProperty('opacity', '1', 'important');
    console.log('Modal display set to flex, modal element:', modal);
    console.log('Modal computed style:', window.getComputedStyle(modal).display);
    console.log('Modal offsetWidth:', modal.offsetWidth, 'offsetHeight:', modal.offsetHeight);
    
    // Force a reflow to ensure the display change takes effect
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
        uploadMessage.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Uploading...';
        
        const formData = new FormData();
        formData.append('file', file);
        
        return fetch('api/admin/upload_cosplay.php', {
            method: 'POST',
            credentials: 'same-origin',
            body: formData
        })
        .then(r => r.json())
        .then(resp => {
            if (resp && resp.ok) {
                imagePathEl.value = resp.url;
                imageUrlEl.value = resp.url;
                uploadMessage.innerHTML = '<span style="color: #4CAF50;"><i class="fas fa-check"></i> Image uploaded successfully!</span>';
                return true;
            } else {
                uploadMessage.innerHTML = '<span style="color: #f44336;">Upload failed: ' + (resp.error || 'Unknown error') + '</span>';
                imageFileEl.value = '';
                return false;
            }
        })
        .catch(() => {
            uploadMessage.innerHTML = '<span style="color: #f44336;">Failed to upload image. Please try again.</span>';
            imageFileEl.value = '';
            return false;
        });
    };

    // File input change handler for thumbnail
    imageFileEl.onchange = function(e) {
        if (e.target.files && e.target.files[0]) {
            handleFileUpload(e.target.files[0]);
        }
    };
    
    // Thumbnail preview when URL is entered
    imageUrlEl.oninput = function() {
        const previewDiv = document.getElementById('cm-thumbnail-preview');
        const previewImg = document.getElementById('cm-thumbnail-preview-img');
        if (previewDiv && previewImg && imageUrlEl.value.trim()) {
            previewImg.src = imageUrlEl.value.trim();
            previewDiv.style.display = 'block';
            previewImg.onerror = function() {
                previewDiv.style.display = 'none';
            };
        } else if (previewDiv) {
            previewDiv.style.display = 'none';
        }
    };
    
    // Grid images upload area setup (Google Forms style)
    const gridUploadArea = document.getElementById('cm-grid-upload-area');
    const gridImagesInput = document.getElementById('cm-grid-images');
    const gridUploadContent = document.getElementById('cm-grid-upload-content');
    const gridUploadProgress = document.getElementById('cm-grid-upload-progress');
    const uploadedImagesSection = document.getElementById('cm-uploaded-images-section');
    const uploadedImagesGrid = document.getElementById('cm-uploaded-images-grid');
    const uploadedCountSpan = document.getElementById('cm-uploaded-count');
    
    // Store uploaded images (will be saved when cosplay is created/updated)
    let uploadedCosplayGalleryImages = [];
    
    // Click to upload
    if (gridUploadArea && gridImagesInput) {
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
                handleGridImagesUpload(e.dataTransfer.files);
            }
        };
        
        // File input change
        gridImagesInput.onchange = function(e) {
            if (e.target.files && e.target.files.length > 0) {
                handleGridImagesUpload(e.target.files);
            }
        };
    }
    
    // Function to handle immediate upload of grid images
    function handleGridImagesUpload(files) {
        if (!files || files.length === 0) return;
        
        // Check if we have a cosplay ID (for editing) or if we're creating new
        const cosplayId = cosplayIdEl ? cosplayIdEl.value : null;
        
        if (!cosplayId) {
            // For new cosplay, store files temporarily and upload after cosplay is created
            Array.from(files).forEach(file => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    window.uploadedCosplayGalleryImages.push({
                        file: file,
                        preview: e.target.result,
                        gridSize: document.getElementById('cm-grid-size') ? document.getElementById('cm-grid-size').value : 'medium',
                        tempId: Date.now() + Math.random()
                    });
                    updateUploadedImagesDisplay();
                };
                reader.readAsDataURL(file);
            });
            return;
        }
        
        // For existing cosplay, upload immediately
        uploadGridImagesImmediately(files, cosplayId);
    }
    
    // Upload grid images immediately for existing cosplay
    function uploadGridImagesImmediately(files, cosplayId) {
        const gridSize = document.getElementById('cm-grid-size') ? document.getElementById('cm-grid-size').value : 'medium';
        const formData = new FormData();
        formData.append('cosplay_id', cosplayId);
        formData.append('grid_size', gridSize);
        
        for (let i = 0; i < files.length; i++) {
            formData.append('images[]', files[i]);
        }
        
        // Show upload progress
        if (gridUploadContentEl) gridUploadContentEl.style.display = 'none';
        if (gridUploadProgressEl) gridUploadProgressEl.style.display = 'block';
        
        fetch('api/admin/upload_cosplay_images.php', {
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
                    window.uploadedCosplayGalleryImages.push({
                        id: img.id,
                        image_path: img.image_path,
                        grid_size: img.grid_size,
                        display_order: img.display_order
                    });
                });
                updateUploadedImagesDisplay();
                
                // Show success message
                const statusDiv = document.getElementById('cm-grid-upload-status');
                const messageSpan = document.getElementById('cm-grid-upload-message');
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
            if (gridUploadContent) gridUploadContent.style.display = 'block';
            if (gridUploadProgress) gridUploadProgress.style.display = 'none';
            alert('Failed to upload images. Please try again.');
            if (gridImagesInput) gridImagesInput.value = '';
        });
    }
    
    // Update the uploaded images display
    function updateUploadedImagesDisplay() {
        if (!uploadedImagesGrid || !uploadedImagesSectionEl || !uploadedCountSpan) return;
        
        const images = window.uploadedCosplayGalleryImages || [];
        
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
                        fetch('api/admin/cosplay_images.php', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json' },
                            credentials: 'same-origin',
                            body: JSON.stringify({ action: 'delete', id: img.id })
                        })
                        .then(r => r.json())
                        .then(json => {
                            if (json && json.ok) {
                                window.uploadedCosplayGalleryImages.splice(index, 1);
                                updateUploadedImagesDisplay();
                            } else {
                                alert('Failed to delete image');
                            }
                        });
                    } else {
                        // Remove from temp array
                        window.uploadedCosplayGalleryImages.splice(index, 1);
                        updateUploadedImagesDisplay();
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
        loadExistingGalleryImages(data.id);
    }
    
    function loadExistingGalleryImages(cosplayId) {
        fetch('api/admin/cosplay_images.php?cosplay_id=' + cosplayId, { credentials: 'same-origin' })
            .then(r => r.json())
            .then(json => {
                if (json && json.ok && Array.isArray(json.data)) {
                    window.uploadedCosplayGalleryImages = json.data;
                    updateUploadedImagesDisplay();
                }
            })
            .catch(err => {
                console.error('Error loading gallery images:', err);
            });
    }
    
    // Load existing images when editing
    if (data && data.id) {
        loadExistingGalleryImages(data.id);
    }

    // Form submission handler
    form.onsubmit = function(e) {
        e.preventDefault();
        console.log('Form submitted');
        
        const title = titleInput.value.trim();
        const description = descriptionEl.value.trim();
        const imageUrl = imageUrlEl.value.trim();
        const imagePath = imagePathEl.value.trim();
        const altText = altTextEl.value.trim();
        const cosplayId = cosplayIdEl.value;
        
        const finalImagePath = imagePath || imageUrl;
        
        console.log('Form data:', {title, description, finalImagePath, altText, cosplayId});
        
        if (!title) {
            alert('Cosplay title is required');
            return;
        }
        
        if (!finalImagePath) {
            alert('Image URL or file is required');
            return;
        }
        
        const payload = {
            action: cosplayId ? 'update' : 'create',
            id: cosplayId || undefined,
            title: title,
            description: description,
            image_path: finalImagePath,
            alt_text: altText
        };
        
        // Check for uploaded gallery images (either from server or temp)
        const hasUploadedImages = uploadedCosplayGalleryImages && uploadedCosplayGalleryImages.length > 0;
        
        console.log('Sending payload:', payload);
        
        const saveBtn = document.getElementById('cm-save');
        const originalText = saveBtn.textContent;
        saveBtn.disabled = true;
        saveBtn.textContent = 'Saving...';
        
        fetch('api/admin/cosplay.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            credentials: 'same-origin',
            body: JSON.stringify(payload)
        })
        .then(r => {
            console.log('Response status:', r.status);
            return r.json();
        })
        .then(resp => {
            console.log('Response data:', resp);
            
            if (resp && resp.ok) {
                const savedCosplayId = resp.id || cosplayId;
                
                // Upload temp gallery images if any (for new cosplay)
                const tempImages = (window.uploadedCosplayGalleryImages || []).filter(img => !img.id && img.file);
                if (tempImages.length > 0 && savedCosplayId) {
                    const gridSize = document.getElementById('cm-grid-size') ? document.getElementById('cm-grid-size').value : 'medium';
                    const gridFormData = new FormData();
                    gridFormData.append('cosplay_id', savedCosplayId);
                    gridFormData.append('grid_size', gridSize);
                    
                    tempImages.forEach(img => {
                        gridFormData.append('images[]', img.file);
                    });
                    
                    return fetch('api/admin/upload_cosplay_images.php', {
                        method: 'POST',
                        credentials: 'same-origin',
                        body: gridFormData
                    })
                    .then(r => r.json())
                    .then(gridResp => {
                        if (gridResp && gridResp.ok) {
                            // Update temp images with server IDs
                            if (gridResp.uploaded) {
                                gridResp.uploaded.forEach((uploadedImg, idx) => {
                                    const tempIdx = window.uploadedCosplayGalleryImages.findIndex(img => !img.id && img.file);
                                    if (tempIdx !== -1) {
                                        window.uploadedCosplayGalleryImages[tempIdx] = uploadedImg;
                                    }
                                });
                            }
                        }
                        return resp;
                    })
                    .catch(err => {
                        console.error('Error uploading temp grid images:', err);
                        return resp;
                    });
                }
                
                return resp;
            } else {
                throw new Error(resp.error || 'Unknown error');
            }
        })
        .then(resp => {
            saveBtn.disabled = false;
            saveBtn.textContent = originalText;
            
            if (resp && resp.ok) {
                modal.style.display = 'none';
                form.reset();
                uploadStatus.style.display = 'none';
                window.uploadedCosplayGalleryImages = [];
                const uploadedImagesSection = document.getElementById('cm-uploaded-images-section');
                const gridUploadStatus = document.getElementById('cm-grid-upload-status');
                if (uploadedImagesSection) uploadedImagesSection.style.display = 'none';
                if (gridUploadStatus) {
                    setTimeout(() => {
                        gridUploadStatus.style.display = 'none';
                    }, 3000);
                }
                loadDashboardCosplay();
                
                // If editing, also reload page content
                if (cosplayId) {
                    loadCosplayPageContent();
                }
                
                alert('Cosplay saved successfully!');
            }
        })
        .catch((err) => {
            console.error('Error:', err);
            saveBtn.disabled = false;
            saveBtn.textContent = originalText;
            alert('Failed to save cosplay: ' + (err.message || 'Unknown error'));
        });
    };

    // Cancel button
    const cancelBtn = document.getElementById('cm-cancel');
    cancelBtn.onclick = function() {
        modal.style.display = 'none';
        form.reset();
        uploadStatus.style.display = 'none';
    };
    
    // Close modal when clicking outside
    modal.onclick = function(e) {
        if (e.target === modal) {
            modal.style.display = 'none';
            form.reset();
            uploadStatus.style.display = 'none';
        }
    };
}

// Helper function to escape HTML
function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// Dashboard cosplay management functions
function loadDashboardCosplay() {
    console.log('loadDashboardCosplay called');
    const container = document.getElementById('dashboard-cosplay');
    if (!container) {
        console.error('dashboard-cosplay container not found');
        // Try again after a short delay
        setTimeout(loadDashboardCosplay, 500);
        return;
    }
    console.log('Container found, loading cosplay...');
    
    // Ensure cosplay section is visible
    const cosplaySection = document.getElementById('cosplayContent');
    if (cosplaySection) {
        cosplaySection.style.display = 'block';
    }
    
    container.innerHTML = '<div style="background: #08090D; border: 1px solid #A1A69C; border-radius: 8px; padding: 16px;"><p style="color:#A1A69C; font-size:14px;">Loading cosplay…</p></div>';

    fetch('api/admin/cosplay.php', { credentials: 'same-origin' })
      .then(r => {
          console.log('Cosplay API response status:', r.status);
          return r.json();
      })
      .then(json => {
          console.log('Cosplay API response:', json);
          container.innerHTML = '';
          if (!json || !json.ok) {
              const errorMsg = json && json.error ? json.error : 'Failed to load cosplay';
              container.innerHTML = '<div style="background:#08090D; border:1px solid #A1A69C; border-radius:8px; padding:16px;"><p style="color:#A1A69C; font-size:14px;">Error: ' + errorMsg + '</p></div>';
              return;
          }
          if (!Array.isArray(json.data) || json.data.length === 0) {
              container.innerHTML = '<div style="background:#08090D; border:1px solid #A1A69C; border-radius:8px; padding:16px;"><p style="color:#A1A69C; font-size:14px;">No cosplay yet. Click "Add Cosplay" to get started.</p></div>';
              return;
          }
          console.log('Loading', json.data.length, 'cosplay');
          json.data.forEach(item => {
              const card = document.createElement('div');
              card.className = 'dashboard-cosplay-card';
              card.style.background = '#08090D';
              card.style.border = '1px solid #A1A69C';
              card.style.borderRadius = '8px';
              card.style.padding = '16px';
              card.style.textAlign = 'center';
              
              const imageUrl = item.image_path || '';
              const hasImage = imageUrl && (imageUrl.startsWith('http') || imageUrl.startsWith('/') || imageUrl.startsWith('assets'));
              
              card.innerHTML = `
                <div style="width: 100%; height: 120px; background: #292c3a; border-radius: 4px; margin-bottom: 8px; display: flex; align-items: center; justify-content: center; color: #A1A69C; ${hasImage ? `background-image: url('${escapeHtml(imageUrl)}'); background-size: cover; background-position: center;` : ''}">
                    ${!hasImage ? '<i class="fas fa-image" style="font-size: 24px;"></i>' : ''}
                </div>
                <h4 style="color: #fff; margin-bottom: 4px;">${escapeHtml(item.title)}</h4>
                <p style="color: #A1A69C; font-size: 12px; margin-bottom: 8px;">${escapeHtml(item.description || 'No description')}</p>
                <div style="margin-top: 8px; display: flex; gap: 4px; justify-content: center; flex-wrap: wrap;">
                    <button class="btn btn-primary btn-edit-cosplay" style="padding: 4px 8px; font-size: 11px;" data-id="${item.id}">Edit</button>
                    <button class="btn btn-secondary btn-delete-cosplay" style="padding: 4px 8px; font-size: 11px;" data-id="${item.id}">Delete</button>
                </div>
              `;
              container.appendChild(card);
          });

          // Add "Add Cosplay" card at the end
          const addCard = document.createElement('div');
          addCard.style.background = '#08090D';
          addCard.style.border = '1px solid #A1A69C';
          addCard.style.borderRadius = '8px';
          addCard.style.padding = '16px';
          addCard.style.textAlign = 'center';
          addCard.innerHTML = `
            <div style="width: 100%; height: 120px; background: #292c3a; border-radius: 4px; margin-bottom: 8px; display: flex; align-items: center; justify-content: center; color: #A1A69C;">
                <i class="fas fa-plus" style="font-size: 24px;"></i>
            </div>
            <h4 style="color: #fff; margin-bottom: 4px;">Add Cosplay</h4>
            <p style="color: #A1A69C; font-size: 12px;">Click to add new</p>
            <div style="margin-top: 8px;">
                <button class="btn btn-primary btn-add-cosplay" style="padding: 4px 8px; font-size: 12px;">Add</button>
            </div>
          `;
          container.appendChild(addCard);

          // Bind edit/delete/add actions
          container.querySelectorAll('.btn-edit-cosplay').forEach(btn => {
              btn.addEventListener('click', function(){
                  const id = Number(this.getAttribute('data-id'));
                  const cosplay = json.data.find(c => c.id === id);
                  if (cosplay) {
                      openCosplayModal('edit', cosplay);
                  }
              });
          });

          container.querySelectorAll('.btn-delete-cosplay').forEach(btn => {
              btn.addEventListener('click', function(){
                  const id = Number(this.getAttribute('data-id'));
                  if (!confirm('Delete this cosplay?')) return;
                  fetch('api/admin/cosplay.php', {
                      method: 'POST',
                      headers: { 'Content-Type': 'application/json' },
                      credentials: 'same-origin',
                      body: JSON.stringify({ action: 'delete', id })
                  }).then(r=>r.json()).then(resp=>{
                      if (resp && resp.ok) {
                          loadDashboardCosplay();
                      } else {
                          alert('Failed to delete cosplay');
                      }
                  }).catch(()=>alert('Failed to delete cosplay'));
              });
          });

          container.querySelectorAll('.btn-add-cosplay').forEach(btn => {
              btn.addEventListener('click', function(){
                  openCosplayModal('create', null);
              });
          });
      })
      .catch((err) => {
          console.error('Error loading cosplay:', err);
          container.innerHTML = '<div style="background:#08090D; border:1px solid #A1A69C; border-radius:8px; padding:16px;"><p style="color:#A1A69C; font-size:14px;">Failed to load cosplay. Please refresh the page.</p></div>';
      });
}

// Load Cosplay page content values
function loadCosplayPageContent(){
    fetch('api/admin/page_content.php?page=cosplay&section=page_title', { credentials: 'same-origin' })
      .then(r=>r.json()).then(j=>{ 
          if (j && j.ok && j.content != null) { 
              const el = document.getElementById('cosplay-page-title'); 
              if (el) el.value = j.content; 
          } 
      });
    
    fetch('api/admin/page_content.php?page=cosplay&section=page_description', { credentials: 'same-origin' })
      .then(r=>r.json()).then(j=>{ 
          if (j && j.ok && j.content != null) { 
              const el = document.getElementById('cosplay-page-description'); 
              if (el) el.value = j.content; 
          } 
      });
    
    fetch('api/admin/page_content.php?page=cosplay&section=hero_title', { credentials: 'same-origin' })
      .then(r=>r.json()).then(j=>{ 
          if (j && j.ok && j.content != null) { 
              const el = document.getElementById('cosplay-hero-title'); 
              if (el) el.value = j.content; 
          } 
      });
    
    fetch('api/admin/page_content.php?page=cosplay&section=hero_subtitle', { credentials: 'same-origin' })
      .then(r=>r.json()).then(j=>{ 
          if (j && j.ok && j.content != null) { 
              const el = document.getElementById('cosplay-hero-subtitle'); 
              if (el) el.value = j.content; 
          } 
      });
}
