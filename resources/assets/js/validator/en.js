vimport localEn from 'vee-validate/dist/locale/en';

// This is the dictionary used by vee-validate.
// Language is english.

export default Object.assign({}, localEn,
    {
        attributes: {
            'booking code': 'booking code',
            'first_name': 'the first name',
            'last_name': 'the name',
            'email': "the email address",
            'birthdate': "the date of birth",
            'gender': "the gender",
            'location': 'the location',
            'phone' : 'the phone number',
            'password': "the password",
            'password_confirmation': 'the password confirmation'

            'price': 'the price',
            'travel_date': 'the journey date',
            'train_number': 'the train number',
            'departure_station': 'the departure station,
            'arrival_station': 'the arrival station',
            'departure_time': "the departure time",
            'arrival_time': "the arrival time",
            'company': "the train company",
            'flexibility': "the flexibility",
            'classe': "the class",
            'currency': "the currency",
            'bought_price': "the buying price",
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