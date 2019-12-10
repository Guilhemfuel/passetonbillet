/**
 *
 * Date Vue Filter
 *
 */
Vue.filter('date', (value, format = 'MMM-YY', input_format = null) => {
    if (typeof value === 'string') {
        if (input_format) {
            // If a format for input is specified
            return moment(value,input_format).format(format);
        } else {
            // Default date formatting
            return moment(value).format(format);
        }
    } else if (typeof value === 'object' && value != null
        && value.hasOwnProperty('date') && value.date != null) {
        if (input_format) {
            // If a format is specied use it othwerwise use default one
            return moment(value.date,input_format).format(format);
        } else {
            // Default date formatting
            return moment(value.date).format(format);
        }
    }
    return null;
});