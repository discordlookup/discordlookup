window._ = require('lodash');
window.Popper = require('@popperjs/core');

import Alpine from 'alpinejs'
import collapse from '@alpinejs/collapse'
import focus from '@alpinejs/focus'
window.Alpine = Alpine
Alpine.plugin(collapse)
Alpine.plugin(focus)
Alpine.start()

import moment from 'moment'
window.moment = moment;

window.JSZip = require('jszip');
window.JSZipUtils = require('jszip-utils');
import { saveAs } from 'file-saver';

// vegeta897/snow-stamp is licensed under the MIT License ( https://github.com/vegeta897/snow-stamp/blob/main/src/convert.js )
window.validateSnowflake = function(snowflake, epoch) {
    if (!Number.isInteger(+snowflake)) {
        return "That doesn't look like a valid snowflake. Snowflakes contain only numbers.";
    }
    if (snowflake < 4194304) {
        return "That doesn't look like a valid snowflake. Snowflakes are much larger numbers.";
    }

    const timestamp = convertSnowflakeToDate(snowflake, epoch);
    if (isNaN(timestamp.getTime())) {
        return "That doesn't look like a valid snowflake. Snowflakes have fewer digits.";
    }

    return timestamp;
}

window.convertSnowflakeToDate = function(snowflake, epoch = 1420070400000) {
    return new Date(snowflake / 4194304 + epoch);
}

window.copyToClipboard = function(inputElemId, successElemId) {
    const inputElem = document.getElementById(inputElemId);
    inputElem.select();
    inputElem.setSelectionRange(0, 99999);
    navigator.clipboard.writeText(inputElem.value);

    const successElem = document.getElementById(successElemId);
    successElem.style.display = 'block';
    setTimeout(() => successElem.style.display = 'none', 3000);
}
