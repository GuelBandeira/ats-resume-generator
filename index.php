<?php
// --- CONFIGURAÇÃO E LÓGICA PHP (BACKEND) ---

// Mapeamento: Nome do País => Código ISO (para buscar na API)
$countries = [
   "United States" => "us",
   "Brazil"        => "br",
   "United Kingdom" => "gb",
   "Canada"        => "ca",
   "Germany"       => "de",
   "France"        => "fr",
   "Japan"         => "jp",
   "China"         => "cn",
   "India"         => "in",
   "Australia"     => "au",
   "Italy"         => "it",
   "Spain"         => "es",
   "Portugal"      => "pt",
   "Russia"        => "ru",
   "Mexico"        => "mx"
];

// 1. AÇÃO: CRIAR NOVO ARQUIVO (Fonte .md)
if (isset($_POST['create_resume'])) {
   $selectedCountry = $_POST['country_name'];

   // Define nome base
   if ($selectedCountry === "United States") {
      $baseName = "Resume";
   } else {
      $cleanName = strtolower(str_replace(' ', '_', $selectedCountry));
      $baseName = "Resume_" . $cleanName;
   }

   $filenameMD = $baseName . ".md";

   // TEMPLATE OTIMIZADO PARA ATS
   if (!file_exists($filenameMD)) {
      $defaultContent = <<<EOT
# [YOUR NAME]
[City, State, Zip Code] | [Phone Number] | [Email Address]
[LinkedIn Profile URL] | [Portfolio URL]

## PROFESSIONAL SUMMARY
Results-oriented [Job Title] with [Number] years of experience in [Core Skill 1] and [Core Skill 2]. Committed to professional growth in **$selectedCountry**.

## WORK EXPERIENCE

### [Most Recent Company Name] | [City, State]
**[Job Title]** | *[Month, Year] – Present*
* Spearheaded [Project Name], resulting in a [Number]% increase in [Metric].
* Developed [System/Process] using [Technology/Tool], reducing processing time by [Number]%.

### [Previous Company Name] | [City, State]
**[Job Title]** | *[Month, Year] – [Month, Year]*
* Managed [Responsibility], overseeing a budget of $[Amount].
* Resolved [Specific Problem] by implementing [Solution].

## EDUCATION

**[University Name]** | [City, State]
**[Degree Name] in [Major]** | *[Month, Year]*
* Relevant Coursework: [Subject 1], [Subject 2]

## TECHNICAL SKILLS

* **Languages:** [Skill 1], [Skill 2]
* **Tools:** [Tool 1], [Tool 2]
EOT;

      file_put_contents($filenameMD, $defaultContent);
   }

   header("Location: " . $_SERVER['PHP_SELF']);
   exit;
}

// 2. AÇÃO: AJAX - CARREGAR CONTEÚDO
if (isset($_GET['action']) && $_GET['action'] == 'load' && isset($_GET['file'])) {
   $file = basename($_GET['file']);
   if (file_exists($file)) echo file_get_contents($file);
   exit;
}

