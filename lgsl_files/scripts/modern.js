(function () {
  "use strict";

  function labelServerListCells() {
    var table = document.getElementById("server_list_table");
    if (!table) {
      return;
    }

    var headers = Array.prototype.map.call(
      table.querySelectorAll("#server_list_table_top th"),
      function (header) {
        return header.textContent.replace(/:\s*$/, "").trim();
      }
    );

    Array.prototype.forEach.call(table.querySelectorAll("tr:not(#server_list_table_top)"), function (row) {
      row.style.setProperty("--lgsl-row-index", row.rowIndex > 0 ? row.rowIndex - 1 : 0);
      Array.prototype.forEach.call(row.children, function (cell, index) {
        if (headers[index]) {
          cell.setAttribute("data-lgsl-label", headers[index]);
        }
      });
    });
  }

  function animatePlayerBars() {
    Array.prototype.forEach.call(document.querySelectorAll(".inner_bar"), function (bar) {
      var width = bar.style.width;
      if (!width || bar.dataset.lgslAnimated === "1") {
        return;
      }

      bar.dataset.lgslAnimated = "1";
      bar.style.width = "0";

      window.requestAnimationFrame(function () {
        bar.style.width = width;
      });
    });
  }

  function markEmptyList() {
    var table = document.getElementById("server_list_table");
    if (!table) {
      return;
    }

    var rows = table.querySelectorAll("tr:not(#server_list_table_top)");
    document.body.classList.toggle("lgsl-empty-list", rows.length === 0);
  }

  function parseJsonAttribute(element, name, fallback) {
    try {
      return JSON.parse(element.getAttribute(name) || "");
    } catch (error) {
      return fallback;
    }
  }

  function uniqueOptions(rows, key, labelKey, extraValues, labelMap) {
    var options = [];
    var seen = {};

    function add(value, label) {
      value = (value || "").trim();
      label = (label || value).trim();

      if (!value || seen[value]) {
        return;
      }

      seen[value] = true;
      options.push({ value: value, label: label });
    }

    (extraValues || []).forEach(function (value) {
      add(value, labelMap && labelMap[value] ? labelMap[value] : value);
    });

    rows.forEach(function (row) {
      var value = (row.dataset[key] || "").trim();
      var label = labelKey ? row.dataset[labelKey] : "";
      add(value, labelMap && labelMap[value] ? labelMap[value] : label);
    });

    return options.sort(function (a, b) {
      return a.label.localeCompare(b.label);
    });
  }

  function catalogKeys(labels) {
    return Object.keys(labels || {}).sort(function (a, b) {
      return String(labels[a]).localeCompare(String(labels[b]));
    });
  }

  function addOptions(select, options, allLabel) {
    select.innerHTML = "";

    var all = document.createElement("option");
    all.value = "";
    all.textContent = allLabel;
    select.appendChild(all);

    options.forEach(function (item) {
      var option = document.createElement("option");
      option.value = item.value;
      option.textContent = item.label;
      select.appendChild(option);
    });
  }

  function enhanceServerFilters() {
    var table = document.getElementById("server_list_table");
    var filters = document.getElementById("server_list_filters");
    if (!table || !filters || filters.dataset.lgslFiltersReady === "1") {
      return;
    }

    var rows = Array.prototype.slice.call(table.querySelectorAll("tr:not(#server_list_table_top)"));
    if (!rows.length) {
      return;
    }

    filters.dataset.lgslFiltersReady = "1";

    var search = document.createElement("input");
    search.type = "search";
    search.placeholder = filters.dataset.searchLabel || "Search server or address";
    search.setAttribute("aria-label", filters.dataset.searchLabel || "Search server or address");

    var map = document.createElement("select");
    var mode = document.createElement("select");
    var game = document.createElement("select");
    var type = document.createElement("select");
    var players = document.createElement("select");

    var mapCatalog = parseJsonAttribute(filters, "data-map-catalog", []);
    var modeLabels = parseJsonAttribute(filters, "data-mode-labels", {});
    var gameLabels = parseJsonAttribute(filters, "data-game-labels", {});
    var typeLabels = parseJsonAttribute(filters, "data-type-labels", {});

    addOptions(map, uniqueOptions(rows, "map", "", mapCatalog, {}), filters.dataset.allMaps || "All maps");
    addOptions(mode, uniqueOptions(rows, "mode", "modeLabel", catalogKeys(modeLabels), modeLabels), filters.dataset.allModes || "All modes");
    addOptions(game, uniqueOptions(rows, "game", "gameLabel", catalogKeys(gameLabels), gameLabels), filters.dataset.allGames || "All games");
    addOptions(type, uniqueOptions(rows, "type", "typeLabel", catalogKeys(typeLabels), typeLabels), filters.dataset.allTypes || "All types");

    players.innerHTML = [
      "<option value=''>" + (filters.dataset.allPlayers || "All players") + "</option>",
      "<option value='not-empty'>" + (filters.dataset.withPlayers || "With players") + "</option>",
      "<option value='has-slots'>" + (filters.dataset.hasSlots || "Has slots") + "</option>",
      "<option value='full'>" + (filters.dataset.full || "Full") + "</option>",
      "<option value='empty'>" + (filters.dataset.empty || "Empty") + "</option>"
    ].join("");

    [search, map, mode, game, type, players].forEach(function (control) {
      filters.appendChild(control);
    });

    var empty = document.createElement("div");
    empty.className = "lgsl-filter-empty";
    empty.hidden = true;
    empty.textContent = filters.dataset.noResults || "No servers match the selected filters.";
    table.parentNode.insertBefore(empty, table.nextSibling);

    function matchesPlayerFilter(row, value) {
      var current = parseInt(row.dataset.players || "0", 10);
      var max = parseInt(row.dataset.playersmax || "0", 10);

      if (value === "not-empty") {
        return current > 0;
      }

      if (value === "has-slots") {
        return max === 0 || current < max;
      }

      if (value === "full") {
        return max > 0 && current >= max;
      }

      if (value === "empty") {
        return current === 0;
      }

      return true;
    }

    function applyFilters() {
      var query = search.value.trim().toLowerCase();
      var visible = 0;

      rows.forEach(function (row) {
        var haystack = [
          row.dataset.name,
          row.dataset.map,
          row.dataset.game,
          row.dataset.type,
          row.querySelector(".connectlink_cell") ? row.querySelector(".connectlink_cell").textContent : ""
        ].join(" ").toLowerCase();

        var isVisible =
          (!query || haystack.indexOf(query) !== -1) &&
          (!map.value || row.dataset.map === map.value) &&
          (!mode.value || row.dataset.mode === mode.value) &&
          (!game.value || row.dataset.game === game.value || row.dataset.type === game.value) &&
          (!type.value || row.dataset.type === type.value) &&
          matchesPlayerFilter(row, players.value);

        row.classList.toggle("lgsl-filter-hidden", !isVisible);
        row.setAttribute("aria-hidden", isVisible ? "false" : "true");
        if (isVisible) {
          visible += 1;
        }
      });

      empty.hidden = visible > 0;
    }

    [search, map, mode, game, type, players].forEach(function (control) {
      control.addEventListener("input", applyFilters);
      control.addEventListener("change", applyFilters);
      control.addEventListener("keyup", applyFilters);
    });

    filters.addEventListener("input", applyFilters);
    filters.addEventListener("change", applyFilters);
    applyFilters();
  }

  function enhanceMenu() {
    var menu = document.getElementById("topmenu");
    if (!menu || menu.dataset.lgslMenuReady === "1") {
      return;
    }

    menu.dataset.lgslMenuReady = "1";

    var toggle = document.createElement("button");
    toggle.type = "button";
    toggle.className = "lgsl-menu-toggle";
    toggle.setAttribute("aria-expanded", "false");
    toggle.setAttribute("aria-controls", "topmenu");
    toggle.setAttribute("title", "Menu");

    toggle.addEventListener("click", function () {
      var isOpen = menu.classList.toggle("lgsl-menu-open");
      toggle.setAttribute("aria-expanded", isOpen ? "true" : "false");
    });

    Array.prototype.forEach.call(menu.querySelectorAll("a"), function (link) {
      link.addEventListener("click", function () {
        menu.classList.remove("lgsl-menu-open");
        toggle.setAttribute("aria-expanded", "false");
      });
    });

    menu.insertBefore(toggle, menu.firstChild);
  }

  function enhanceAdminProfile() {
    var profile = document.querySelector(".admin_profile");
    if (!profile || profile.dataset.lgslProfileReady === "1") {
      return;
    }

    var button = profile.querySelector(".admin_profile_button");
    var menu = profile.querySelector(".admin_profile_menu");
    if (!button || !menu) {
      return;
    }

    profile.dataset.lgslProfileReady = "1";

    button.addEventListener("click", function (event) {
      event.preventDefault();
      var isOpen = profile.classList.toggle("lgsl-profile-open");
      button.setAttribute("aria-expanded", isOpen ? "true" : "false");
    });

    document.addEventListener("click", function (event) {
      if (profile.contains(event.target)) {
        return;
      }

      profile.classList.remove("lgsl-profile-open");
      button.setAttribute("aria-expanded", "false");
    });
  }

  function enhanceModernTheme() {
    document.documentElement.classList.add("lgsl-modern-ready");
    enhanceMenu();
    enhanceAdminProfile();
    labelServerListCells();
    enhanceServerFilters();
    animatePlayerBars();
    markEmptyList();
  }

  document.addEventListener("DOMContentLoaded", enhanceModernTheme);
  document.addEventListener("lgsl:refresh", enhanceModernTheme);

  var observer = new MutationObserver(function (mutations) {
    var shouldEnhance = mutations.some(function (mutation) {
      return mutation.addedNodes && mutation.addedNodes.length;
    });

    if (shouldEnhance) {
      enhanceModernTheme();
    }
  });

  document.addEventListener("DOMContentLoaded", function () {
    var container = document.getElementById("container");
    if (container) {
      observer.observe(container, { childList: true, subtree: true });
    }
  });
})();
