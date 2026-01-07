📄 ATS-Friendly Markdown Resume Generator

A lightweight, self-hosted tool to write resumes in Markdown and export them as clean, ATS-optimized HTML.
No complex setups, no databases, no PDF parsing errors. Just write, preview, and save.
🔴 View Live Demo · Report Bug · Request Feature

📸 Screenshot

[![Main page - ATS-Friendly Markdown Resume Generator](/assets/main_page.png)]

🚀 Why this project?
Modern Applicant Tracking Systems (ATS) often struggle with complex PDF layouts, columns, and icons. The safest bet for parsing is a clean, semantic HTML document.
This tool allows you to:

Write in Markdown: Focus on content, not formatting.
Real-time Preview: See how it looks as you type.
Target Multiple Countries: Create different versions of your resume for specific markets (e.g., Resume_Brazil, Resume_USA) identified by flags.
ATS Optimization: The exported HTML is stripped of CSS frameworks (Bootstrap), using only semantic tags (<h1>, <ul>, <p>) and standard system fonts to ensure 100% readability by robots.

✨ Features

Split-Screen Editor: Markdown input on the left, live HTML preview on the right.
Smart Saving (Ctrl+S): Instantly saves your work to the server.
Dual File Generation: - .md file (Source of truth for editing).

.html file (Clean output for distribution).

Template System: Starts new resumes with a professional placeholder structure.
FlagCDN Integration: Visual indicators for country-specific versions using ISO codes.
Flat-File Storage: No database required (MySQL/PostgreSQL). Data is stored in local files.

🛠️ Tech Stack

Backend: PHP (Native)
Frontend: HTML5, Bootstrap 4 (Editor UI only), jQuery
Markdown Parser: Marked.js
Icons: FlagCDN

⚙️ Installation & Usage
You can run this project locally without installing complex dependencies like Composer or Node.js. You just need PHP installed.
Prerequisites

PHP 7.4 or higher.

Steps

Clone the repository
git clone [https://github.com/GuelBandeira/resume-generator.git](https://github.com/GuelBandeira/resume-generator.git)cd resume-generator
