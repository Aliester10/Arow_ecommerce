/**
 * Google Translate Auto-Translate System
 * Adapted from Aldiron Logistics (React) for Laravel
 *
 * Uses Google Translate Website Translator to translate all page content.
 * 100% client-side — no backend translation needed.
 */

// ===== Language Configuration =====
var INCLUDED_LANGS = ["en", "id", "ms", "zh-CN", "ar"];
var FLAG_MAP = {
    id: { label: "ID", flag: "id" },   // Indonesia (default)
    en: { label: "EN", flag: "gb" },   // English
    ms: { label: "MY", flag: "my" },   // Melayu
    "zh-CN": { label: "ZH", flag: "cn" },   // Mandarin
    ar: { label: "AR", flag: "sa" },   // Arab
};

// ===== Cookie Management =====
function getCookie(name) {
    var v = document.cookie.match('(^|;)\\s*' + name + '\\s*=\\s*([^;]+)');
    return v ? v.pop() : '';
}

function readCurrentLang() {
    var v = getCookie("googtrans");
    if (!v) return "id";
    var parts = v.split("/");
    var target = parts[2];
    return target && INCLUDED_LANGS.indexOf(target) !== -1 ? target : "id";
}

function setGoogTransCookie(code) {
    var domain = window.location.hostname;
    if (code === "id") {
        // Delete cookie — revert to original language
        document.cookie = "googtrans=; path=/; expires=Thu, 01 Jan 1970 00:00:00 GMT";
        document.cookie = "googtrans=; path=/; domain=." + domain + "; expires=Thu, 01 Jan 1970 00:00:00 GMT";
        document.cookie = "googtrans=; path=/; domain=" + domain + "; expires=Thu, 01 Jan 1970 00:00:00 GMT";
    } else {
        // Set cookie — format: /source_lang/target_lang
        var val = "/id/" + code;
        document.cookie = "googtrans=" + val + "; path=/";
        document.cookie = "googtrans=" + val + "; path=/; domain=." + domain;
        document.cookie = "googtrans=" + val + "; path=/; domain=" + domain;
    }
}

// ===== Hide Google Translate Banner UI Only =====
// IMPORTANT: Only hide the VISIBLE banner/toolbar, NOT the working iframes
function hideGoogleBanner() {
    // Hide the banner frame (the bar at the top)
    var bannerSelectors = [
        ".goog-te-banner-frame",
        ".goog-te-banner-frame.skiptranslate",
        "#goog-gt-tt",
        ".goog-te-balloon-frame",
        ".goog-te-ftab",
        ".goog-text-highlight",
    ];
    bannerSelectors.forEach(function (s) {
        document.querySelectorAll(s).forEach(function (el) {
            el.style.display = "none";
            el.style.visibility = "hidden";
            el.style.height = "0";
        });
    });

    // Reset body position — Google adds top: 40px for its banner
    var html = document.querySelector("html");
    var body = document.querySelector("body");
    if (html) {
        html.style.top = "0px";
        html.style.position = "static";
    }
    if (body) {
        body.style.top = "0px";
        body.style.position = "static";
        body.style.marginTop = "0px";
    }
}

// ===== Load Google Translate Script =====
function loadGoogleTranslate() {
    window.googleTranslateElementInit = function () {
        new window.google.translate.TranslateElement(
            {
                pageLanguage: "id",
                includedLanguages: INCLUDED_LANGS.join(","),
                layout: window.google.translate.TranslateElement.InlineLayout.SIMPLE,
                autoDisplay: false,
            },
            "google_translate_element"
        );
        // Hide banner after init
        setTimeout(hideGoogleBanner, 500);
        setTimeout(hideGoogleBanner, 1000);
        setTimeout(hideGoogleBanner, 2000);
        setTimeout(hideGoogleBanner, 3000);
    };

    if (!document.getElementById("google-translate-script")) {
        var script = document.createElement("script");
        script.id = "google-translate-script";
        script.src = "//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit";
        script.async = true;
        document.body.appendChild(script);
    }
}

// ===== Observer to hide banner when Google adds it =====
function setupBannerObserver() {
    var observer = new MutationObserver(function () {
        hideGoogleBanner();
    });
    observer.observe(document.documentElement, { childList: true, subtree: false });
    observer.observe(document.body, { childList: true, subtree: false });

    // Periodic cleanup for first few seconds
    var count = 0;
    var interval = setInterval(function () {
        hideGoogleBanner();
        count++;
        if (count > 30) clearInterval(interval);
    }, 200);
}

// ===== Flag Dropdown UI =====
function initFlagDropdown() {
    var container = document.getElementById("gtranslate-dropdown");
    if (!container) return;

    var currentLang = readCurrentLang();
    var currentInfo = FLAG_MAP[currentLang] || FLAG_MAP["id"];

    // Build the button
    var button = document.createElement("button");
    button.type = "button";
    button.className = "gtranslate-btn";
    button.innerHTML =
        '<img src="https://flagcdn.com/w20/' + currentInfo.flag + '.png" alt="' + currentInfo.label + '" style="width:20px;height:14px;object-fit:cover;border-radius:2px;">' +
        '<span>' + currentInfo.label + '</span>' +
        '<i class="fas fa-chevron-down" style="font-size:8px;margin-left:2px;"></i>';

    // Build the dropdown menu
    var menu = document.createElement("div");
    menu.className = "gtranslate-menu";
    menu.style.display = "none";

    INCLUDED_LANGS.forEach(function (code) {
        var info = FLAG_MAP[code];
        if (!info) return;

        var item = document.createElement("button");
        item.type = "button";
        item.className = "gtranslate-item" + (code === currentLang ? " active" : "");
        item.innerHTML =
            '<img src="https://flagcdn.com/w20/' + info.flag + '.png" alt="' + info.label + '" style="width:24px;height:16px;object-fit:cover;border-radius:2px;">' +
            '<span>' + info.label + '</span>';

        item.addEventListener("click", function () {
            if (code === currentLang) {
                menu.style.display = "none";
                return;
            }
            setGoogTransCookie(code);
            menu.style.display = "none";
            // Reload to apply translation
            window.location.reload();
        });

        menu.appendChild(item);
    });

    button.addEventListener("click", function (e) {
        e.stopPropagation();
        menu.style.display = menu.style.display === "none" ? "flex" : "none";
    });

    // Close dropdown when clicking outside
    document.addEventListener("click", function () {
        menu.style.display = "none";
    });

    container.appendChild(button);
    container.appendChild(menu);
}

// ===== Initialize Everything =====
document.addEventListener("DOMContentLoaded", function () {
    initFlagDropdown();
    loadGoogleTranslate();
    setupBannerObserver();
});

window.addEventListener("load", function () {
    hideGoogleBanner();
});
