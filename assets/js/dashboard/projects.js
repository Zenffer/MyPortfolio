// Modal helpers for project management
function openProjectModal(mode, data) {
    console.log('openProjectModal called', mode, data);
    const modal = document.getElementById('projectModal');
    if (!modal) {
        console.error('Project modal not found!');
        alert('Project modal not found. Please refresh the page.');
        return;
    }
    
    const title = document.getElementById('pm-title');
    const form = document.getElementById('project-form');
    const titleInput = document.getElementById('pm-title-input');
    const descriptionEl = document.getElementById('pm-description');
    const imageUrlEl = document.getElementById('pm-image-url');
    const imageFileEl = document.getElementById('pm-image-file');
    const imagePathEl = document.getElementById('pm-image-path');
    const altTextEl = document.getElementById('pm-alt-text');
    const projectIdEl = document.getElementById('pm-project-id');
    const uploadStatus = document.getElementById('pm-image-upload-status');
    const uploadMessage = document.getElementById('pm-upload-message');
    
    if (!form || !titleInput || !imageUrlEl) {
        console.error('Form elements not found!', {form, titleInput, imageUrlEl});
        alert('Form elements not found. Please refresh the page.');
        return;
    }

    // Reset form
    title.textContent = mode === 'edit' ? 'Edit Project' : 'Add Project';
    form.reset();
    uploadStatus.style.display = 'none';
    
    if (data && data.id) {
        projectIdEl.value = data.id;
        titleInput.value = data.title || '';
        descriptionEl.value = data.description || '';
        imageUrlEl.value = data.image_path || '';
        imagePathEl.value = data.image_path || '';
        altTextEl.value = data.alt_text || '';
    } else {
        projectIdEl.value = '';
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
        
        return fetch('api/admin/upload_project_image.php', {
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

    // File input change handler
    imageFileEl.onchange = function(e) {
        if (e.target.files && e.target.files[0]) {
            handleFileUpload(e.target.files[0]);
        }
    };

    // Form submission handler
    form.onsubmit = function(e) {
        e.preventDefault();
        console.log('Form submitted');
        
        const title = titleInput.value.trim();
        const description = descriptionEl.value.trim();
        const imageUrl = imageUrlEl.value.trim();
        const imagePath = imagePathEl.value.trim();
        const altText = altTextEl.value.trim();
        const projectId = projectIdEl.value;
        
        const finalImagePath = imagePath || imageUrl;
        
        console.log('Form data:', {title, description, finalImagePath, altText, projectId});
        
        if (!title) {
            alert('Project title is required');
            return;
        }
        
        if (!finalImagePath) {
            alert('Image URL or file is required');
            return;
        }
        
        const payload = {
            action: projectId ? 'update' : 'create',
            id: projectId || undefined,
            title: title,
            description: description,
            image_path: finalImagePath,
            alt_text: altText
        };
        
        console.log('Sending payload:', payload);
        
        const saveBtn = document.getElementById('pm-save');
        const originalText = saveBtn.textContent;
        saveBtn.disabled = true;
        saveBtn.textContent = 'Saving...';
        
        fetch('api/admin/projects.php', {
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
            saveBtn.disabled = false;
            saveBtn.textContent = originalText;
            
            if (resp && resp.ok) {
                modal.style.display = 'none';
                loadDashboardProjects();
                alert('Project saved successfully!');
            } else {
                alert('Failed to save project: ' + (resp.error || 'Unknown error'));
            }
        })
        .catch((err) => {
            console.error('Error:', err);
            saveBtn.disabled = false;
            saveBtn.textContent = originalText;
            alert('Failed to save project. Please try again.');
        });
    };

    // Cancel button
    const cancelBtn = document.getElementById('pm-cancel');
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

// Dashboard project management functions
function loadDashboardProjects() {
    console.log('loadDashboardProjects called');
    const container = document.getElementById('dashboard-projects');
    if (!container) {
        console.error('dashboard-projects container not found');
        // Try again after a short delay
        setTimeout(loadDashboardProjects, 500);
        return;
    }
    console.log('Container found, loading projects...');
    
    // Ensure projects section is visible
    const projectsSection = document.getElementById('projectsContent');
    if (projectsSection) {
        projectsSection.style.display = 'block';
    }
    
    container.innerHTML = '<div style="background: #08090D; border: 1px solid #A1A69C; border-radius: 8px; padding: 16px;"><p style="color:#A1A69C; font-size:14px;">Loading projects…</p></div>';

    fetch('api/admin/projects.php', { credentials: 'same-origin' })
      .then(r => {
          console.log('Projects API response status:', r.status);
          return r.json();
      })
      .then(json => {
          console.log('Projects API response:', json);
          container.innerHTML = '';
          if (!json || !json.ok) {
              const errorMsg = json && json.error ? json.error : 'Failed to load projects';
              container.innerHTML = '<div style="background:#08090D; border:1px solid #A1A69C; border-radius:8px; padding:16px;"><p style="color:#A1A69C; font-size:14px;">Error: ' + errorMsg + '</p></div>';
              return;
          }
          if (!Array.isArray(json.data) || json.data.length === 0) {
              container.innerHTML = '<div style="background:#08090D; border:1px solid #A1A69C; border-radius:8px; padding:16px;"><p style="color:#A1A69C; font-size:14px;">No projects yet. Click "Add Project" to get started.</p></div>';
              return;
          }
          console.log('Loading', json.data.length, 'projects');
          json.data.forEach(item => {
              const card = document.createElement('div');
              card.className = 'dashboard-project-card';
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
                <div style="margin-top: 8px; display: flex; gap: 8px; justify-content: center;">
                    <button class="btn btn-primary btn-edit-project" style="padding: 4px 8px; font-size: 12px;" data-id="${item.id}">Edit</button>
                    <button class="btn btn-secondary btn-delete-project" style="padding: 4px 8px; font-size: 12px;" data-id="${item.id}">Delete</button>
                </div>
              `;
              container.appendChild(card);
          });

          // Add "Add Project" card at the end
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
            <h4 style="color: #fff; margin-bottom: 4px;">Add Project</h4>
            <p style="color: #A1A69C; font-size: 12px;">Click to add new</p>
            <div style="margin-top: 8px;">
                <button class="btn btn-primary btn-add-project" style="padding: 4px 8px; font-size: 12px;">Add</button>
            </div>
          `;
          container.appendChild(addCard);

          // Bind edit/delete/add actions
          container.querySelectorAll('.btn-edit-project').forEach(btn => {
              btn.addEventListener('click', function(){
                  const id = Number(this.getAttribute('data-id'));
                  const project = json.data.find(p => p.id === id);
                  if (project) {
                      openProjectModal('edit', project);
                  }
              });
          });

          container.querySelectorAll('.btn-delete-project').forEach(btn => {
              btn.addEventListener('click', function(){
                  const id = Number(this.getAttribute('data-id'));
                  if (!confirm('Delete this project?')) return;
                  fetch('api/admin/projects.php', {
                      method: 'POST',
                      headers: { 'Content-Type': 'application/json' },
                      credentials: 'same-origin',
                      body: JSON.stringify({ action: 'delete', id })
                  }).then(r=>r.json()).then(resp=>{
                      if (resp && resp.ok) {
                          loadDashboardProjects();
                      } else {
                          alert('Failed to delete project');
                      }
                  }).catch(()=>alert('Failed to delete project'));
              });
          });

          container.querySelectorAll('.btn-add-project').forEach(btn => {
              btn.addEventListener('click', function(){
                  openProjectModal('create', null);
              });
          });
      })
      .catch((err) => {
          console.error('Error loading projects:', err);
          container.innerHTML = '<div style="background:#08090D; border:1px solid #A1A69C; border-radius:8px; padding:16px;"><p style="color:#A1A69C; font-size:14px;">Failed to load projects. Please refresh the page.</p></div>';
      });
}

// Load Projects page content values
function loadProjectsPageContent(){
    fetch('api/admin/page_content.php?page=index&section=projects_title', { credentials: 'same-origin' })
      .then(r=>r.json()).then(j=>{ 
          if (j && j.ok && j.content != null) { 
              const el = document.getElementById('projects-page-title'); 
              if (el) el.value = j.content; 
          } 
      });
    
    fetch('api/admin/page_content.php?page=index&section=projects_description', { credentials: 'same-origin' })
      .then(r=>r.json()).then(j=>{ 
          if (j && j.ok && j.content != null) { 
              const el = document.getElementById('projects-page-description'); 
              if (el) el.value = j.content; 
          } 
      });
    
    fetch('api/admin/page_content.php?page=index&section=hero_title', { credentials: 'same-origin' })
      .then(r=>r.json()).then(j=>{ 
          if (j && j.ok && j.content != null) { 
              const el = document.getElementById('projects-hero-title'); 
              if (el) el.value = j.content; 
          } 
      });
    
    fetch('api/admin/page_content.php?page=index&section=hero_subtitle', { credentials: 'same-origin' })
      .then(r=>r.json()).then(j=>{ 
          if (j && j.ok && j.content != null) { 
              const el = document.getElementById('projects-hero-subtitle'); 
              if (el) el.value = j.content; 
          } 
      });
}
