<?php
/**
 * Resume PDF Generator
 * Generates a PDF version of the resume
 */

require_once 'db.php';
$config = $db_config;

// Get resume data from site settings
$owner_name = getSiteSetting($config, 'owner_name', 'Jeroboam T. Oliveros');
$owner_title = getSiteSetting($config, 'owner_title', 'Developer, Photographer & Cosplayer');
$email = getSiteSetting($config, 'email', 'hello@example.com');
$phone = getSiteSetting($config, 'phone', '');
$location = getSiteSetting($config, 'location', '');
$linkedin = getSiteSetting($config, 'linkedin', 'https://www.linkedin.com');
$github = getSiteSetting($config, 'github', '');
$website = getSiteSetting($config, 'website', '');
$bio = getSiteSetting($config, 'bio', 'I craft clean, performant web experiences and tell stories through images and character work.');
$skills_csv = getSiteSetting($config, 'skills', 'HTML/CSS, JavaScript, PHP, MySQL, jQuery, REST APIs, Responsive UI');
$tools_csv = getSiteSetting($config, 'tools', 'VS Code, Git & GitHub, Docker, Postman, Figma, Adobe Photoshop');

// Resume-specific fields
$resume_summary = getSiteSetting($config, 'resume_summary', $bio);
$resume_education = getSiteSetting($config, 'resume_education', '');
$resume_experience = getSiteSetting($config, 'resume_experience', '');
$resume_projects = getSiteSetting($config, 'resume_projects', '');
$resume_certifications = getSiteSetting($config, 'resume_certifications', '');

// Check if Dompdf is available
$dompdf_path = __DIR__ . '/vendor/dompdf/dompdf/src/Dompdf.php';
$use_dompdf = file_exists($dompdf_path);

if ($use_dompdf) {
    // Use Dompdf if available
    require_once __DIR__ . '/vendor/dompdf/dompdf/autoload.inc.php';
    
    // Check if classes are available after loading
    if (class_exists('\Dompdf\Dompdf') && class_exists('\Dompdf\Options')) {
        // Use fully qualified class names to avoid use statement issues
        $options = new \Dompdf\Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        
        $dompdf = new \Dompdf\Dompdf($options);
        
        // Build HTML content
        $html = buildResumeHTML($owner_name, $owner_title, $email, $phone, $location, $linkedin, $github, $website, 
                               $resume_summary, $skills_csv, $tools_csv, $resume_experience, $resume_education, $resume_certifications);
        
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        
        // Output PDF
        $filename = 'Resume_' . preg_replace('/[^a-zA-Z0-9]/', '_', $owner_name) . '.pdf';
        $dompdf->stream($filename, array('Attachment' => 1));
        exit;
    }
}

// Fallback: Use browser print to PDF if Dompdf is not available or failed
// Redirect to resume page with print parameter and auto-trigger print dialog
header('Location: resume.php?print=1');
exit;

