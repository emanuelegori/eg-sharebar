<?php
/*
Plugin Name: EG Sharebar
Description: Barra social personalizzata richiamabile via funzione PHP.
Author: Emanuele Gori
Version: 5.0
*/

if (!defined('ABSPATH')) exit;

function eg_sharebar_render() {
    $titolo = get_the_title();
    $url = get_permalink();

    $default_instance = 'mastodon.uno';
    $instances = [
        'mastodon.uno' => 'mastodon.uno',
        'sociale.network' => 'sociale.network',
        'mastodon.social' => 'mastodon.social',
        'mastodon.art' => 'mastodon.art',
        'livellosecreto.it' => 'livellosecreto.it',
    ];

    ob_start();
    ?>
    <div class="eg-sharebar" style="display:flex; gap:14px; flex-wrap:wrap; justify-content:center;">
        <!-- Colonna Mastodon -->
        <div class="eg-masto-col" style="display:flex; flex-direction:column; align-items:center; margin-right:12px;">
            <a id="eg-masto-btn" class="share-btn mastodon" href="https://<?php echo $default_instance; ?>/share?text=<?php echo urlencode($titolo . ' ' . $url); ?>" target="_blank" rel="noopener" style="margin-bottom:0;">
                <img class="icon" src="/wp-content/plugins/eg-sharebar/social-icons/mastodon.svg" alt="Mastodon" />
                <span id="eg-masto-label">Mastodon</span>
            </a>
            <!-- Select come casella sotto Mastodon -->
            <select id="eg-masto-select" class="masto-select" style="margin-top:4px; margin-bottom:4px; background:rgba(99,100,255,0.07); border:1.5px dashed #6364ff77; border-radius:8px; color:#6364ff; font-weight:500; padding:8px 19px; font-size:1.10em; min-width:150px; text-align:center; cursor:pointer; outline:none;">
                <?php foreach ($instances as $urlist => $label): ?>
                    <option value="<?php echo $urlist; ?>"><?php echo $label; ?></option>
                <?php endforeach; ?>
                <option value="other">Altra istanza...</option>
            </select>
            <input id="eg-masto-custom" class="masto-input" type="text" placeholder="esc per uscire"
                style="width:100%; display:none; margin-bottom:7px; padding:7px 12px; border-radius:8px; border:1.5px solid #6364ff33; font-size:1.1em; text-align:center;" />
        </div>
        <!-- Altri pulsanti social -->
        <a class="share-btn x" href="https://x.com/intent/tweet?text=<?php echo urlencode($titolo . ' ' . $url); ?>" target="_blank" rel="noopener">
            <img class="icon" src="/wp-content/plugins/eg-sharebar/social-icons/x.svg" alt="X" />
            X
        </a>
        <a class="share-btn bluesky" href="https://bsky.app/intent/compose?text=<?php echo urlencode($titolo . ' ' . $url); ?>" target="_blank" rel="noopener">
            <img class="icon" src="/wp-content/plugins/eg-sharebar/social-icons/bluesky.svg" alt="Bluesky" />
            Bluesky
        </a>
        <a class="share-btn telegram" href="https://t.me/share/url?url=<?php echo urlencode($url); ?>&text=<?php echo urlencode($titolo); ?>" target="_blank" rel="noopener">
            <img class="icon" src="/wp-content/plugins/eg-sharebar/social-icons/telegram.svg" alt="Telegram" />
            Telegram
        </a>
        <button class="share-btn link" onclick="copyLink('<?php echo $url; ?>')">
            <img class="icon" src="/wp-content/plugins/eg-sharebar/social-icons/link.svg" alt="Link" />
            Copia Link
        </button>
    </div>
    <script>
    // Salva in LocalStorage l'istanza scelta
    function egSetInstance(val) { try { localStorage.setItem("egMastoInstance", val); } catch(e){} }
    function egGetInstance() { try { return localStorage.getItem("egMastoInstance"); } catch(e) { return null; } }
    const mastoSelect = document.getElementById("eg-masto-select");
    const mastoCustom = document.getElementById("eg-masto-custom");
    const mastoBtn = document.getElementById("eg-masto-btn");
    const defaultInstance = "<?php echo $default_instance; ?>";
    let currentInstance = egGetInstance() || defaultInstance;

    function updateMastoBtn() {
        mastoBtn.href = "https://" + currentInstance + "/share?text=<?php echo urlencode($titolo . ' ' . $url); ?>";
    }

    // Imposta la select sull'istanza attuale
    function setSelectValue(val) {
        let found = false;
        for (let i=0; i<mastoSelect.options.length; i++) {
            if (mastoSelect.options[i].value === val) {
                mastoSelect.selectedIndex = i; found = true; break;
            }
        }
        if (!found) mastoSelect.value = "other";
    }

    setSelectValue(currentInstance);
    updateMastoBtn();

    mastoSelect.onchange = function() {
        if (this.value === "other") {
            mastoSelect.style.display = "none";
            mastoCustom.style.display = "block";
            mastoCustom.value = "";
            mastoCustom.focus();
        } else {
            currentInstance = this.value;
            egSetInstance(currentInstance);
            updateMastoBtn();
        }
    };
    mastoCustom.onkeydown = function(e) {
        if (e.key === "Enter") {
            let val = mastoCustom.value.trim();
            if (!val.match(/^[a-z0-9.-]+\.[a-z]+$/i)) {
                alert("Inserisci un dominio valido (es. mastodon.social)");
                return;
            }
            currentInstance = val;
            egSetInstance(val);
            updateMastoBtn();
            mastoSelect.style.display = "block";
            setSelectValue(val);
            mastoCustom.style.display = "none";
        } else if (e.key === "Escape") {
            mastoCustom.style.display = "none";
            mastoSelect.style.display = "block";
            setSelectValue(currentInstance);
        }
    };
    function copyLink(link) {
      navigator.clipboard.writeText(link);
      alert("Link copiato!");
    }
    </script>
    <?php
    return ob_get_clean();
}

function eg_sharebar() { echo eg_sharebar_render(); }
add_shortcode('eg_sharebar', 'eg_sharebar_render');
add_action('wp_enqueue_scripts', function() {
    if (is_singular()) {
        wp_register_style('eg-sharebar-css', false);
        wp_enqueue_style('eg-sharebar-css');
        $css_file = plugin_dir_path(__FILE__).'sharebar-style.css';
        if(file_exists($css_file)){
            wp_add_inline_style('eg-sharebar-css', file_get_contents($css_file));
        }
    }
});
