/**
 * Amount inputs accept values pasted in locale formats (e.g. "15.000,02" where
 * "." groups thousands and "," is the decimal) and normalize them to the
 * canonical machine format the backend expects ("15000.02"), without corrupting
 * values that are already canonical or use high-precision decimals.
 */

export function normalizeAmount(raw) {
    if (raw == null) {
        return '';
    }
    let s = String(raw).trim();
    if (s === '') {
        return '';
    }

    const neg = s.startsWith('-');
    s = s.replace(/[^0-9.,]/g, '');
    if (s === '') {
        return neg ? '-' : '';
    }

    const commas = (s.match(/,/g) || []).length;
    const dots = (s.match(/\./g) || []).length;

    let out;
    if (commas === 0) {
        // No comma: already canonical, unless several dots => thousands grouping.
        out = dots > 1 ? s.replace(/\./g, '') : s;
    } else {
        const dotAfterComma = dots > 0 && s.lastIndexOf('.') > s.lastIndexOf(',');
        if (dotAfterComma) {
            // US style: "." is the decimal, "," are thousands.
            out = s.replace(/,/g, '');
        } else {
            // AR/EU style: "," is the decimal, "." are thousands.
            const t = s.replace(/\./g, '');
            const lastComma = t.lastIndexOf(',');
            const decimals = t.length - lastComma - 1;
            if (commas > 1 && decimals === 3) {
                // e.g. "1,000,000" grouped by commas => integer, no decimals.
                out = t.replace(/,/g, '');
            } else {
                out = t.slice(0, lastComma).replace(/,/g, '') + '.' + t.slice(lastComma + 1);
            }
        }
    }

    // Drop a dangling decimal point (e.g. "15." -> "15") so it stays numeric.
    out = out.replace(/\.$/, '');

    return (neg ? '-' : '') + out;
}

function attach() {
    const inputs = document.querySelectorAll('input[name="amount"]');

    inputs.forEach(function (input) {
        input.setAttribute('inputmode', 'decimal');
        input.setAttribute('autocomplete', 'off');

        const apply = function () {
            const normalized = normalizeAmount(input.value);
            if (normalized !== input.value) {
                input.value = normalized;
            }
        };

        // Normalize just after a paste lands, when leaving the field, and as a
        // safety net right before the form is submitted.
        input.addEventListener('paste', function () {
            setTimeout(apply, 0);
        });
        input.addEventListener('blur', apply);
        if (input.form) {
            input.form.addEventListener('submit', apply);
        }
    });
}

if (typeof document !== 'undefined') {
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', attach);
    } else {
        attach();
    }
}
