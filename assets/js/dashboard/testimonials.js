// Modal helpers for testimonial management
function openTestimonialModal(mode, data) {
    const modal = document.getElementById('testimonialModal');
    const title = document.getElementById('tm-title');
    const nameEl = document.getElementById('tm-name');
    const roleEl = document.getElementById('tm-role');
    const quoteEl = document.getElementById('tm-quote');
    const saveBtn = document.getElementById('tm-save');
    const cancelBtn = document.getElementById('tm-cancel');

    title.textContent = mode === 'edit' ? 'Edit Testimonial' : 'Add Testimonial';
    nameEl.value = (data && data.name) ? data.name : '';
    roleEl.value = (data && data.role) ? data.role : '';
    quoteEl.value = (data && data.quote) ? data.quote : '';

    modal.style.display = 'flex';

    const onCancel = () => { modal.style.display = 'none'; cleanup(); };
    const onSave = () => {
        const payload = {
            action: mode === 'edit' ? 'update' : 'create',
            id: data ? data.id : undefined,
            name: nameEl.value.trim(),
            role: roleEl.value.trim(),
            quote: quoteEl.value.trim()
        };
        if (!payload.name || !payload.quote) { alert('Name and quote are required'); return; }
        fetch('api/admin/testimonials.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            credentials: 'same-origin',
            body: JSON.stringify(payload)
        }).then(r=>r.json()).then(resp=>{
            if (resp && resp.ok) {
                modal.style.display = 'none';
                cleanup();
                loadDashboardTestimonials();
            } else {
                alert('Failed to save testimonial');
            }
        }).catch(()=>alert('Failed to save testimonial'));
    };

    cancelBtn.addEventListener('click', onCancel);
    saveBtn.addEventListener('click', onSave);
    modal.addEventListener('click', function(e){ if (e.target === modal) onCancel(); });

    function cleanup(){
        cancelBtn.removeEventListener('click', onCancel);
        saveBtn.removeEventListener('click', onSave);
    }
}

// Dashboard testimonial management functions
function loadDashboardTestimonials() {
    const container = document.getElementById('dashboard-testimonials');
    if (!container) return;
    container.innerHTML = '<div style="background: #08090D; border: 1px solid #A1A69C; border-radius: 8px; padding: 16px;"><p style="color:#A1A69C; font-size:14px;">Loading testimonials…</p></div>';

    fetch('api/testimonials.php', { credentials: 'same-origin' })
      .then(r => r.json())
      .then(json => {
          container.innerHTML = '';
          if (!json || !json.ok || !Array.isArray(json.data) || json.data.length === 0) {
              container.innerHTML = '<div style="background:#08090D; border:1px solid #A1A69C; border-radius:8px; padding:16px;"><p style="color:#A1A69C; font-size:14px;">No testimonials yet.</p></div>';
              return;
          }
          json.data.forEach(item => {
              const card = document.createElement('div');
              card.className = 'dashboard-testimonial-card';
              card.style.background = '#08090D';
              card.style.border = '1px solid #A1A69C';
              card.style.borderRadius = '8px';
              card.style.padding = '16px';
              card.innerHTML = `
                <p style="color:#A1A69C; font-size:14px; margin-bottom:8px;">${escapeHtml(item.quote)}</p>
                <div style="display:flex; align-items:center;">
                    <div style="width:32px; height:32px; background:#292c3a; border-radius:50%; display:flex; align-items:center; justify-content:center; color:#A1A69C; margin-right:8px;">
                        <i class="fas fa-user"></i>
                    </div>
                    <span style="color:#fff; font-size:13px;">${escapeHtml(item.name)}${item.role ? ' • ' + escapeHtml(item.role) : ''}</span>
                </div>
                <div style="margin-top:8px; display:flex; gap:8px;">
                    <button class="btn btn-primary btn-edit-testimonial" style="padding: 4px 8px; font-size: 12px;" data-id="${item.id}">Edit</button>
                    <button class="btn btn-secondary btn-delete-testimonial" style="padding: 4px 8px; font-size: 12px;" data-id="${item.id}">Delete</button>
                </div>
              `;
              container.appendChild(card);
          });

          // Bind edit/delete actions
          container.querySelectorAll('.btn-edit-testimonial').forEach(btn => {
              btn.addEventListener('click', function(){
                  const id = Number(this.getAttribute('data-id'));
                  const card = this.closest('.dashboard-testimonial-card');
                  if (!card) return;
                  const quoteEl = card.querySelector('p');
                  const nameSpan = card.querySelector('span');
                  const currentText = quoteEl ? quoteEl.textContent : '';
                  const nameRoleText = nameSpan ? nameSpan.textContent : '';
                  const parts = nameRoleText.split(' • ');
                  const currentName = parts[0] || '';
                  const currentRole = parts[1] || '';
                  openTestimonialModal('edit', { id, name: currentName, role: currentRole, quote: currentText });
              });
          });

          container.querySelectorAll('.btn-delete-testimonial').forEach(btn => {
              btn.addEventListener('click', function(){
                  const id = Number(this.getAttribute('data-id'));
                  if (!confirm('Delete this testimonial?')) return;
                  fetch('api/admin/testimonials.php', {
                      method: 'POST',
                      headers: { 'Content-Type': 'application/json' },
                      credentials: 'same-origin',
                      body: JSON.stringify({ action: 'delete', id })
                  }).then(r=>r.json()).then(resp=>{
                      if (resp && resp.ok) {
                          loadDashboardTestimonials();
                      } else {
                          alert('Failed to delete testimonial');
                      }
                  }).catch(()=>alert('Failed to delete testimonial'));
              });
          });
      })
      .catch(() => {
          container.innerHTML = '<div style="background:#08090D; border:1px solid #A1A69C; border-radius:8px; padding:16px;"><p style="color:#A1A69C; font-size:14px;">Failed to load testimonials.</p></div>';
      });
}

// Load Kind Words page content values
function loadKindWordsPageContent(){
    fetch('api/admin/page_content.php?page=kind-words&section=page_title', { credentials: 'same-origin' })
      .then(r=>r.json()).then(j=>{ if (j && j.ok && j.content != null) { const el=document.getElementById('kw-page-title'); if (el) el.value = j.content; } });
    fetch('api/admin/page_content.php?page=kind-words&section=page_description', { credentials: 'same-origin' })
      .then(r=>r.json()).then(j=>{ if (j && j.ok && j.content != null) { const el=document.getElementById('kw-page-desc'); if (el) el.value = j.content; } });
}

// Save page content helper
function savePageContent(page, section, content){
    return fetch('api/admin/page_content.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        credentials: 'same-origin',
        body: JSON.stringify({ page, section, content })
    }).then(r=>r.json()).catch(()=>({ ok:false }));
}

