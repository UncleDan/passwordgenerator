# 🔐 Password Generator — HTML & PHP Versions

## 🇬🇧 English

This project provides **two versions** of a strong password generator:

### ✅ HTML Version (`password-generator-HTML.html`)
- Fully client-side: built with HTML, CSS, and JavaScript only.
- Random passwords are generated in the browser.
- Each password:
  - Is exactly 12 characters long
  - Starts with a meaningful word (animal, color, flower, or fruit)
  - Includes one random digit and one special character (`! $ % & + _`)
- Passwords appear as **colorful buttons**.
- Clicking a button copies the password to the clipboard with a 2-second visual notification.
- Passwords are grouped in **columns by word type**.

### ✅ PHP Version (`password-generator-PHP.php`)
- Passwords are generated server-side using PHP.
- Reads words from the `vocabolario.txt` file (1 word per line, at least 160 words).
- Divides the word list into 4 categories: animals, colors, flowers, fruits.
- Features:
  - 40 total passwords, 10 per category
  - Each password starts with a word and is padded to 12 characters with digits and a symbol
  - Button colors are assigned to avoid repetition in neighboring buttons
- Shares the same layout and clipboard functionality as the HTML version.

---

## 🇮🇹 Italiano

Questo progetto include **due versioni** di un generatore di password sicure:

### ✅ Versione HTML (`password-generator-HTML.html`)
- Completamente lato client: costruita solo con HTML, CSS e JavaScript.
- Le password vengono generate nel browser.
- Ogni password:
  - È lunga esattamente 12 caratteri
  - Inizia con una parola significativa (animale, colore, fiore o frutto)
  - Contiene una cifra casuale e un carattere speciale (`! $ % & + _`)
- Le password sono visualizzate come **pulsanti colorati**.
- Cliccando su un pulsante, la password viene copiata negli appunti con una notifica visiva di 2 secondi.
- Le password sono organizzate in **colonne per tipo di parola**.

### ✅ Versione PHP (`password-generator-PHP.php`)
- Le password vengono generate lato server usando PHP.
- Legge le parole da un file chiamato `vocabolario.txt` (una per riga, minimo 160 parole).
- Il vocabolario è suddiviso in 4 categorie: animali, colori, fiori, frutti.
- Caratteristiche:
  - 40 password in totale, 10 per categoria
  - Ogni password inizia con una parola e viene completata a 12 caratteri con cifre e un simbolo
  - I colori dei pulsanti evitano ripetizioni tra pulsanti adiacenti
- La grafica e la funzione di copia negli appunti sono le stesse della versione HTML.

---

## 📁 Files

- `index.html` — Menu principale per scegliere la versione
- `password-generator-HTML.html` — Versione statica con JavaScript
- `password-generator-PHP.php` — Versione dinamica con PHP
- `vocabolario.txt` — Elenco di parole (una per riga, almeno 160 parole totali)

---

## ⚙️ Requirements

- **HTML version**: qualsiasi browser moderno
- **PHP version**: server locale (es. XAMPP, MAMP) o hosting compatibile con PHP

---

## 🗒️ Note

- All words used for password generation (animals, colors, fruits, flowers) are currently **in Italian**.
- You can replace the contents of `vocabolario.txt` with English or multilingual words if needed, keeping the format: **one word per line**, and **grouped in 4 blocks of equal size**.
