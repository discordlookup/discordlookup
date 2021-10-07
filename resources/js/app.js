require('./bootstrap');

window.Popper = require('@popperjs/core');

import * as Bootstrap from 'bootstrap'
window.Bootstrap = Bootstrap;

import moment from 'moment'
window.moment = moment;

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
