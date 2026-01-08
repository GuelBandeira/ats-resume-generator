# 📄 ATS-Friendly Markdown Resume Generator

[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)
[![PHP](https://img.shields.io/badge/PHP-7.4%2B-blue)](https://www.php.net/)
[![Maintenance](https://img.shields.io/badge/Maintained%3F-yes-green.svg)](https://github.com/GuelBandeira/resume-generator/graphs/commit-activity)

A lightweight, self-hosted tool to write resumes in **Markdown** and export them as **clean, ATS-optimized HTML**. 

No complex setups, no databases, no PDF parsing errors. Just write, preview, and save.

<a target="_blank" href="https://guelbandeira.github.io/ats-resume-generator/">**🟢View Live Demo**</a> · [Report Bug](https://github.com/GuelBandeira/ats-resume-generator/issues) · [Request Feature](https://github.com/GuelBandeira/ats-resume-generator/issues)

---

## 📸 Screenshot

![Application Screenshot](/assets/main_page.png)

## 🚀 Why this project?

Modern Applicant Tracking Systems (ATS) often struggle with complex PDF layouts, columns, and icons. The safest bet for parsing is a clean, semantic HTML document. 

This tool allows you to:
1.  **Write in Markdown:** Focus on content, not formatting.
2.  **Real-time Preview:** See how it looks as you type.
3.  **Target Multiple Countries:** Create different versions of your resume for specific markets (e.g., `Resume_Brazil`, `Resume_USA`) identified by flags.
4.  **ATS Optimization:** The exported HTML is stripped of CSS frameworks (Bootstrap), using only semantic tags (`<h1>`, `<ul>`, `<p>`) and standard system fonts to ensure 100% readability by robots.

## ✨ Features

- **Split-Screen Editor:** Markdown input on the left, live HTML preview on the right.
- **Smart Saving (Ctrl+S):** Instantly saves your work to the server.
- **Dual File Generation:** - `.md` file (Source of truth for editing).
  - `.html` file (Clean output for distribution).
- **Template System:** Starts new resumes with a professional placeholder structure.
- **FlagCDN Integration:** Visual indicators for country-specific versions using ISO codes.
- **Flat-File Storage:** No database required (MySQL/PostgreSQL). Data is stored in local files.

## 🛠️ Tech Stack

- **Backend:** PHP (Native)
- **Frontend:** HTML5, Bootstrap 4 (Editor UI only), jQuery
- **Markdown Parser:** [Marked.js](https://github.com/markedjs/marked)
- **Icons:** [FlagCDN](https://flagcdn.com/)

## ⚙️ Installation & Usage

You can run this project locally without installing complex dependencies like Composer or Node.js. You just need PHP installed.

### Prerequisites

- PHP 7.4 or higher.

### Steps

1. **Clone the repository**
   ```bash
   git clone [https://github.com/YOUR_USERNAME/resume-generator.git](https://github.com/YOUR_USERNAME/resume-generator.git)
   cd resume-generator
   ```
