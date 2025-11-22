# Resume PDF Setup Guide

## Current Implementation

The resume system is now set up with:
- **resume.php** - Displays the resume in a web-friendly format
- **resume-pdf.php** - Generates PDF downloads

## PDF Generation Options

### Option 1: Browser Print to PDF (Current - No Setup Required)

The current implementation uses the browser's built-in "Print to PDF" functionality. When users click "Download as PDF", they'll be redirected to the resume page with a print dialog that allows them to save as PDF.

**Pros:**
- No additional setup required
- Works immediately
- High quality output
- Supports all CSS styling

**Cons:**
- Requires user interaction (clicking print dialog)
- Not fully automated

### Option 2: Dompdf Library (Recommended for Automated PDFs)

For fully automated PDF generation without user interaction, install Dompdf:

#### Installation via Composer:

```bash
composer require dompdf/dompdf
```

#### Manual Installation:

1. Download Dompdf from: https://github.com/dompdf/dompdf/releases
2. Extract to `vendor/dompdf/dompdf/` in your project root
3. The resume-pdf.php will automatically detect and use it

#### After Installation:

Once Dompdf is installed, `resume-pdf.php` will automatically:
- Generate PDFs server-side
- Download directly without user interaction
- Maintain formatting and styling

## Resume Data Structure

Resume data is stored in the `site_settings` table. The following fields are used:

### Basic Fields:
- `owner_name` - Full name
- `owner_title` - Professional title
- `email` - Contact email
- `phone` - Phone number
- `location` - Location/address
- `linkedin` - LinkedIn URL
- `github` - GitHub URL
- `website` - Personal website
- `skills` - Comma-separated list of skills
- `tools` - Comma-separated list of tools/technologies

### Resume-Specific Fields (JSON format recommended):

#### `resume_summary`
Plain text summary/bio

#### `resume_experience` (JSON array)
```json
[
  {
    "title": "Job Title",
    "company": "Company Name",
    "period": "2020 - Present",
    "description": "Job description",
    "achievements": [
      "Achievement 1",
      "Achievement 2"
    ]
  }
]
```

#### `resume_education` (JSON array)
```json
[
  {
    "degree": "Bachelor of Science in Computer Science",
    "school": "University Name",
    "year": "2020",
    "details": "Additional details"
  }
]
```

#### `resume_certifications` (JSON array)
```json
[
  {
    "name": "Certification Name",
    "issuer": "Issuing Organization",
    "year": "2023"
  }
]
```

## Managing Resume Content

Resume content can be managed through:
1. **Dashboard** - Add resume management section (future enhancement)
2. **Database** - Directly update `site_settings` table
3. **API** - Use `api/admin/settings.php` endpoint

## Testing

1. Visit `resume.php` to view the resume
2. Click "Download as PDF" to test PDF generation
3. Click "Print" to test print functionality

## Notes

- The resume page is print-friendly with optimized CSS for PDF output
- All styling is responsive and works on both screen and print
- The system gracefully falls back to browser print if Dompdf is not installed