// 3. AÇÃO: AJAX - SALVAR (GERA O HTML LIMPO PARA ATS)
if (isset($_POST['action']) && $_POST['action'] == 'save') {
   $fileMD = basename($_POST['file']);
   $contentMD = $_POST['content'];
   $contentHTML = $_POST['html_content'];

   // Salva o Markdown
   file_put_contents($fileMD, $contentMD);

   // GERA O ARQUIVO FINAL HTML (SEM BOOTSTRAP, ESTILO DOC WORD)
   $fileHTML = str_replace('.md', '.html', $fileMD);

   $finalHTML = "<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Resume</title>
    <style>
        /* ESTILO OTIMIZADO PARA ATS */
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11pt;
            line-height: 1.5;
            color: #000000;
            margin: 0;
            padding: 40px;
            background-color: #ffffff;
        }
        .resume-container { max-width: 800px; margin: 0 auto; }
        h1 { font-size: 22pt; text-transform: uppercase; margin-bottom: 5px; border-bottom: 2px solid #000; padding-bottom: 5px; }
        h2 { font-size: 14pt; text-transform: uppercase; margin-top: 20px; margin-bottom: 10px; border-bottom: 1px solid #ccc; }
        h3 { font-size: 12pt; font-weight: bold; margin-top: 15px; margin-bottom: 5px; }
        a { color: #000; text-decoration: none; }
        ul { margin-top: 5px; margin-bottom: 15px; padding-left: 20px; }
        li { margin-bottom: 3px; }
        strong { font-weight: bold; }
        p { margin-bottom: 10px; }
    </style>
</head>
<body>
    <div class='resume-container'>
        $contentHTML
    </div>
</body>
</html>";

   file_put_contents($fileHTML, $finalHTML);
   echo "success";
   exit;
}

// Lista arquivos .md existentes
$existingFiles = glob("Resume*.md");
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>ATS Resume Editor</title>
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
   <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

   <style>
      body {
         height: 100vh;
         overflow: hidden;
         background-color: #f8f9fa;
      }

      .sidebar {
         height: 100vh;
         overflow-y: auto;
         border-right: 1px solid #dee2e6;
         background: white;
         padding: 20px;
      }

      .editor-container {
         height: 100vh;
         padding: 0;
         display: flex;
         flex-direction: column;
      }

      .toolbar {
         background: #343a40;
         color: white;
         padding: 10px 20px;
         display: flex;
         justify-content: space-between;
         align-items: center;
      }

      .split-view {
         display: flex;
         flex: 1;
         height: 100%;
      }

      /* Ajuste das Bandeiras */
      .flag-icon {
         width: 24px;
         border-radius: 2px;
         margin-right: 10px;
         border: 1px solid #eee;
         box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
      }

      #markdown-input {
         width: 50%;
         height: 100%;
         border: none;
         padding: 20px;
         font-family: 'Courier New', Courier, monospace;
         background-color: #2b2b2b;
         color: #f8f8f2;
         resize: none;
         outline: none;
         font-size: 14px;
      }

      /* Preview ATS */
      #html-preview {
         width: 50%;
         height: 100%;
         padding: 40px;
         overflow-y: auto;
         background-color: white;
         border-left: 1px solid #ddd;
         font-family: Arial, Helvetica, sans-serif;
         color: #000;
      }

      #html-preview h1 {
         border-bottom: 2px solid #000;
         text-transform: uppercase;
         font-size: 22pt;
      }

      #html-preview h2 {
         border-bottom: 1px solid #ccc;
         text-transform: uppercase;
         font-size: 14pt;
         margin-top: 20px;
      }

      .file-item {
         cursor: pointer;
         transition: 0.2s;
         display: flex;
         align-items: center;
      }

      .file-item:hover {
         background-color: #f1f1f1;
      }

      .file-item.active {
         background-color: #e9ecef;
         border-left: 4px solid #007bff;
      }

      #toast {
         visibility: hidden;
         min-width: 250px;
         background-color: #28a745;
         color: #fff;
         text-align: center;
         border-radius: 4px;
         padding: 16px;
         position: fixed;
         z-index: 1;
         right: 30px;
         bottom: 30px;
         font-size: 17px;
      }

      #toast.show {
         visibility: visible;
         -webkit-animation: fadein 0.5s, fadeout 0.5s 2.5s;
         animation: fadein 0.5s, fadeout 0.5s 2.5s;
      }

      @keyframes fadein {
         from {
            bottom: 0;
            opacity: 0;
         }

         to {
            bottom: 30px;
            opacity: 1;
         }
      }

      @keyframes fadeout {
         from {
            bottom: 30px;
            opacity: 1;
         }

         to {
            bottom: 0;
            opacity: 0;
         }
      }
   </style>
</head>

