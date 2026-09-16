#!/usr/bin/env python3
"""Build the Font Awesome subset this theme ships: only the glyphs it renders.

Newspaper X draws icons two ways -- `fa-solid fa-x` classes in templates, and
raw `content: '\fXXX'` codepoints in the stylesheet, which is how the social
links pick a glyph from their href. Both are scanned here, so the shipped font
files stay a few kilobytes instead of a few hundred.

    python3 .github/build-icon-subset.py

Re-run it after adding an icon anywhere, or the new glyph renders as a blank
box for everyone who has not set the newspaper_x_full_fontawesome filter.
"""
import re, sys, json, pathlib, subprocess

THEME    = pathlib.Path(__file__).resolve().parent.parent
FA       = THEME / 'assets' / 'vendors' / 'fontawesome'
CSS      = FA / 'css'
WEBFONTS = FA / 'webfonts'
OUT      = FA / 'subset'
PREFIX   = 'newspaper_x'
# The theme's own stylesheets, which carry raw codepoints.
THEME_CSS = ['style.css', 'assets/css/style.css', 'assets/css/custom-editor-style.css', 'rtl.css']

OUT.mkdir(exist_ok=True)


def codepoint(value):
    """Turn a Font Awesome `--fa` value into a Unicode scalar.

    Most icons are `\\f005`, but 51 of them are plain characters -- fa-hashtag
    is a literal `#`, fa-1 is a `1`. Miss those and the icon ships as tofu.
    """
    m = re.fullmatch(r'\\([0-9a-fA-F]{1,6}) ?', value)
    if m:
        return int(m.group(1), 16)
    m = re.fullmatch(r'\\(.)', value, re.S)
    if m:
        return ord(m.group(1))
    return ord(value) if len(value) == 1 else None


def icon_map(path):
    """name -> codepoint, for one Font Awesome stylesheet."""
    out = {}
    for chunk in (CSS / path).read_text().split('}'):
        m = re.search(r'--fa:"([^"]*)"$', chunk)
        if not m:
            continue
        cp = codepoint(m.group(1))
        if cp is None:
            continue
        for name in re.findall(r'\.fa-([a-z0-9-]+)(?=[,{])', chunk[:chunk.rfind('{')] + '{'):
            out[name] = cp
    return out


core_map, brand_map = icon_map('fontawesome.min.css'), icon_map('brands.min.css')

# Sizing, stacking and animation classes share the fa- prefix but name no glyph.
MOD = {'solid', 'regular', 'brands', 'classic', 'light', 'thin', 'duotone', 'sharp', 'fw', 'spin',
       'pulse', 'li', 'ul', 'border', 'pull-left', 'pull-right', 'rotate-90', 'rotate-180',
       'rotate-270', 'flip-horizontal', 'flip-vertical', 'flip-both', 'stack', 'stack-1x',
       'stack-2x', 'inverse', 'lg', 'xs', 'sm', '2x', '3x', '4x', '5x', 'beat', 'fade', 'flip',
       'shake', 'bounce', 'spin-pulse', 'spin-reverse', '2xs', 'xl', '2xl'}

solid, regular, brands = set(), set(), set()

# 1. icon classes in templates, in whichever style they are rendered
for f in list(THEME.rglob('*.php')) + list(THEME.rglob('*.js')):
    sp = str(f)
    if any(k in sp for k in ('/.git/', 'node_modules', 'fontawesome', 'vendors')):
        continue
    text = f.read_text(errors='ignore')
    for m in re.finditer(r'''['"]([^'"]*\bfa-[a-z0-9-]+[^'"]*)['"]''', text):
        cls = m.group(1)
        names = [n for n in re.findall(r'\bfa-([a-z0-9-]+)', cls) if n not in MOD]
        is_regular = 'fa-regular' in cls or re.search(r'\bfar\b', cls)
        for n in names:
            if n in brand_map:
                brands.add(brand_map[n])
            elif n in core_map:
                (regular if is_regular else solid).add(core_map[n])

