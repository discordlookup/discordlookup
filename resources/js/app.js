window._ = require('lodash');
window.Popper = require('@popperjs/core');

import Alpine from 'alpinejs'
import collapse from '@alpinejs/collapse'
window.Alpine = Alpine
Alpine.plugin(collapse)
Alpine.start()

import moment from 'moment'
window.moment = moment;

window.JSZip = require('jszip');
window.JSZipUtils = require('jszip-utils');
import { saveAs } from 'file-saver';

var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new Bootstrap.Tooltip(tooltipTriggerEl)
})

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
