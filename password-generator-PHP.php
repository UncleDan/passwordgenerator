<?php
// Lettura parole da file
$filename = __DIR__ . '/vocabolario.txt';  // nome file aggiornato
if (!file_exists($filename)) {
    die('File vocabolario.txt non trovato.');
}

$lines = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
if (count($lines) < 160) {
    die('Il file vocabolario.txt deve contenere almeno 160 parole.');
}

// Divido le parole in 4 gruppi da 40 parole ciascuno
$groups = [
    'animali' => array_slice($lines, 0, 40),
    'colori' => array_slice($lines, 40, 40),
    'fiori' => array_slice($lines, 80, 40),
    'frutti' => array_slice($lines, 120, 40)
];

$special_chars = ['!', '$', '%', '&', '+', '_'];

function generatePassword($word, $special_chars) {
    $word_len = strlen($word);
    $total_len = 12;
    $fill_len = $total_len - $word_len;
    if ($fill_len < 1) return null;

    // Maiuscola iniziale della parola
    $word = ucfirst($word);

    // Scegli un carattere speciale
    $special = $special_chars[array_rand($special_chars)];

    // Genera numeri casuali per riempire gli altri caratteri (fill_len-1 numeri)
    $numbers = '';
    for ($i = 0; $i < $fill_len - 1; $i++) {
        $numbers .= rand(0, 9);
    }

    // Posiziona il carattere speciale in posizione casuale dentro la parte numerica
    $pos = rand(0, strlen($numbers));
    $password_fill = substr($numbers, 0, $pos) . $special . substr($numbers, $pos);

    return $word . $password_fill;
}

// Genera 10 password per ogni gruppo
$passwords = [];
foreach ($groups as $group_name => $words) {
    for ($i = 0; $i < 10; $i++) {
        // Parola casuale nel gruppo
        $word = $words[array_rand($words)];
        $pwd = generatePassword($word, $special_chars);
        if ($pwd === null) {
            $i--; // rigenera se fallisce
            continue;
        }
        $passwords[$group_name][] = $pwd;
    }
}

// Colori pulsanti
$btn_colors = [
    '#FFD700', // giallo
    '#FF00FF', // magenta
    '#00FFFF', // ciano
    '#FFA500', // arancione
    '#800080', // viola
    '#008000'  // verde
];

// Funzione per determinare colore testo in base a luminosità sfondo
function textColor($hexColor) {
    $hex = str_replace('#', '', $hexColor);
    $r = hexdec(substr($hex, 0, 2));
    $g = hexdec(substr($hex, 2, 2));
    $b = hexdec(substr($hex, 4, 2));
    $lum = 0.299 * $r + 0.587 * $g + 0.114 * $b;
    return ($lum > 186) ? '#000000' : '#FFFFFF';
}

// Funzione per scegliere un colore per il bottone evitando che vicini abbiano lo stesso colore
function pickColor($colors, $assigned, $pos, $colCount = 4) {
    $neighbors = [];
    if ($pos % $colCount !== 0 && isset($assigned[$pos - 1])) {
        $neighbors[] = $assigned[$pos - 1];
    }
    if ($pos - $colCount >= 0 && isset($assigned[$pos - $colCount])) {
        $neighbors[] = $assigned[$pos - $colCount];
    }
    $possible = array_filter($colors, function($c) use ($neighbors) {
        return !in_array($c, $neighbors);
    });
    if (count($possible) === 0) {
        return $colors[array_rand($colors)];
    }
    return $possible[array_rand($possible)];
}

// Riordina le password per stampa: 10 righe x 4 colonne (tipo)
$ordered_passwords = [];
$nCols = count($passwords);
$nRows = 10;
$group_names = array_keys($passwords);
for ($r = 0; $r < $nRows; $r++) {
    for ($c = 0; $c < $nCols; $c++) {
        $ordered_passwords[] = $passwords[$group_names[$c]][$r];
    }
}

// Assegna colori pulsanti evitando vicini uguali
$assigned_colors = [];
for ($i = 0; $i < count($ordered_passwords); $i++) {
    $assigned_colors[$i] = pickColor($btn_colors, $assigned_colors, $i, $nCols);
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Generatore Password PHP</title>
<style>
  body {
    background: #f8f9fa;
    padding: 2rem;
    font-family: Arial, sans-serif;
  }
  h1 {
    margin-bottom: 1rem;
    font-weight: normal;
  }
  .container {
    max-width: 900px;
    margin: auto;
  }
  #buttons-container {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    grid-auto-rows: auto;
    gap: 1rem;
  }
  button.password-btn {
    font-family: 'Courier New', Courier, monospace;
    font-weight: bold;
    font-size: 1.3rem;
    padding: 0.6rem 1rem;
    border: none;
    cursor: pointer;
    white-space: nowrap;
    border-radius: 12px;
    transition: transform 0.1s ease;
    width: 100%;
    box-sizing: border-box;
  }
  button.password-btn:active {
    transform: scale(0.97);
  }
  #copy-notice {
    position: fixed;
    top: 1rem;
    right: 1rem;
    background: #28a745;
    color: white;
    padding: 0.75rem 1.25rem;
    border-radius: 0.3rem;
    box-shadow: 0 0 10px rgba(40,167,69,0.7);
    display: none;
    z-index: 1050;
    font-weight: bold;
    font-family: Arial, sans-serif;
  }
</style>
</head>
<body>

<div class="container">
  <h1>Password casuali (12 caratteri, 1 simbolo speciale)</h1>
  <p>Clicca su una password per copiarla negli appunti.</p>
  <div id="buttons-container">
<?php
foreach ($ordered_passwords as $i => $pwd) {
    $bg = $assigned_colors[$i];
    $color = textColor($bg);
    echo "<button class='password-btn' style='background-color: $bg; color: $color;' data-password='$pwd'>" . htmlspecialchars($pwd) . "</button>\n";
}
?>
  </div>
</div>

<div id="copy-notice"></div>

<script>
(() => {
  const buttons = document.querySelectorAll('button.password-btn');
  const notice = document.getElementById('copy-notice');
  let timeoutId;

  buttons.forEach(btn => {
    btn.addEventListener('click', () => {
      const pwd = btn.getAttribute('data-password');
      navigator.clipboard.writeText(pwd).then(() => {
        notice.textContent = 'Password copiata: ' + pwd;
        notice.style.display = 'block';
        clearTimeout(timeoutId);
        timeoutId = setTimeout(() => {
          notice.style.display = 'none';
        }, 2000);
      }).catch(() => alert('Copia negli appunti fallita'));
    });
  });
})();
</script>

</body>
</html>
