![EG Sharebar - screenshot](https://github.com/emanuelegori/eg-sharebar/raw/main/screenshot.png)

# EG Sharebar

**EG Sharebar** è un plugin WordPress che aggiunge una barra di condivisione social personalizzata a post e pagine, con pulsanti grandi e usabilità ottimizzata.

---

## Ambiente - Environment

- **WordPress**: 6.8.2 
- **PHP**: 8.2.29
- **Redis**: 	8.2.0
- **Browser**: Chrome (desktop e mobile), Firefox (desktop e mobile), Librewolf (desktop)

---

## Funzionalità principali - Main features

- Pulsanti di condivisione social grandi e accessibili per Mastodon, X (ex Twitter), Bluesky e Copia link.
- Supporto per Mastodon con selezione istanza e inserimento istanza personalizzata.
- Firma personalizzabile per ogni social ("via @emanuelegori", ecc.).
- Copia rapida del link negli appunti.
- Compatibile con shortcode `[eg_sharebar]` e inserimento via PHP: `<?php eg_sharebar(); ?>` o `if (function_exists('eg_sharebar')) eg_sharebar();`
- Non è presente alcun sistema di telemetria o tracciamento. 
- Compatibile con la maggior parte dei temi WordPress.

## Installazione - Installation

1. Scarica o clona il plugin nella cartella `wp-content/plugins/eg-sharebar.
2. Modifica firma personalizzata in eg-sharebar: 'via @username@istanza'
3. Attiva il plugin dalla bacheca di WordPress.
4. Inserisci lo shortcode `[eg_sharebar]` dove vuoi mostrare la barra, oppure richiama la funzione PHP `eg_sharebar()` nel tuo tema/template.

## Configurazione - Configuration

- Puoi personalizzare l’istanza di default Mastodon modificando la variabile `$default_instance` nel file `eg-sharebar.php`.
- La firma per ogni social è configurabile nelle variabili apposite del file PHP.
- Per una corretta anteprima su Twitter/X, assicurati che il tuo sito abbia i meta tag Twitter Card e che il file `robots.txt` consenta l’accesso alle immagini in `/wp-content/uploads/`.

## Esempio di utilizzo - Usage Example

### Shortcode:

```wordpress
[eg_sharebar]
```

### PHP nel template:

```php
<?php if (function_exists('eg_sharebar')) { eg_sharebar(); } ?>
```

## Personalizzazione - Customization

- Per modificare lo stile, puoi editare il file CSS `sharebar-style.css` oppure aggiungere CSS personalizzato.
- Gli SVG delle icone social sono nella cartella `social-icons`.

## Supporto - Support

Questo plugin è stato sviluppato per uso personale e viene distribuito senza supporto attivo. Non sono garantiti aggiornamenti o assistenza.
Se lo trovi utile, usalo pure e personalizzalo secondo le tue esigenze!

This plugin was developed for personal use and is distributed without active support. Updates or assistance are not guaranteed.  
If you find it useful, feel free to use it and customize it to suit your needs!

## Licenza - License

Questo plugin è distribuito sotto licenza **MIT**.  
Vedi il file LICENSE per dettagli.

## Autore - Author

Blog: [Homelab notes](https://emanuelegori.uno) - Fediverso: [@emanuelegori@mastodon.uno](https://mastodon.uno/@emanuelegori)
