/**
 * EG Sharebar — Plugin WordPress
 * -------------------------------------------
 * Versione:      5.2
 * Autore:        Emanuele Gori
 * Descrizione:   Barra social personalizzata per WordPress, richiamabile via funzione PHP,
 *                con supporto a Mastodon multiistanza (anche custom) e altri social.
 *
 * FUNZIONALITÀ PRINCIPALI:
 * - Pulsante Mastodon con selezione istanza tra predefinite o personalizzata (“altra istanza...”)
 * - Salvataggio e ripristino dell’ultima istanza scelta (anche personalizzata) via localStorage
 * - Inserimento dinamico dell’istanza personalizzata come opzione reale nella select
 * - UX pulita sia su desktop che mobile (input si nasconde anche con esc o tap fuori)
 * - Supporto condivisione su X, Bluesky, Telegram e “Copia Link”
 * - Icone SVG locali facilmente configurabili tramite variabile centrale
 * - Accessibilità: aria-label su input/select/bottoni per screen reader
 *
 * COME FUNZIONA (logica):
 * 1. L’utente vede la barra social con il pulsante Mastodon e una select delle istanze predefinite.
 * 2. Può scegliere “Altra istanza...” per inserire una propria istanza Mastodon.
 *    - L’input viene mostrato, la select nascosta.
 *    - Premendo INVIO, la nuova istanza viene aggiunta come opzione vera (prima di “Altra istanza…”), selezionata e salvata.
 *    - Premendo ESC o facendo tap fuori, l’input viene nascosto e si torna alla select (senza cambiare la scelta se non confermata).
 * 3. L’ultima scelta (anche custom) viene memorizzata in localStorage e ripristinata al reload.
 * 4. Il pulsante Mastodon aggiorna sempre il link di share sull’istanza selezionata/corrente.
 *
 * PUNTI DI FORZA:
 * - Rispetto della privacy, nessuna telemetria
 * - Semplice da personalizzare e manutenere
 * - Nessuna dipendenza esterna (tutto Vanilla JS)
 * - Unica fonte per le icone, basta cambiare $icons_url
 * - Accessibilità curata (per SEO e inclusività)
 *
 * PERSONALIZZAZIONE:
 * - Per cambiare le istanze di default, modifica l’array $instances.
 * - Per cambiare la directory delle icone, cambia $icons_url.
 * - Puoi aggiungere o togliere altri social aggiungendo/rimuovendo i rispettivi <a> nella sharebar.
 *
 * NOTE:
 * - Testato su WordPress 6.8.3, PHP 8.2.29, browser desktop e mobile principali.
 * - Compatibile con la maggior parte dei temi, grazie a stili inline.
 * - Il file CSS “sharebar-style.css” può essere usato per personalizzare il look.
 *
 * Autore: Emanuele Gori — https://emanuelegori.uno
 * Data ultima modifica: 20 agosto 2025
 */