<body>

   <div class="container-fluid">
      <div class="row">
         <div class="col-md-3 sidebar">
            <h4>ATS Ready Resumes</h4>
            <hr>
            <form method="POST" class="mb-4">
               <div class="form-group">
                  <label>Select Target Country</label>
                  <select class="form-control" name="country_name">
                     <?php foreach ($countries as $name => $code) : ?>
                        <option value="<?= $name ?>" <?= $name == 'United States' ? 'selected' : '' ?>><?= $name ?></option>
                     <?php endforeach; ?>
                  </select>
               </div>
               <button type="submit" name="create_resume" class="btn btn-dark btn-block">Create New</button>
            </form>

            <div class="list-group">
               <?php foreach ($existingFiles as $file) :
                  $displayName = str_replace(['Resume_', '.md'], '', $file);
                  if ($file == 'Resume.md') $displayName = 'United States';

                  // Lógica para encontrar o código da bandeira baseado no nome
                  $isoCode = 'us'; // Padrão
                  $found = false;
                  foreach ($countries as $cName => $cCode) {
                     // Compara nome do país com o nome do arquivo (normalizado)
                     if (strtolower(str_replace(' ', '_', $cName)) == strtolower($displayName)) {
                        $isoCode = $cCode;
                        $found = true;
                        break;
                     }
                  }
                  // URL da Bandeira (FlagCDN)
                  $flagUrl = "https://flagcdn.com/w40/" . $isoCode . ".png";
               ?>
                  <a href="#" class="list-group-item list-group-item-action file-item" onclick="loadFile('<?= $file ?>', this)">
                     <img src="<?= $flagUrl ?>" class="flag-icon" alt="<?= $displayName ?>">
                     <?= $displayName ?>
                  </a>
               <?php endforeach; ?>
            </div>
         </div>

         <div class="col-md-9 editor-container">
            <div class="toolbar">
               <span id="current-file-label">Select a file to edit...</span>
               <div>
                  <button class="btn btn-success btn-sm" onclick="saveFile()">Save (Ctrl+S)</button>
                  <a id="view-html-btn" href="#" target="_blank" class="btn btn-light text-dark btn-sm border" style="display:none;">View Clean HTML</a>
               </div>
            </div>

            <div class="split-view">
               <textarea id="markdown-input" placeholder="# Select a file on the left..." disabled></textarea>
               <div id="html-preview"></div>
            </div>
         </div>
      </div>
   </div>

   <div id="toast">Saved (ATS Optimized)!</div>

   <script>
      let currentFile = null;
      const mdInput = document.getElementById('markdown-input');
      const htmlPreview = document.getElementById('html-preview');
      const label = document.getElementById('current-file-label');
      const viewBtn = document.getElementById('view-html-btn');

      function loadFile(filename, element) {
         currentFile = filename;
         $('.file-item').removeClass('active');
         $(element).addClass('active');
         label.innerText = "Editing: " + filename;
         viewBtn.href = filename.replace('.md', '.html');
         viewBtn.style.display = 'inline-block';
         mdInput.disabled = false;

         $.get('?action=load&file=' + filename, function(data) {
            mdInput.value = data;
            updatePreview();
         });
      }

      function updatePreview() {
         const markdownText = mdInput.value;
         htmlPreview.innerHTML = marked.parse(markdownText);
      }

      mdInput.addEventListener('input', updatePreview);

      function saveFile() {
         if (!currentFile) return alert("Select a file first!");
         const contentHTML = htmlPreview.innerHTML;

         $.post('index.php', {
            action: 'save',
            file: currentFile,
            content: mdInput.value,
            html_content: contentHTML
         }, function(response) {
            if (response.trim() === 'success') showToast();
            else alert("Error saving file.");
         });
      }

      document.addEventListener('keydown', function(e) {
         if ((e.ctrlKey || e.metaKey) && e.key === 's') {
            e.preventDefault();
            saveFile();
         }
      });

      function showToast() {
         var x = document.getElementById("toast");
         x.className = "show";
         setTimeout(function() {
            x.className = x.className.replace("show", "");
         }, 3000);
      }
   </script>
</body>

</html>