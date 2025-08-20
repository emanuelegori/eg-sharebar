<?php
/*
Plugin Name: EG Sharebar
Description: Barra social personalizzata richiamabile via funzione PHP.
Author: Emanuele Gori
Version: 5.2
*/

if (!defined('ABSPATH')) exit;

function eg_sharebar_render() {
    $titolo = get_the_title();
    $url = get_permalink();

    $default_instance = 'mastodon.uno';
    $instances = [
        'mastodon.uno'      => 'mastodon.uno',
        'sociale.network'   => 'sociale.network',
        'mastodon.social'   => 'mastodon.social',
        'mastodon.art'      => 'mastodon.art',
        'livellosecreto.it' => 'livellosecreto.it',
    ];

    $icons_url = plugins_url('social-icons/', __FILE__);

    ob_start();
    ?>
    <div class="eg-condividi-label" style="font-weight:600; margin-top:32px; margin-bottom:12px; font-size:1.1em; color:#222;">
      Condividi l'articolo su:
    </div>
    <div class="eg-sharebar" style="display:flex; gap:14px; flex-wrap:wrap; justify-content:center;">
        <div class="eg-masto-col" style="display:flex; flex-direction:column; align-items:center; margin-right:12px;">
            <a id="eg-masto-btn" class="share-btn mastodon" href="<?php echo esc_url("https://{$default_instance}/share?text=" . urlencode($titolo . ' ' . $url)); ?>" 
               target="_blank" rel="noopener" aria-label="Condividi su Mastodon">
                <img class="icon" src="<?php echo esc_url($icons_url . 'mastodon.svg'); ?>" alt="Mastodon" />
                <span id="eg-masto-label">Mastodon</span>
            </a>
            <select id="eg-masto-select" class="masto-select" style="margin-top:4px; margin-bottom:4px; background:rgba(99,100,255,0.07); border:1.5px dashed #6364ff77; border-radius:8px; color:#6364ff;" aria-label="Seleziona istanza Mastodon">
                <?php foreach ($instances as $urlist => $label): ?>
                    <option value="<?php echo esc_attr($urlist); ?>"><?php echo esc_html($label); ?></option>
                <?php endforeach; ?>
                <option value="other">Altra istanza...</option>
            </select>
            <input id="eg-masto-custom" class="masto-input" type="text" placeholder="esc per uscire"
                style="width:100%; display:none; margin-bottom:7px; padding:7px 12px; border-radius:8px; border:1.5px solid #6364ff33; font-size:1.1em; text-align:center;" aria-label="Inserisci istanza personalizzata"/>
        </div>
        <a class="share-btn x" href="<?php echo esc_url('https://x.com/intent/tweet?text=' . urlencode($titolo . ' ' . $url)); ?>" target="_blank" rel="noopener" aria-label="Condividi su X">
            <img class="icon" src="<?php echo esc_url($icons_url . 'x.svg'); ?>" alt="X" />
            X
        </a>
        <a class="share-btn bluesky" href="<?php echo esc_url('https://bsky.app/intent/compose?text=' . urlencode($titolo . ' ' . $url)); ?>" target="_blank" rel="noopener" aria-label="Condividi su Bluesky">
            <img class="icon" src="<?php echo esc_url($icons_url . 'bluesky.svg'); ?>" alt="Bluesky" />
            Bluesky
        </a>
        <a class="share-btn telegram" href="<?php echo esc_url('https://t.me/share/url?url=' . urlencode($url) . '&text=' . urlencode($titolo)); ?>" target="_blank" rel="noopener" aria-label="Condividi su Telegram">
            <img class="icon" src="<?php echo esc_url($icons_url . 'telegram.svg'); ?>" alt="Telegram" />
            Telegram
        </a>
        <button class="share-btn link" onclick="egCopyLink('<?php echo esc_js($url); ?>')" aria-label="Copia link negli appunti">
            <img class="icon" src="<?php echo esc_url($icons_url . 'link.svg'); ?>" alt="Link" />
            Copia Link
        </button>
    </div>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        function egSetInstance(val) { try { localStorage.setItem("egMastoInstance", val); } catch(e){} }
        function egGetInstance() { try { return localStorage.getItem("egMastoInstance"); } catch(e) { return null; } }

        const mastoSelect = document.getElementById("eg-masto-select");
        const mastoCustom = document.getElementById("eg-masto-custom");
        const mastoBtn = document.getElementById("eg-masto-btn");
        const defaultInstance = <?php echo json_encode($default_instance); ?>;
        const shareText = <?php echo json_encode($titolo . ' ' . $url); ?>;

        let currentInstance = egGetInstance() || defaultInstance;
        let customOption = null; // Per tenere traccia se la custom è già presente

        function updateMastoBtn() {
            mastoBtn.href = "https://" + currentInstance + "/share?text=" + encodeURIComponent(shareText);
        }

        function setSelectValue(val) {
            let found = false;
            for (let i = 0; i < mastoSelect.options.length; i++) {
                if (mastoSelect.options[i].value === val) {
                    mastoSelect.selectedIndex = i;
                    found = true;
                    break;
                }
            }
            if (!found) {
                // Se non presente, aggiungi la custom istanza come opzione
                addOrUpdateCustomOption(val);
                mastoSelect.value = val;
            }
        }

        function addOrUpdateCustomOption(val) {
            // Se già presente aggiorna, altrimenti aggiungi
            if (customOption) {
                customOption.value = val;
                customOption.text = val;
            } else {
                customOption = document.createElement("option");
                customOption.value = val;
                customOption.text = val;
                // Inserisci la custom prima di "Altra istanza..."
                let otherOption = mastoSelect.querySelector('option[value="other"]');
                mastoSelect.insertBefore(customOption, otherOption);
            }
        }

        mastoSelect.addEventListener('change', function() {
            if (this.value === "other") {
                mastoCustom.value = "";
                mastoCustom.style.display = "block";
                mastoCustom.focus();
                mastoSelect.style.display = "none";
            } else {
                currentInstance = this.value;
                egSetInstance(currentInstance);
                updateMastoBtn();
            }
        });

        mastoCustom.addEventListener('keydown', function(e) {
            if (e.key === "Enter") {
                let val = mastoCustom.value.trim();
                if (!val.match(/^[a-z0-9.-]+\.[a-z]+$/i)) {
                    alert("Inserisci un dominio valido (es. mastodon.social)");
                    return;
                }
                currentInstance = val;
                egSetInstance(val);
                updateMastoBtn();
                mastoCustom.style.display = "none";
                mastoSelect.style.display = "block";
                addOrUpdateCustomOption(val);
                setSelectValue(val);
            } else if (e.key === "Escape") {
                mastoCustom.style.display = "none";
                mastoSelect.style.display = "block";
                setSelectValue(currentInstance);
            }
        });

        mastoCustom.addEventListener('blur', function() {
            setTimeout(function() {
                if (mastoCustom.style.display === "block") {
                    mastoCustom.style.display = "none";
                    mastoSelect.style.display = "block";
                    setSelectValue(currentInstance);
                }
            }, 200);
        });

        setSelectValue(currentInstance);
        updateMastoBtn();
    });

    function egCopyLink(link) {
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
        if (file_exists($css_file)) {
            wp_add_inline_style('eg-sharebar-css', file_get_contents($css_file));
        }
    }
});
