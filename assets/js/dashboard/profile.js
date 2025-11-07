// ===== Profile helpers =====
function loadProfileSettings(){
    // Load available images first
    loadAvailableImages();
    
    fetch('api/admin/settings.php?keys=owner_name,display_name,owner_title,location,bio,bio_secondary,skills,tools,profile_image', { credentials: 'same-origin' })
      .then(r=>r.json()).then(resp=>{
          if (!resp || !resp.ok) return;
          const d = resp.data || {};
          const q = sel => document.querySelector('#profileLayout ' + sel);
          if (q('input[name="full_name"]')) q('input[name="full_name"]').value = d.owner_name || '';
          if (q('input[name="display_name"]')) q('input[name="display_name"]').value = (d.display_name || d.owner_name || '');
          if (q('input[name="title"]')) q('input[name="title"]').value = d.owner_title || '';
          if (q('input[name="location"]')) q('input[name="location"]').value = d.location || '';
          if (q('textarea[name="bio"]')) q('textarea[name="bio"]').value = d.bio || '';
          if (q('textarea[name="bio_secondary"]')) q('textarea[name="bio_secondary"]').value = d.bio_secondary || '';
          if (q('input[name="skills"]')) q('input[name="skills"]').value = d.skills || '';
          if (q('input[name="tools"]')) q('input[name="tools"]').value = d.tools || '';
          const img = document.querySelector('#profileLayout .current-picture img');
          if (img && d.profile_image) img.src = d.profile_image;
      });
}

function saveSettings(updates){
    return fetch('api/admin/settings.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        credentials: 'same-origin',
        body: JSON.stringify({ updates })
    }).then(r=>r.json()).then(resp=>!!(resp && resp.ok)).catch(()=>false);
}

// Load available profile images
function loadAvailableImages() {
    fetch('api/admin/list_profile_images.php', { credentials: 'same-origin' })
        .then(r => r.json())
        .then(resp => {
            if (!resp || !resp.ok || !Array.isArray(resp.images)) {
                console.error('Invalid response format:', resp);
                return;
            }
            const container = document.getElementById('imagesList');
            if (!container) {
                console.error('Container #imagesList not found');
                return;
            }
            container.innerHTML = '';
            
            if (resp.images.length === 0) {
                container.innerHTML = '<p style="color: #A1A69C; font-size: 14px; grid-column: 1 / -1;">No profile images available. Upload one to get started!</p>';
                return;
            }
            
            resp.images.forEach(img => {
                const imgEl = document.createElement('div');
                imgEl.style.cssText = 'position: relative; cursor: pointer; border: 2px solid #A1A69C; border-radius: 4px; overflow: hidden; transition: border-color 0.2s;';
                
                // Check if this is the default image (cannot be deleted)
                const isDefault = img.is_default || img.filename === 'profil1.jpg';
                
                imgEl.innerHTML = `
                    <img src="${escapeHtml(img.url)}" style="width: 100%; height: 80px; object-fit: cover; display: block;" alt="${escapeHtml(img.filename)}" />
                    ${!isDefault ? `
                        <button class="delete-image-btn" style="
                            position: absolute;
                            top: 4px;
                            right: 4px;
                            background: rgba(0, 0, 0, 0.7);
                            border: 1px solid #ff4444;
                            color: #ff4444;
                            border-radius: 4px;
                            width: 24px;
                            height: 24px;
                            cursor: pointer;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            font-size: 12px;
                            transition: all 0.2s;
                            padding: 0;
                        " title="Delete image">
                            <i class="fas fa-times"></i>
                        </button>
                    ` : ''}
                `;
                
                // Add hover effect
                imgEl.addEventListener('mouseenter', function() {
                    this.style.borderColor = '#fff';
                });
                imgEl.addEventListener('mouseleave', function() {
                    this.style.borderColor = '#A1A69C';
                });
                
                // Click to select image (but not if clicking delete button)
                imgEl.addEventListener('click', function(e) {
                    // Don't trigger selection if clicking the delete button
                    if (e.target.closest('.delete-image-btn')) {
                        return;
                    }
                    // Set as profile image
                    saveSettings({ profile_image: img.url }).then(ok => {
                        if (ok) {
                            const currentImg = document.querySelector('#profileLayout .current-picture img');
                            if (currentImg) currentImg.src = img.url;
                            document.getElementById('availableImages').style.display = 'none';
                            alert('Profile image updated');
                        } else {
                            alert('Failed to update profile image');
                        }
                    });
                });
                
                // Delete button handler (only for non-default images)
                if (!isDefault) {
                    const deleteBtn = imgEl.querySelector('.delete-image-btn');
                    if (deleteBtn) {
                        deleteBtn.addEventListener('click', function(e) {
                            e.stopPropagation(); // Prevent triggering image selection
                            
                            if (!confirm(`Are you sure you want to delete "${img.filename}"?`)) {
                                return;
                            }
                            
                            // Disable button during deletion
                            deleteBtn.disabled = true;
                            deleteBtn.style.opacity = '0.5';
                            deleteBtn.style.cursor = 'not-allowed';
                            
                            // Delete the image
                            deleteProfileImage(img.filename).then(success => {
                                if (success) {
                                    // Reload the images list
                                    loadAvailableImages();
                                    // If this was the current profile image, reload settings
                                    const currentImg = document.querySelector('#profileLayout .current-picture img');
                                    if (currentImg && currentImg.src.includes(img.filename)) {
                                        loadProfileSettings();
                                    }
                                } else {
                                    deleteBtn.disabled = false;
                                    deleteBtn.style.opacity = '1';
                                    deleteBtn.style.cursor = 'pointer';
                                }
                            });
                        });
                        
                        // Hover effect for delete button
                        deleteBtn.addEventListener('mouseenter', function() {
                            this.style.background = 'rgba(255, 68, 68, 0.9)';
                            this.style.color = '#fff';
                        });
                        deleteBtn.addEventListener('mouseleave', function() {
                            this.style.background = 'rgba(0, 0, 0, 0.7)';
                            this.style.color = '#ff4444';
                        });
                    }
                }
                
                container.appendChild(imgEl);
            });
        })
        .catch((error) => {
            console.error('Failed to load images:', error);
            const container = document.getElementById('imagesList');
            if (container) {
                container.innerHTML = '<p style="color: #A1A69C; font-size: 14px; grid-column: 1 / -1;">Failed to load images. Please try again.</p>';
            }
        });
}

