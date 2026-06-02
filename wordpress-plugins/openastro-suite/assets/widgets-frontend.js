(function () {
  var PLANET_OVERVIEW = {
    sun: 'The Sun reflects core identity, vitality, and the drive to become fully oneself.',
    moon: 'The Moon describes emotional needs, instinctive reactions, and inner security patterns.',
    mercury: 'Mercury shows how the mind perceives, learns, and communicates.',
    venus: 'Venus indicates relationship style, values, attraction, and harmony.',
    mars: 'Mars represents action, assertion, desire, and the way energy is directed.',
    jupiter: 'Jupiter expands perspective, beliefs, and pathways to growth and meaning.',
    saturn: 'Saturn defines responsibility, structure, discipline, and long-term mastery.',
    uranus: 'Uranus marks originality, disruption, awakening, and the need for freedom.',
    neptune: 'Neptune symbolizes imagination, sensitivity, ideals, and subtle inner perception.',
    pluto: 'Pluto points to deep transformation, power dynamics, and regenerative change.',
    north_node: 'The North Node highlights life direction, growth edges, and developmental themes.',
    lilith: 'Lilith reveals instinctive shadow material, autonomy themes, and denied desires.',
    chiron: 'Chiron marks core wounds and the path toward integration and healing wisdom.'
  };

  var BODY_GLYPHS = {
    sun: 's',
    moon: 'a',
    mercury: 'f',
    venus: 'g',
    mars: 'h',
    jupiter: 'j',
    saturn: 's',
    uranus: 'F',
    neptune: 'G',
    pluto: 'J',
    north_node: 'k',
    true_node: 'k',
    mean_node: 'k',
    lilith: 'L',
    chiron: 'D'
  };

  var SIGN_GLYPHS = {
    aries: 'x',
    taurus: 'c',
    gemini: 'v',
    cancer: 'b',
    leo: 'n',
    virgo: 'm',
    libra: 'X',
    scorpio: 'C',
    sagittarius: 'V',
    capricorn: 'B',
    aquarius: 'N',
    pisces: 'M',
    ari: 'x',
    tau: 'c',
    gem: 'v',
    can: 'b',
    vir: 'm',
    lib: 'X',
    sco: 'C',
    sag: 'V',
    cap: 'B',
    aqu: 'N',
    pis: 'M'
  };
  var HISTORY_KEY = 'openastro_history_v1';
  var HISTORY_LIMIT = 20;

  function getCfg() {
    var cfg = window.AstrologySuiteBlocks || window.OpenAstroBlocks || { root: '/wp-json/astrology-suite/v1/', nonce: '', permissions: {}, report: {}, style: {}, typography: {} };
    cfg.permissions = cfg.permissions || {};
    cfg.report = cfg.report || {};
    cfg.style = cfg.style || {};
    cfg.typography = cfg.typography || {};
    cfg.permissions.canCalculate = !!cfg.permissions.canCalculate;
    cfg.permissions.calculationMessage = cfg.permissions.calculationMessage || 'This astrology form is available only to logged-in users who can edit posts on this site.';
    cfg.report.detailLevel = cfg.report.detailLevel === 'concise' ? 'concise' : 'full';
    cfg.report.maxPlanets = Number(cfg.report.maxPlanets || 13);
    cfg.report.maxAspects = Number(cfg.report.maxAspects || 40);
    cfg.report.showTables = cfg.report.showTables !== false;
    cfg.report.showAngles = cfg.report.showAngles !== false;
    cfg.report.showPrintButton = cfg.report.showPrintButton !== false;
    cfg.style.showBorder = cfg.style.showBorder !== false;
    cfg.style.backgroundColor = cfg.style.backgroundColor || '#ffffff';
    cfg.style.textColor = cfg.style.textColor || '#111111';
    cfg.style.inputBorderRadius = Number(cfg.style.inputBorderRadius || 6);
    cfg.style.inputBorderColor = cfg.style.inputBorderColor || '#d1d5db';
    cfg.style.inputBgColor = cfg.style.inputBgColor || '#ffffff';
    cfg.style.inputTextColor = cfg.style.inputTextColor || '#111111';
    cfg.style.inputPlaceholderColor = cfg.style.inputPlaceholderColor || '#6b7280';
    cfg.style.buttonBorderRadius = Number(cfg.style.buttonBorderRadius || 6);
    cfg.style.buttonBgColor = cfg.style.buttonBgColor || '#111827';
    cfg.style.buttonTextColor = cfg.style.buttonTextColor || '#ffffff';
    cfg.style.buttonBorderColor = cfg.style.buttonBorderColor || '#111827';
    cfg.style.labelColor = cfg.style.labelColor || '#111111';
    cfg.style.labelWeight = cfg.style.labelWeight || '600';
    cfg.style.focusRingColor = cfg.style.focusRingColor || '#2563eb';
    cfg.style.astroFontSize = Number(cfg.style.astroFontSize || 20);
    cfg.style.astroFontColor = cfg.style.astroFontColor || '#111111';
    cfg.typography.h2 = Number(cfg.typography.h2 || 28);
    cfg.typography.h3 = Number(cfg.typography.h3 || 22);
    cfg.typography.h4 = Number(cfg.typography.h4 || 18);
    cfg.typography.body = Number(cfg.typography.body || 16);
    cfg.typography.table = Number(cfg.typography.table || 14);
    cfg.typography.input = Number(cfg.typography.input || 16);
    cfg.typography.button = Number(cfg.typography.button || 16);
    cfg.typography.meta = Number(cfg.typography.meta || 13);
    return cfg;
  }

  function chartSectionHtml(svg, reportCfg) {
    var printButton = reportCfg.showPrintButton
      ? '<button type="button" class="' + expandClassNames('openastro-print-btn') + '" data-openastro-print-chart="1">Print</button>'
      : '';
    return '<section class="' + expandClassNames('openastro-card openastro-chart-card') + '"><h3>Natal Wheel</h3>' + printButton + '<div class="' + expandClassNames('openastro-chart') + '">' + (svg || '<p>Chart unavailable.</p>') + '</div></section>';
  }

  function isSimpleSignMode(mode) {
    return mode === 'simple-sign-sun' ||
      mode === 'simple-sign-moon' ||
      mode === 'simple-sign-rising' ||
      mode === 'simple-sign-midheaven';
  }

  function pointForSimpleMode(mode) {
    if (mode === 'simple-sign-sun') return 'sun';
    if (mode === 'simple-sign-moon') return 'moon';
    if (mode === 'simple-sign-rising') return 'rising';
    return 'mc';
  }

  function prettyPoint(point) {
    var p = String(point || '').toLowerCase();
    if (p === 'sun') return 'Sun';
    if (p === 'moon') return 'Moon';
    if (p === 'rising') return 'Rising';
    if (p === 'mc' || p === 'midheaven') return 'Midheaven';
    return point || 'Point';
  }

  function simpleSignHtml(result, includeInterpretation) {
    var point = prettyPoint(result.point || '');
    var sign = result.sign || result.sign_id || 'Unknown';
    var signGlyph = glyphForSign(sign);
    var degree = typeof result.degree === 'number' ? result.degree.toFixed(2) + '°' : '';
    var interp = result.interpretation && result.interpretation.body ? result.interpretation.body : '';

    var html = '<section class="' + expandClassNames('openastro-card openastro-simple-sign-card') + '">';
    html += '<h3>' + esc(point) + ' Sign</h3>';
    html += '<p class="' + expandClassNames('openastro-simple-sign-value') + '">' + glyphSpan(signGlyph) + esc(sign) + (degree ? ' · ' + esc(degree) : '') + '</p>';

    if (includeInterpretation) {
      html += '<div class="' + expandClassNames('openastro-simple-sign-interpretation') + '">';
      html += '<h4>Interpretation</h4>';
      html += '<p>' + esc(interp || 'Interpretation was not returned for this point.') + '</p>';
      html += '</div>';
    }

    html += '</section>';
    return html;
  }

  function printChartCard(card) {
    var chartEl = card ? card.querySelector('.openastro-chart') : null;
    var svgEl = chartEl ? chartEl.querySelector('svg') : null;

    if (!svgEl) {
      window.print();
      return;
    }

    var printWindow = window.open('', '_blank', 'width=900,height=900');
    if (!printWindow) {
      window.print();
      return;
    }

    var svgMarkup = svgEl.outerHTML;
    var html = '<!doctype html><html><head><meta charset="utf-8"><title>Natal Wheel</title>' +
      '<style>body{margin:0;padding:24px;font-family:system-ui,sans-serif;}svg{width:100%;height:auto;max-width:760px;display:block;margin:0 auto;}</style>' +
      '</head><body>' + svgMarkup + '</body></html>';

    printWindow.document.open();
    printWindow.document.write(html);
    printWindow.document.close();
    printWindow.focus();
    printWindow.print();
  }

  function expandClassNames(value) {
    return String(value || '').split(/\s+/).filter(Boolean).reduce(function (classes, item) {
      if (item.indexOf('openastro-') === 0) {
        classes.push(item.replace('openastro-', 'astrology-suite-'));
      }
      classes.push(item);
      return classes;
    }, []).join(' ');
  }

  function create(tag, attrs, text) {
    var node = document.createElement(tag);
    if (attrs) {
      Object.keys(attrs).forEach(function (k) {
        if (k === 'checked') {
          node.checked = !!attrs[k];
          return;
        }
        if (k === 'class') {
          node.setAttribute(k, expandClassNames(attrs[k]));
          return;
        }
        node.setAttribute(k, attrs[k]);
      });
    }
    if (text) {
      node.textContent = text;
    }
    return node;
  }

  function esc(v) {
    return String(v)
      .replace(/&/g, '&amp;')
      .replace(/</g, '&lt;')
      .replace(/>/g, '&gt;')
      .replace(/"/g, '&quot;')
      .replace(/'/g, '&#039;');
  }

  function glyphForBody(id) {
    return BODY_GLYPHS[String(id || '').toLowerCase()] || '';
  }

  function glyphForSign(sign) {
    return SIGN_GLYPHS[String(sign || '').toLowerCase()] || '';
  }

  function glyphSpan(char) {
    if (!char) return '';
    return '<span class="' + expandClassNames('openastro-astro-glyph') + '">' + esc(char) + '</span>';
  }

  function api(path, options) {
    var cfg = getCfg();
    var headers = options.headers || {};
    if (cfg.nonce) {
      headers['X-WP-Nonce'] = cfg.nonce;
    }

    return fetch(cfg.root.replace(/\/$/, '') + path, Object.assign({}, options, { headers: headers }))
      .then(function (r) {
        return r.json().then(function (body) {
          return { ok: r.ok, body: body };
        });
      });
  }

  function safeJsonParse(raw) {
    try {
      return JSON.parse(raw);
    } catch (e) {
      return null;
    }
  }

  function getHistory() {
    try {
      var raw = window.localStorage.getItem(HISTORY_KEY);
      if (!raw) return [];
      var parsed = safeJsonParse(raw);
      if (!Array.isArray(parsed)) {
        window.localStorage.removeItem(HISTORY_KEY);
        return [];
      }
      return parsed;
    } catch (e) {
      return [];
    }
  }

  function saveHistory(history) {
    try {
      window.localStorage.setItem(HISTORY_KEY, JSON.stringify(history.slice(0, HISTORY_LIMIT)));
    } catch (e) {
      // Ignore storage issues to keep widget functional.
    }
  }

  function pad2(v) {
    var n = Number(v || 0);
    return n < 10 ? '0' + n : String(n);
  }

  function toDateValue(entry) {
    return [entry.year, pad2(entry.month), pad2(entry.day)].join('-');
  }

  function toTimeValue(entry) {
    return pad2(entry.hour) + ':' + pad2(entry.minute);
  }

  function normalizeNum(v, fixed) {
    var num = Number(v || 0);
    return num.toFixed(fixed || 4);
  }

  function historyIdFromEntry(entry) {
    return [
      String(entry.year || ''),
      String(entry.month || ''),
      String(entry.day || ''),
      String(entry.hour || ''),
      String(entry.minute || ''),
      normalizeNum(entry.lat, 4),
      normalizeNum(entry.lng, 4)
    ].join('|');
  }

  function makeHistoryEntry(mode, payload, selectedCity, includeMinor) {
    var country = selectedCity.country || selectedCity.country_name || selectedCity.country_code || '';
    var entry = {
      saved_at: new Date().toISOString(),
      name: payload.name || '',
      year: Number(payload.year || 0),
      month: Number(payload.month || 0),
      day: Number(payload.day || 0),
      hour: Number(payload.hour || 0),
      minute: Number(payload.minute || 0),
      city_name: selectedCity.name || payload.city || '',
      country: country,
      timezone: selectedCity.timezone || payload.tz_str || '',
      lat: Number(selectedCity.lat || payload.lat || 0),
      lng: Number(selectedCity.lng || payload.lng || 0),
      include_minor_aspects: !!includeMinor,
      last_mode: mode
    };
    entry.id = historyIdFromEntry(entry);
    return entry;
  }

  function upsertHistory(entry) {
    var history = getHistory();
    var deduped = history.filter(function (h) {
      return historyIdFromEntry(h) !== entry.id;
    });
    deduped.unshift(entry);
    if (deduped.length > HISTORY_LIMIT) {
      deduped = deduped.slice(0, HISTORY_LIMIT);
    }
    saveHistory(deduped);
    return deduped;
  }

  function historyOptionLabel(entry) {
    var datePart = [pad2(entry.day), pad2(entry.month), String(entry.year)].join('/');
    var timePart = [pad2(entry.hour), pad2(entry.minute)].join(':');
    var place = entry.city_name || 'Unknown city';
    var country = entry.country ? ' (' + entry.country + ')' : '';
    var person = String(entry.name || '').trim();
    var personPrefix = person ? person + ' - ' : '';
    return personPrefix + datePart + ' ' + timePart + ' - ' + place + country;
  }

  function normalizeSearchText(value) {
    var text = String(value || '');
    if (typeof text.normalize === 'function') {
      text = text.normalize('NFD').replace(/[\u0300-\u036f]/g, '');
    }
    return text.toLowerCase();
  }

  function parseCitySearchInput(value) {
    var query = String(value || '').trim();
    var country = '';
    var commaParts = query.split(',');
    var possibleCountry = commaParts.length > 1 ? commaParts[commaParts.length - 1].trim() : '';
    var trailingCountry = query.match(/\s+([A-Za-z]{2})$/);

    if (/^[A-Za-z]{2}$/.test(possibleCountry)) {
      country = possibleCountry.toUpperCase();
      query = commaParts.slice(0, -1).join(',').trim();
    } else if (trailingCountry) {
      country = trailingCountry[1].toUpperCase();
      query = query.slice(0, trailingCountry.index).trim();
    }

    return {
      query: query,
      country: country
    };
  }

  function cityCountryCode(item) {
    var code = item.country_code || item.country || '';
    if (/^[A-Za-z]{2,3}$/.test(String(code))) {
      return String(code).toUpperCase();
    }
    return code;
  }

  function cityCountryName(item) {
    return item.country_name || item.country_full_name || '';
  }

  function cityCountryLabel(item) {
    var code = cityCountryCode(item);
    var name = cityCountryName(item);
    if (name && code && normalizeSearchText(name) !== normalizeSearchText(code)) {
      return name + ' (' + code + ')';
    }
    return code || name || 'Unknown country';
  }

  function cityValueLabel(item) {
    var code = cityCountryCode(item);
    var country = /^[A-Z]{2,3}$/.test(String(code)) ? code : cityCountryName(item);
    return (item.name || '') + (country ? ', ' + country : '');
  }

  function cityTimezoneLabel(item) {
    return item.timezone || item.tz_str || '';
  }

  function cityRegionLabel(item) {
    return item.admin1_name || item.admin_name || item.region || item.state || item.province || '';
  }

  function cityCoordinateLabel(item) {
    var lat = Number(item.lat);
    var lng = Number(item.lng);
    if (!Number.isFinite(lat) || !Number.isFinite(lng)) {
      return '';
    }
    return lat.toFixed(2) + ', ' + lng.toFixed(2);
  }

  function cityMetaParts(item) {
    var parts = [];
    var region = cityRegionLabel(item);
    var countryName = cityCountryName(item);
    var timezone = cityTimezoneLabel(item);
    var coordinates = cityCoordinateLabel(item);

    if (region && normalizeSearchText(region) !== normalizeSearchText(item.name)) {
      parts.push(region);
    }
    if (countryName && normalizeSearchText(countryName) !== normalizeSearchText(cityCountryCode(item))) {
      parts.push(countryName);
    }
    if (timezone) {
      parts.push(timezone);
    }
    if (coordinates) {
      parts.push(coordinates);
    }

    return parts;
  }

  function citySuggestionLabel(item) {
    var label = [item.name || 'Unknown city', cityCountryLabel(item)].filter(Boolean).join(', ');
    var meta = cityMetaParts(item);
    return meta.length ? label + ', ' + meta.join(', ') : label;
  }

  function citySearchRank(item, query) {
    var q = normalizeSearchText(query);
    var name = normalizeSearchText(item.name);
    var countryCode = normalizeSearchText(cityCountryCode(item));
    var countryName = normalizeSearchText(cityCountryName(item));
    var words = name.split(/[\s\-_,.]+/);

    if (name === q) return 0;
    if (name.indexOf(q) === 0) return 1;
    for (var i = 0; i < words.length; i += 1) {
      if (words[i].indexOf(q) === 0) return 2;
    }
    if (countryCode === q) return 3;
    if (name.indexOf(q) !== -1) return 4;
    if (countryName.indexOf(q) !== -1) return 5;
    return 6;
  }

  function sortCitySuggestions(items, query) {
    return items.slice().sort(function (a, b) {
      var rankDiff = citySearchRank(a, query) - citySearchRank(b, query);
      if (rankDiff !== 0) return rankDiff;
      var populationDiff = Number(b.population || 0) - Number(a.population || 0);
      if (populationDiff !== 0) return populationDiff;
      var aName = String(a.name || '');
      var bName = String(b.name || '');
      if (aName.length !== bName.length) return aName.length - bName.length;
      return aName.localeCompare(bName);
    });
  }

  function textFromEntry(entry) {
    if (!entry) return '';
    if (typeof entry === 'string') return entry.trim();
    if (typeof entry !== 'object') return '';
    var candidates = ['body', 'text', 'content', 'description', 'interpretation', 'summary'];
    for (var i = 0; i < candidates.length; i += 1) {
      var v = entry[candidates[i]];
      if (typeof v === 'string' && v.trim()) {
        return v.trim();
      }
    }
    return '';
  }

  function findAngleAtom(atoms, token) {
    var t = token.toLowerCase();
    for (var i = 0; i < atoms.length; i += 1) {
      var atom = atoms[i];
      var title = String(atom.title || '').toLowerCase();
      var key = String(atom.key || '').toLowerCase();
      if (title.indexOf(t) >= 0 || key.indexOf(t) >= 0) {
        return atom;
      }
    }
    return null;
  }

  function collectInterpretationAtoms(interpretation) {
    if (!interpretation || typeof interpretation !== 'object' || Array.isArray(interpretation)) {
      return [];
    }

    var sections = interpretation.sections;
    if (!sections || typeof sections !== 'object' || Array.isArray(sections)) {
      return [];
    }

    var out = [];
    Object.keys(sections).forEach(function (cat) {
      var entries = sections[cat];
      if (!Array.isArray(entries)) {
        return;
      }
      entries.forEach(function (entry) {
        var title = '';
        var body = '';
        var key = '';
        if (entry && typeof entry === 'object') {
          title = typeof entry.title === 'string' ? entry.title.trim() : '';
          body = textFromEntry(entry);
          key = typeof entry.key === 'string' ? entry.key : '';
        } else if (typeof entry === 'string') {
          body = entry.trim();
        }
        if (!title) {
          title = cat.charAt(0).toUpperCase() + cat.slice(1);
        }
        if (!title || !body) {
          return;
        }
        out.push({
          category: cat,
          title: title,
          body: body,
          key: key
        });
      });
    });

    return out;
  }

  function cropText(text, detail) {
    if (detail !== 'concise') {
      return text;
    }

    var s = String(text || '');
    if (s.length <= 240) {
      return s;
    }

    return s.slice(0, 240).trim() + '...';
  }

  function findPlanetAtom(atoms, planet) {
    var id = String(planet.id || '').toLowerCase();
    var name = String(planet.name || '').toLowerCase();

    for (var i = 0; i < atoms.length; i += 1) {
      var atom = atoms[i];
      var title = atom.title.toLowerCase();
      var key = atom.key.toLowerCase();
      if (key.indexOf('planet.' + id + '.') >= 0 || title.indexOf(name + ' in ') === 0) {
        return atom;
      }
    }

    return null;
  }

  function reportHtml(response, svg, mode, reportCfg) {
    var planets = Array.isArray(response.planets) ? response.planets : [];
    var aspects = Array.isArray(response.aspects) ? response.aspects.slice() : [];
    var atoms = collectInterpretationAtoms(response.interpretation);

    aspects.sort(function (a, b) {
      return Number(a.orb || 0) - Number(b.orb || 0);
    });

    var html = '<h2 class="' + expandClassNames('openastro-report-title') + '">Natal Report</h2>';

    if (mode === 'chart-report' && svg) {
      html += chartSectionHtml(svg, reportCfg);
    }

    if (reportCfg.showAngles) {
      var ascAtom = findAngleAtom(atoms, 'ascendant') || findAngleAtom(atoms, 'asc');
      var mcAtom = findAngleAtom(atoms, 'midheaven') || findAngleAtom(atoms, 'mc');
      var asc = response.angles_details && response.angles_details.asc ? response.angles_details.asc : null;
      var mc = response.angles_details && response.angles_details.mc ? response.angles_details.mc : null;

      html += '<section class="' + expandClassNames('openastro-card') + '"><h3>1st House / ASC</h3>';
      if (asc) {
        var ascSignGlyph = glyphForSign(asc.sign);
        html += '<p><strong>Sign:</strong> ' + esc(asc.sign || '-') + (ascSignGlyph ? ' ' + glyphSpan(ascSignGlyph) : '') + ' <strong>House:</strong> ' + esc(asc.house || '-') + '</p>';
      }
      html += '<p>' + esc(cropText(ascAtom ? ascAtom.body : 'Ascendant interpretation was not returned for this chart.', reportCfg.detailLevel)) + '</p>';
      html += '</section>';

      html += '<section class="' + expandClassNames('openastro-card') + '"><h3>10th House Cusp / MC</h3>';
      if (mc) {
        var mcSignGlyph = glyphForSign(mc.sign);
        html += '<p><strong>Sign:</strong> ' + esc(mc.sign || '-') + (mcSignGlyph ? ' ' + glyphSpan(mcSignGlyph) : '') + ' <strong>House:</strong> ' + esc(mc.house || '-') + '</p>';
      }
      html += '<p>' + esc(cropText(mcAtom ? mcAtom.body : 'Midheaven interpretation was not returned for this chart.', reportCfg.detailLevel)) + '</p>';
      html += '</section>';
    }

    html += '<section class="' + expandClassNames('openastro-card') + '"><h3>Planet Interpretations</h3>';
    planets.slice(0, reportCfg.maxPlanets).forEach(function (planet) {
      var atom = findPlanetAtom(atoms, planet);
      var defaultBody = PLANET_OVERVIEW[String(planet.id || '').toLowerCase()] || 'Interpretation not available for this planet.';
      var body = atom ? atom.body : defaultBody;
      var bodyGlyph = glyphForBody(planet.id);
      var signGlyph = glyphForSign(planet.sign);
      var planetName = planet.name || planet.id || '-';
      var signName = planet.sign || '-';
      var houseLabel = planet.house || '-';
      html += '<article class="' + expandClassNames('openastro-planet-item') + '">';
      html += '<h4>' + esc(planetName) + (bodyGlyph ? ' ' + glyphSpan(bodyGlyph) : '') + esc(' in ' + signName) + (signGlyph ? ' ' + glyphSpan(signGlyph) : '') + esc(' (House ' + houseLabel + ')') + '</h4>';
      html += '<p>' + esc(cropText(body, reportCfg.detailLevel)) + '</p>';
      html += '</article>';
    });
    html += '</section>';

    html += '<section class="' + expandClassNames('openastro-card') + '"><h3>All Aspect Dynamics</h3>';
    if (reportCfg.showTables) {
      html += '<table><thead><tr><th>P1</th><th>Aspect</th><th>P2</th><th>Orb</th><th>Major</th></tr></thead><tbody>';
      aspects.slice(0, reportCfg.maxAspects).forEach(function (a) {
        html += '<tr>' +
          '<td>' + esc(a.p1 || '-') + '</td>' +
          '<td>' + esc(a.type || '-') + '</td>' +
          '<td>' + esc(a.p2 || '-') + '</td>' +
          '<td>' + esc(typeof a.orb === 'number' ? a.orb.toFixed(2) : a.orb || '-') + '</td>' +
          '<td>' + esc(a.is_major ? 'Yes' : 'No') + '</td>' +
          '</tr>';
      });
      html += '</tbody></table>';
    } else {
      html += '<p>' + esc(aspects.length) + ' aspects detected.</p>';
    }
    html += '</section>';

    return html;
  }

  function setSuiteVariable(container, name, value) {
    container.style.setProperty(name, value);
    if (name.indexOf('--openastro-') === 0) {
      container.style.setProperty(name.replace('--openastro-', '--astrology-suite-'), value);
    }
  }

  function mount(container) {
    var mode = container.getAttribute('data-mode') || 'chart-report';
    var cfg = getCfg();
    var includeInterpretation = container.getAttribute('data-include-interpretation') !== '0';
    var interpretationStyle = container.getAttribute('data-interpretation-style') === 'poetic' ? 'poetic' : 'improved';
    var simpleMode = isSimpleSignMode(mode);

    container.classList.add('wp-block-astrology-suite-widget');
    setSuiteVariable(container, '--openastro-bg', cfg.style.backgroundColor);
    setSuiteVariable(container, '--openastro-text', cfg.style.textColor);
    setSuiteVariable(container, '--openastro-input-radius', cfg.style.inputBorderRadius + 'px');
    setSuiteVariable(container, '--openastro-input-border-color', cfg.style.inputBorderColor);
    setSuiteVariable(container, '--openastro-input-bg', cfg.style.inputBgColor);
    setSuiteVariable(container, '--openastro-input-text', cfg.style.inputTextColor);
    setSuiteVariable(container, '--openastro-input-placeholder', cfg.style.inputPlaceholderColor);
    setSuiteVariable(container, '--openastro-button-radius', cfg.style.buttonBorderRadius + 'px');
    setSuiteVariable(container, '--openastro-button-bg', cfg.style.buttonBgColor);
    setSuiteVariable(container, '--openastro-button-text', cfg.style.buttonTextColor);
    setSuiteVariable(container, '--openastro-button-border', cfg.style.buttonBorderColor);
    setSuiteVariable(container, '--openastro-label-color', cfg.style.labelColor);
    setSuiteVariable(container, '--openastro-label-weight', cfg.style.labelWeight);
    setSuiteVariable(container, '--openastro-focus-ring', cfg.style.focusRingColor);
    setSuiteVariable(container, '--openastro-astro-font-size', cfg.style.astroFontSize + 'px');
    setSuiteVariable(container, '--openastro-astro-font-color', cfg.style.astroFontColor);
    setSuiteVariable(container, '--openastro-font-h2', cfg.typography.h2 + 'px');
    setSuiteVariable(container, '--openastro-font-h3', cfg.typography.h3 + 'px');
    setSuiteVariable(container, '--openastro-font-h4', cfg.typography.h4 + 'px');
    setSuiteVariable(container, '--openastro-font-body', cfg.typography.body + 'px');
    setSuiteVariable(container, '--openastro-font-table', cfg.typography.table + 'px');
    setSuiteVariable(container, '--openastro-font-input', cfg.typography.input + 'px');
    setSuiteVariable(container, '--openastro-font-button', cfg.typography.button + 'px');
    setSuiteVariable(container, '--openastro-font-meta', cfg.typography.meta + 'px');
    if (cfg.style.showBorder === false) {
      container.classList.add('astrology-suite-no-border');
      container.classList.add('openastro-no-border');
    } else {
      container.classList.remove('astrology-suite-no-border');
      container.classList.remove('openastro-no-border');
    }

    if (!cfg.permissions.canCalculate) {
      var accessNote = create('section', { class: 'openastro-card openastro-access-note' });
      accessNote.appendChild(create('h3', null, 'Calculation Access Required'));
      accessNote.appendChild(create('p', null, cfg.permissions.calculationMessage));
      container.appendChild(accessNote);
      return;
    }

    var form = create('form', { class: 'openastro-form' });
    var formHeader = create('div', { class: 'openastro-form-header' });
    var historyWrap = create('div', { class: 'openastro-load-recent-wrap' });
    var historyPanel = create('div', { class: 'openastro-load-recent-panel' });
    var historyId = 'openastro-history-select-' + Math.random().toString(36).slice(2, 10);
    var historyLabel = create('label', { class: 'openastro-history-label openastro-load-recent-label', for: historyId }, 'Past inputs');
    var historySelect = create('select', { id: historyId, class: 'openastro-history-select openastro-load-recent-select', 'aria-label': 'Load recent past inputs' });
    var historyDefaultOption = create('option', { value: '' }, 'Past inputs...');
    historySelect.appendChild(historyDefaultOption);
    historyPanel.appendChild(historyLabel);
    historyPanel.appendChild(historySelect);
    historyWrap.appendChild(historyPanel);
    formHeader.appendChild(historyWrap);
    var name = create('input', { type: 'text', class: 'openastro-input', placeholder: 'Name (optional)' });
    var date = create('input', { type: 'date', class: 'openastro-input' });
    var time = create('input', { type: 'time', step: '60', class: 'openastro-input' });
    var cityId = 'openastro-city-input-' + Math.random().toString(36).slice(2, 10);
    var cityResultsId = 'openastro-city-results-' + Math.random().toString(36).slice(2, 10);
    var cityMessageId = 'openastro-city-message-' + Math.random().toString(36).slice(2, 10);
    var city = create('input', {
      id: cityId,
      type: 'text',
      class: 'openastro-input openastro-city-input',
      placeholder: 'City or city, country code',
      role: 'combobox',
      'aria-autocomplete': 'list',
      'aria-haspopup': 'listbox',
      'aria-controls': cityResultsId,
      'aria-describedby': cityMessageId,
      'aria-expanded': 'false'
    });
    var cityWrap = create('div', { class: 'openastro-city-field' });
    var cityLoading = create('p', { id: cityMessageId, class: 'openastro-city-loading', 'aria-live': 'polite' }, '');
    var cityResults = create('div', { id: cityResultsId, class: 'openastro-results', role: 'listbox', 'aria-label': 'City suggestions' });
    var includeMinorWrap = create('label', { class: 'openastro-inline' });
    var includeMinor = create('input', { type: 'checkbox', checked: 'checked' });
    includeMinorWrap.appendChild(includeMinor);
    includeMinorWrap.appendChild(document.createTextNode(' Include minor aspects'));

    var submit = create('button', { type: 'submit', class: 'openastro-btn' }, 'Generate');
    var status = create('p', { class: 'openastro-status' }, '');
    var output = create('div', { class: 'openastro-output' });

    form.appendChild(formHeader);
    form.appendChild(name);
    form.appendChild(date);
    form.appendChild(time);
    cityWrap.appendChild(city);
    cityWrap.appendChild(cityLoading);
    cityWrap.appendChild(cityResults);
    form.appendChild(cityWrap);
    if (!simpleMode) {
      form.appendChild(includeMinorWrap);
    }
    form.appendChild(submit);
    form.appendChild(status);

    container.appendChild(form);
    container.appendChild(output);

    var cityTimer = null;
    var cityRequestId = 0;
    var citySuggestions = [];
    var activeCityIndex = -1;
    var selectedCity = null;
    var historyEntries = getHistory();

    function setCityExpanded(expanded) {
      var isExpanded = expanded && citySuggestions.length;
      city.setAttribute('aria-expanded', isExpanded ? 'true' : 'false');
      cityWrap.classList.toggle('is-open', !!isExpanded);
      if (!expanded) {
        city.removeAttribute('aria-activedescendant');
      }
    }

    function setCityMessage(message) {
      cityLoading.textContent = message || '';
    }

    function clearCityResults() {
      citySuggestions = [];
      activeCityIndex = -1;
      cityResults.innerHTML = '';
      setCityExpanded(false);
    }

    function setActiveCityIndex(index) {
      var buttons = cityResults.querySelectorAll('.openastro-result-btn');
      if (!citySuggestions.length || !buttons.length) {
        activeCityIndex = -1;
        city.removeAttribute('aria-activedescendant');
        return;
      }

      activeCityIndex = (index + citySuggestions.length) % citySuggestions.length;
      Array.prototype.forEach.call(buttons, function (button, idx) {
        var isActive = idx === activeCityIndex;
        button.classList.toggle('is-active', isActive);
        button.setAttribute('aria-selected', isActive ? 'true' : 'false');
        if (isActive) {
          city.setAttribute('aria-activedescendant', button.id);
          button.scrollIntoView({ block: 'nearest' });
        }
      });
    }

    function chooseCity(item) {
      cityRequestId += 1;
      selectedCity = item;
      city.value = cityValueLabel(item);
      setCityMessage('Selected ' + cityValueLabel(item) + (cityTimezoneLabel(item) ? ' - ' + cityTimezoneLabel(item) : '') + '.');
      clearCityResults();
    }

    function renderCitySuggestions(items, query) {
      cityResults.innerHTML = '';
      citySuggestions = items;
      activeCityIndex = -1;

      items.forEach(function (item, idx) {
        var button = create('button', {
          id: cityResultsId + '-option-' + idx,
          type: 'button',
          class: 'openastro-result-btn',
          role: 'option',
          'aria-selected': 'false',
          'aria-label': citySuggestionLabel(item)
        });
        var main = create('span', { class: 'openastro-result-main' });
        var primary = create('span', { class: 'openastro-result-primary' });
        var countryCode = cityCountryCode(item);
        primary.appendChild(create('span', { class: 'openastro-result-name' }, item.name || 'Unknown city'));
        if (countryCode) {
          primary.appendChild(create('span', { class: 'openastro-result-country' }, countryCode));
        }
        main.appendChild(primary);

        var metaParts = cityMetaParts(item);

        button.appendChild(main);
        if (metaParts.length) {
          var meta = create('span', { class: 'openastro-result-meta' });
          metaParts.forEach(function (part) {
            meta.appendChild(create('span', { class: 'openastro-result-meta-item' }, part));
          });
          button.appendChild(meta);
        }
        button.addEventListener('click', function () {
          chooseCity(item);
        });
        cityResults.appendChild(button);
      });

      setCityExpanded(true);
      setActiveCityIndex(0);
      setCityMessage(items.length + ' match' + (items.length === 1 ? '' : 'es') + ' for "' + query + '". Use arrow keys or click a city.');
    }

    function refreshHistorySelect() {
      historySelect.innerHTML = '';
      historySelect.appendChild(create('option', { value: '' }, 'Past inputs...'));
      historyEntries.forEach(function (entry, idx) {
        var option = create('option', { value: String(idx) }, historyOptionLabel(entry));
        historySelect.appendChild(option);
      });
    }

    function applyHistoryEntry(entry) {
      if (!entry) return;
      name.value = entry.name || '';
      date.value = toDateValue(entry);
      time.value = toTimeValue(entry);
      var country = entry.country ? entry.country : '--';
      city.value = (entry.city_name || '') + ', ' + country;
      selectedCity = {
        name: entry.city_name || '',
        country: entry.country || '',
        timezone: entry.timezone || 'UTC',
        lat: Number(entry.lat || 0),
        lng: Number(entry.lng || 0)
      };
      if (!simpleMode) {
        includeMinor.checked = !!entry.include_minor_aspects;
      }
      cityRequestId += 1;
      clearCityResults();
      setCityMessage('');
      status.textContent = 'Loaded saved input.';
    }

    refreshHistorySelect();
    historySelect.addEventListener('change', function () {
      var idx = Number(historySelect.value);
      if (!historySelect.value || Number.isNaN(idx)) {
        return;
      }
      applyHistoryEntry(historyEntries[idx]);
    });

    city.addEventListener('input', function () {
      var parsedSearch = parseCitySearchInput(city.value);
      selectedCity = null;
      clearCityResults();
      setCityMessage('');
      if (cityTimer) {
        clearTimeout(cityTimer);
      }
      cityRequestId += 1;
      var requestId = cityRequestId;
      if (parsedSearch.query.length < 2) {
        if (parsedSearch.query.length > 0) {
          setCityMessage('Type at least 2 characters to search cities.');
        }
        return;
      }

      setCityMessage('Searching cities...');
      cityTimer = setTimeout(function () {
        var path = '/geo/search?q=' + encodeURIComponent(parsedSearch.query) + '&limit=8';
        if (parsedSearch.country) {
          path += '&country=' + encodeURIComponent(parsedSearch.country);
        }
        api(path, { method: 'GET' })
          .then(function (result) {
            if (requestId !== cityRequestId) {
              return;
            }
            clearCityResults();
            setCityMessage('');
            if (!result.ok || !result.body || !Array.isArray(result.body.results)) {
              setCityMessage('Could not load city suggestions.');
              return;
            }
            if (result.body.results.length === 0) {
              setCityMessage('No cities found. Try another query.');
              return;
            }

            renderCitySuggestions(sortCitySuggestions(result.body.results, parsedSearch.query), parsedSearch.query);
          })
          .catch(function () {
            if (requestId !== cityRequestId) {
              return;
            }
            clearCityResults();
            setCityMessage('Could not load city suggestions.');
          });
      }, 300);
    });

    city.addEventListener('keydown', function (event) {
      if (!citySuggestions.length) {
        return;
      }
      if (event.key === 'ArrowDown') {
        event.preventDefault();
        setActiveCityIndex(activeCityIndex < 0 ? 0 : activeCityIndex + 1);
      } else if (event.key === 'ArrowUp') {
        event.preventDefault();
        setActiveCityIndex(activeCityIndex < 0 ? citySuggestions.length - 1 : activeCityIndex - 1);
      } else if (event.key === 'Enter' && activeCityIndex >= 0) {
        event.preventDefault();
        chooseCity(citySuggestions[activeCityIndex]);
      } else if (event.key === 'Escape') {
        event.preventDefault();
        clearCityResults();
        setCityMessage('');
      }
    });

    city.addEventListener('blur', function () {
      window.setTimeout(function () {
        if (!cityResults.contains(document.activeElement)) {
          clearCityResults();
        }
      }, 120);
    });

    form.addEventListener('submit', function (event) {
      event.preventDefault();

      if (!date.value || !time.value || !selectedCity) {
        status.textContent = 'Date, time, and a city from suggestions are required.';
        return;
      }

      var d = date.value.split('-');
      var t = time.value.split(':');
      var payload = {
        name: name.value || '',
        year: Number(d[0]),
        month: Number(d[1]),
        day: Number(d[2]),
        hour: Number(t[0]),
        minute: Number(t[1]),
        city: selectedCity.name,
        lat: selectedCity.lat,
        lng: selectedCity.lng,
        tz_str: selectedCity.timezone
      };

      submit.disabled = true;
      status.textContent = 'Generating...';
      output.innerHTML = '';

      if (simpleMode) {
        payload.include_points = [pointForSimpleMode(mode)];
        payload.include_interpretation = includeInterpretation;
        payload.interpretation_style = interpretationStyle;

        api('/western/simple-signs', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify(payload)
        })
          .then(function (result) {
            if (!result.ok || !result.body) {
              status.textContent = (result.body && result.body.message) || 'Could not generate simple sign.';
              return;
            }

            output.innerHTML = simpleSignHtml(result.body, includeInterpretation);
            status.textContent = 'Done.';
            historyEntries = upsertHistory(makeHistoryEntry(mode, payload, selectedCity, false));
            refreshHistorySelect();
          })
          .catch(function () {
            status.textContent = 'Unexpected error while generating data.';
          })
          .finally(function () {
            submit.disabled = false;
          });

        return;
      }

      payload.include_minor_aspects = includeMinor.checked;

      Promise.all([
        api('/natal/calculate', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify(payload)
        }),
        api('/natal/chart-svg', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify(payload)
        })
      ])
        .then(function (result) {
          var natal = result[0];
          var chart = result[1];

          if (!natal.ok || !natal.body) {
            status.textContent = 'Could not generate natal data.';
            return;
          }

          var svg = chart.ok && chart.body && chart.body.svg ? chart.body.svg : '';
          var detail = {
            request: payload,
            response: natal.body,
            chartSvg: svg || null
          };

          window.dispatchEvent(new CustomEvent('openastro:natal:generated', { detail: detail }));

          if (mode === 'chart-only') {
            output.innerHTML = chartSectionHtml(svg, cfg.report);
          } else if (mode === 'report-only') {
            output.innerHTML = reportHtml(natal.body, '', mode, cfg.report);
          } else {
            output.innerHTML = reportHtml(natal.body, svg, mode, cfg.report);
          }

          status.textContent = 'Done.';
          historyEntries = upsertHistory(makeHistoryEntry(mode, payload, selectedCity, includeMinor.checked));
          refreshHistorySelect();
        })
        .catch(function () {
          status.textContent = 'Unexpected error while generating data.';
        })
        .finally(function () {
          submit.disabled = false;
        });
    });

    output.addEventListener('click', function (event) {
      var target = event.target;
      if (!target || !target.closest) {
        return;
      }

      var button = target.closest('[data-openastro-print-chart="1"]');
      if (!button) {
        return;
      }

      event.preventDefault();
      var card = button.closest('.openastro-chart-card');
      printChartCard(card);
    });
  }

  document.addEventListener('DOMContentLoaded', function () {
    var nodes = document.querySelectorAll('[data-astrology-suite-widget="1"], [data-openastro-widget="1"]');
    nodes.forEach(mount);
  });
})();
