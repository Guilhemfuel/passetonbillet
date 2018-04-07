import localEn from 'vee-validate/dist/locale/en';

// This is the dictionary used by vee-validate.
// Language is english.

export default Object.assign({}, localEn,
    {
        attributes: {
            'booking code': 'booking code'
        },
        custom: {
            'booking_code': {
                required: 'The Eurostar booking code is required.',
                max: 'The Eurostar booking code should be 6 characters long.',
                min: 'The Eurostar booking code should be 6 characters long.'
            }
        }
    }
);