// Delete profile image function
function deleteProfileImage(filename) {
    return fetch('api/admin/remove_profile_image.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        credentials: 'same-origin',
        body: JSON.stringify({ filename: filename })
    })
    .then(r => r.json())
    .then(resp => {
        if (resp && resp.ok) {
            alert('Image deleted successfully');
            return true;
        } else {
            const errorMsg = resp && resp.error ? resp.error : 'Failed to delete image';
            alert(errorMsg);
            return false;
        }
    })
    .catch(err => {
        console.error('Delete error:', err);
        alert('Failed to delete image. Please try again.');
        return false;
    });
}

// Upload profile image function
function uploadProfileImage() {
    const input = document.getElementById('profileUpload');
    if (!input) return;
    
    // Trigger file input click
    input.click();
    
    // Handle file selection
    input.onchange = function() {
        const fileInput = this; // Store reference for use in finally block
        
        if (!fileInput.files || !fileInput.files[0]) return;
        
        const file = fileInput.files[0];
        
        // Validate file size (5MB max)
        if (file.size > 5 * 1024 * 1024) {
            alert('File too large. Maximum size is 5MB.');
            fileInput.value = ''; // Reset input
            return;
        }
        
        // Validate file type
        const allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
        if (!allowedTypes.includes(file.type)) {
            alert('Unsupported file type. Please upload JPG, PNG, or WebP images.');
            fileInput.value = ''; // Reset input
            return;
        }
        
        // Show loading state
        const uploadBtn = document.getElementById('profileUploadBtn');
        const originalText = uploadBtn ? uploadBtn.textContent : '';
        if (uploadBtn) {
            uploadBtn.disabled = true;
            uploadBtn.textContent = 'Uploading...';
        }
        
        // Create FormData - API expects 'file' not 'image'
        const formData = new FormData();
        formData.append('file', file);
        
        // Upload file
        fetch('api/admin/upload_profile_image.php', {
            method: 'POST',
            credentials: 'same-origin',
            body: formData
        })
        .then(r => r.json())
        .then(resp => {
            if (resp && resp.ok && resp.url) {
                // Update the profile image immediately
                const currentImg = document.querySelector('#profileLayout .current-picture img');
                if (currentImg) {
                    currentImg.src = resp.url;
                }
                // Reload available images list to include the new upload
                loadAvailableImages();
                // Reload profile settings to ensure everything is in sync
                loadProfileSettings();
                alert('Image uploaded successfully!');
            } else {
                const errorMsg = resp && resp.error ? resp.error : 'Failed to upload image';
                alert(errorMsg);
            }
        })
        .catch(err => {
            console.error('Upload error:', err);
            alert('Failed to upload image. Please try again.');
        })
        .finally(() => {
            // Reset button state
            if (uploadBtn) {
                uploadBtn.disabled = false;
                uploadBtn.textContent = originalText;
            }
            // Reset input
            fileInput.value = '';
        });
    };
}