function buildResumeHTML($owner_name, $owner_title, $email, $phone, $location, $linkedin, $github, $website,
                        $resume_summary, $skills_csv, $tools_csv, $resume_experience, $resume_education, $resume_certifications) {
    $html = '<style>
        body { font-family: Arial, sans-serif; line-height: 1.6; }
        h1 { font-size: 24px; margin: 0 0 5px 0; color: #000; }
        h2 { font-size: 18px; margin: 20px 0 10px 0; color: #333; border-bottom: 2px solid #333; padding-bottom: 5px; }
        h3 { font-size: 14px; margin: 15px 0 5px 0; color: #000; }
        .header { text-align: center; margin-bottom: 20px; }
        .title { font-size: 14px; color: #666; margin: 0 0 15px 0; }
        .contact { font-size: 11px; color: #666; margin: 10px 0; }
        .contact span { margin: 0 10px; }
        .section { margin-bottom: 15px; }
        .item { margin-bottom: 12px; }
        .meta { font-size: 11px; color: #666; margin: 5px 0; }
        ul { margin: 5px 0; padding-left: 20px; }
        li { margin: 3px 0; font-size: 11px; }
        .skills { margin: 10px 0; }
        .skill-tag { display: inline-block; background: #f0f0f0; padding: 3px 8px; margin: 3px 5px 3px 0; border-radius: 3px; font-size: 10px; }
        p { margin: 8px 0; font-size: 11px; }
    </style>';
    
    $html .= '<div class="header">';
    $html .= '<h1>' . htmlspecialchars($owner_name) . '</h1>';
    $html .= '<p class="title">' . htmlspecialchars($owner_title) . '</p>';
    $html .= '<div class="contact">';
    if ($email) $html .= '<span>' . htmlspecialchars($email) . '</span>';
    if ($phone) $html .= '<span>' . htmlspecialchars($phone) . '</span>';
    if ($location) $html .= '<span>' . htmlspecialchars($location) . '</span>';
    if ($linkedin && $linkedin !== '#') $html .= '<span>LinkedIn</span>';
    if ($github) $html .= '<span>GitHub</span>';
    $html .= '</div>';
    $html .= '</div>';
    
    if ($resume_summary) {
        $html .= '<div class="section">';
        $html .= '<h2>Summary</h2>';
        $html .= '<p>' . nl2br(htmlspecialchars($resume_summary)) . '</p>';
        $html .= '</div>';
    }
    
    if ($skills_csv) {
        $skills = array_filter(array_map('trim', explode(',', $skills_csv)));
        $html .= '<div class="section">';
        $html .= '<h2>Skills</h2>';
        $html .= '<div class="skills">';
        foreach ($skills as $skill) {
            $html .= '<span class="skill-tag">' . htmlspecialchars($skill) . '</span>';
        }
        $html .= '</div>';
        $html .= '</div>';
    }
    
    if ($resume_experience) {
        $html .= '<div class="section">';
        $html .= '<h2>Experience</h2>';
        $experiences = json_decode($resume_experience, true);
        if (is_array($experiences)) {
            foreach ($experiences as $exp) {
                $html .= '<div class="item">';
                $html .= '<h3>' . htmlspecialchars($exp['title'] ?? '') . '</h3>';
                $html .= '<div class="meta">';
                if (!empty($exp['company'])) $html .= '<strong>' . htmlspecialchars($exp['company']) . '</strong>';
                if (!empty($exp['period'])) $html .= ' • ' . htmlspecialchars($exp['period']);
                $html .= '</div>';
                if (!empty($exp['description'])) {
                    $html .= '<p>' . nl2br(htmlspecialchars($exp['description'])) . '</p>';
                }
                if (!empty($exp['achievements']) && is_array($exp['achievements'])) {
                    $html .= '<ul>';
                    foreach ($exp['achievements'] as $achievement) {
                        $html .= '<li>' . htmlspecialchars($achievement) . '</li>';
                    }
                    $html .= '</ul>';
                }
                $html .= '</div>';
            }
        } else {
            $html .= '<p>' . nl2br(htmlspecialchars($resume_experience)) . '</p>';
        }
        $html .= '</div>';
    }
    
    if ($resume_education) {
        $html .= '<div class="section">';
        $html .= '<h2>Education</h2>';
        $educations = json_decode($resume_education, true);
        if (is_array($educations)) {
            foreach ($educations as $edu) {
                $html .= '<div class="item">';
                $html .= '<h3>' . htmlspecialchars($edu['degree'] ?? '') . '</h3>';
                $html .= '<div class="meta">';
                if (!empty($edu['school'])) $html .= '<strong>' . htmlspecialchars($edu['school']) . '</strong>';
                if (!empty($edu['year'])) $html .= ' • ' . htmlspecialchars($edu['year']);
                $html .= '</div>';
                if (!empty($edu['details'])) {
                    $html .= '<p>' . nl2br(htmlspecialchars($edu['details'])) . '</p>';
                }
                $html .= '</div>';
            }
        } else {
            $html .= '<p>' . nl2br(htmlspecialchars($resume_education)) . '</p>';
        }
        $html .= '</div>';
    }
    
    if ($tools_csv) {
        $tools = array_filter(array_map('trim', explode(',', $tools_csv)));
        $html .= '<div class="section">';
        $html .= '<h2>Tools & Technologies</h2>';
        $html .= '<div class="skills">';
        foreach ($tools as $tool) {
            $html .= '<span class="skill-tag">' . htmlspecialchars($tool) . '</span>';
        }
        $html .= '</div>';
        $html .= '</div>';
    }
    
    if ($resume_certifications) {
        $html .= '<div class="section">';
        $html .= '<h2>Certifications</h2>';
        $certs = json_decode($resume_certifications, true);
        if (is_array($certs)) {
            foreach ($certs as $cert) {
                $html .= '<div class="item">';
                $html .= '<h3>' . htmlspecialchars($cert['name'] ?? '') . '</h3>';
                $html .= '<div class="meta">';
                if (!empty($cert['issuer'])) $html .= '<strong>' . htmlspecialchars($cert['issuer']) . '</strong>';
                if (!empty($cert['year'])) $html .= ' • ' . htmlspecialchars($cert['year']);
                $html .= '</div>';
                $html .= '</div>';
            }
        } else {
            $html .= '<p>' . nl2br(htmlspecialchars($resume_certifications)) . '</p>';
        }
        $html .= '</div>';
    }
    
    return $html;
}
?>