# 2. raw codepoints in the theme's stylesheets, filed by the family the rule names
for rel in THEME_CSS:
    path = THEME / rel
    if not path.exists():
        continue
    for _sel, body in re.findall(r'([^{}]+)\{([^{}]*)\}', path.read_text(errors='ignore')):
        m = re.search(r'''content: *['"]\\([0-9a-fA-F]{1,6})['"]''', body)
        if not m:
            continue
        cp = int(m.group(1), 16)
        if 'Font Awesome 7 Brands' in body:
            brands.add(cp)
        elif 'Font Awesome 7 Free' in body:
            (regular if 'font-weight: 400' in body else solid).add(cp)
        elif cp in brand_map.values():
            brands.add(cp)
        elif cp in core_map.values():
            solid.add(cp)

faces = {'fa-solid-900': solid, 'fa-regular-400': regular, 'fa-brands-400': brands}
report = {}
for face, cps in faces.items():
    src = WEBFONTS / f'{face}.woff2'
    dst = OUT / f'{face}.woff2'
    if not cps:
        dst.unlink(missing_ok=True)
        report[face] = {'glyphs': 0, 'skipped': True}
        continue
    if not src.exists():
        sys.exit(f'missing {src}')
    subprocess.run([sys.executable, '-m', 'fontTools.subset', str(src),
                    '--unicodes=' + ','.join('U+%04X' % c for c in sorted(cps)),
                    '--flavor=woff2', f'--output-file={dst}'], check=True, capture_output=True)
    report[face] = {'glyphs': len(cps), 'bytes': dst.stat().st_size, 'from': src.stat().st_size}

# 3. the stylesheet: Font Awesome's structural rules, the used icon names, subset @font-face
full = (CSS / 'fontawesome.min.css').read_text()
structural = re.sub(r'((?:\.fa-[a-z0-9-]+,?)+)\{--fa:"[^"]*"\}', '', full).strip()

defs = []
for cps, mp in ((solid | regular, core_map), (brands, brand_map)):
    rev = {}
    for name, cp in mp.items():
        rev.setdefault(cp, []).append(name)
    for cp in sorted(cps):
        if cp in rev:
            defs.append(','.join(f'.fa-{n}' for n in sorted(rev[cp])) + '{--fa:"\\%04x"}' % cp)

FACE = ('@font-face{font-family:"%s";font-style:normal;font-weight:%s;font-display:block;'
        'src:url(%s.woff2) format("woff2")}')


def style_rules(sheet):
    """Everything a style stylesheet declares except its @font-face.

    These carry the :root custom properties and the .fa-solid / .fa-regular /
    .fa-brands rules that point a class at the right family and weight. Leave
    them out and .fa-brands falls back to the Free face and renders nothing.
    """
    css = (CSS / sheet).read_text()
    css = re.sub(r'@font-face\{[^}]*\}', '', css)
    # brands.min.css also carries the full 572-name brand map; the names this
    # theme uses are emitted from the subset below, so drop the map here.
    css = re.sub(r'((?:\.fa-[a-z0-9-]+,?)+)\{--fa:"[^"]*"\}', '', css)
    return css.replace(HEADER, '').strip()


HEADER = re.match(r'/\*!.*?\*/', (CSS / 'solid.min.css').read_text(), re.S).group(0)

ff = []
if solid:
    ff.append(style_rules('solid.min.css'))
    ff.append(FACE % ('Font Awesome 7 Free', '900', 'fa-solid-900'))
if regular:
    ff.append(style_rules('regular.min.css'))
    ff.append(FACE % ('Font Awesome 7 Free', '400', 'fa-regular-400'))
if brands:
    ff.append(style_rules('brands.min.css'))
    ff.append(FACE % ('Font Awesome 7 Brands', '400', 'fa-brands-400'))

banner = ("/*!\n * Font Awesome 7.3.1 subset for this theme, built by .github/build-icon-subset.py\n"
          " * Contains only the glyphs the theme renders. Load the complete Font Awesome with:\n"
          f" *   add_filter( '{PREFIX}_full_fontawesome', '__return_true' );\n"
          " * Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT -- https://fontawesome.com/license/free\n */\n")

target = OUT / 'fontawesome-subset.min.css'
target.write_text(banner + structural + ''.join(ff) + ''.join(defs) + '\n')
report['css'] = {'bytes': target.stat().st_size, 'icons': len(defs)}
print(json.dumps(report, indent=1))
