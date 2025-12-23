export function filterAndFormatInputs(inputElement, config = {}) {
    const {
        allowAlpha = false,
        allowNumbers = false,
        allowedSpecialChars = '',
        capitalizeWords = false,
        preserveCase = true,
        trimSpaces = false,
        maxLength = null
    } = config;

    const specials = allowedSpecialChars.replace(/[-/\\^$*+?.()|[\]{}]/g, '\\$&');
    const allowedPattern = [
        allowAlpha ? 'a-zA-Z' : '',
        allowNumbers ? '0-9' : '',
        '\\s',
        specials
    ].join('');
    const regex = new RegExp(`[^${allowedPattern}]`, 'g');

    const start = inputElement.selectionStart;
    const end = inputElement.selectionEnd;
    const oldValue = inputElement.value;

    let value = oldValue.replace(regex, '');

    if (trimSpaces) value = value.replace(/\s+/g, ' ').trim();
    if (!preserveCase) value = value.toLowerCase();

    if (capitalizeWords && preserveCase && allowAlpha) {
        value = value.split(' ').map(word => word.replace(/^[a-zA-Z]/, c => c.toUpperCase())).join(' ');
    }

    if (maxLength && typeof maxLength === 'number') value = value.substring(0, maxLength);

    if (value !== oldValue) {
        inputElement.value = value;
        let newPos = start - (oldValue.length - value.length);
        newPos = Math.max(0, Math.min(value.length, newPos));
        inputElement.setSelectionRange(newPos, newPos);
    }
}

window.filterAndFormatInputs = filterAndFormatInputs;
