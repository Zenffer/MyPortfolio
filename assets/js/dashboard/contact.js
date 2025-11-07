// ===== Contact Management: Load and Save =====
function loadContactSettings() {
    fetch('api/admin/settings.php?keys=contact_email,contact_phone,contact_location,contact_website,contact_linkedin,contact_instagram,contact_twitter,contact_github,contact_behance,contact_dribbble', { credentials: 'same-origin' })
      .then(r=>r.json()).then(resp=>{
        if (!resp || !resp.ok) return;
        const d = resp.data || {};
        const emailEl = document.getElementById('contact-email');
        const phoneEl = document.getElementById('contact-phone');
        const locationEl = document.getElementById('contact-location');
        const websiteEl = document.getElementById('contact-website');
        const linkedinEl = document.getElementById('contact-linkedin');
        const instagramEl = document.getElementById('contact-instagram');
        const twitterEl = document.getElementById('contact-twitter');
        const githubEl = document.getElementById('contact-github');
        const behanceEl = document.getElementById('contact-behance');
        const dribbbleEl = document.getElementById('contact-dribbble');
        
        if (emailEl) emailEl.value = d.contact_email || '';
        if (phoneEl) phoneEl.value = d.contact_phone || '';
        if (locationEl) locationEl.value = d.contact_location || '';
        if (websiteEl) websiteEl.value = d.contact_website || '';
        if (linkedinEl) linkedinEl.value = d.contact_linkedin || '';
        if (instagramEl) instagramEl.value = d.contact_instagram || '';
        if (twitterEl) twitterEl.value = d.contact_twitter || '';
        if (githubEl) githubEl.value = d.contact_github || '';
        if (behanceEl) behanceEl.value = d.contact_behance || '';
        if (dribbbleEl) dribbbleEl.value = d.contact_dribbble || '';
      });
}

// Load contact messages with pagination
function loadContactMessages(page) {
    if (!page || page < 1) page = 1;
    window.__cmPage = page;
    
    fetch(`api/admin/contact_messages.php?page=${page}&pageSize=20`, { credentials: 'same-origin' })
        .then(r => r.json())
        .then(resp => {
            if (!resp || !resp.ok) {
                document.getElementById('contactMessagesContainer').innerHTML = '<p style="color:#A1A69C;">Failed to load messages.</p>';
                return;
            }
            
            const container = document.getElementById('contactMessagesContainer');
            const pageInfo = document.getElementById('cmPageInfo');
            const total = resp.total || 0;
            const pageSize = resp.pageSize || 20;
            const totalPages = Math.ceil(total / pageSize);
            
            if (pageInfo) {
                pageInfo.textContent = `Page ${page} of ${totalPages || 1}`;
            }
            
            // Update pagination buttons
            const prevBtn = document.getElementById('cmPrev');
            const nextBtn = document.getElementById('cmNext');
            if (prevBtn) prevBtn.disabled = (page <= 1);
            if (nextBtn) nextBtn.disabled = (page >= totalPages);
            
            container.innerHTML = '';
            if (!resp.data || resp.data.length === 0) {
                container.innerHTML = '<p style="color:#A1A69C;">No messages yet.</p>';
                return;
            }
            
            resp.data.forEach(msg => {
                const card = document.createElement('div');
                card.style.cssText = 'background: #08090D; border: 1px solid #A1A69C; border-radius: 8px; padding: 16px;';
                card.innerHTML = `
                    <h4 style="color: #fff; margin-bottom: 8px;">${escapeHtml(msg.name || 'Anonymous')}</h4>
                    <p style="color: #A1A69C; font-size: 12px; margin-bottom: 4px;">${escapeHtml(msg.email || '')}</p>
                    ${msg.subject ? `<p style="color: #fff; font-size: 14px; margin-bottom: 8px;"><strong>${escapeHtml(msg.subject)}</strong></p>` : ''}
                    <p style="color: #A1A69C; font-size: 13px; margin-bottom: 8px;">${escapeHtml(msg.message || '')}</p>
                    <p style="color: #A1A69C; font-size: 11px; margin-bottom: 8px;">${new Date(msg.created_at).toLocaleString()}</p>
                    <button class="btn btn-secondary cm-delete" style="padding: 4px 8px; font-size: 12px;" data-id="${msg.id}">Delete</button>
                `;
                container.appendChild(card);
            });
        })
        .catch(() => {
            document.getElementById('contactMessagesContainer').innerHTML = '<p style="color:#A1A69C;">Failed to load messages.</p>';
        });
}

// Change contact messages page
function changeContactMessagesPage(delta) {
    const currentPage = window.__cmPage || 1;
    const newPage = currentPage + delta;
    if (newPage >= 1) {
        loadContactMessages(newPage);
    }
}

