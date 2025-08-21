![EG Sharebar - screenshot](https://github.com/emanuelegori/eg-sharebar/raw/main/screenshot.png)

# EG Sharebar

**EG Sharebar** è un plugin WordPress che aggiunge una barra di condivisione social personalizzata a post e pagine, con pulsanti grandi e usabilità ottimizzata.

---

## Ambiente di test

- **WordPress**: 6.8.2 
- **PHP**: 8.2
- **Browser**: Chrome (desktop e mobile), Firefox (desktop e mobile), Librewolf (desktop)

---

## Funzionalità principali

- Pulsanti di condivisione social grandi e accessibili per Mastodon, X (ex Twitter), Bluesky e Copia link.
- Supporto per Mastodon con selezione istanza e inserimento istanza personalizzata.
- Firma personalizzabile per ogni social ("via @emanuelegori", ecc.).
- Copia rapida del link negli appunti.
- Anteprima ottimizzata per Twitter/X e social (se meta tag e robots.txt sono configurati).
- Compatibile con shortcode `[eg_sharebar]` e inserimento via PHP: `<?php eg_sharebar(); ?>` o `if (function_exists('eg_sharebar')) eg_sharebar();`

## Installazione

1. Scarica o clona il plugin nella cartella `wp-content/plugins/eg-sharebar`.
2. Attiva il plugin dalla bacheca di WordPress.
3. Inserisci lo shortcode `[eg_sharebar]` dove vuoi mostrare la barra, oppure richiama la funzione PHP `eg_sharebar()` nel tuo tema/template.

## Configurazione

- Puoi personalizzare l’istanza di default Mastodon modificando la variabile `$default_instance` nel file `eg-sharebar.php`.
- La firma per ogni social è configurabile nelle variabili apposite del file PHP.
- Per una corretta anteprima su Twitter/X, assicurati che il tuo sito abbia i meta tag Twitter Card e che il file `robots.txt` consenta l’accesso alle immagini in `/wp-content/uploads/`.

## Esempio di utilizzo

### Shortcode:

```wordpress
[eg_sharebar]
```

### PHP nel template:

```php
<?php if (function_exists('eg_sharebar')) { eg_sharebar(); } ?>
```

## Personalizzazione

- Per modificare lo stile, puoi editare il file CSS `sharebar-style.css` oppure aggiungere CSS personalizzato.
- Gli SVG delle icone social sono nella cartella `social-icons`.

## Supporto

Questo plugin è stato sviluppato per uso personale e viene distribuito senza supporto attivo. Non sono garantiti aggiornamenti o assistenza.
Se lo trovi utile, usalo pure e personalizzalo secondo le tue esigenze!

## Licenza

Questo plugin è distribuito sotto licenza **MIT**.  
Vedi il file LICENSE per dettagli.

## Autore

Blog: [Homelab notes](https://emanuelegori.uno) - Fediverso: [@emanuelegori@mastodon.uno](https://mastodon.uno/@emanuelegori)
